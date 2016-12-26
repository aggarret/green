@extends('layouts.app')

@section('title')
    Pyament
@endsection

@section('head')
@endsection


@section('content')
	<form action="{{ route('organization.account.payment') }}" method="post" id="payment-form">
		<span class="payment-errors"></span>

	  	<div class="form-row">
	    	<label>
		      	<span>Card Number</span>
		      	<input type="text" size="20" data-stripe="number">
	    	</label>
	  	</div>

	  	<div class="form-row">
		    <label>
				<span>Expiration (MM/YY)</span>
				<input type="text" size="2" data-stripe="exp_month">
		    </label>
	    	<span> / </span>
	    	<input type="text" size="2" data-stripe="exp_year">
	  	</div>

	  	<div class="form-row">
	    	<label>
	      		<span>CVC</span>
	      		<input type="text" size="4" data-stripe="cvc">
	    	</label>
	  	</div>

	  	<input type="submit" class="submit" value="Submit Payment">
	  	<input type="hidden" value="{{ Session::token() }}" name="_token">
	</form>
@endsection

@section('script')
    <!-- Stripe API-->
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script type="text/javascript">Stripe.setPublishableKey('{{ env('STRIPE_PUBLISHABLE_KEY') }}');</script>
    <!-- Custom JS to support Stripe-->
    <script src="{{ URL::asset('js/organization/stripe.js') }}"></script>
@endsection