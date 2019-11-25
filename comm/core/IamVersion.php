<?php
namespace comm\core;

class IamVersion
{
    public static $version = '2.4.1';
    public static $datetime = '2019-11-25';

    public static function getVersion()
    {
        return self::$version;
    }
}
