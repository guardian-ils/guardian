<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Config;

if (!function_exists('preference')) {

    /**
     * @param string $name
     * @param mixed $fallback
     *
     * @return mixed|null
     */
    function preference($name, $fallback = null)
    {
        $value = env($name);
        if ($value !== null) {
            return $value;
        }

        $value = config($name);
        if ($value !== null) {
            return $value;
        }

        // Try to load from cache
        $value = Cache::get("config:{$name}");
        if ($value !== null) {
            return $value;
        }

        try {
            $modal = Config::findOrFail($name);
            $value = $modal->value;
            Cache::forever("config:{$name}", $value);
        } catch (ModelNotFoundException $e) {
            Cache::forever("config:{$name}", $fallback);

            return $fallback;
        }

        return $value;
    }
}
