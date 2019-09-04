<?php
namespace comm\core;

class IamVersion
{
    public static $version = '2.3.8';
    public static $datetime = '2019-09-04';

    public static function getVersion()
    {
        return self::$version;
    }
}
