<?php

namespace App\Http\Requests\Concerns;

trait SanitizesInput
{
    protected function sanitizeString(?string $value, bool $allowBasicFormatting = false): string
    {
        if (!$value) return '';
        $value = trim($value);

        if ($allowBasicFormatting) {
            // allow minimal tags; strip attributes
            $allowed = '<b><strong><i><em><u><br><p><ul><ol><li>';
            $value = strip_tags($value, $allowed);
            // remove on* handlers & javascript: URIs
            $value = preg_replace('/on\w+\s*=\s*("|').*?\1/i', '', $value);
            $value = preg_replace('/javascript\s*:/i', '', $value);
            return $value;
        }

        return strip_tags($value);
    }
}
