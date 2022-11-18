<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;

class AdminSalesReportController extends Controller
{
    public function index(){

        return view('admin.sales_report');
    }

    public function show(Request $request){

        $request->validate([

            'select_month' => 'required'

        ]);
        $month = explode('-',$request->select_month);
        
        $date = Order::whereMonth('created_at', '=', $month[0])->whereYear('created_at', '=', $month[1])->get();
        
        dd($month[0]);
        return view('admin.sales_report_detail',compact('date','month'));
    }
}
