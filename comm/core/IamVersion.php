<?php
namespace comm\core;

class IamVersion
{
    public static $version = '2.3.17';
    public static $datetime = '2019-11-06';

    public static function getVersion()
    {
        return self::$version;
    }
}
