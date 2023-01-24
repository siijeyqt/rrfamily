@extends('customer.layout.app')

@section('heading','Booking Invoice')

@section('main_content')

<div class="section-body">
    <div class="invoice">
        <div class="invoice-print">
            <div class="row">
                <div class="col-lg-12">
                    <div class="invoice-title">
                        <h2>Invoice</h2>
                        <div class="invoice-number">Booking #{{$order->order_no}}</div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <address>
                                <strong>Invoice To</strong><br>
                                {{Auth::guard('customer')->user()->name}}<br>
                                {{Auth::guard('customer')->user()->purok}}, {{Auth::guard('customer')->user()->barangay}},<br>
                                {{Auth::guard('customer')->user()->city}}, {{Auth::guard('customer')->user()->province}}, {{Auth::guard('customer')->user()->zip}}
                            </address>
                        </div>
                        <div class="col-md-6 text-md-right">
                            <address>
                                <strong>Invoice Date</strong><br>
                                {{$order->booking_date}}
                            </address>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="section-title">Booking Summary</div>
                    <p class="section-lead">Room booking information are given below:</p>
                    <hr class="invoice-above-table">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-md">
                            <tr>
                                <th>Room Name</th>
                                <th class="text-center">Checkin Date</th>
                                <th class="text-center">Checkout Date</th>
                                <th class="text-center">Number of Rooms</th>
                                <th class="text-center">Number of Adults</th>
                                <th class="text-center">Number of Children</th>
                                <th class="text-right">Subtotal</th>
                            </tr>
                            @php
                                $total = 0;
                                $tax = 0.05;
                            @endphp
                            @foreach ($order_detail as $item)
                            @php
                               $room_data = \App\Models\Room::where('id', $item->room_id)->first();
                               $order_data = \App\Models\Order::where('id',$item->order_id)->first();
                            @endphp
                            <tr>
                                <td>{{$room_data->name}}</td>
                                <td class="text-center">{{$item->checkin_date}}</td>
                                <td class="text-center">{{ $item->checkout_date }}</td>
                                <td class="text-center">{{ $item->no_of_rooms }}</td>
                                <td class="text-center">{{ $item->adult }}</td>
                                <td class="text-center">{{ $item->children }}</td>
                                <td class="text-right">
                                    ₱{{number_format($item->subtotal, 2)}}
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="6" class="text-right">Subtotal Amount:</td>
                                <td class="text-right">₱{{number_format($order_data->total_amount, 2)}}</td>
                            </tr>
                            <tr>
                                <td colspan="6" class="text-right">Transaction Fee:</td>
                                @if($order_data->payment_method == 'PayPal')
                                    <td class="text-right">₱{{number_format($order_data->total_amount * $tax, 2)}}</td>
                                @else
                                    <td class="text-right">₱{{number_format(0, 2)}}</td>
                                @endif
                            </tr>
                            <tr>
                                @if($order_data->payment_method == 'PayPal')
                                    <td colspan="6" class="text-right">Total Amount:</td>
                                    <td colspan="7" class="text-right">₱{{number_format($order_data->total_amount + ($order_data->total_amount * $tax), 2)}}</td>
                                @else
                                    <td colspan="6" class="text-right">Total Amount:</td>
                                    <td colspan="7" class="text-right">₱{{number_format($order_data->total_amount, 2)}}</td>
                                @endif
                            </tr>
                        </table>
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-12 text-right">
                            <div class="invoice-detail-item">
                                <div class="invoice-detail-name">Paid Amount</div>
                                <div class="invoice-detail-value invoice-detail-value-lg">₱{{number_format($order_data->paid_amount, 2)}}</div>
                                <div class="invoice-detail-name">Balance</div>
                                @if($order_data->payment_method == 'PayPal')
                                    <div class="invoice-detail-value invoice-detail-value-lg">₱{{number_format($order_data->total_amount + ($order_data->total_amount* $tax) - $order_data->paid_amount, 2)}}</div>
                                @else
                                    <div class="invoice-detail-value invoice-detail-value-lg">₱{{number_format($order_data->total_amount - $order_data->paid_amount, 2)}}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr class="about-print-button">
        <div class="text-md-right">
            <a href="javascript:window.print();" class="btn btn-warning btn-icon icon-left text-white print-invoice-button"><i class="fa fa-print"></i> Print</a>
        </div>
    </div>
</div>
@endsection