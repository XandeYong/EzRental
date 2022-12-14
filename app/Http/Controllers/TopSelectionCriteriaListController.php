<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class TopSelectionCriteriaListController extends Controller
{
    public $name = 'Top Selection Criteria List';

    public function index()
    {
        //get topselectioncriterialist from database  
        $topResults = DB::table('criterias')
            ->orderBy('selected_count','DESC')
            ->select('name', 'type', 'selected_count')
            ->get();

        return view('dashboard/admin/dashboard_topselectioncriterialist', [
            'page' => 'Report',
            'header' => $this->name,
            'topResults' => $topResults
        ]);
    }

}