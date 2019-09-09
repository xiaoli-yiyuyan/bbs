<?php
namespace comm\core;

class IamVersion
{
    public static $version = '2.3.12';
    public static $datetime = '2019-09-09';

    public static function getVersion()
    {
        return self::$version;
    }
}
