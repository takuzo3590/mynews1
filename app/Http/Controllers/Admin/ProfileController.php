<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Profile;

class ProfileController extends Controller
{
    //
    public function add()
    {
        return view('admin.profile.create');
    }
    public function create(Request $request)
    {
        // validationの実行
        $this->validate($request, Profile::$rules);
        $profile = new Profile;
        $form = $request->all();
        //  フォームから送られてきた_tokenを削除
         unset($form['_token']);
        //  フォームから送信されてきた imageを削除
         unset($form['image']);
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
