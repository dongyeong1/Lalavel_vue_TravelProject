<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class PaypalController extends Controller
{
    public function index(Request $request)
    //index함수에선 판매에 필요한 상품정보를 준비
    {
        $product_info = array('pd_id' => '1', 'description' => 'paypal test product', 'amount' => array('value' => '0.01', 'currency' => config('paypal.currency')));
        return view('index', ['product_info' => $product_info]);
    }
}
