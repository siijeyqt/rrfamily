@extends('admin.layout.app')

@section('heading','View Rooms')


@section('right_top_button')
<div class="ml-auto">
    <a href="{{route('admin_room_add')}}" class="btn btn-primary"><i class="fa fa-plus"></i>Add New</a>
</div>
@endsection


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
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Price (per night)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php 
                                    $i = 0;
                                @endphp
                                @foreach ($rooms as $row)
                                @php 
                                    $i++;
                                @endphp
                                <tr>
                                    <td>
                                        <img src="{{asset('uploads/'.$row->featured_photo)}}" alt="" class="w_200">
                                    </td>
                                    <td>{{$row->name}}</td>
                                    <td>₱{{number_format($row->price, 2)}}</td>
                                    <td class="pt_10 pb_10">
                                        <button class="btn btn-warning" data-toggle="modal" data-target="#exampleModal{{$i}}">Detail</button>
                                        <a href="{{route('admin_room_gallery', $row->id)}}" class="btn btn-success">Gallery</a>
                                        <a href="{{route('admin_room_edit', $row->id)}}" class="btn btn-primary">Edit</a>
                                        <a href="{{route('admin_room_delete', $row->id)}}" class="btn btn-danger" onClick="return confirm('Are you sure?');">Delete</a>
                                    </td>
                                </tr>
                                <div class="modal fade" id="exampleModal{{$i}}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Room Detail</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group row bdb1 pt_10 mb_0">
                                                    <div class="col-md-4"><label class="form-label">Photo</label></div>
                                                    <img src="{{asset('uploads/'.$row->featured_photo)}}" alt="" class="w_200">
                                                </div>
                                                <div class="form-group row bdb1 pt_10 mb_0">
                                                    <div class="col-md-4"><label class="form-label">Name</label></div>
                                                    <div class="col-md-8">{{$row->name}}</div>
                                                </div>
                                                <div class="form-group row bdb1 pt_10 mb_0">
                                                    <div class="col-md-4"><label class="form-label">Description</label></div>
                                                    <div class="col-md-8">{!!$row->description !!}</div>
                                                </div>
                                                <div class="form-group row bdb1 pt_10 mb_0">
                                                    <div class="col-md-4"><label class="form-label">Price (per night)</label></div>
                                                    <div class="col-md-8">₱{{number_format($row->price, 2) }}</div>
                                                </div>
                                                <div class="form-group row bdb1 pt_10 mb_0">
                                                    <div class="col-md-4"><label class="form-label">Total Rooms</label></div>
                                                    <div class="col-md-8">{{$row->total_rooms}}</div>
                                                </div>
                                                <div class="form-group row bdb1 pt_10 mb_0">
                                                    <div class="col-md-4"><label class="form-label">Amenities</label></div>
                                                    <div class="col-md-8">
                                                        @php
                                                            $arr = explode(',',$row->amenities);
                                                            for($j=0;$j<count($arr);$j++){
                                                                $temp_row = \App\Models\Amenity::where('id',$arr[$j])->first();
                                                                echo $temp_row->name. '<br>';
                                                            }
                                                        @endphp
                                                    </div>
                                                </div>
                                                <div class="form-group row bdb1 pt_10 mb_0">
                                                    <div class="col-md-4"><label class="form-label">Size</label></div>
                                                    <div class="col-md-8">{{$row->size }}</div>
                                                </div>
                                                <div class="form-group row bdb1 pt_10 mb_0">
                                                    <div class="col-md-4"><label class="form-label"></label>Total Beds</div>
                                                    <div class="col-md-8">{{$row->total_beds}}</div>
                                                </div>
                                                <div class="form-group row bdb1 pt_10 mb_0">
                                                    <div class="col-md-4"><label class="form-label"></label>Total Bathrooms</div>
                                                    <div class="col-md-8">{{$row->total_bathrooms}}</div>
                                                </div>
                                                <div class="form-group row bdb1 pt_10 mb_0">
                                                    <div class="col-md-4"><label class="form-label"></label>Total Guests</div>
                                                    <div class="col-md-8">{{$row->total_guests}}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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