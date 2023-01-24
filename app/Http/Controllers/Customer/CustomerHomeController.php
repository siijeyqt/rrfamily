<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Auth;
Use App\Models\Customer;
Use App\Models\OrderDetail;
Use App\Models\BookedRoom;

class CustomerHomeController extends Controller
{
    public function index(){

        $total_completed_orders = Order::where('status', 'Completed')->where('customer_id',Auth::guard('customer')->user()->id)->count();
        $total_pending_orders = Order::where('status', 'Pending')->where('customer_id',Auth::guard('customer')->user()->id)->count();
        $orders = Order::where('customer_id',Auth::guard('customer')->user()->id)->get();
        return view('customer.home', compact('total_completed_orders','total_pending_orders','orders'));
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
