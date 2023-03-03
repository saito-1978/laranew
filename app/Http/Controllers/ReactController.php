<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReactController extends Controller
{
    public function index(Request $request)
    {

        return view('/react.index');
        
    }

    
}
