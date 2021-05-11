<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Area;
use Illuminate\Support\Facades\Storage;
use App\Facades\Profile;



class ImageController extends Controller
{
  
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        {
            $areas = Area::all();
    
            // $myId = Auth::id();
            // $myAccount = User::find($myId);
            $myAccount = Auth::user();
            
            $area_id = $myAccount->area_id;

            $schools = Profile::returnSchoolsArrayes($myAccount);

            return view('myService.profile')->with([
                'areas' => $areas,
                'myAccount' => $myAccount,
                'area_id' => $area_id,
                'schools' => $schools,
            ]);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
    public function update(ImageRequest $request, $id)
    {
        {


            // $myAccount = User::find($myId);
            $myAccount = Auth::user();
          
            //  // ↓　ここで画像のデータを表す意味わかんない長い文字列を$imageに入れる
            // $image = $request->file('image');
            // // ↓　ここで画像データをS3に保存(/testにpublicで).  そのS3の中での画像のパスを$pathに保存
            // $path = Storage::disk('s3')->putFile('test', $image, 'public');
            $path = Profile::saveImageToDatabaseAndReturnThePath($request);


            // こっち側からS3の中のそのファイルまでのフルパスをUserテーブルのimageカラムに保存
            // $myAccount->image = Storage::disk('s3')->url($path);
            // $myAccount->save();
            Profile::saveImagePathToUsersTable($path);

            $areas = Area::all();
            
            $area_id = $myAccount->area_id;
    
            $schools = Profile::returnSchoolsArrayes($myAccount);


            return view('myService.profile')->with([
                'areas' => $areas,
                'myAccount' => $myAccount,
                'area_id' => $area_id,
                'schools' => $schools,
            ]);
        }
    }


    
}
