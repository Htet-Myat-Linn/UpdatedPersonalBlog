<?php

namespace App\Http\Controllers;

use App\Article;
use App\Category;
use App\User;
use Illuminate\Http\Request;


class ArticleController extends Controller
{   
    public $numImage = 0; //variable for the same image name
    public function __construct()
    {
        $this->middleware('auth',['except' => ['index','show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        $articleData = Article::orderBy('id','desc')->paginate(6);
        
        return view('index',compact('articleData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(User $user,Article $article)
    {   
        $this->authorize('view',$article);
        $categoryData = Category::all();
        return view('create',compact('categoryData'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Article $article)
    {   $this->authorize('create',$article);
        $validatedData=$request->validate([
            'article_name'=>'required',
            'content'=>'required',
            'category_id'=>'required',
            'description'=>'required',
            'rimage' =>'image',
            'contentImage' =>'image',
        ]);
        if(isset(Article::all()->last()->id)){
            $article_id = Article::all()->last()->id + 1;
        }
        else{
            $article_id = 1;
        }
        if(!empty($request->rimage)){
            $firstImageName=$this->imageStorage($request->rimage);
        }
        if(!empty($request->contentImage)){
            $secondImageName=$this->imageStorage($request->contentImage);
        }
        $article = Article::create($validatedData+['article' => $article_id,'images'=>empty($firstImageName) ? null : $firstImageName,'contentImages'=>empty($secondImageName)? null : $secondImageName,]);
                                                                            
        return redirect('/article');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article,User $user)
    {   
        $id=auth()->id();
        $user =User::find($id);

        return view('show',compact('article','user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article,User $user)
    {   
        $this->authorize('view',$article);
        $category = Category::all();

        return view('edit',compact('article','category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Article $article,User $user)
    {   $this->authorize('view',$article);
        $validatedData=$request->validate([
            'article_name'=>'required',
            'content'=>'required',
            'category_id'=>'required',
            'description'=>'required',
            'rimage' => 'image',
            'contentImage' => 'image',
        ]);
        if(!empty($request->rimage)){
            $firstImageNameUpdate=$this->imageStorage($request->rimage);
        }
        if(!empty($request->contentImage)){
            $secondImageNameUpdate=$this->imageStorage($request->contentImage);
        } 
        
        $article->update($validatedData+['images'=>empty($firstImageNameUpdate) ? $article->images : $firstImageNameUpdate,'contentImages'=>empty($secondImageNameUpdate) ? $article->contentImages : $secondImageNameUpdate]);
        return redirect('/article/'.$article->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article,User $user)
    {   $this->authorize('view',$article);
        $article->delete();
        return redirect('/article');
    }
    public function imageStorage($image){
        $this->numImage +=1;
        $image_name="";
        $image_name = Date('YmdHis').$this->numImage.".".$image->getClientOriginalExtension();
        $image->move(public_path('img'),$image_name);
        return $image_name;
    }
}
    