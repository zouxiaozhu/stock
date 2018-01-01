<?php
namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;

class Chart extends \App\Http\Controllers\Controller{


    public function __construct()
    {

    }


    public function addChart(Request $request)
    {
//        $type = ['jinshu','waihui','qihuo','jiaochapan'];
        $type  = $request->get('type','jinshu');



    }
}