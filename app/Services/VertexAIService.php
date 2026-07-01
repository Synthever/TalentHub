<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VertexAIService
{
    protected string $projectId;

    protected string $location;

    protected string $model;

    protected ?string $accessToken = null;

    protected string $authMode;

    protected ?string $apiKey = null;

    public function __construct()
    {
        $this->authMode = config('vertexai.auth_mode', 'apikey');
        $this->apiKey = config('vertexai.api_key');
        $this->projectId = config('vertexai.project_id');
        $this->location = config('vertexai.location');
        $this->model = config('vertexai.model');

        // Only initialize OAuth2 if using vertex mode
        if ($this->authMode === 'vertex') {
            $credentials = config('vertexai.credentials');

            if (! file_exists($credentials)) {
                throw new \Exception('Vertex AI credentials file not found: '.$credentials);
            }

            putenv('GOOGLE_APPLICATION_CREDENTIALS='.$credentials);

            $this->accessToken = $this->getAccessToken($credentials);
        }
    }

    protected function getAccessToken(string $credentialsPath): string
    {
        $credentials = json_decode(file_get_contents($credentialsPath), true);

        $jwt = $this->createJWT($credentials);

        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt,
        ]);

        if (! $response->successful()) {
            throw new \Exception('Failed to get access token: '.$response->body());
        }

        return $response->json('access_token');
    }

    protected function createJWT(array $credentials): string
    {
        $now = time();
        $expiration = $now + 3600;

        $header = [
            'alg' => 'RS256',
            'typ' => 'JWT',
        ];

        $payload = [
            'iss' => $credentials['client_email'],
            'scope' => 'https://www.googleapis.com/auth/cloud-platform',
            'aud' => 'https://oauth2.googleapis.com/token',
            'exp' => $expiration,
            'iat' => $now,
        ];

        $encodedHeader = $this->base64UrlEncode(json_encode($header));
        $encodedPayload = $this->base64UrlEncode(json_encode($payload));

        $signature = '';
        openssl_sign(
            "{$encodedHeader}.{$encodedPayload}",
            $signature,
            $credentials['private_key'],
            OPENSSL_ALGO_SHA256
        );

        $encodedSignature = $this->base64UrlEncode($signature);

        return "{$encodedHeader}.{$encodedPayload}.{$encodedSignature}";
    }

    protected function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    public function generateSkillMatching(array $userSkills, array $allSkills): array
    {
        if (! config('vertexai.features.skill_matching')) {
            return [];
        }

        $cacheKey = 'skill_matching_'.md5(json_encode($userSkills));

        if (config('vertexai.cache.enabled')) {
            $cached = Cache::get($cacheKey);
            if ($cached) {
                return $cached;
            }
        }

        $prompt = $this->buildSkillMatchingPrompt($userSkills, $allSkills);
        $response = $this->generateContent($prompt);

        $result = $this->parseJsonResponse($response);

        if (config('vertexai.cache.enabled')) {
            Cache::put($cacheKey, $result, config('vertexai.cache.ttl'));
        }

        return $result;
    }

    public function generateDevelopmentPath($userProfile, $userSkills, $targetRole = null): array
    {
        if (! config('vertexai.features.development_path')) {
            return [];
        }

        $cacheKey = 'dev_path_'.$userProfile['id'].'_'.md5($targetRole ?? 'general');

        if (config('vertexai.cache.enabled')) {
            $cached = Cache::get($cacheKey);
            if ($cached) {
                return $cached;
            }
        }

        $prompt = $this->buildDevelopmentPathPrompt($userProfile, $userSkills, $targetRole);
        $response = $this->generateContent($prompt);

        $result = $this->parseJsonResponse($response);

        if (config('vertexai.cache.enabled')) {
            Cache::put($cacheKey, $result, config('vertexai.cache.ttl'));
        }

        return $result;
    }

    public function generateCollaborationRecommendations($userId, $userSkills, $allUsers): array
    {
        if (! config('vertexai.features.collaboration')) {
            return [];
        }

        $cacheKey = 'collab_'.$userId;

        if (config('vertexai.cache.enabled')) {
            $cached = Cache::get($cacheKey);
            if ($cached) {
                return $cached;
            }
        }

        $prompt = $this->buildCollaborationPrompt($userSkills, $allUsers);
        $response = $this->generateContent($prompt);

        $result = $this->parseJsonResponse($response);

        if (config('vertexai.cache.enabled')) {
            Cache::put($cacheKey, $result, config('vertexai.cache.ttl'));
        }

        return $result;
    }

    protected function generateContent(string $prompt): string
    {
        try {
            if ($this->authMode === 'apikey') {
                // Use Generative Language API (simpler, API key based)
                $url = 'https://generativelanguage.googleapis.com/v1beta/models/'.$this->model.':generateContent';

                $response = Http::withHeaders([
                    'x-goog-api-key' => $this->apiKey,
                    'Content-Type' => 'application/json',
                ])->post($url, [
                    'contents' => [
                        [
                            'role' => 'user',
                            'parts' => [
                                ['text' => $prompt],
                            ],
                        ],
                    ],
                    'generationConfig' => [
                        'temperature' => config('vertexai.temperature'),
                        'maxOutputTokens' => config('vertexai.max_tokens'),
                        'topP' => config('vertexai.top_p'),
                        'topK' => config('vertexai.top_k'),
                    ],
                ]);
            } else {
                // Use Vertex AI endpoint (OAuth2 based)
                $url = sprintf(
                    'https://%s-aiplatform.googleapis.com/v1/projects/%s/locations/%s/publishers/google/models/%s:generateContent',
                    $this->location,
                    $this->projectId,
                    $this->location,
                    $this->model
                );

                $response = Http::withHeaders([
                    'Authorization' => 'Bearer '.$this->accessToken,
                    'Content-Type' => 'application/json',
                ])->post($url, [
                    'contents' => [
                        [
                            'role' => 'user',
                            'parts' => [
                                ['text' => $prompt],
                            ],
                        ],
                    ],
                    'generation_config' => [
                        'temperature' => config('vertexai.temperature'),
                        'maxOutputTokens' => config('vertexai.max_tokens'),
                        'topP' => config('vertexai.top_p'),
                        'topK' => config('vertexai.top_k'),
                    ],
                ]);
            }

            if (! $response->successful()) {
                throw new \Exception('Gemini API error: '.$response->body());
            }

            $data = $response->json();

            if (empty($data['candidates'])) {
                throw new \Exception('No candidates returned from Gemini API');
            }

            if (empty($data['candidates'][0]['content']['parts'])) {
                throw new \Exception('No content parts returned from Gemini API');
            }

            return $data['candidates'][0]['content']['parts'][0]['text'];
        } catch (\Exception $e) {
            Log::error('Gemini API error: '.$e->getMessage());
            throw $e;
        }
    }


    protected function buildSkillMatchingPrompt(array $userSkills, array $allSkills): string
    {
        $userSkillNames = array_column($userSkills, 'name');
        $allSkillNames = array_column($allSkills, 'name');

        return <<<PROMPT
Anda adalah AI assistant yang membantu mencocokkan skill mahasiswa dengan skill yang tersedia.

User saat ini memiliki skill berikut:
{$this->formatArray($userSkillNames)}

Skill yang tersedia di sistem:
{$this->formatArray($allSkillNames)}

Berdasarkan skill yang dimiliki user, rekomendasikan 5 skill berikutnya yang sebaiknya dipelajari untuk meningkatkan kemampuan mereka. Pertimbangkan:
1. Skill yang saling melengkapi
2. Progression path yang natural
3. Skill yang sedang diminati industri

IMPORTANT: Respond ONLY with valid JSON in this exact format:
{
  "recommendations": [
    {
      "skill_name": "nama skill",
      "reason": "alasan mengapa skill ini direkomendasikan",
      "priority": "high/medium/low",
      "estimated_time": "estimasi waktu belajar dalam minggu"
    }
  ]
}
PROMPT;
    }

    protected function buildDevelopmentPathPrompt($userProfile, $userSkills, $targetRole): string
    {
        $skillList = array_column($userSkills, 'name');
        $targetInfo = $targetRole ? "Target role: {$targetRole}" : 'General career development';
        $totalPoin = $userProfile['total_poin'] ?? 0;

        return <<<PROMPT
Anda adalah career advisor AI yang membantu mahasiswa merencanakan development path mereka.

Profil mahasiswa:
- Nama: {$userProfile['name']}
- Skill saat ini: {$this->formatArray($skillList)}
- Total poin: {$totalPoin}
{$targetInfo}

Buatkan development path yang terstruktur dengan tahapan-tahapan konkret. Berikan roadmap pembelajaran yang jelas dengan milestone.

IMPORTANT: Respond ONLY with valid JSON in this exact format:
{
  "path": [
    {
      "phase": "nama fase (contoh: Foundation, Intermediate, Advanced)",
      "duration": "estimasi durasi dalam bulan",
      "skills": ["skill1", "skill2"],
      "projects": ["project1", "project2"],
      "certifications": ["cert1", "cert2"],
      "description": "deskripsi fase ini"
    }
  ],
  "timeline": "total estimasi waktu dalam bulan",
  "tips": ["tips1", "tips2", "tips3"]
}
PROMPT;
    }

    protected function buildCollaborationPrompt($userSkills, $allUsers): string
    {
        $userSkillNames = array_column($userSkills, 'name');

        $userList = array_map(function ($user) {
            return [
                'name' => $user['name'],
                'skills' => array_column($user['skills'] ?? [], 'name'),
                'poin' => $user['total_poin'] ?? 0,
            ];
        }, $allUsers);

        return <<<PROMPT
Anda adalah AI yang membantu mencocokkan mahasiswa untuk kolaborasi berdasarkan skill mereka.

Skill user saat ini:
{$this->formatArray($userSkillNames)}

Mahasiswa lain di sistem:
{$this->formatJson($userList)}

Rekomendasikan 5 mahasiswa yang paling cocok untuk berkolaborasi. Pertimbangkan:
1. Complementary skills (skill yang saling melengkapi)
2. Potential for knowledge exchange
3. Balanced skill levels

IMPORTANT: Respond ONLY with valid JSON in this exact format:
{
  "recommendations": [
    {
      "name": "nama mahasiswa",
      "match_score": 85,
      "complementary_skills": ["skill1", "skill2"],
      "collaboration_ideas": ["ide1", "ide2"],
      "reason": "alasan mengapa cocok untuk kolaborasi"
    }
  ]
}
PROMPT;
    }

    protected function formatArray(array $items): string
    {
        return '- '.implode("\n- ", $items);
    }

    protected function formatJson(array $data): string
    {
        return json_encode($data, JSON_PRETTY_PRINT);
    }

    protected function parseJsonResponse(string $response): array
    {
        // Extract JSON from response (handle cases where AI adds markdown formatting)
        $response = trim($response);

        // Remove markdown code blocks if present
        $response = preg_replace('/^```json\s*/m', '', $response);
        $response = preg_replace('/^```\s*/m', '', $response);

        $decoded = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('Failed to parse Vertex AI response: '.$response);
            throw new \Exception('Invalid JSON response from Vertex AI: '.json_last_error_msg());
        }

        return $decoded;
    }
}
