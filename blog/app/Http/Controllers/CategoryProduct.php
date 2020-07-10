<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();


class CategoryProduct extends Controller
{
    public function Authlogin(){

       $admin_id = Session::get('admin_id');
       if ($admin_id) {
            return Redirect::to('dashboard');
       }else{
            return Redirect::to('admin') -> send();
       }
    }
    public function add_category_product(){

        $this -> Authlogin();
    	return view('admin.add_category_product');
    }
    public function all_category_product(){

        $this -> Authlogin();
    	$all_category_product = DB::table('tbl_categogy_product')->get();
    	$manager_category_product = view('admin.all_category_product')->with('all_category_product',$all_category_product);
    	return view('admin_layout')->with('admin.all_category_product',$manager_category_product);
    } 
    public function save_category_product(Request $request){

        $this -> Authlogin();
    	$data = array();
    	$data['category_name'] = $request->category_product_name;
    	$data['category_desc'] = $request->category_product_desc;
    	$data['category_status'] = $request->category_product_status;

    	DB::table('tbl_categogy_product')->insert($data);
    	Session::put('message','Successful');
    	return Redirect::to('add-category-product');


    }
    public function unactive_category_product($category_product_id)
    {
        $this -> Authlogin();
        DB::table('tbl_categogy_product')->where('category_id',$category_product_id)->update(['category_status'=>1]);
        Session::put('message','Successful unactive');
        return Redirect::to('all-category-product');
    }
    public function active_category_product($category_product_id)
    {
        $this -> Authlogin();
        DB::table('tbl_categogy_product')->where('category_id',$category_product_id)->update(['category_status'=>0]);
        Session::put('message','Successful active');
        return Redirect::to('all-category-product');
    }
    public function edit_category_product($category_product_id)
    {
        $this -> Authlogin();
        $edit_category_product = DB::table('tbl_categogy_product')->where('category_id',$category_product_id)->get();
        $manager_category_product = view('admin.edit_category_product')->with('edit_category_product',$edit_category_product);
        return view('admin_layout')->with('admin.edit_category_product',$manager_category_product);
    }
    public function update_category_product(Request $request, $category_product_id)
    {
        $this -> Authlogin();
        $data = array();
        $data['category_name'] = $request->category_product_name;
        $data['category_desc'] = $request->category_product_desc;
        DB::table('tbl_categogy_product')->where('category_id',$category_product_id)->update($data);
        Session::put('message','Update Successful ');
        return Redirect::to('all-category-product');
    }
    public function delete_category_product( $category_product_id)
    {
        $this -> Authlogin();
        DB::table('tbl_categogy_product')->where('category_id',$category_product_id)->delete();
        Session::put('message','Delete Successful ');
        return Redirect::to('all-category-product');
    }
    //end function of admin

    public function show_category_home($category_id)
    {
        $cate_product = DB::table('tbl_categogy_product') -> where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')-> where('brand_status','0')-> orderby('brand_id','desc')->get();

        $category_by_id = DB::table('tbl_product') 
        -> join('tbl_categogy_product','tbl_categogy_product.category_id','=','tbl_product.category_id') 
        -> where('tbl_categogy_product.category_id',$category_id) ->get();


        $category_name = DB::table('tbl_categogy_product') ->where('tbl_categogy_product.category_id',$category_id)->limit(1) ->get();

        return view('pages.category.show_category')->with('category',$cate_product) ->with('brand',$brand_product)->with('category_by_id',$category_by_id)->with('category_name',$category_name);
    }
}