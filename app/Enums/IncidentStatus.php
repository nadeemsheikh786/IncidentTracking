<?php

namespace App\Enums;

enum IncidentStatus: string {
    case OPEN = 'open';
    case IN_PROGRESS = 'in_progress';
    case RESOLVED = 'resolved';

    public static function values(): array {
        return array_map(fn($e) => $e->value, self::cases());
    }
}
