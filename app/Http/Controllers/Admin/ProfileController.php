<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use app\profile;

class ProfileController extends Controller
{
    //
    public function add()
    {
        return view('admin.profile.create');
    }
    public function create()
    {
        // validationの実行
         $this->validate($request, profile::$rules);
         $profile = new profile;
         $form = $request->all();
        //  フォームから送られてきた_tokenを削除
         unset($form['token']);
        //  データベースに保存
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
