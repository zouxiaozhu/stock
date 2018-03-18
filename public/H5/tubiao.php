<?php
/**
 * Created by PhpStorm.
 * User: qfkin
 * Date: 2018/1/12
 * Time: 21:21
 */


$rows['LLG']=array('LLG','倫敦金','xau');
$rows['LLS']=array('LLS','倫敦銀','xag');
$rows['HKG']=array('HKG','港金','hkg');
$rows['Plat']=array('Plat.','白金','xpt');
$rows['LGLS']=array('LGLS','黃金白銀','XAU-XAG');
$rows['LGEU']=array('LGEU','黃金歐元','LGEU');
$rows['LGJP']=array('LGJP','黃金日圓','LGJP');
$rows['LGGP']=array('LGGP','黃金英鎊','gbp');
$rows['LGAU']=array('LGAU','黃金澳元','LGAU');


$rows['EUR']=array('EUR','歐元','eur');
$rows['JPY']=array('JPY','日圓','jpy');
$rows['GBP']=array('GBP','英鎊','gbp');
$rows['CHF']=array('CHF','瑞郎','chf');
$rows['AUD']=array('AUD','澳元','aud');
$rows['NZD']=array('NZD','紐元','nzd');
$rows['CAD']=array('CAD','加元','cad');
$rows['USD']=array('USD','美元','usd');
$rows['CNH']=array('CNH','人民幣','cnh');


$rows['EUJP']=array('EUJP','歐元日圓','eurjpy');
$rows['EUCF']=array('EUCF','歐元瑞郎','eurchf');
$rows['EUGP']=array('EUGP','歐元英鎊','eurgbp');
$rows['GPJP']=array('GPJP','英鎊日圓','gbpjpy');
$rows['CFJP']=array('CFJP','瑞郎日圓','chfjpy');
$rows['AUJP']=array('AUJP','澳元日圓','audjpy');
$rows['AUNZ']=array('AUNZ','澳元紐元','audnzd');


$rows['OIL']=array('OIL','原油','oil');
$rows['COPPER']=array('COPPER','銅','hg');
$rows['CRB']=array('CRB','商品期貨指數','crb');
$rows['HSI']=array('HSI','恒生指數','hsi');
$rows['SSECI']=array('SSECI','上海綜合指數','ssec');
$rows['DOW']=array('DOW','道瓊斯指數','dow');
$rows['SPX']=array('SPX','標準普爾','spx');
$rows['NDX']=array('NDX','納斯達克','ndx');

    foreach ($rows as $key => $row){
        echo "<br>";
        $n=$row[2];
        if($key == 'HKG'){
            echo $row[1]."($row[0]) $n";
            url_hkg($n);
             continue;
        }

        echo $row[1]."($row[0]) ";
        url($n);

    }

    function url($n){
        if(preg_match('/^[A-Z]+$/', substr($n,0,2))){
            echo  "<img src='http://www.mw801.com/website2/Graphs/".$n."_D.png  ' height ='40' width='60' />";
            echo  "<img src='http://www.mw801.com/website2/Graphs/".$n."_L_D.png ' height ='40' width='60' />  ";
            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            echo  "<img src='http://www.mw801.com/website2/Graphs/".$n."_W.png  ' height ='40' width='60' /> ";
            echo  "<img src='http://www.mw801.com/website2/Graphs/".$n."_L_W.png ' height ='40' width='60' />  ";
            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            echo  "<img src='http://www.mw801.com/website2/Graphs/".$n."_M.png  ' height ='40' width='60' /> ";
            echo  "<img src='http://www.mw801.com/website2/Graphs/".$n."_L_M.png  ' height ='40' width='60' /> ";
        }else{
            echo  "<img src='http://www.mw801.com/website2/Graphs/".$n."_d.png  ' height ='40' width='60' />";
            echo  "<img src='http://www.mw801.com/website2/Graphs/".$n."_l_d.png ' height ='40' width='60' />  ";
            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            echo  "<img src='http://www.mw801.com/website2/Graphs/".$n."_w.png  ' height ='40' width='60' /> ";
            echo  "<img src='http://www.mw801.com/website2/Graphs/".$n."_l_w.png ' height ='40' width='60' />  ";
            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            echo  "<img src='http://www.mw801.com/website2/Graphs/".$n."_m.png  ' height ='40' width='60' /> ";
            echo  "<img src='http://www.mw801.com/website2/Graphs/".$n."_l_m.png  ' height ='40' width='60' /> ";
        }



    }
function url_hkg($n){
    echo  "<img src='http://www.mw801.com/website2/Graphs/".$n."_d.png' height ='40' width='60' />  ";
    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    echo  "<img src='http://www.mw801.com/website2/Graphs/".$n."_w.png' height ='40' width='60' /> ";
    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    echo  "<img src='http://www.mw801.com/website2/Graphs/".$n."_m.png' height ='40' width='60' />  ";


}