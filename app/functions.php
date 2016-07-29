<?php

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
