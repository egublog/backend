<?php

namespace App\Http\Controllers;


class FindController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 検索の変数が空だとエラーになるから入れる(era_id team_id)
        return view('myService.find')->with([
            'era_id' => 1,
            'team_string' => '',
        ]);
    }

}
