<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\PostCriteria;
use App\Models\RoomRentalPost;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;

class CriteriaController extends Controller
{
    
    public function ownerIndex($postID) {

        $return = [
            'page' => 'Room Rental Post',
            'header' => 'Select Criteria',
            'back' => "/dashboard/room_rental_post_list/$postID",
            'postID' => $postID,
            'criterias' => ''
        ];

        $data = $this->decrypt([
            'postID' => $postID
        ]);

        $criterias = Criteria::get();
        $postCriterias = RoomRentalPost::find($data['postID'])->criterias()->get();

        while($pc = $postCriterias->pop()) {
            foreach ($criterias as $i => $criteria) {
                if ($criteria->criteria_id == $pc->criteria_id) {
                    $criteria->check = "checked";
                }
            }
        }

        $return['criterias'] = $criterias;

        return view('/dashboard/owner/dashboard_criteria_list', $return);
    }

    public function updateCriteria(Request $request, $postID) {

        $return = [
            'postID' => $postID
        ];

        $data = $this->decrypt([
            'postID' => $postID
        ]);

        $criterias = $request->input('criterias', array());
        $dbCriterias = PostCriteria::where('post_id', $data['postID'])
            ->get();

        foreach ($criterias as $i => $criteria) {
            $record = PostCriteria::where('post_id', $data['postID'])
                ->where('criteria_id', $criteria)
                ->get();

            if($record->isEmpty()) {
                $insert = [
                    'criteria_id' => Arr::pull($criterias, $i),
                    'post_id' => $data['postID']
                ];

                PostCriteria::insert($insert);
            } else {
                foreach ($dbCriterias as $j => $dbCriteria) {
                    if ($dbCriteria->criteria_id == $criteria) {
                        $dbCriterias->pull($j);
                    }
                }
            }
        }
        
        foreach ($dbCriterias as $dbCriteria) {
            PostCriteria::where('post_id', $data['postID'])
                ->where('criteria_id', $dbCriteria->criteria_id)
                ->delete();
        }

        return redirect(route('dashboard.owner.room_rental_post', $return));
    }


    public function decrypt($data) {

        try {
            foreach ($data as $i => $v) {
                $data[$i] = Crypt::decrypt($v);
            }
        } catch (DecryptException $ex) {
            abort('500', $ex->getMessage());
        }

        return $data;
    }

}
