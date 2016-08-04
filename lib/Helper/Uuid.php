<?php

namespace Guardian\Helper;


abstract class Uuid
{
    const NIL = '00000000-0000-0000-0000-000000000000';

    public static function valid($uuid)
    {
        return preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $uuid) !== 0;
    }

    public static function nil()
    {
        return static::NIL;
    }
}