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
    'event'         =>     $host . 'event/event.xml',                   //财经日报
    'news'          =>     $host . 'news/news.xml',                     //财经新闻
    'strong-weak'   =>     $host . 'strong-weak/strong-weak.xml',       //强弱指数
    'ref-bullion'   =>     $host . 'ref/ref-bullion.xml',               //贵金属价位参考
    'ref-forex'     =>     $host . 'ref/ref-forex.xml',                 //外汇价位参考
    'notice'        =>     $host . 'news/notice.xml',                   //英皇公告
    'econ'          =>     $host . 'econ-index/econ-index.xml',         //经济数据
    'xau-eng'       =>     $host . 'commentary/commentary-xau-eng.xml', //1.倫敦黃金
    'xag-eng'       =>     $host . 'commentary/commentary-xag-eng.xml', //2.倫敦白銀
    'eur-eng'       =>     $host . 'commentary/commentary-eur-eng.xml', //3.歐元
    'jpy-eng'       =>     $host . 'commentary/commentary-jpy-eng.xml', //4.日元
    'gbp-eng'       =>     $host . 'commentary/commentary-gbp-eng.xml', //5.英鎊
    'chf-eng'       =>     $host . 'commentary/commentary-chf-eng.xml', //6.端郎
    'aud-eng'       =>     $host . 'commentary/commentary-aud-eng.xml',  //7.澳元
    'nzd-eng'       =>     $host . 'commentary/commentary-nzd-eng.xml',  //8.紐元
    'cad-eng'       =>     $host . 'commentary/commentary-cad-eng.xml',  //9.加元
    'xau'           =>     $host . 'commentary/commentary-xau.xml', //1.倫敦黃金
    'xag'           =>     $host . 'commentary/commentary-xag.xml', //2.倫敦白銀
    'eur'           =>     $host . 'commentary/commentary-eur.xml', //3.歐元
    'jpy'           =>     $host . 'commentary/commentary-jpy.xml', //4.日元
    'gbp'           =>     $host . 'commentary/commentary-gbp.xml', //5.英鎊
    'chf'           =>     $host . 'commentary/commentary-chf.xml', //6.端郎
    'aud'           =>     $host . 'commentary/commentary-aud.xml',  //7.澳元
    'nzd'           =>     $host . 'commentary/commentary-nzd.xml',  //8.紐元
    'cad'           =>     $host . 'commentary/commentary-cad.xml',  //9.加元
    'stock'         =>     $host . 'commentary/commentary-stocks.xml',   //10港股分析
    'yesterday'     =>     $host . 'commentary/commentary-yesterday.xml', //11.昨日总结
    'focus'         =>     $host . 'commentary/commentary-focus.xml',    //12.市场焦距


];