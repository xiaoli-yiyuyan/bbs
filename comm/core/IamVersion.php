<?php
namespace comm\core;

class IamVersion
{
    public static $version = '2.3.2';
    public static $datetime = '2019-09-03';

    public static function getVersion()
    {
        return self::$version;
    }
}
