@extends('customer.layout.app')

@section('heading','Edit Profile')

@section('main_content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form  method="POST" action="{{route('customer_profile_submit')}}" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                @php
                                if(Auth::guard('customer')->user()->photo != ''){
                                    $customer_photo = Auth::guard('customer')->user()->photo;
                                }
                                else{
                                    $customer_photo = 'default.png';
                                }
                                @endphp
                                <img src="{{asset('uploads/' .$customer_photo)}}" alt="" class="profile-photo w_100_p">
                                <input type="file" class="form-control mt_10" name="photo">
                            </div>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label class="form-label">Name *</label>
                                            <input type="text" class="form-control" name="name" value="{{Auth::guard('customer')->user()->name}}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label class="form-label">Email *</label>
                                            <input type="text" class="form-control" name="email" value="{{Auth::guard('customer')->user()->email}}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label class="form-label">Phone </label>
                                            <input type="text" class="form-control" name="phone" value="{{Auth::guard('customer')->user()->phone}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label class="form-label">Purok </label>
                                            <input type="text" class="form-control" name="purok" value="{{Auth::guard('customer')->user()->purok}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label class="form-label">Barangay </label>
                                            <input type="text" class="form-control" name="barangay" value="{{Auth::guard('customer')->user()->barangay}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label class="form-label">City/Municipality</label>
                                            <input type="text" class="form-control" name="city" value="{{Auth::guard('customer')->user()->city}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label class="form-label">Province</label>
                                            <input type="text" class="form-control" name="province" value="{{Auth::guard('customer')->user()->province}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label class="form-label">ZIP code</label>
                                            <input type="text" class="form-control" name="zip" value="{{Auth::guard('customer')->user()->zip}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                                <label class="form-label">Password</label>
                                                <input type="password" class="form-control" name="password">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                                <label class="form-label">Retype Password</label>
                                                <input type="password" class="form-control" name="retype_password">
                                        </div>
                                    </div>
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