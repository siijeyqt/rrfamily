@extends('admin.layout.app')

@section('heading','Sales Report')

@section('main_content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin_sales_report')}}" method="GET">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Filter by Year</label>
                                <select name="years" data-column="0" class="form-control filter-select">
                                    <option value="">Select Year</option>
                                    @foreach($date as $row)
                                        <option value="{{$row->years}}"{{Request::get('years') == $row->years ? 'selected' : ''}}>{{$row->years}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <button name ="filter" type="submit" class="btn btn-primary" style="margin-top: 31px; width:100px;">Filter</button>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="example1">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Month - Year</th>
                                    <th class="text-right">Sales</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($data as $row)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$row->months}}</td>
                                    <td class="text-right">₱{{number_format($row->price,2)}}</td>
                                    <td class="pt_10 pb_10 w_150">
                                        <a href="" class="btn btn-warning">Detail</a>
                                    </td>
                                </tr>
                                @php
                                    $total += $row->price;
                                @endphp
                                @endforeach
                                <tr>
                                    <td class="text-right" colspan="2">Total Revenue</td>
                                    <td class="text-right">₱{{number_format($total,2)}}</td>
                                </tr> 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascripts')
	<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
@endsection