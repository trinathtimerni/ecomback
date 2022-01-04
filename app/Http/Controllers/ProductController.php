<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $productRepo;

    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepo = $productRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        $this->filterAndResponse($request, $query);

        $query->orderBy('id', 'DESC');

        $products = $query->paginate(15);

        return response()->json(['products' => $products], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            $product = new Product();
            $product->name = $request->name;
            $product->product_id = "P-".rand(10000,99999);
            $product->short_description = $request->short_description;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->quantity = $request->quantity;
            $product->category_id = $request->category_id;
            $product->brand_id = $request->brand_id;
            if ($request->has('image') && $request->image != '') {
                $request->validate(['image' => 'required|image|mimes:jpeg,jpg,png']);
                $path = 'uploads/users/' . date("Y") . "/" . date("m") . "/";
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                    $new_file = fopen($path . '/index.html', 'w') or die('Cannot create file:  [UC-1001]');
                    fclose($new_file);
                }
                $root_path = public_path(); // Path to the project's root folder
                $image = $request->image;
                $imageName = time() . '.' . $image->extension();
                $image->move($root_path . '/' . $path, $imageName);
                $product->main_image = $path . $imageName;
            }

            $res = $this->productRepo->Insert($product);

            return response()->json(['success' => 1, 'message' => $res->message, 'product' => $product], $res->code);
        } catch (\Exception $e) {
            $product->delete();

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
        $product = Product::with('category')->findOrFail($id);

        return response()->json(['product' => $product], 200);
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
            $product = Product::find($request->product_id);
            $product->name = $request->name;
            $product->short_description = $request->short_description;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->quantity = $request->quantity;
            $product->category_id = $request->category_id;
            $product->brand_id = $request->brand_id;
            if ($request->has('image') && $request->image != '') {
                    $this->imageDelete($product->main_image);
                $request->validate(['image' => 'required|image|mimes:jpeg,jpg,png']);
                $path = 'uploads/users/' . date("Y") . "/" . date("m") . "/";
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                    $new_file = fopen($path . '/index.html', 'w') or die('Cannot create file:  [UC-1001]');
                    fclose($new_file);
                }
                $root_path = base_path(); // Path to the project's root folder
                $image = $request->image;
                $imageName = time() . '.' . $image->extension();
                $image->move($root_path . '/' . $path, $imageName);
                $product->main_image = $path . $imageName;
            }

            $res = $this->productRepo->Update($product);

            return response()->json(['success' => 1, 'message' => $res->message, 'product' => $res->product], $res->code);
        } catch (\Exception $e) {
            $product->delete();

            return response()->json(['success' => 0, 'message' => $e->getMessage()], 500);
        }
    }

        public function updateProduct(Request $request)
        {
        // try {
            $product = Product::findOrFail($request->id);
            $product->name = $request->name;
            $product->short_description = $request->short_description;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->quantity = $request->quantity;
            $product->category_id = $request->category_id;
            if ($request->has('image') && $request->image != '') {
                    $this->imageDelete($product->main_image);
                $request->validate(['image' => 'required|image|mimes:jpeg,jpg,png']);
                $path = 'uploads/users/' . date("Y") . "/" . date("m") . "/";
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                    $new_file = fopen($path . '/index.html', 'w') or die('Cannot create file:  [UC-1001]');
                    fclose($new_file);
                }
                $root_path = base_path(); // Path to the project's root folder
                $image = $request->image;
                $imageName = time() . '.' . $image->extension();
                $image->move($root_path . '/' . $path, $imageName);
                $product->main_image = $path . $imageName;
            }

            $res = $this->productRepo->Update($product);

            return response()->json(['success' => 1, 'message' => $res->message, 'product' => $product], $res->code);
        // } catch (\Exception $e) {
        //     return response()->json(['success' => 0, 'message' => $e->getMessage()], 500);
        // }
    }

    private function imageDelete($file_path){
        if(file_exists($file_path)){
            @unlink($file_path);
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
        $product = Product::find($id);
        if($product){
            $this->imageDelete($product->main_image);
        }
        $res = $this->productRepo->Delete($id);
        return response()->json(['success' => 1,'message' => $res->message], $res->code);
    }

    private function filterAndResponse($request, $query)
    {
        if($request->has('id')) {
            $query->where('id', $request->id);
        }

        if($request->has('name')) {
            $query->where('name', 'like', "%$request->name%");
        }

        if($request->has('price')) {
            $query->where('price', $request->price);
        }

        if($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if($request->has('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }
    }
}
