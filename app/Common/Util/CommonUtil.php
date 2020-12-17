<?php
/**
 * Created by shaofeng
 * Date: 2020/12/11 15:15
 * 常用工具类
 */

namespace App\Common\Util;


class CommonUtil
{
    public static function isEmpty($string): bool
    {
        if ($string == null || empty($string)) {
            return true;
        }
        return false;
    }

    public static function isNull($object): bool
    {
        return $object == null;
    }

    public static function isNotEmpty($string): bool
    {
        return !self::isEmpty($string);
    }
}