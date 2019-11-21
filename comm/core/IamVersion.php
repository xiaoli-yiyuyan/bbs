<?php
namespace comm\core;

class IamVersion
{
    public static $version = '2.4.0';
    public static $datetime = '2019-11-21';

    public static function getVersion()
    {
        return self::$version;
    }
}
