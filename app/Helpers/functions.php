<?php
/**
 * Created by PhpStorm.
 * Date: 2017/12/11
 * Time: 下午11:59
 * =================================================================
 */



/**
 * @params $url xml数据源地址
 * 通过url获取xml数据源并将xml字符串转换为php数组返回
 */
if (!function_exists('xml2arr')) {
    function xml2arr($url) {
        //url不存在或为空返回空数组
        if (!isset($url) || empty($url)) return [];
        //获取xml数据并转换为数组返回
        $content = file_get_contents($url);
        //获取xml数据,包括<![CDATA[]]>部分
        $xml = simplexml_load_string($content, null, LIBXML_NOCDATA);
        $xml2json = json_encode($xml);
        $data = json_decode($xml2json, true);
        return $data;
    }
}