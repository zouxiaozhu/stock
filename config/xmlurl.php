<?php
/**
 * Created by PhpStorm.
 * Date: 2017/12/11
 * Time: 下午11:59
 */


/*
|--------------------------------------------------------------------------
| Defined remote host;
|--------------------------------------------------------------------------
*/
$host = 'http://www.mw801.com/appcn/';


/*
|--------------------------------------------------------------------------
| Return url which use to get xml data;
|--------------------------------------------------------------------------
*/
return [
    'event'         =>     $host . 'event/event.xml',               //财经日报
    'news'          =>     $host . 'news/news.xml',                 //财经新闻
    'strong-weak'   =>     $host . 'strong-weak/strong-weak.xml',   //强弱指数
    'ref-bullion'   =>     $host . 'ref/ref-bullion.xml',           //贵金属价位参考
    'ref-forex'     =>     $host . 'ref-forex.xml',                 //外汇价位参考
];