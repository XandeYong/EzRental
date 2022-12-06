<?php

namespace App\Http\Controllers;

use App\Models\Negotiation;
use Illuminate\Http\Request;

class NegotiationController extends Controller
{
    //

    public function acceptNegotiation(Request $request) {
        $negotiation_id = $request->input('negotiationID', '');
        $deposit = $request->input('deposit_payment', '');
        $monthly = $request->input('monthly_payment', '');
        $message = $request->input('message', '');
        
        $status = "accepted";

        $negotiation = Negotiation::find($negotiation_id);
        $negotiation->deposit_price = $deposit;
        $negotiation->monthly_price = $monthly;
        $negotiation->message = $message;
        $negotiation->status = $status;
        $negotiation->save();

    }

    public function rejectNegotiation($id = "") {
        $negotiation = Negotiation::find($id);
        $negotiation->status = 'rejected';
        $negotiation->save();

        return redirect('/chat');
    }

}
