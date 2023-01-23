<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
Use App\Models\Customer;
Use App\Models\Order;
Use App\Models\OrderDetail;
Use App\Models\BookedRoom;

class CustomerOrderController extends Controller
{
    public function index(){

        $orders = Order::where('customer_id',Auth::guard('customer')->user()->id)->get();
        return view('customer.order', compact('orders'));
    }
    public function invoice($id){

        $order = Order::where('id', $id)->first();
        $order_detail = OrderDetail::where('order_id', $id)->get();
        return view('customer.invoice', compact('order','order_detail'));
    }

    public function delete($id){

        $order = Order::where('id', $id)->delete();
        $order_detail = OrderDetail::where('order_id', $id)->delete();
        $booked_room = BookedRoom::where('order_id', $id)->delete();

        return redirect()->back()->with('success', 'Booking is canceled successfully.');
    }
}
