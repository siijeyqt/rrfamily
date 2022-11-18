@extends('admin.layout.app')

@section('heading','Edit Room')

@section('right_top_button')
    <a href="{{route('admin_room_view')}}" class="btn btn-primary"><i class="fa fa-eye"></i>View All</a>
@endsection


@section('main_content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form  method="POST" action="{{route('admin_room_update', $room_data->id)}}" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-4">
                                    <label class="form-label">Existing Featured Photo</label>
                                    <div>
                                        <img src="{{asset('uploads/'.$room_data->featured_photo)}}" alt="" class="w_200">
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Change Featured Photo</label>
                                    <div>
                                        <input type="file" name="featured_photo">
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Name *</label>
                                    <input type="text" class="form-control" name="name" value="{{$room_data->name}}">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Description *</label>
                                    <textarea name="description" class="form-control snote" cols="30" row="10">{{$room_data->description}}</textarea>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Price *</label>
                                    <input type="text" class="form-control" name="price" value="{{$room_data->price}}">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Total Rooms *</label>
                                    <input type="text" class="form-control" name="total_rooms" value="{{$room_data->total_rooms}}">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Amenities</label>
                                    @php
                                        $i=0;
                                    @endphp
                                    @foreach($all_amenities as $item)

                                        @if(in_array($item->id,$existing_amenities))
                                            @php
                                                $checked_type='checked';
                                            @endphp
                                        @else
                                            @php
                                                $checked_type='';
                                            @endphp
                                            
                                        @endif
                                        @php 
                                            $i++; 
                                        @endphp
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{$item->id}}" id="defaultCheck{{$i}}" name="arr_amenities[]" {{$checked_type}}>
                                            <label class="form-check-label" for="defaultCheck{{$i}}">
                                            {{$item->name}}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Room Size</label>
                                    <input type="text" class="form-control" name="size" value="{{$room_data->size}}">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Total Beds</label>
                                    <input type="text" class="form-control" name="total_beds" value="{{$room_data->total_beds}}">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Total Bathrooms</label>
                                    <input type="text" class="form-control" name="total_bathrooms" value="{{$room_data->total_bathrooms}}">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Total Guests</label>
                                    <input type="text" class="form-control" name="total_guests" value="{{$room_data->total_guests}}">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label"></label>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection