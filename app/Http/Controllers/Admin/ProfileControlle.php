<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\profile;

class ProfileControlle extends Controller
{
    //
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
        
        $profile->fill($form);
        $profile->save();
          
        return redirect('admin/profile/create');
    }
    
    public function edit()
    {
        return view('admin.profile.edit');
    }
    
    public function update()
    {
        return redirect('admin/profile/edit');
    }
}
