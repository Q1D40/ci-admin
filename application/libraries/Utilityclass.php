<?php

/**
 * 工具类
 */
class Utilityclass {

    /**
     * 构造函数
     */
    public function __construct()
    {
        // TODO
    }

    /**
     * 把数据导出Excel
     *
     * @param array $data 数据数组
     * @Description
     *  $data['title'] 标题数组
     *  $data['list'] 数据数组
     */
    public static function exportExcel($data)
    {
        header("Content-type:application/vnd.ms-excel;");
        header("Content-Disposition:attachment;filename=export_data.xls");
        $str = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
         <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
         <html>
             <head>
                <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
             </head>
             <body>
                     <table border="1">';
        $str .= '<tr>';
        foreach($data['title'] as $row){
            $str .= '<th>' . $row . '</th>';
        }
        $str .= '</tr>';
        foreach($data['list'] as $row){
            $str .= '<tr>';
            foreach($row as $r){
                $str .= '<td>' . $r . '</td>';
            }
            $str .= '</tr>';
        }
        $str .= '</table>
             </body>
         </html>';
        die($str);
    }

    /**
     * 析构函数
     */
    public function __destruct()
    {
        // TODO
    }
}