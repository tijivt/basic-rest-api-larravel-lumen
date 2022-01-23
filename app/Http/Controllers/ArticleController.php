<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;

class ArticleController extends Controller
{

    public function showAllArticles()
    {
        return response()->json(Article::all());
    }

    public function showOneArticle($id)
    {
        return response()->json(Article::find($id));
    }

    public function create(Request $request)
    {
        $user = $request->user();

        $name=$request['name'];
        $desc=$request['description'];
        $author=$request['author'];
        if(empty($desc) or empty($author) or empty($name)) {
            return response()->json(['status'=>'401','message'=>'Fill all the fields']);

        }

        $article_res = Article::create($request->all());


        return response()->json($article_res, 201);
    }

    public function update($id, Request $request)
    {
        /*$api_token=$request['api_token'];


        $article_author=Article::select('author')->where(['id'=> $id])->get();

        if($article_author=="" || $article_author==0) {
            return response()->json(['status'=>'401','message'=>'No such Article']);
        }
        $api_tokn_get=User::select('api_token')->where(['id'=>$article_author])->get();
        if($api_tokn_get!=$api_token) {
            return response()->json(['status'=>'401','message'=>'User unauthorized']);
        }*/
        $user = $request->user();
        $articlexists=Article::where(['id'=>$id])->count();
        if($articlexists==0) {
            return response()->json(['status'=>'401','message'=>'No such article exists']);
        }

        $article_res = Article::findOrFail($id);

        if($article_res) {
        $article_respone=$article_res->update($request->all());
            return response()->json($article_res, 200);
        }
        else {
            return response()->json(['status'=>'401','message'=>'Invalid Request']);
        }
    }

    public function delete($id)
    {
        $articlexists=Article::where(['id'=>$id])->count();
        if($articlexists==0) {
            return response()->json(['status'=>'401','message'=>'No such article exists']);
        }

        Article::findOrFail($id)->delete();
        return response()->json(['status'=>'200','message'=>'Article Deleted Successfully']);
    }
}
