<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['article_list'] = Article::with('category')->paginate(15);
        return view('article.article-list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['category_list'] = Category::get();
        return view('article.article-form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        $category_data = Category::where('name', $request->input('category'))->first();

        $image_file = $request->file('image');
        $image_name  = $image_file->hashName();
        $image_path  = 'public/assets/resources/article/';
        $image_file->store($image_path);

        
        $article = new Article;
        $article->name = $request->input('name');
        $article->description = $request->input('description');
        $article->category_id = $category_data->id;
        $article->created_at = date('Y-m-d H:i:s');
        $article->image = $image_name;
        $article->image_path = $image_path;
        $article->save();

        return redirect()->route('article.index')->with('success_msg', 'Article Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['article_data'] = Article::where('id', $id)->firstOrFail();
        $data['category_list'] = Category::get();
        return view('article.article-form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, $id)
    {
        $article_data = Article::where('id', $id)->firstOrFail();
        $category_data = Category::where('name', $request->input('category'))->first();

        $article_data->name = $request->input('name');
        $article_data->description = $request->input('description');
        $article_data->category_id = $category_data->id;
        $article_data->updated_at = date('Y-m-d H:i:s');
        if ($request->file('image')) {
            $image_file = $request->file('image');
            $image_name  = $image_file->hashName();
            $image_path  = 'public/assets/resources/article/';
            $image_file->store($image_path);

            $article_data->image = $image_name;
            $article_data->image_path = $image_path;
        }
        $article_data->save();

        return redirect()
            ->route('article.index')
            ->with('success_msg', 'Article Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
