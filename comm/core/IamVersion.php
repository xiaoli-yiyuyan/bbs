<?php
namespace comm\core;

class IamVersion
{
    public static $version = '2.3.20';
    public static $datetime = '2019-11-11';

    public static function getVersion()
    {
        return self::$version;
    }
}
