<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class ContractController extends Controller
{
    //
    public $name = 'Renting Record';

    public function index(Request $request, $rentingID)
    {
        //Decrypt the parameter
        try {
            $rentingID = Crypt::decrypt($rentingID);
        } catch (DecryptException $ex) {
            abort('500', $ex->getMessage());
        }


        $account = $request->session()->get('account');
        $user = $account->role;

        //get contract details from database 
        $contractDetails = DB::table('contracts')
            ->join('rentings', 'rentings.contract_id', '=', 'contracts.contract_id')
            ->where('rentings.renting_id', $rentingID)
            ->select('contracts.*')
            ->get();

            return view('dashboard/tenant/dashboard_contract', [
                'user' => $user,
                'page' => $this->name,
                'header' => 'Contract',
                'back' => "/dashboard/rentingrecord/getrecordDetails/" . Crypt::encrypt($rentingID),
                'contractDetails' => $contractDetails
            ]);
        
        
    }
}
