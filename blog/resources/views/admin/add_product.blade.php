@extends('admin_layout')
@section('admin_content')

<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Add product
                        </header>
                        <div class="panel-body">
                            <?php
                                $message = Session::get('message');
                                if($message){
                                    echo '<span class="text-alert">',$message,'</span>';
                                    Session::put('message',null);
                                }
                            ?>
                            <div class="position-center">
                                <form role="form" action="{{URL::to('/save-product')}}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Name of product</label>
                                    <input type="text" name="product_name" class="form-control" id="exampleInputEmail1" placeholder="Name danh mục">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Product's image</label>
                                    <input type="file" name="product_image" class="form-control" id="exampleInputEmail1">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Product's price</label>
                                    <input type="text" name="product_price" class="form-control" id="exampleInputEmail1" placeholder="Name danh mục">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Details</label>
                                    <textarea style="resize: none" rows="7" class="form-control" name="product_desc" id="exampleInputPassword1" placeholder="Details"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Content</label>
                                    <textarea style="resize: none" rows="7" class="form-control" name="product_content" id="exampleInputPassword1" placeholder="Content"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Danh mục</label>
                                    <select name="product_cate"class="form-control input-sm m-bot15">
                                    @foreach($cate_product as $key => $cate)
                                        <option value="{{$cate -> category_id}}">{{$cate -> category_name}}</option>
                                    @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Brand</label>
                                    <select name="product_brand"class="form-control input-sm m-bot15">
                                    @foreach($brand_product as $key => $brand)  
                                        <option value="{{$brand -> brand_id}}">{{$brand -> brand_name}}</option>
                                    @endforeach 
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Hiển thị</label>
                                    <select name="product_status"class="form-control input-sm m-bot15">
                                        <option value="0">Ẩn</option>
                                        <option value="1">Hiển thị</option>
                                    </select>
                                </div>
                                 
                                <button type="submit" name="add_product" class="btn btn-info">Submit</button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
@endsection