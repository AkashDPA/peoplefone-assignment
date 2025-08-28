<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PhoneValidationService
{
    /**
     * Validate a phone number via external API.
     */
    public static function validate(string $phone): bool
    {
        try {
            $url = config('services.abstractapi.endpoint');
            $response = Http::get($url, [
                'phone' => $phone,
                'api_key' => config('services.abstractapi.key'),
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['valid'] ?? false;
            }

            return false;
        } catch (\Exception $e) {
            Log::error('Phone validation failed', [
                'phone' => $phone,
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }
}
