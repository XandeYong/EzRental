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
            ->join('criterias', 'criterias.criteria_id', '=', 'selected_criterias.criteria_id')
            ->where('selected_criterias.account_id', $id)
            ->select('criterias.criteria_id', 'criterias.name')
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
            ->join('criterias', 'criterias.criteria_id', '=', 'selected_criterias.criteria_id')
            ->where('selected_criterias.account_id', $id)
            ->select('criterias.criteria_id', 'criterias.selected_count')
            ->get();

        //get all criterias from database 
        $criterias = DB::table('criterias')
            ->select('criteria_id', 'name')
            ->get();

        //Put session
        if (session()->has('selectedCriterias')) {
            session()->forget('selectedCriterias');
        }
        if (!$selectedCriterias->isEmpty()) {
            $request->session()->put('selectedCriterias', $selectedCriterias);
        }



        return view('dashboard/tenant/dashboard_recommendation_select', [
            'user' => $user,
            'page' => $this->name,
            'header' => 'Recommendation Criteria',
            'back' => '/dashboard/recommendation/index',
            'selectedCriterias' => $selectedCriterias,
            'criterias' => $criterias
        ]);
    }

    public function updateSelectionCriteriaToDB(Request $request)
    {

        $account = $request->session()->get('account');
        $id = $account->account_id;

        //get collection from session
        if (session()->has('selectedCriterias')) {
            $selectedCriterias = $request->session()->get('selectedCriterias');
            session()->forget('selectedCriterias');
        }

        //remove 1 from all selected_criteria counts
        if (isset($selectedCriterias)) {
            foreach ($selectedCriterias as $selectedCriteria) {
                $updated = DB::table('criterias')
                    ->where('criteria_id', $selectedCriteria->criteria_id)
                    ->update(['selected_count' => $selectedCriteria->selected_count - 1]);
            }
        }

        //Clear the tenant selected criteria
        $deleted = DB::table('selected_criterias')
            ->where('account_id', $id)
            ->delete();


        //Get checkbox array from post
        $criterias = $_POST["criteria"];

        if (count($criterias) != 0) {
            //come here if there is something checked in form

            for ($i = 0; $i < count($criterias); $i++) {

                //add to database cause is checked
                DB::table('selected_criterias')->insert([
                    'account_id' => $id,
                    'criteria_id' => $criterias[$i]
                ]);

                //get selected criterias counts from database 
                $selectedCriteriaCount = DB::table('criterias')
                ->where('criteria_id', $criterias[$i])
                ->get();

                //add 1 from all selected_criteria counts
                $updated = DB::table('criterias')
                ->where('criteria_id', $criterias[$i])
                ->update(['selected_count' => $selectedCriteriaCount[0]->selected_count+1]);

            }
        }


        return redirect(route("dashboard.tenant.recommendation"));
    }
}
