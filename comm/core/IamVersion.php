<?php
namespace comm\core;

class IamVersion
{
    public static $version = '2.0.1';
    public static $datetime = '2019-04-01';

    public static function getVersion()
    {
        return self::$version;
    }
}
