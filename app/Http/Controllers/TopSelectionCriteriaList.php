<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopSelectionCriteriaList extends Controller
{
    //
    public $name = 'Top Selection Criteria List';

    public function index(Request $request)
    {
        $account = $request->session()->get('account');
        $user = $account->role;

        //get topselectioncriterialist from database  
        $topResults = DB::table('post_criterias')
            ->orderBy('selected_count','DESC')
            ->select('name', 'selected_count')
            ->get();


        return view('dashboard/admin/dashboard_topselectioncriterialist', [
            'user' => $user,
            'page' => $this->name,
            'header' => $this->name,
            'topResults' => $topResults
        ]);
    }

















    
}
