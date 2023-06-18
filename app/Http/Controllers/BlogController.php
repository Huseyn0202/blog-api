<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::all();
        return response($blogs, 200);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "tittle" => "required",
            "text" => "required",
            "photo" => "image",
            "views" => "required"
        ]);
        
        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 400);
        }

        $blog = new Blog();
        $blog->tittle = $request->tittle;
        $blog->text = $request->text;
        $blog->views = $request->views;
        if ($request->hasfile("photo")) {
            $photo = $request->file("photo")->store("public/images");
            $blog->photo = $photo;
        }
        $blog->save();
        return response($blog, 201);
    }

    public function show(string $id)
    {
        $blog = Blog::find($id);
        return response($blog, 200);
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "tittle" => "required",
            "text" => "required",
            "photo" => "image",
            "views" => "required"
        ]);
        
        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 400);
        }

        $blog = Blog::find($id);



        if (!$blog) {
            return response()->json(["message" => "Blog not found"], 404);
        }
        $blog->tittle = $request->tittle;
        $blog->text = $request->text;
        $blog->views = $request->views;
        if ($request->hasfile("photo")) {
            $photo = $request->file("photo")->store("public/images");
            $blog->photo = $photo;
        }
        $blog->update();



        return response()->json(["message" => "Blog was changed", 'statusCode' => 200]);
    }
}
