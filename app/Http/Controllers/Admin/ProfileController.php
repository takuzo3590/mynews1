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
    public function index(Request $request)
    {
        $cond_title = $request->$cond_title;
        if ($cond_title !='') {
            $posts = News::where('title', $cond_title)->get();
        } else {
            $posts = News::al();
        }
        return view('admin.profile.index', ['posts' => $posts, 'cond_title' => $cond_title]);
    }
    public function edit(Request $request)
    {
        $profile = Profile::find($request->id);
        if (empty($profile)) {
            abort(404);
        }
        return view('admin.profile.edit', ['profile_form' => $news]);
    }
    public function update(Request $request)
    {
        $this->validate($request, Profile::$rules);
        $profile = Profile::find($rules->id);
        $profile_form = $request->all();
        unset($profile_form['_token']);
        $profile->fill($prpfile_form)->save();
        return redirect('admin/profile/edit');
    }
    public function delete(Request $request)
    {
        $profile = Profile::find($request->id);
        $profile->delete();
        return redirect('admin/profile/');
    }
   
   
}
