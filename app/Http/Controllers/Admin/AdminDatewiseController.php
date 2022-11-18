<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookedRoom;

class AdminDatewiseController extends Controller
{
    public function index(){

        return view('admin.datewise_room');
    }

    public function show(Request $request){

        $request->validate([

            'select_date' => 'required'

        ]);

        $select_date = $request->select_date;
        

        return view('admin.datewise_room_detail', compact('select_date'));

    }
}
