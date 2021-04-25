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
    
    
       
            // $allEra1 = $myAccount->alls()->where('era_id', 1)->first();
            // $allEra2 = $myAccount->alls()->where('era_id', 2)->first();
            // $allEra3 = $myAccount->alls()->where('era_id', 3)->first();
            // $allEra4 = $myAccount->alls()->where('era_id', 4)->first();
    
       
            //     $elementaryTeam = $allEra1->team->team_name;
            //     $elementaryPosition = $allEra1->position_id;
     
            //     $juniorHighTeam = $allEra2->team->team_name;
            //     $juniorHighPosition = $allEra2->position_id;
        
            //     $highTeam = $allEra3->team->team_name;
            //     $highPosition = $allEra3->position_id;
           
            //     $universityTeam = $allEra4->team->team_name;
            //     $universityPosition = $allEra4->position_id;
         
            // $schools = array(
            //     array('小学校の所属チーム', 'elementaryTeam', 'elementaryPosition', $elementaryTeam, $elementaryPosition),
            //     array('中学校の所属チーム', 'juniorHighTeam', 'juniorHighPosition', $juniorHighTeam, $juniorHighPosition),
            //     array('高校の所属チーム', 'highTeam', 'highPosition', $highTeam, $highPosition),
            //     array('大学の所属チーム', 'universityTeam', 'universityPosition', $universityTeam, $universityPosition)
            // );

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
          
             // ↓　ここで画像のデータを表す意味わかんない長い文字列を$imageに入れる
            $image = $request->file('image');
            // ↓　ここで画像データをS3に保存(/testにpublicで).  そのS3の中での画像のパスを$pathに保存
            $path = Storage::disk('s3')->putFile('test', $image, 'public');
            // こっち側からS3の中のそのファイルまでのフルパスをUserテーブルのimageカラムに保存
            $myAccount->image = Storage::disk('s3')->url($path);
            $myAccount->save();


            $areas = Area::all();
    
    
            // $myId = Auth::id();

            
    
            
            $area_id = $myAccount->area_id;
    
    
       
            // $allEra1 = $myAccount->alls()->where('era_id', 1)->first();
            // $allEra2 = $myAccount->alls()->where('era_id', 2)->first();
            // $allEra3 = $myAccount->alls()->where('era_id', 3)->first();
            // $allEra4 = $myAccount->alls()->where('era_id', 4)->first();
    
       
            //     $elementaryTeam = $allEra1->team->team_name;
            //     $elementaryPosition = $allEra1->position_id;
     
            //     $juniorHighTeam = $allEra2->team->team_name;
            //     $juniorHighPosition = $allEra2->position_id;
        
            //     $highTeam = $allEra3->team->team_name;
            //     $highPosition = $allEra3->position_id;
           
            //     $universityTeam = $allEra4->team->team_name;
            //     $universityPosition = $allEra4->position_id;
         
            // $schools = array(
            //     array('小学校の所属チーム', 'elementaryTeam', 'elementaryPosition', $elementaryTeam, $elementaryPosition),
            //     array('中学校の所属チーム', 'juniorHighTeam', 'juniorHighPosition', $juniorHighTeam, $juniorHighPosition),
            //     array('高校の所属チーム', 'highTeam', 'highPosition', $highTeam, $highPosition),
            //     array('大学の所属チーム', 'universityTeam', 'universityPosition', $universityTeam, $universityPosition)
            // );
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
