<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allCategories = Category::orderBy('id', 'ASC')
                        ->with('articles')
                        ->get();

        return view('knowledgebase.categories', compact('allCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        return view('knowledgebase.category_new', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required|min:3'
        ]);
        $category = Category::create([
            'name' => request('name'),
            'user_id' => auth()->id()
        ]);
        $category->save();

        session()->flash('message', 'Your category has been created!');
        return redirect('/knowledgebase');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category, $id)
    {
        $category = Category::where('id', $id)->first();
        $articles = $category->articles;
        $article_ids = $articles->pluck('id')->toArray();
        return view ('knowledgebase.category', compact(
            'category',
            'article_ids',
            'articles'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category, $id)
    {
        $category = Category::where('id', $id)->first();
        return view('knowledgebase.category_edit',
            compact('category')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category, $id)
    {
        $category = Category::where('id', $id)->first();
        $category->update([
            'name' => request('name')
        ]);
        session()->flash('message', 'Your category has been updated!');
        return redirect('/knowledgebase/category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category, $id)
    {
        $category = Category::where('id', $id)->first();
        Category::destroy($category->id);
        session()->flash('message', 'Your category has been deleted.');
        return back();
    }
}
