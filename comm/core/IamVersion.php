<?php
namespace comm\core;

class IamVersion
{
    public static $version = '2.1.0';
    public static $datetime = '2019-05-28';

    public static function getVersion()
    {
        return self::$version;
    }
}
