<?php
namespace comm\core;

class IamVersion
{
    public static $version = '2.3.15';
    public static $datetime = '2019-10-31';

    public static function getVersion()
    {
        return self::$version;
    }
}
