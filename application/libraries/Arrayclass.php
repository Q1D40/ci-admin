<?php

/**
 * 数组操作类
 */
class Arrayclass {

    public static $sortKey;
    public static $sortType;

    /**
     * 构造函数
     */
    public function __construct()
    {
        // TODO
    }

    /**
     * 按照数字子项的一个值排序
     */
    public static function arraySunValueSort($a, $b)
    {
        if ($a[self::$sortKey] == $b[self::$sortKey]) {
            return 0;
        }
        if(self::$sortType == 0)
            return ($a[self::$sortKey] < $b[self::$sortKey]) ? -1 : 1;
        else
            return ($a[self::$sortKey] < $b[self::$sortKey]) ? 1 : -1;
    }

    /**
     * 析构函数
     */
    public function __destruct()
    {
        // TODO
    }
}