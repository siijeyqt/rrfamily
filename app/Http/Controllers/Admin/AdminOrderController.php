<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Room;
use App\Models\BookedRoom;

class AdminOrderController extends Controller
{
    public function index(){

        $orders = Order::get();
        return view('admin.order', compact('orders'));
    }
    public function invoice($id){

        $order = Order::where('id', $id)->first();
        $order_detail = OrderDetail::where('order_id', $id)->get();
        $customer_data = Customer::where('id',$order->customer_id)->first();
        return view('admin.invoice', compact('order','order_detail','customer_data'));
    }

    public function delete($id){

        $order = Order::where('id', $id)->delete();
        $order_detail = OrderDetail::where('order_id', $id)->delete();
        $booked_room = BookedRoom::where('order_id', $id)->delete();

        return redirect()->back()->with('success', 'Order is deleted successfully.');
    }
    public function change_status(Request $request, $id){

        // dd($request->all());
        // dd($id);
        $order_data = Order::where('id',$id)->first();
        $order_detail = OrderDetail::where('id',$id)->get();
        foreach ($order_detail as $item){
            $room_data = Room::where('id', $item->room_id)->first();
            $arr = $item->no_of_rooms;
            $d1 = explode('/',$item->checkin_date);
            $d2 = explode('/',$item->checkout_date);
            $d1_new = $d1[2].'-'.$d1[0].'-'.$d1[1];
            $d2_new = $d2[2].'-'.$d2[0].'-'.$d2[1];
            $t1 = strtotime($d1_new);
            $t2 = strtotime($d2_new);
            $diff = ($t2 - $t1)/60/60/24;
            $subtotal = $room_data->price * $diff *$arr;
        }
        // dd($order_detail->all());
        // dd($item);
        if($request->payment_type == 'Partial Payment'){
            $order_data->paid_amount += $request->payment;
            $order_data->status = "Pending";
        }
        else{
            // $order_data->total_amount - $request->payment != 0;
            $order_data->paid_amount += $request->payment;
            $order_data->status = "Completed";
        }
        $order_data->update();

        return redirect()->back()->with('success','Status is changed successfully');
    }
}
