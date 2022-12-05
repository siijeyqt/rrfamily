<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Room;
use App\Models\BookedRoom;
use Auth;
use DB;
use App\Mail\Websitemail;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;

class BookingController extends Controller
{
    public function cart_submit(Request $request){

        if(Auth::guard('customer')->check()){
            $request->validate([

                'room_id' => 'required',
                'checkin_checkout' => 'required',
                'adult' => 'required',
                'no_of_rooms' => 'required'

            ]);

            $dates = explode(' - ',$request->checkin_checkout);
            $checkin_date = $dates[0];
            $checkout_date = $dates[1];

            $d1 = explode('/',$checkin_date);
            $d2 = explode('/',$checkout_date);
            $d1_new = $d1[2].'-'.$d1[0].'-'.$d1[1];
            $d2_new = $d2[2].'-'.$d2[0].'-'.$d2[1];
            $t1 = strtotime($d1_new);
            $t2 = strtotime($d2_new);
            
            $count = 1;
            while(1) {
                if($t1>=$t2) {
                    break;
                }
                $single_date = date('m/d/Y',$t1);

                $total_booked = BookedRoom::where('booking_date',$single_date)->where('room_id',$request->room_id)->count();
                $arr = Room::where('id',$request->room_id)->first();
                $total_allowed = $arr->total_rooms;
                
                $guests = $request->adult + $request->children;
                
                if($request->no_of_rooms > $total_allowed || $guests > ($request->no_of_rooms * $arr->total_guests)){
                    $count = 0;
                    break;
                }

                $t1 = strtotime('+1 day',$t1);
            }
            if($count == 0){

                return redirect()->back()->with('error','Change the quantity of your NUMBER OF GUESTS or NUMBER OF ROOMS!');
            }
            
            session()->push('cart_room_id',$request->room_id);
            session()->push('cart_checkin_date',$checkin_date);
            session()->push('cart_checkout_date',$checkout_date);
            session()->push('cart_no_of_rooms',$request->no_of_rooms);
            session()->push('cart_adult',$request->adult);
            session()->push('cart_children',$request->children);
            
            return redirect()->back()->with('success','Your booking is added, check it out NOW!');
        }
        else{
            return redirect()->route('customer_login')->with('error','Login first!');
        }
    }

    public function cart_view(){

            return view('front.cart');
    }

    public function cart_delete($id){
        
        $arr_cart_room_id = array();
        $i = 0;
        foreach(session()->get('cart_room_id') as $value){
            $arr_cart_room_id[$i] = $value;
            $i++;
        }
        $arr_cart_checkin_date = array();
        $i = 0;
        foreach(session()->get('cart_checkin_date') as $value){
            $arr_cart_checkin_date[$i] = $value;
            $i++;
        }
        $arr_cart_checkout_date = array();
        $i = 0;
        foreach(session()->get('cart_checkout_date') as $value){
            $arr_cart_checkout_date[$i] = $value;
            $i++;
        }
        $arr_cart_no_of_rooms = array();
        $i = 0;
        foreach(session()->get('cart_no_of_rooms') as $value){
            $arr_cart_no_of_rooms[$i] = $value;
            $i++;
        }
        $arr_cart_adult = array();
        $i = 0;
        foreach(session()->get('cart_adult') as $value){
            $arr_cart_adult[$i] = $value;
            $i++;
        }
        $arr_cart_children = array();
        $i = 0;
        foreach(session()->get('cart_children') as $value){
            $arr_cart_children[$i] = $value;
            $i++;
        }
        session()->forget('cart_room_id');
        session()->forget('cart_checkin_date');
        session()->forget('cart_checkout_date');
        session()->forget('cart_no_of_rooms');
        session()->forget('cart_adult');
        session()->forget('cart_children');

        for($i=0;$i<count($arr_cart_room_id);$i++){
            if($arr_cart_room_id[$i] == $id){
                continue;
            }
            else{
                session()->push('cart_room_id', $arr_cart_room_id[$i]);
                session()->push('cart_checkin_date', $arr_cart_checkin_date[$i]);
                session()->push('cart_checkout_date', $arr_cart_checkout_date[$i]);
                session()->push('cart_no_of_rooms', $arr_cart_no_of_rooms[$i]);
                session()->push('cart_adult', $arr_cart_adult[$i]);
                session()->push('cart_children', $arr_cart_children[$i]);
            }
        }

        return redirect()->back()->with('success','Cart item is deleted successfully.');
    }

