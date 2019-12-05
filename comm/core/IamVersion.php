<?php
namespace comm\core;

class IamVersion
{
    public static $version = '2.4.2';
    public static $datetime = '2019-12-05';

    public static function getVersion()
    {
        return self::$version;
    }
}
