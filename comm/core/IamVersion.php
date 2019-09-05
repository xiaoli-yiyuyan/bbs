<?php
namespace comm\core;

class IamVersion
{
    public static $version = '2.3.10';
    public static $datetime = '2019-09-05';

    public static function getVersion()
    {
        return self::$version;
    }
}
