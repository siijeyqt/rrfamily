@extends('admin.layout.app')

@section('heading','Dashboard')

@section('main_content')
<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-success">
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
            <div class="card-icon bg-primary">
                <i class="fa fa-shopping-cart"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Incomplete Bookings</h4>
                </div>
                <div class="card-body">
                    {{$total_incomplete_orders}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
                <i class="fa fa-book"></i>
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
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
                <i class="fa fa-hotel"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Rooms</h4>
                </div>
                <div class="card-body">
                    {{$total_rooms}}
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
                <i class="fa fa-users"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Subscribers</h4>
                </div>
                <div class="card-body">
                    {{$total_subscribers}}
                </div>
            </div>
        </div>
    </div> --}}
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-success">
                <i class="fa fa-user"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Validated Customers</h4>
                </div>
                <div class="card-body">
                    {{$total_active_customers}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-danger">
                <i class="fa fa-user"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Invalidated Customers</h4>
                </div>
                <div class="card-body">
                    {{$total_inactive_customers}}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <section class="section">
            <div class="section-header">
                <h1>Recent Bookings</h1>
            </div>            
        </section>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Booking Number</th>
                                            <th>Payment Method</th>
                                            <th>Booking Date</th>
                                            <th>Paid Amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $row)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$row->order_no}}</td>
                                            <td>{{$row->payment_method}}</td>
                                            <td>{{$row->booking_date}}</td>
                                            <td>₱{{number_format($row->paid_amount, 2)}}</td>
                                            <td class="pt_10 pb_10 w_200">
                                                <a href="{{route('admin_invoice', $row->id)}}" class="btn btn-warning">Detail</a>
                                                <a href="{{route('admin_order_delete', $row->id)}}" class="btn btn-danger" onClick="return confirm('Are you sure?');">Delete</a>
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
    </div>
</div>
@endsection