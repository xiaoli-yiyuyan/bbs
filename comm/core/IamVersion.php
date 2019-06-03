<?php
namespace comm\core;

class IamVersion
{
    public static $version = '2.1.5';
    public static $datetime = '2019-06-03';

    public static function getVersion()
    {
        return self::$version;
    }
}
