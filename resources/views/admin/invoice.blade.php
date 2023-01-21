@extends('admin.layout.app')

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
                                {{$customer_data->name}}<br>
                                {{$customer_data->purok}}, {{$customer_data->barangay}},<br>
                                {{$customer_data->city}}, {{$customer_data->province}}, {{$customer_data->zip}}
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
                                <th>SL</th>
                                <th>Room Name</th>
                                <th class="text-center">Checkin Date</th>
                                <th class="text-center">Checkout Date</th>
                                <th class="text-center">Number of Rooms</th>
                                <th class="text-center">Number of Adults</th>
                                <th class="text-center">Number of Children</th>
                                <th class="text-center">Transaction Fee</th>
                                <th class="text-center">Paid Amount</th>
                                <th class="text-center">Total</th>
                            </tr>
                            @php
                                $total = 0;
                                $tax = 0.05;
                            @endphp
                            
                            @foreach ($order_detail as $item)
                            @php
                               $room_data = \App\Models\Room::where('id', $item->room_id)->first();
                               $order_data = \App\Models\Order::where('id',$item->id)->first();

                               
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{$room_data->name}}</td>
                                <td class="text-center">{{$item->checkin_date}}</td>
                                <td class="text-center">{{ $item->checkout_date }}</td>
                                <td class="text-center">{{ $item->no_of_rooms }}</td>
                                <td class="text-center">{{ $item->adult }}</td>
                                <td class="text-center">{{ $item->children }}</td>
                                @if($order_data->payment_method == 'PayPal')
                                    <td class="text-right">₱{{number_format($item->subtotal * $tax, 2)}}</td>
                                @else
                                    <td class="text-right">₱{{number_format(0, 2)}}</td>
                                @endif
                                <td class="text-right">₱{{number_format($order_data->paid_amount, 2)}}</td>
                                <td class="text-right">
                                    @php
                                        $arr = $item->no_of_rooms;
                                        $d1 = explode('/',$item->checkin_date);
                                        $d2 = explode('/',$item->checkout_date);
                                        $d1_new = $d1[2].'-'.$d1[0].'-'.$d1[1];
                                        $d2_new = $d2[2].'-'.$d2[0].'-'.$d2[1];
                                        $t1 = strtotime($d1_new);
                                        $t2 = strtotime($d2_new);
                                        $diff = ($t2 - $t1)/60/60/24;
                                        $subtotal = $room_data->price * $diff * $arr;

                                        if($order_data->payment_method == 'PayPal'){
                                            $transac = $subtotal * $tax;
                                            $total = $transac + $subtotal;
                                        }
                                        else{
                                            $total = $subtotal;
                                        }
                                    @endphp
                                    ₱{{number_format($total, 2)}}
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-12 text-right">
                            <div class="invoice-detail-item">
                                <div class="invoice-detail-name">Balance</div>
                                <div class="invoice-detail-value invoice-detail-value-lg">₱{{number_format($total - $order_data->paid_amount, 2)}}</div>
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