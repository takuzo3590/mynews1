<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\News;

class NewsController extends Controller
{
    public function add()
    {
        return view ('admin.news.create');
    }
    public function create(Request $request)
    {
        // validation
        $this->validate($request, News::$rules);
        $news = new News;
        $form = $request->all();
        // フォームに送られてきた画像を保存してパスを保存する
        if (isset($form['image'])){
            $path = $request->file('image')->store('public/image');
            $news->image_path = basename($path);
        }else{
            $news->image_path = null;
        }
        // フォームから送られきた_tokenを削除
        unset($form['_token']);
        // フォームから送られてきたimageを削除
        unset($form['image']);
        
        // データベースに保存
        $news->fill($form);
        $news->save();
        
        return redirect('admin/news/create');
    }
    public function index(Request $request)
    {
        $cond_title = $request->cond_title;
        if ($cond_title != '') {
            $posts = News::where('title', $cond_title)->get();
        }else{
            $posts = News::all();
        }
        return view('admin.news.index', ['posts' => $posts, 'cond_title' => $cond_title]);
    }
    public function edit(Request $request)
    {
        // News Modelからデータ取得
        $news = News::find($request->id);
        if (empty($news)) {
            abort(404);
        }
        return view('admin.news.edit',['news_form' => $news]);
    }
    
    public function update(Request $request)
    {
        // validation
        $this->validate($request, News::$rules);
        // News Modelからデータ取得
        $news = News::find($request->id);
        // 送信されてきたデータを格納
        $news_form = $request->all();
        if ($request->remove == 'true') {
            $news_form['image_path'] = null;
        } elseif ($request->file('image')) {
            $path = $request->file('image')->store('public/image');
            $news_form['image_path'] = basename($path);
        } else {
            $news_form['image_path'] = $news->image_path;
        }
        unset($news_form['_token']);
        // 該当するデータを上書きして保存
        $news->fill($news_form)->save();
        
        return redirect('admin/news');
    }
}
