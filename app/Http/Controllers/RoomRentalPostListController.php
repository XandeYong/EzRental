<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomRentalPostListController extends Controller
{

    public function index() {

        $rrpList = DB::table('room_rental_posts')
            ->join('contracts', 'contracts.post_id', '=', 'room_rental_posts.post_id')
            ->where('room_rental_posts.status', 'available')
            ->select('room_rental_posts.*', 'contracts.monthly_price')
            ->get();

        return view('rentalpost_list', [
            'roomRentalPostLists' => $rrpList
        ]);

    }
}
