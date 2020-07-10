@extends('welcome')
@section('content')

<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{URL::to('/')}}">Home</a></li>
				  <li class="active">Thanks</li>
				</ol>
			</div><!--/breadcrums-->


			<div class="register-req">
				<p>Thank to your order!! See you later</p>
			</div><!--/register-req-->

			
		</div>
	</section> <!--/#cart_items-->






@endsection