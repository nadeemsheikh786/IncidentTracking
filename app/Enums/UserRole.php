<?php

namespace App\Enums;

enum UserRole: string {
    case ADMIN = 'admin';
    case RESPONDER = 'responder';
    case USER = 'user';

    public static function values(): array {
        return array_map(fn($e) => $e->value, self::cases());
    }
}
