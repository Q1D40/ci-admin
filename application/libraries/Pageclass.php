<?php

/**
 * 分页类
 */
class Pageclass {

    /**
     * 构造函数
     */
    public function __construct()
    {
        // TODO
    }

    /**
     * 获取分页
     */
    public static function getPage($current, $total)
    {
        $page['current'] = $current;

        if($current <= 1)
            $page['pre'] = 0;
        else
            $page['pre'] = $current - 1;

        if($current >= $total)
            $page['next'] = 0;
        else
            $page['next'] = $current + 1;

        if($current > 5){
            $page['left'] = array(1, 2, '...', ($current - 2), ($current - 1));
        }else{
            for($i = 1; $i < $current; $i++){
                $page['left'][] = $i;
            }
        }

        if(($total - $current) > 3){
            if($current > 2){
                $page['right'] = array(($current + 1), ($current + 2), '...');
            }else{
                for($i = 1; $i <= (5 - $current); $i++){
                    $page['right'][] = $current + $i;
                }
                $page['right'][] = '...';
            }
        }else{
            for($i = ($current + 1); $i <= $total; $i++){
                $page['right'][] = $i;
            }
        }

        return $page;
    }

    /**
     * 析构函数
     */
    public function __destruct()
    {
        // TODO
    }
}