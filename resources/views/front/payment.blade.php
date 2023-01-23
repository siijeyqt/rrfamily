@extends('front.layout.app')

@section('main_content')

<script src="https://www.paypalobjects.com/api/checkout.js"></script>

<div class="page-top">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>{{$global_page_data->payment_heading}}</h2>
            </div>
        </div>
    </div>
</div>
<div class="page-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 checkout-left">
                <div class="col-lg-9 col-md-4 checkout-left mb_30">
                    
                    <h4>Make Payment</h4>
                    <select name="payment_method" class="form-control select2" id="paymentMethodChange" autocomplete="off">
                        <option value="">Select Payment Method</option>
                        <option value="WalkIn">Walk In</option>
                        <option value="PayPal">PayPal</option>
                    </select>

                    <div class="walkin mt_20">
                        <h4>Pay for Walk In</h4>
                        <td class="pt_10 pb_10 w_150">
                            <a href="{{route('walkin')}}" class="btn btn-warning">Detail</a>
                        </td>
                    </div>
                        
                    <div class="paypal mt_20">
                        <h4>Pay with PayPal</h4>
                        <div id="paypal-button"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 checkout-right">
                <div class="inner">
                    <h4 class="mb_10">Billing Details</h4>
                    <div>
                        Name: {{session()->get('billing_name')}}
                    </div>
                    <div>
                        Email: {{session()->get('billing_email')}}
                    </div>
                    <div>
                        Phone Number: {{session()->get('billing_phone')}}
                    </div>
                    <div>
                        Purok: {{session()->get('billing_purok')}}
                    </div>
                    <div>
                        Barangay: {{session()->get('billing_barangay')}}
                    </div>
                    <div>
                        City/Municipality: {{session()->get('billing_city')}}
                    </div>
                    <div>
                        Province: {{session()->get('billing_province')}}
                    </div>
                    <div>
                        Zip Code: {{session()->get('billing_zip')}}
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 checkout-right">
                <div class="inner">
                    <h4 class="mb_10">Booking Details</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                            @php
                                $arr_cart_room_id = array();
                                $i=0;
                                foreach(session()->get('cart_room_id') as $value) {
                                    $arr_cart_room_id[$i] = $value;
                                    $i++;
                                }

                                $arr_cart_checkin_date = array();
                                $i=0;
                                foreach(session()->get('cart_checkin_date') as $value) {
                                    $arr_cart_checkin_date[$i] = $value;
                                    $i++;
                                }

                                $arr_cart_checkout_date = array();
                                $i=0;
                                foreach(session()->get('cart_checkout_date') as $value) {
                                    $arr_cart_checkout_date[$i] = $value;
                                    $i++;
                                }

                                $arr_cart_no_of_rooms = array();
                                $i=0;
                                foreach(session()->get('cart_no_of_rooms') as $value) {
                                    $arr_cart_no_of_rooms[$i] = $value;
                                    $i++;
                                }


                                $arr_cart_adult = array();
                                $i=0;
                                foreach(session()->get('cart_adult') as $value) {
                                    $arr_cart_adult[$i] = $value;
                                    $i++;
                                }

                                $arr_cart_children = array();
                                $i=0;
                                foreach(session()->get('cart_children') as $value) {
                                    $arr_cart_children[$i] = $value;
                                    $i++;
                                }

                                $total_price = 0;
                                $tax = 0.05;
                                for($i = 0; $i < count($arr_cart_room_id);$i++){
                                    
                                    $room_data = DB::table('rooms')->where('id', $arr_cart_room_id[$i])->first();
                                    @endphp

                                    <tr>
                                        <td>
                                            {{$room_data->name}}
                                            <br>
                                            ({{$arr_cart_checkin_date[$i]}} - {{$arr_cart_checkout_date[$i]}})
                                            <br>
                                            Number of Rooms: {{$arr_cart_no_of_rooms[$i]}}
                                            <br>
                                            Adult: {{$arr_cart_adult[$i]}}, Children: {{$arr_cart_children[$i]}}
                                        </td>
                                        <td class="p_price">
                                            @php
                                                $arr = $arr_cart_no_of_rooms[$i];
                                                $d1 = explode('/',$arr_cart_checkin_date[$i]);
                                                $d2 = explode('/',$arr_cart_checkout_date[$i]);
                                                $d1_new = $d1[2].'-'.$d1[0].'-'.$d1[1];
                                                $d2_new = $d2[2].'-'.$d2[0].'-'.$d2[1];
                                                $t1 = strtotime($d1_new);
                                                $t2 = strtotime($d2_new);

                                                $diff = ($t2 - $t1)/60/60/24;
                                                echo'₱'. number_format($room_data->price * $diff * $arr, 2);
                                            @endphp
                                        </td>
                                    </tr>
                                    @php
                                    $total_price = $total_price + ($room_data->price * $diff * $arr);
                                    $transac = $total_price * $tax;
                                }
                            @endphp
                                {{-- <tr>
                                    <td><b>Transaction Fee:</b></td>
                                    <td class="p_price"><b>₱{{number_format($transac, 2)}}</b></td>
                                </tr> --}}
                                <tr>
                                    <td><b>Subtotal:</b></td>
                                    <td class="p_price"><b>₱{{number_format($total_price, 2)}}</b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@php
$client = 'Acjm9MzddsaTPRNABVXZHYsGUlw0KIlLt2ZztbVDvUoPgCdNJCaaFO1dI7K_i0kbLFDcAecCF1yIalW9';
@endphp
<script>
	paypal.Button.render({
		env: 'sandbox',
		client: {
			sandbox: '{{ $client }}',
			production: '{{ $client }}'
		},
		locale: 'en_PH',
		style: {
			size: 'medium',
			color: 'blue',
			shape: 'rect',
		},
		// Set up a payment
		payment: function (data, actions) {
			return actions.payment.create({
				redirect_urls:{
					return_url: '{{ url("payment/paypal/$total_price") }}'
				},
				transactions: [{
					amount: {
						total: '{{ $total_price + $transac }}',
						currency: 'PHP'
					}
				}]
			});
		},
		// Execute the payment
		onAuthorize: function (data, actions) {
			return actions.redirect();
		}
	}, '#paypal-button');
</script>
@endsection