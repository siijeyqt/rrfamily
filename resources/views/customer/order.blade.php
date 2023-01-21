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
                                    <th>SL</th>
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
                                @php
                                    $tax = 0.05;
                                @endphp
                                @foreach ($orders as $row)
                                @php
                                    $order_data = \App\Models\OrderDetail::where('id',$row->id)->first();
                                @endphp
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$row->order_no}}</td>
                                    <td>{{$row->payment_method}}</td>
                                    <td>{{$row->booking_date}}</td>
                                    @if($row->payment_method == 'PayPal')
                                        <td class="text-right">₱{{number_format($order_data->subtotal * $tax, 2)}}</td>
                                    @else
                                        <td class="text-right">₱{{number_format(0, 2)}}</td>
                                    @endif
                                    <td class="text-right">₱{{number_format($row->total_amount, 2)}}</td>
                                    <td class="text-right">₱{{number_format($row->paid_amount, 2)}}</td>
                                    <td class="text-right">₱
                                        {{number_format($row->total_amount - $row->paid_amount, 2)}} 
                                    </td>
                                    <td>@if ($row->status == "Pending")
                                        <span class="badge badge-pill badge-warning">Pending</span>
                                        @else
                                        <span class="badge badge-pill badge-primary">Completed</span>
                                        @endif</td>
                                    <td class="pt_10 pb_10 w_150">
                                        <a href="{{route('customer_invoice', $row->id)}}" class="btn btn-warning">Detail</a>
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