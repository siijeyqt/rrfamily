@extends('admin.layout.app')

@section('heading','Rooms (Booked and Available) '.$select_date)


@section('right_top_button')
<div class="ml-auto">
    <a href="{{route('admin_datewise_room')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i>Back to previous</a>
</div>
@endsection


@section('main_content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Room Name</th>
                                    <th>Total Rooms</th>
                                    <th>Booked Rooms</th>
                                    <th>Available Rooms</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                   $rooms =  \App\Models\Room::get();
                                  
                                @endphp
                                @foreach ($rooms as $row)
                                <tr>
                                    <td>{{$row->name}}</td>
                                    <td>{{$row->total_rooms}}</td>
                                    <td>
                                        @php
                                        $complete = \App\Models\BookedRoom::where('room_id',$row->id)->where('booking_date',$select_date)->where('status','Completed')->get();
                                        $incomplete = \App\Models\BookedRoom::where('room_id',$row->id)->where('booking_date',$select_date)->where('status','Incomplete')->get();

                                        @endphp
                                        {{!count($complete) && !count($incomplete) ? 0 : (count($complete) + count($incomplete))}}
                                    </td>
                                    <td>
                                        {{$row->total_rooms - (count($complete) + count($incomplete))}}
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