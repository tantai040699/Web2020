<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
use Cart;
session_start();

class CartController extends Controller
{
    public function save_cart(Request $request)
    {

    	$cate_product = DB::table('tbl_categogy_product') -> where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')-> where('brand_status','0')-> orderby('brand_id','desc')->get();

    	$productid = $request ->productid_hidden;
    	$quantity = $request ->qty;


    	$product_info = DB::table('tbl_product')-> where('product_id',$productid)->first();

    	$data['id'] = $product_info ->product_id;
    	$data['qty'] = $quantity;
    	$data['name'] = $product_info ->product_name;
    	$data['price'] = $product_info ->product_price;
    	$data['weight'] = '123';
    	$data['options']['image'] = $product_info ->product_image;

    	Cart::add($data);


    	return Redirect::to('show-cart');
    }

    public function show_cart()
    {
    	$cate_product = DB::table('tbl_categogy_product') -> where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')-> where('brand_status','0')-> orderby('brand_id','desc')->get();
    	return view('pages.cart.show_cart')->with('category',$cate_product) ->with('brand',$brand_product);
    }
    public function delete_to_cart($rowId)
    {
    	Cart::update($rowId,0);
    	return Redirect::to('show-cart');
    }
    public function update_cart_quantity(Request $request)
    {
    	$rowId = $request ->rowId_cart;
    	$quanty = $request->quantity_cart;
    	Cart::update($rowId,$quanty);
    	return Redirect::to('show-cart');
    }
}
