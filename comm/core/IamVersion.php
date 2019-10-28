<?php
namespace comm\core;

class IamVersion
{
    public static $version = '2.3.14';
    public static $datetime = '2019-10-28';

    public static function getVersion()
    {
        return self::$version;
    }
}
