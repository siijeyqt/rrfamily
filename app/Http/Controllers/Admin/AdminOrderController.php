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

        return redirect()->back()->with('success', 'Booking is deleted successfully.');
    }
    public function change_status(Request $request, $id){

        $booked_room = BookedRoom::where('order_id',$id)->get();
        $order_data = Order::where('id',$id)->first();

        if($request->payment_type == 'Partial Payment'){
            $order_data->paid_amount += $request->payment;
            $order_data->status = "Incomplete";
        }
        else{
            $order_data->paid_amount += $request->payment;
            $order_data->status = "Completed";
        }
        foreach($booked_room as $row){
            if($request->payment_type == 'Partial Payment'){
                
                $row->status = "Incomplete";
            }
            else{
                
                $row->status = "Completed";
            }
            $row->update();
            $order_data->update();
        }

        return redirect()->back()->with('success','Status is changed successfully');
    }
}
