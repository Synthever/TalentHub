<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Models\User;
use App\Services\VertexAIService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AIRecommendationController extends Controller
{
    public function __construct(
        protected VertexAIService $aiService
    ) {}

    public function index(): View
    {
        return view('mahasiswa.ai.index');
    }

    public function skillMatching(): JsonResponse
    {
        try {
            if (! config('vertexai.enabled')) {
                return response()->json([
                    'error' => 'AI features are currently disabled',
                ], 503);
            }

            $user = Auth::user();
            $userSkills = $user->skills()->with('skill')->get()->map(function ($userSkill) {
                return [
                    'id' => $userSkill->skill->id,
                    'name' => $userSkill->skill->name,
                ];
            })->toArray();

            if (empty($userSkills)) {
                return response()->json([
                    'recommendations' => [],
                    'message' => 'Anda belum memiliki skill. Tambahkan skill terlebih dahulu untuk mendapatkan rekomendasi.',
                ]);
            }

            $allSkills = Skill::all()->map(function ($skill) {
                return [
                    'id' => $skill->id,
                    'name' => $skill->name,
                ];
            })->toArray();

            $recommendations = $this->aiService->generateSkillMatching($userSkills, $allSkills);

            return response()->json($recommendations);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to generate skill recommendations',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function developmentPath(Request $request): JsonResponse
    {
        try {
            if (! config('vertexai.enabled')) {
                return response()->json([
                    'error' => 'AI features are currently disabled',
                ], 503);
            }

            $user = Auth::user();

            $userProfile = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'total_poin' => DB::table('points')
                    ->where('user_id', $user->id)
                    ->sum('jumlah'),
            ];

            $userSkills = $user->skills()->with('skill')->get()->map(function ($userSkill) {
                return [
                    'id' => $userSkill->skill->id,
                    'name' => $userSkill->skill->name,
                    'level' => $userSkill->level,
                ];
            })->toArray();

            if (empty($userSkills)) {
                return response()->json([
                    'path' => [],
                    'message' => 'Anda belum memiliki skill. Tambahkan skill terlebih dahulu untuk mendapatkan development path.',
                ]);
            }

            $targetRole = $request->input('target_role');

            $path = $this->aiService->generateDevelopmentPath($userProfile, $userSkills, $targetRole);

            return response()->json($path);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to generate development path',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function collaboration(): JsonResponse
    {
        try {
            if (! config('vertexai.enabled')) {
                return response()->json([
                    'error' => 'AI features are currently disabled',
                ], 503);
            }

            $user = Auth::user();

            $userSkills = $user->skills()->with('skill')->get()->map(function ($userSkill) {
                return [
                    'id' => $userSkill->skill->id,
                    'name' => $userSkill->skill->name,
                ];
            })->toArray();

            if (empty($userSkills)) {
                return response()->json([
                    'recommendations' => [],
                    'message' => 'Anda belum memiliki skill. Tambahkan skill terlebih dahulu untuk mendapatkan rekomendasi kolaborasi.',
                ]);
            }

            // Get other users with their skills
            $allUsers = User::where('role', 'mahasiswa')
                ->where('id', '!=', $user->id)
                ->with(['skills.skill', 'profile'])
                ->get()
                ->map(function ($otherUser) {
                    return [
                        'id' => $otherUser->id,
                        'name' => $otherUser->name,
                        'skills' => $otherUser->skills->map(fn ($us) => [
                            'name' => $us->skill->name,
                        ])->toArray(),
                        'total_poin' => DB::table('points')
                            ->where('user_id', $otherUser->id)
                            ->sum('jumlah'),
                    ];
                })
                ->toArray();

            if (empty($allUsers)) {
                return response()->json([
                    'recommendations' => [],
                    'message' => 'Belum ada mahasiswa lain di sistem.',
                ]);
            }

            $recommendations = $this->aiService->generateCollaborationRecommendations(
                $user->id,
                $userSkills,
                $allUsers
            );

            return response()->json($recommendations);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to generate collaboration recommendations',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