    public function checkout(){

        if(!Auth::guard('customer')->check()){
            return redirect()->route('customer_login')->with('error','Login first!');
        }

        if(!session()->has('cart_room_id')){
            return redirect()->back()->with('error','There is no item in the cart.');
        }
        return view('front.checkout');
    }

    public function payment(Request $request){

        if(!Auth::guard('customer')->check()){
            return redirect()->route('customer_login')->with('error','Login first!');
        }

        if(!session()->has('cart_room_id')){
            return redirect()->back()->with('error','There is no item in the cart.');
        }

        $request->validate([

            'billing_name' => 'required',
            'billing_email' => 'required|email',
            'billing_phone' => 'required',
            'billing_purok' => 'required',
            'billing_barangay' => 'required',
            'billing_city' => 'required',
            'billing_province' => 'required',
            'billing_zip' => 'required'

        ]);

        session()->put('billing_name', $request->billing_name);
        session()->put('billing_email', $request->billing_email);
        session()->put('billing_phone', $request->billing_phone);
        session()->put('billing_purok', $request->billing_purok);
        session()->put('billing_barangay', $request->billing_barangay);
        session()->put('billing_city', $request->billing_city);
        session()->put('billing_province', $request->billing_province);
        session()->put('billing_zip', $request->billing_zip);
        
        return view('front.payment');
    }

