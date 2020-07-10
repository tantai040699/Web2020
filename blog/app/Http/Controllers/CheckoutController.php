<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
use Cart;
session_start();


class CheckoutController extends Controller
{
    public function Authlogin(){

       $admin_id = Session::get('admin_id');
       if ($admin_id) {
            return Redirect::to('dashboard');
       }else{
            return Redirect::to('admin') -> send();
       }
    }
    public function view_order($orderId)
    {
        $this -> Authlogin();
        $order_by_id = DB::table('tbl_order') 
        -> join('tbl_customer','tbl_customer.customer_id','=','tbl_order.customer_id')
        -> join('tbl_shipping','tbl_shipping.shipping_id','=','tbl_order.shipping_id')
        -> join('tbl_order_detail','tbl_order_detail.order_id','=','tbl_order.order_id')
        -> select('tbl_order.*','tbl_customer.*','tbl_shipping.*','tbl_order_detail.*')->first();
        $manager_order_by_id = view('admin.view_order')->with('order_by_id',$order_by_id);
        return view('admin_layout')->with('admin.view_order',$manager_order_by_id);
    }




    public function login_checkout($value='')
    {
    	$cate_product = DB::table('tbl_categogy_product') -> where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')-> where('brand_status','0')-> orderby('brand_id','desc')->get();

    	return view('pages.checkout.login_checkout')->with('category',$cate_product) ->with('brand',$brand_product);
    }
    public function add_customer(Request $request)
    {
    	$data = array();

    	$data['customer_name'] = $request->customer_name;
    	$data['customer_email'] = $request->customer_email;
    	$data['customer_password'] = md5($request->customer_password);
    	$data['customer_phone'] = $request->customer_phone;
    	
        $customer_id = DB::table('tbl_customer')->insertGetId($data);

        Session::put('customer_id',$customer_id);
        Session::put('customer_name',$request->customer_name);

        return Redirect::to('/checkout');
    }
    public function checkout()
    {
      $cate_product = DB::table('tbl_categogy_product') -> where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')-> where('brand_status','0')-> orderby('brand_id','desc')->get();

        return view('pages.checkout.show_checkout')->with('category',$cate_product) ->with('brand',$brand_product);
    }
    public function save_checkout_customer(Request $request)
    {
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_note'] = $request->shipping_note;
        $data['shipping_phone'] = $request->shipping_phone;
        $data['shipping_address'] = $request->shipping_address;
        
        $shipping_id = DB::table('tbl_shipping')->insertGetId($data);

        Session::put('shipping_id',$shipping_id);

        return Redirect::to('/payment');
    }
    public function payment()
    {
        $cate_product = DB::table('tbl_categogy_product') -> where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')-> where('brand_status','0')-> orderby('brand_id','desc')->get();

        return view('pages.checkout.payment')->with('category',$cate_product) ->with('brand',$brand_product);
    }
    public function order_place(Request $request)
    {


        //insert paymemt method
        $data = array();
        $data['payment_method'] = $request->payment_options;
        $data['payment_status'] = 'Waiting for loading';
        $payment_id = DB::table('tbl_payment')->insertGetId($data);

        //insert order 
        $orderdata = array();
        $orderdata['customer_id'] = Session::get('customer_id');
        $orderdata['shipping_id'] = Session::get('shipping_id');
        $orderdata['order_status'] = 'Waiting for loading';
        $orderdata['payment_id'] = $payment_id;
        $orderdata['order_total'] = Cart::total();
        $order_id = DB::table('tbl_order')->insertGetId($orderdata);


        //insert order detail;
        $content = Cart::content();
        foreach ($content as $key => $v_content) {

        $detaildata['order_id'] = $order_id;
        $detaildata['product_id'] = $v_content->id;
        $detaildata['product_name'] = $v_content->name;
        $detaildata['product_price'] = $v_content->price;
        $detaildata['product_sale_quantity'] = $v_content->qty;
        $order_detail_id = DB::table('tbl_order_detail')->insert($detaildata);
        }

        if ($data['payment_method'] ==1) {
           echo "ATM";
        }else{
            $cate_product = DB::table('tbl_categogy_product') -> where('category_status','0')->orderby('category_id','desc')->get();
            $brand_product = DB::table('tbl_brand')-> where('brand_status','0')-> orderby('brand_id','desc')->get();
            Cart::destroy();
            return view('pages.checkout.handcash')->with('category',$cate_product) ->with('brand',$brand_product);
        }

        
        

        //return Redirect::to('/payment');
    }

    public function logout_checkout($value='')
    {
       Session::flush();
       return Redirect::to('/login-checkout');
    }
    public function login_customer(Request $request)
    {
        $email = $request->email_account;
        $password = md5($request->password_account);
        $result = DB::table('tbl_customer')->where('customer_email',$email)->where('customer_password',$password)->first();

       
        if ($result) {
            Session::put('customer_id',$result->customer_id);
            return Redirect::to('/checkout');
        }else{
             return Redirect::to('/login-checkout');
        }
         

        
    }
    public function manage_order($value='')
    {
        $this -> Authlogin();
        $order_product = DB::table('tbl_order') 
        -> join('tbl_customer','tbl_customer.customer_id','=','tbl_order.customer_id') 
        -> select('tbl_order.*','tbl_customer.customer_name') 
        -> orderby('tbl_order.order_id','desc') ->get();
        $manager_order = view('admin.manage_order')->with('order_product',$order_product);
        return view('admin_layout')->with('admin.manage_order',$manager_order);
    }
}
