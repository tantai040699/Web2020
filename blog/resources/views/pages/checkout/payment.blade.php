@extends('welcome')
@section('content')

<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{URL::to('/')}}">Home</a></li>
				  <li class="active">Check out cart</li>
				</ol>
			</div><!--/breadcrums-->


			<div class="register-req">
				<p>Please review and checkout cart</p>
			</div><!--/register-req-->

			
			<div class="review-payment">
				<h2>Review & Payment</h2>
			</div>
			<div class="table-responsive cart_info">
				<?php
				$content = Cart::content();
				?>
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">Item</td>
							<td class="description"></td>
							<td class="price">Price</td>
							<td class="quantity">Quantity</td>
							<td class="total">Total</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
					@foreach($content as $v_content)
						<tr>
							<td class="cart_product">
								<a href=""><img src="{{URL::to('public/upload/product/'.$v_content-> options-> image)}}" width="50" alt=""></a>
							</td>
							<td class="cart_description">
								<h4><a href="">{{$v_content->name}}</a></h4>
								<p>Web ID: 1089772</p>
							</td>
							<td class="cart_price">
								<p>{{'$'.number_format($v_content->price)}}</p>
							</td>
							<td class="cart_quantity">
								<div class="cart_quantity_button">
									<form action="{{URL::to('/update-cart-quantity')}}" method="POST">

										{{csrf_field()}}
										<input class="cart_quantity_input" type="text" name="quantity_cart" value="{{$v_content->qty}}">

										<input type="hidden" value="{{$v_content->rowId}}" name="rowId_cart" class="btn btn-default btn-sm">
										<!-- <input type="submit" value="Update" name="update_qty" class="btn btn-default btn-sm"> -->
									</form>
								</div>
							</td>
							<td class="cart_total">
								<p class="cart_total_price">
									
									<?php
									$subtotal = $v_content->price * $v_content->qty;
									echo '$'.' '.number_format($subtotal);


									?>


								</p>
							</td>
							<td class="cart_delete">
								<a class="cart_quantity_delete" href="{{URL::to('/delete-to-cart/'.$v_content->rowId)}}"><i class="fa fa-times"></i></a>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>

			<form action="{{URL::to('/order-place')}}" method="POST">
				{{csrf_field()}}
			<div class="payment-options">
					<span>
						<label><input name="payment_options" value="1" type="checkbox"> Direct Bank Transfer</label>
					</span>
					<span>
						<label><input name="payment_options" value="2" type="checkbox"> Check Payment</label>
					</span>
					<input type="submit" style="margin-top:0 " value="Order" name="send_order_place" class="btn btn-primary btn-sm">
					
				</div>
			</form>
		</div>
	</section> <!--/#cart_items-->






@endsection