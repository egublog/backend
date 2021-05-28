<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Talk;
use Illuminate\Support\Arr;


class MyhomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $myAccount = Auth::user();
       
        // 自分のプロフィール表示用に自分のアカウント情報を付ける (myAccount)
        return view('myService.home')->with([
            'myAccount' => $myAccount,
        ]);
    }

}
