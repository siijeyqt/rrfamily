@extends('admin.layout.app')

@section('heading','Customer Bookings')

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
                                @php
                                    $tax = 0.05;
                                @endphp
                                @foreach ($orders as $row)
                                @php
                                    $order_data = \App\Models\OrderDetail::where('id',$row->id)->first();

                                @endphp
                                <tr>
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
                                        <a type="button" class="badge badge-pill badge-warning" data-toggle="modal" data-target="#exampleModalCenter{{$row->id}}">Pending</a>
                                        @else
                                        <span class="badge badge-pill badge-primary">Completed</span>
                                        @endif</td>
                                    <td class="pt_10 pb_10 w_150">
                                        <a href="{{route('admin_invoice', $row->id)}}" class="btn btn-warning">Detail</a>
                                        <a href="{{route('admin_order_delete', $row->id)}}" class="btn btn-danger" onClick="return confirm('Are you sure?');">Delete</a>
                                    </td>
                                </tr>
                                    <div class="modal fade" id="exampleModalCenter{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <form action="{{route('admin_order_change_status', $row->id)}}" method="post" autocomplete="off">
                                            @csrf
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Input Payment</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="text" id="payment" name="payment" autocomplete="off"><br>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Please select your payment type:</p>
                                                    <input type="radio" id="partial" name="payment_type" value="Partial Payment" required>
                                                    <label>Partial Payment</label><br>
                                                    <input type="radio" id="full" name="payment_type" value="Full Payment" required>
                                                    <label>Full Payment</label><br>
                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    </div>
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