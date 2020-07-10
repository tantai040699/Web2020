
@extends('welcome')
@section('content')


					<div class="features_items"><!--features_items-->

						@foreach($category_name as $key => $cate)
						<h2 class="title text-center">{{$cate -> category_name}}</h2>
						@endforeach
						@foreach($category_by_id as $key => $product)
						<a href="{{URL::to('/product-detail/'.$product ->product_id)}}">
						<div class="col-sm-4">
							<div class="product-image-wrapper">
								<div class="single-products">
										<div class="productinfo text-center">
											<img src="{{URL::to('public/upload/product/'.$product ->product_image)}}" alt="" />
											<h2>{{'$ '.number_format($product ->product_price)}}</h2>
											<p>{{$product -> product_name}}</p>
											<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
										</div>
								</div>
								<div class="choose">
									<ul class="nav nav-pills nav-justified">
										<li><a href="#"><i class="fa fa-plus-square"></i>Add to wishlist</a></li>
										<li><a href="#"><i class="fa fa-plus-square"></i>Add to compare</a></li>
									</ul>
								</div>
							</div>
						</div>
						</a>
						@endforeach
					</div><!--features_items-->
					
					
@endsection