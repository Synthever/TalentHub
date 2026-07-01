# TalentHub Database Schema

## 1. Talents
- id (INT, PK)
- name (VARCHAR)
- skills (JSON - e.g., ["Flutter", "PHP", "AI"])
- experience_years (INT)
- bio (TEXT)

## 2. Jobs
- id (INT, PK)
- company_name (VARCHAR)
- job_title (VARCHAR)
- required_skills (JSON)
- description (TEXT)

## 3. Matches (Result)
- id (INT, PK)
- talent_id (FK)
- job_id (FK)
- match_score (FLOAT)
- reasoning (TEXT)
