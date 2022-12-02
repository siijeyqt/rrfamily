<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Customer;
use Carbon\Carbon;
use DB;
use Auth;

class AdminSalesReportController extends Controller
{
    public function show(Request $request){

        
        $date = Order::select([

            DB::raw("DATE_FORMAT(created_at,'%Y') as years")
        ])
            ->groupBy('years')
            ->get();
        // dd($date);

        if($request->has('years')){
            $data = Order::select([

                DB::raw("DATE_FORMAT(created_at,'%M %Y') as months"),
                DB::raw('sum(paid_amount) as price')
            
                ])
                ->whereYear(DB::raw('date(created_at)'), '=', $request['years'])
                ->orderBy('created_at','asc')
                ->groupBy('months')
                ->get();
        }
        else{
        $data = Order::select([

            DB::raw("DATE_FORMAT(created_at,'%M %Y') as months"),
            DB::raw('sum(paid_amount) as price')
        
         ])
            ->where(DB::raw('date(created_at)'), '>=', \Carbon\Carbon::now()->subMonths(12))
            ->orderBy('created_at','asc')
            ->groupBy('months')
            ->get();
            // dd($data);
        }
         return view('admin.sales_report',compact('data','date'));
    }
}
