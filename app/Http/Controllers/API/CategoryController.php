<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
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
        $category = Category::where('parent_id', Null)->orderBy('order', 'ASC')->paginate(11);
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $category
        ]);
    }
    public function subCategory($id)
    {

        $subCategories = Category::findOrFail($id)->where('parent_id', $id)->orderBy('order', 'ASC')->paginate(10);
        if (empty($subCategories)) {
            return null;
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'data' => $subCategories
            ]);
        }
    }
    public function productCategory(Request $request)
    {
        $userProduct = Product::where('user_promoted', 1)->where('is_valid', 1)->where('category_id', $request->get('category_id'))->get();
        $products = [];
        foreach ($userProduct as $i => $product) {
            $products[$i]['id']    = $product->id;
            $products[$i]['name']    = $product->name;
            $products[$i]['price']   = $product->price;
            $products[$i]['description']   = $product->description;
            $products[$i]['main_image']   = url('storage/' . $product->main_image);
            $products[$i]['company_name']   = $product->company_name;
            $products[$i]['is_favorite']   = $product->is_joined;
        }

        $userProduct = $products;
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $userProduct
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
    
        public function adCategory()
    {
        $category = Category::where('parent_id', Null)->orderBy('order', 'ASC')->limt(10);
        return response()->json(
         $category
        );
    }
}
