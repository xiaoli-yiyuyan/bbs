<?php
namespace comm\core;

class IamVersion
{
    public static $version = '2.3.19';
    public static $datetime = '2019-11-08';

    public static function getVersion()
    {
        return self::$version;
    }
}
