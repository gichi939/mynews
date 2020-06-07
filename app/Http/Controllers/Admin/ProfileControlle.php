<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Profile;

use App\ProfileHistories;
use carbon\carbon;

class ProfileControlle extends Controller
{
    
    public function add()
    {
        return view('admin.profile.create');
    }
    
    public function create(Request $request)
    {
        // Validationを行う
        $this->validate($request, Profile::$rules);
        
        $profile = new Profile;
        $form = $request->all();
        
        
        unset($form['_token']);
        
        unset($form['image']);
        
        
        // $profile->gender = $request->gender;
        $profile->fill($form);
        $profile->save();
          
        return redirect('admin/profile/create');
        
    }
    
     public function index(Request $request)
  {
      $cond_title = $request->cond_title;
      if ($cond_title != '') {
          $posts = Profile::where('name', $cond_title)->get();
      } else {
          $posts = Profile::all();
      }
      return view('admin.profile.index', ['posts' => $posts, 'cond_title' => $cond_title]);
  }
    
   public function edit(Request $request)
  {
      // profile Modelからデータを取得する
      $profile = Profile::find($request->id);
      if (empty($profile)) {
        abort(404);    
      }
      return view('admin.profile.edit', ['profile_form' => $profile]);
  }
    
    public function update(Request $request)
    {
       $this->validate($request, Profile::$rules);
      // profile Modelからデータを取得する
      $profile = Profile::find($request->id);
      // 送信されてきたフォームデータを格納する
      $profile_form = $request->all();
      if (isset($profile_form['image'])) {
        $path = $request->file('image')->store('public/image');
        $profile->image_path = basename($path);
        unset($profile_form['image']);
      } elseif (isset($request->remove)) {
        $profile->image_path = null;
        unset($profile_form['remove']);
      }
      unset($profile_form['_token']);

      // 該当するデータを上書きして保存する
        $profile->fill($profile_form)->save();
      
        $profilehistory = new ProfileHistories;
        $profilehistory->profile_id = $profile->id;
        $profilehistory->edited_at = Carbon::now();
        $profilehistory->save();
        
      return redirect('admin/profile');
  }
  
   public function delete(Request $request)
  {
      $profile = Profile::find($request->id);
      
      $profile->delete();
      return redirect('admin/profile/');
  }
}
