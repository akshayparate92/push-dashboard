<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function __construct()
    {
        
    }

    public function showSendPush(){

        return view('admin.delivery.index-send');
    }
}
