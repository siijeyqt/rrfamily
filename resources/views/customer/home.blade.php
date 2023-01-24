@extends('customer.layout.app')

@section('heading','Dashboard')

@section('main_content')
<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
                <i class="fa fa-shopping-cart"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Completed Bookings</h4>
                </div>
                <div class="card-body">
                    {{$total_completed_orders}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
                <i class="fa fa-user"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Pending Bookings</h4>
                </div>
                <div class="card-body">
                    {{$total_pending_orders}}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <section class="section">
            <div class="section-header">
                <h1>Your Bookings</h1>
            </div>            
        </section>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="example1">
                    <thead>
                        <tr>
                            <th>Booking Number</th>
                            <th>Payment Method</th>
                            <th>Booking Date</th>
                            <th>Transaction Fee</th>
                            <th>Total Amount</th>
                            <th>Paid Amount</th>
                            <th>Balance</th>
                            <th>Payment Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $row)
                        @php
                            $tax = 0.05;
                            $total = $row->total_amount + ($row->total_amount * $tax);
                            $order_data = \App\Models\OrderDetail::where('id',$row->id)->first();
                        @endphp
                        <tr>
                            <td>{{$row->order_no}}</td>
                            <td>{{$row->payment_method}}</td>
                            <td>{{$row->booking_date}}</td>
                            @if($row->payment_method == 'PayPal')
                                <td class="text-right">₱{{number_format($row->total_amount * $tax, 2)}}</td>
                            @else
                                <td class="text-right">₱{{number_format(0, 2)}}</td>
                            @endif
                            <td class="text-right">₱{{number_format($row->total_amount, 2)}}</td>
                            <td class="text-right">₱{{number_format($row->paid_amount, 2)}}</td>
                            @if($row->payment_method == 'PayPal')
                            <td class="text-right">₱
                                {{number_format($total - $row->paid_amount, 2)}} 
                            </td>
                            @else
                            <td class="text-right">₱
                                {{number_format($row->total_amount - $row->paid_amount, 2)}}
                            </td>
                            @endif
                            <td>@if ($row->status == "Pending")
                                <span class="badge badge-pill badge-warning">Pending</span>
                                @else
                                <span class="badge badge-pill badge-primary">Completed</span>
                                @endif</td>
                            <td class="pt_10 pb_10 w_150">
                                <a href="{{route('customer_invoice', $row->id)}}" class="btn btn-warning">Detail</a>
                                @if($row->payment_method == 'Cash')
                                    <a href="{{route('customer_order_delete', $row->id)}}" class="btn btn-danger" onClick="return confirm('Are you sure?');">Cancel</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection