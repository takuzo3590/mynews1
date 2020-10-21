<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Profile;
use App\ProfileHistory;
use Carbon\Carbon;
use Auth;

class ProfileController extends Controller
{
    //
    public function add()
    {
        if (Auth::user()->profile==NULL){
        return view('admin.profile.create');
        } else {
            return redirect('profile');
        }
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
         $profile->user_id = Auth::id();
         $profile->save();
         
        return redirect('admin/profile/create');
    }
    public function index(Request $request)
    {
        $cond_name = $request->cond_name;
        if ($cond_name !='') {
            $posts = Profile::where('name', $cond_name)->get();
        } else {
            $posts = Profile::all();
        }
        return view('admin.profile.index', ['posts' => $posts, 'cond_name' => $cond_name]);
    }
    public function edit(Request $request)
    {
        $profile = Profile::find($request->id);
        if (empty($profile)) {
            abort(404);
        }
        return view('admin.profile.edit', ['profile_form' => $profile]);
    }
    public function update(Request $request)
    {
        $this->validate($request, Profile::$rules);
        
        $profile = Profile::find($request->id);
        if (empty($profile)) {
            abort(404);
        }
        
        $profile_form = $request->all();
        unset($profile_form['_token']);
        unset($profile_form['remove']);
        $profile->fill($profile_form)->save();
        
        $profile_history = new ProfileHistory;
        $profile_history->profile_id = $profile->id;
        $profile_history->edited_at = Carbon::now();
        $profile_history->save();
        
        return redirect('admin/profile');
    }
    public function delete(Request $request)
    {
        $profile = Profile::find($request->id);
        $profile->delete();
        
        return redirect('admin/profile/');
    }
   
   
}
