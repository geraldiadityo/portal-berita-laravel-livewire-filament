<?php

namespace App\Repositories;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingRepository
{
    public function clearCache(): void
    {
        Cache::forget('global_settings');
    }

    public function getAll(): array
    {
        return Cache::rememberForever('global_settings', function () {
            return Setting::pluck('value', 'key')->toArray();
        });
    }

    public function get(string $key, $default = null)
    {
        $setting = $this->getAll();

        return $setting[$key] ?? $default;
    }

    public function update(array $data): void
    {
        foreach ($data as $key => $value) {
            if ($value !== null) {
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value]
                );
            }
        }

        $this->clearCache();
    }
}