    public function paypal($final_price){

        $client = 'Acjm9MzddsaTPRNABVXZHYsGUlw0KIlLt2ZztbVDvUoPgCdNJCaaFO1dI7K_i0kbLFDcAecCF1yIalW9';
        $secret = 'ECNMRN-LbWYuPAeHa-dPY4hhMhRZTJteeoFZvzSk9kw9e35WSh0EWszHOHiQ8a4sQmCRq_nm2til4Oa2';
        $tax = 200;
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                $client, // ClientID
                $secret // ClientSecret
            )
        );
        
        $paymentId = request('paymentId');
        $payment = Payment::get($paymentId, $apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId(request('PayerID'));

        $transaction = new Transaction();
        $amount = new Amount();
        $details = new Details();

        
        $details->setShipping(0)
            ->setTax(0)
            ->setSubtotal($final_price);

        $amount->setCurrency('PHP');
        $amount->setTotal($final_price);
        $amount->setDetails($details);
        $transaction->setAmount($amount);

        $execution->addTransaction($transaction);

        $result = $payment->execute($execution, $apiContext);

        if($result->state == 'approved'){
            $paid_amount = $result->transactions[0]->amount->total;

            $order_no = time();

            $statement = DB::select("SHOW TABLE STATUS LIKE 'orders'");
            $ai_id = $statement[0]->Auto_increment;

            $obj = new Order();
            $obj->customer_id = Auth::guard('customer')->user()->id;
            $obj->order_no = $order_no;
            $obj->transaction_id = $result->id;
            $obj->payment_method = 'PayPal';
            $obj->paid_amount = $paid_amount;
            $obj->booking_date = date('m/d/Y');
            $obj->status = 'Completed';
            $obj->save();

            $arr_cart_room_id = array();
            $i = 0;
            foreach(session()->get('cart_room_id') as $value){
                $arr_cart_room_id[$i] = $value;
                $i++;
            }
            $arr_cart_checkin_date = array();
            $i = 0;
            foreach(session()->get('cart_checkin_date') as $value){
                $arr_cart_checkin_date[$i] = $value;
                $i++;
            }
            $arr_cart_checkout_date = array();
            $i = 0;
            foreach(session()->get('cart_checkout_date') as $value){
                $arr_cart_checkout_date[$i] = $value;
                $i++;
            }
            $arr_cart_no_of_rooms = array();
            $i = 0;
            foreach(session()->get('cart_no_of_rooms') as $value){
                $arr_cart_no_of_rooms[$i] = $value;
                $i++;
            }
            $arr_cart_adult = array();
            $i = 0;
            foreach(session()->get('cart_adult') as $value){
                $arr_cart_adult[$i] = $value;
                $i++;
            }
            $arr_cart_children = array();
            $i = 0;
            foreach(session()->get('cart_children') as $value){
                $arr_cart_children[$i] = $value;
                $i++;
            }

            for($i=0; $i<count($arr_cart_room_id); $i++){

                $room_info = Room::where('id',$arr_cart_room_id[$i])->first();
                $arr = array_sum($arr_cart_no_of_rooms);
                $d1 = explode('/',$arr_cart_checkin_date[$i]);
                $d2 = explode('/',$arr_cart_checkout_date[$i]);
                $d1_new = $d1[2].'-'.$d1[0].'-'.$d1[1];
                $d2_new = $d2[2].'-'.$d2[0].'-'.$d2[1];
                $t1 = strtotime($d1_new);
                $t2 = strtotime($d2_new);

                $diff = ($t2 - $t1)/60/60/24;
                $sub = $room_info->price * $diff * $arr;

                $obj = new OrderDetail();
                $obj->order_id = $ai_id;
                $obj->room_id = $arr_cart_room_id[$i];
                $obj->order_no = $order_no;
                $obj->checkin_date = $arr_cart_checkin_date[$i];
                $obj->checkout_date = $arr_cart_checkout_date[$i];
                $obj->no_of_rooms = $arr_cart_no_of_rooms[$i];
                $obj->adult = $arr_cart_adult[$i];
                $obj->children = $arr_cart_children[$i];
                $obj->subtotal = $sub;
                $obj->save();

                while(1) {
                    if($t1>=$t2) {
                        break;
                    }

                    $obj = new BookedRoom();
                    $obj->booking_date = date('m/d/Y',$t1);
                    $obj->order_no = $order_no;
                    $obj->room_id = $arr_cart_room_id[$i];
                    $obj->order_id = $ai_id;
                    $obj->no_of_rooms = $arr_cart_no_of_rooms[$i];
                    $obj->save();

                    $t1 = strtotime('+1 day',$t1);
                }
            }

            $subject = 'New Order';
            $message = 'You have made an order for room booking. The information is given below: <br>';
            $message .= '<br>Order Number: ' .$order_no;
            $message .= '<br>Transaction ID: ' .$result->id;
            $message .= '<br>Payment Method: PayPal';
            $message .= '<br>Reservation Fee: ₱' .$tax;
            $message .= '<br>Paid Amount: ₱'.$paid_amount;
            $message .= '<br>Booking Date: '.date('m/d/Y').'<br>';

            for($i=0; $i<count($arr_cart_room_id); $i++){

                $room_info = Room::where('id',$arr_cart_room_id[$i])->first();
                $message .= '<br>Room Name: '.$room_info->name;
                $message .= '<br>Price per Night: ₱'.$room_info->price;
                $message .= '<br>Checkin Date: '.$arr_cart_checkin_date[$i];
                $message .= '<br>Checkout Date: '.$arr_cart_checkout_date[$i];
                $message .= '<br>Number of Rooms: '.$arr_cart_no_of_rooms[$i];
                $message .= '<br>Adult: '.$arr_cart_adult[$i];
                $message .= '<br>Children: '.$arr_cart_children[$i].'<br>';
            }

            $customer_email = Auth::guard('customer')->user()->email;
            \Mail::to($customer_email)->send(new Websitemail($subject,$message));

            session()->forget('cart_room_id');
            session()->forget('cart_checkin_date');
            session()->forget('cart_checkout_date');
            session()->forget('cart_no_of_rooms');
            session()->forget('cart_adult');
            session()->forget('cart_children');
            session()->forget('billing_name');
            session()->forget('billing_email');
            session()->forget('billing_phone');
            session()->forget('billing_purok');
            session()->forget('billing_barangay');
            session()->forget('billing_city');
            session()->forget('billing_province');
            session()->forget('billing_zip');

            return redirect()->route('home')->with('success','Payment is successful.');
        }
        else{
            return redirect()->route('home')->with('error','Payment is unsuccessful.');
        }
    }
}
