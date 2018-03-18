<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ChartsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->waihui();
        $this->jinshu();
        $this->jioachapan();
        $this->qihuo();

    }

    public function waihui()
    {
        $waihui = [];

        $insert_key =['eur','jpy','gbp','chf','aud','nzd','cad','usd','cnh'];
        $chinese_key = ['欧元(EUR)','日元(JPY)','英镑(GBP)','瑞郎(CHF)'
            ,'澳元(AUD)','纽元(NZD)','加元(CAD)','美元(USD)','人民币(CNH)'];

        foreach ($insert_key as $k=>$key){
            $waihui[] = ['name'=>$chinese_key[$k],'key'=>$key];
        }

         DB::table('waihui_chart')->insert($waihui);
    }

    public function jinshu()
    {
        $jinshu = [];

        $insert_key =['llg','lls','hkg','plat','lgls','lenu','lgjp','lggp','lgau'];
        $chinese_key = ['伦敦金(LLG)','伦敦银(LLS)','港金(HKG)','白金(PLAT)'
            ,'黄金白银(LGLS)','黄金欧元(LGEU)','黄金日圆(LGJP)','黄金英镑(LGGP)','黄金澳元(LGAU)'];

        foreach ($insert_key as $k=>$key){
            $jinshu[] = ['name'=>$chinese_key[$k],'key'=>$key];
        }

        DB::table('jinshu_chart')->insert($jinshu);
    }

    public function jioachapan()
    {
        $insert_key =['eujp','eucf','eugp','gpjp','cfjp','aujp','aunz'];
        $chinese_key = ['歐元日圓(EUJP)','歐元瑞郎(EUCF) ','歐元英鎊(EUGP)','英鎊日圓(GPJP'
            ,'瑞郎日圓(CFJP) ','澳元日圓(AUJP)','澳元紐元(AUNZ)'];
        foreach ($insert_key as $k=>$key){
            $jiaochapan[] = ['name'=>$chinese_key[$k],'key'=>$key];
        }
        DB::table('jiaochapan_chart')->insert($jiaochapan);
    }

    public function qihuo()
    {
        $insert_key =['oil','copper','crb','hsi','sseci','dow','spx','ndx'];
        $chinese_key = ['原油(OIL)','銅(COPPER)','商品期貨指數(CRB)','恒生指數(HSI)'
            ,'上海綜合指數SSECI)','道瓊斯指數(DOW)','標準普爾(SPX)','納斯達克(NDX)'];
        foreach ($insert_key as $k=>$key){
            $qihuo[] = ['name'=>$chinese_key[$k],'key'=>$key];
        }
        DB::table('qihuo_chart')->insert($qihuo);
    }

}
