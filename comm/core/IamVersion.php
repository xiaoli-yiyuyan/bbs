<?php
namespace comm\core;

class IamVersion
{
    public static $version = '2.2.0';
    public static $datetime = '2019-07-23';

    public static function getVersion()
    {
        return self::$version;
    }
}
