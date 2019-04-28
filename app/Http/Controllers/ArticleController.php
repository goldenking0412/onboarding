<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::latest()->get();

        return view('knowledgebase.articles', compact('articles'));
    }

    public function search()
    {
        $q = Input::get ( 'q' );
        if($q != ""){
            $article = Article::where ( 'body', 'LIKE', '%' . $q . '%' )->orWhere ( 'title', 'LIKE', '%' . $q . '%' )->get ();
            if (count ( $article ) > 0)
                return view ( 'knowledgebase.categories' )->withDetails ( $article )->withQuery ( $q );
            else
                return view ( 'knowledgebase.categories' )->withMessage ( 'No Details found. Try to search again !' );
        }
        return view ( 'knowledgebase.categories' )->withMessage ( 'No Details found. Try to search again !' );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        return view('knowledgebase.article_new', compact('user'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // make sure the fields are filled.
        $this->validate(request(), [
            'title' => 'required|min:3|max:1000',
            'body' => 'required'
        ]);

        $article = Article::create([
            'title' => request('title'),
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);

        $categories = request('categories');
        if (!empty($categories)):
            $article->categories()->sync($categories);
        endif;

        // save the tag to the db.
        $article->save();

        session()->flash('message', 'Your article has been created!');
        return redirect('/knowledgebase');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article, $id)
    {
        $article = Article::where('id', $id)->first();
        $associated_categories = $article->categories;
        $category_ids = $associated_categories->pluck('id')->toArray();
        return view('knowledgebase.article', compact(
            'article',
            'category_ids',
            'associated_categories'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article, $id)
    {
        $article = Article::where('id', $id)->first();

        $categories = $article->categories;
        $category_ids = $categories->pluck('id')->toArray();

        return view('knowledgebase.article_edit', 
            compact(
                'article', 
                'category_ids'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article, $id)
    {
        // $id = $script->id;
        $article = Article::where('id', $id)->first();
        $article->update([
            'title' => request('title'),
            'body' => request('body')
        ]);

        // updates the categories. if there are not selected then pass empty array. 
        // otherwise passing empty $categories is null which throws error.
        $categories = request('categories');
        if (empty($categories)):
            $article->categories()->sync([]);
        else:
            $article->categories()->sync($categories);
        endif;
        

        session()->flash('message', 'Your article has been updated!');
        return redirect('/knowledgebase');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article, $id)
    {
        $article = Article::where('id', $id)->first();
        Article::destroy($article->id);
        session()->flash('message', 'Your article has been deleted.');
        return back();
    }
}
