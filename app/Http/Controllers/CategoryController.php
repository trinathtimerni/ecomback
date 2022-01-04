<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $categories = Category::orderBy('id', 'DESC')->paginate(15);
        return response()->json(['categories' => $categories], 200);
        }
        catch (\Exception $e) {
            return response()->json(["error" => "something error occured"],500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $category = new Category();
            $category->name = $request->name;
            $category->description = $request->description;
            $category->save();

            return response()->json(['success' => 1, 'message' => "category save successfully", 'category' => $category], 200);
        } catch (\Exception $e) {
            $category->delete();

            return response()->json(['success' => 0, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);

        return response()->json(['category' => $category], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function categoryUpdate(Request $request)
    {
        try {
            $category = Category::find($request->id);
            $category->name = $request->name;
            $category->description = $request->description;
            $category->save();

            return response()->json(['success' => 1, 'message' => "category update successfully", 'category' => $category], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $category = Category::find($request->id);
            $category->name = $request->name;
            $category->description = $request->description;
            $category->save();

            return response()->json(['success' => 1, 'message' => "category update successfully", 'category' => $category], 200);
        } catch (\Exception $e) {
            $category->delete();

            return response()->json(['success' => 0, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::find($id)->delete();
        return response()->json(['success' => 1,'message' => 'category deleted successfully'], 200);
    }

    public function getCatSubChildCategory(){
        try {
            $subcategories = Category::orderBy('id', 'desc')->with('sub_category')->get();
            return response()->json($subcategories);
        }
        catch (\Exception $e) {
            return response()->json("status", '400');
        }
    }
}
