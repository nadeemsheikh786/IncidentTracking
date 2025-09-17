<?php

namespace App\Enums;

enum IncidentSeverity: string {
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';
    case CRITICAL = 'critical';

    public static function values(): array {
        return array_map(fn($e) => $e->value, self::cases());
    }
}
