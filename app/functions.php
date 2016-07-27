<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Guardian\Models\Config;

if (!function_exists('apcu_fetch') && function_exists('apc_fetch')) {
    function apcu_fetch($key, &$success) {
        return apc_fetch($key, $success);
    }
}

if (!function_exists('apcu_store') && function_exists('apc_store')) {
    function apcu_store() {
        return call_user_func_array('apc_store', func_get_args());
    }
}


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
