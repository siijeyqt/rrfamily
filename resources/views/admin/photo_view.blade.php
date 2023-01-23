@extends('admin.layout.app')

@section('heading','View Photos')


@section('right_top_button')
<div class="ml-auto">
    <a href="{{route('admin_photo_add')}}" class="btn btn-primary"><i class="fa fa-plus"></i>Add New</a>
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
                                    <th>Caption</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($photos as $row)
                                <tr>
                                    <td>
                                        <img src="{{asset('uploads/'.$row->photo)}}" alt="" class="w_200">
                                    </td>
                                    <td>
                                        {!!  $row->caption  !!}
                                    </td>
                                    <td class="pt_10 pb_10 w_150">
                                        <a href="{{route('admin_photo_edit', $row->id)}}" class="btn btn-primary">Edit</a>
                                        <a href="{{route('admin_photo_delete', $row->id)}}" class="btn btn-danger" onClick="return confirm('Are you sure?');">Delete</a>
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