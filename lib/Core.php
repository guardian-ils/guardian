<?php

namespace Guardian;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Guardian\Models\Config;


class Core {

    /**
     * @param string $name
     * @param mixed $fallback
     *
     * @return mixed|null
     */
    public static function preference($name, $fallback = null)
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
