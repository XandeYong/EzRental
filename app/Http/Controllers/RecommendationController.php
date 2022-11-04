<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecommendationController extends Controller
{
    //
    public $name = 'Recommendation';

    public function index(Request $request)
    {
        $account = $request->session()->get('account'); 
        $id = $account->account_id;
        $user = $account->role;

        //get selected criterias from database 
        $selectedCriterias = DB::table('selected_criterias')
        ->join('post_criterias', 'post_criterias.criteria_id', '=', 'selected_criterias.criteria_id')
        ->where('selected_criterias.account_id', $id)
        ->select('post_criterias.criteria_id', 'post_criterias.name')
        ->get();
        

        return view('dashboard/tenant/dashboard_recommendation', [
            'user' => $user,
            'page' => $this->name,
            'header' => 'Recommendation Criteria',
            'selectedCriterias' => $selectedCriterias
        ]);

    }

    public function getCriteriaList(Request $request)
    {
        $account = $request->session()->get('account'); 
        $id = $account->account_id;
        $user = $account->role;

        //get selected criterias from database 
        $selectedCriterias = DB::table('selected_criterias')
        ->join('post_criterias', 'post_criterias.criteria_id', '=', 'selected_criterias.criteria_id')
        ->where('selected_criterias.account_id', $id)
        ->select('post_criterias.criteria_id')
        ->get();

        //get all post_criterias from database 
        $postCriterias = DB::table('post_criterias')
        ->select('criteria_id', 'name')
        ->get();        
        

        return view('dashboard/tenant/dashboard_recommendation_select', [
            'user' => $user,
            'page' => $this->name,
            'header' => 'Recommendation Criteria',
            'back' => '/dashboard/recommendation/index',
            'selectedCriterias' => $selectedCriterias,
            'postCriterias' => $postCriterias
        ]);

    }




}
