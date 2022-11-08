<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    //
    public $name = 'Test for Auto Search-Match Recommendation Function';

    //Auto Search-Match Recommendation Function
    public function test(Request $request)
    {
        $account = $request->session()->get('account');
        $id = $account->account_id;
        $user = $account->role;

        //get selected criterias from database 
        $selectedCriterias = DB::table('selected_criterias')
            ->join('criterias', 'criterias.criteria_id', '=', 'selected_criterias.criteria_id')
            ->where('selected_criterias.account_id', $id)
            ->select('criterias.criteria_id', 'criterias.name')
            ->get();

        if ($selectedCriterias->isEmpty()){
            $rentalPost = DB::table('room_rental_posts')
            ->get();
            dd($rentalPost);
        }else{

        }


        return view('dashboard/tenant/dashboard_test', [
            'user' => $user,
            'page' => $this->name,
            'header' => $this->name,
            'selectedCriterias' => $selectedCriterias
        ]);

    }





    
}
