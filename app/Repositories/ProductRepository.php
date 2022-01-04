<?php

namespace App\Repositories;

use App\Models\Product;
use Exception;
use stdClass;

class ProductRepository
{


    public function Insert(Product $product)
    {
        $res = new stdClass();
        try {
            $product->save();
            $res->message = "Product inserted";
            $res->code = 200;
        } catch(Exception $ex) {
            $res->message = $ex->getMessage();
            $res->code = 500;
        }
        return $res;
    }

    public function Update(Product $product)
    {
        $res = new stdClass();

        try {
            $product->save();
            $res->message = "Product updated";
            $res->code = 200;
        } catch(Exception $ex) {
            $res->message = $ex->getMessage();
            $res->code = 500;
        }
        return $res;
    }

    public function Delete($id)
    {
        $res = new stdClass();

        try {
            Product::where('id', $id)->delete();
            $res->message = "Product deleted";
            $res->code = 200;
        } catch(Exception $ex) {
            $res->message = $ex->getMessage();
            $res->code = 500;
        }

        return $res;
    }
}
