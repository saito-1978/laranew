<?php

namespace App\Http\Controllers;

use App\Models\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Models\Stock;
use Illuminate\Support\Facades\Auth;



class TestController extends Controller
{
    

    public function index(){
       
        return view('test');

    }

    
    
}