@extends('front.layout.app')

@section('main_content')

<div class="page-top">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>{{$global_page_data->checkout_heading}}</h2>
            </div>
        </div>
    </div>
</div>
<div class="page-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 checkout-left">
                <form action="{{route('payment')}}" method="post" class="frm_checkout" autocomplete="off">
                    @csrf
                    <div class="billing-info">
                        <h4 class="mb_30">Billing Information</h4>
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="">Name: *</label>
                                <input type="text" class="form-control mb_15" name="billing_name" value="{{Auth::guard('customer')->user()->name}}" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="">Email Address: *</label>
                                <input type="text" class="form-control mb_15" name="billing_email" value="{{Auth::guard('customer')->user()->email}}" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="">Phone Number: *</label>
                                <input type="text" class="form-control mb_15" name="billing_phone" value="{{Auth::guard('customer')->user()->phone}}" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="">Purok: *</label>
                                <input type="text" class="form-control mb_15" name="billing_purok" value="{{Auth::guard('customer')->user()->purok}}" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="">Barangay: *</label>
                                <input type="text" class="form-control mb_15" name="billing_barangay" value="{{Auth::guard('customer')->user()->barangay}}" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="">City/Municipality: *</label>
                                <input type="text" class="form-control mb_15" name="billing_city" value="{{Auth::guard('customer')->user()->city}}" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="">Province: *</label>
                                <input type="text" class="form-control mb_15" name="billing_province" value="{{Auth::guard('customer')->user()->province}}" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="">Zip Code: *</label>
                                <input type="text" class="form-control mb_15" name="billing_zip" value="{{Auth::guard('customer')->user()->zip}}" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary bg-website mb_30">Continue to payment</button>
                </form>
            </div>
            <div class="col-lg-6 col-md-6 checkout-right">
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
                                $tax = 200;
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
                                                $arr = array_sum($arr_cart_no_of_rooms);
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
                                }
                            @endphp
                                <tr>
                                    <td><b>Reservation Fee:</b></td>
                                    <td class="p_price"><b>₱{{number_format($tax, 2)}}</b></td>
                                </tr>
                                <tr>
                                    <td><b>Total:</b></td>
                                    <td class="p_price"><b>₱{{number_format($total_price + $tax, 2)}}</b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection