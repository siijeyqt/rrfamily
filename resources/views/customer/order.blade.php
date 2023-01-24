@extends('customer.layout.app')

@section('heading','View Bookings')

@section('main_content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
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
    </div>
</div>
@endsection