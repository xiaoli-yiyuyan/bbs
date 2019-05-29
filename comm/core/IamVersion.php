<?php
namespace comm\core;

class IamVersion
{
    public static $version = '2.1.1';
    public static $datetime = '2019-05-29';

    public static function getVersion()
    {
        return self::$version;
    }
}
