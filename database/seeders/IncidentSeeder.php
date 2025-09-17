<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Incident;

class IncidentSeeder extends Seeder
{
    public function run(): void
    {
        $reporter = User::where('email', 'user@example.com')->first();
        $assignee = User::where('email', 'responder1@example.com')->first();

        if (!$reporter) return;

        $samples = [
            ['title' => 'Low severity sample incident',      'severity' => 'low'],
            ['title' => 'Medium severity sample incident',   'severity' => 'medium'],
            ['title' => 'High severity sample incident',     'severity' => 'high'],
            ['title' => 'Critical severity sample incident', 'severity' => 'critical'],
        ];

        foreach ($samples as $s) {
            Incident::updateOrCreate(
                ['user_id' => $reporter->id, 'title' => $s['title']],
                [
                    'description' => 'Sample description for '.$s['severity'].' incident.',
                    'severity'    => $s['severity'],
                    'status'      => 'open',
                    'assigned_to' => $assignee?->id,
                ]
            );
        }
    }
}
