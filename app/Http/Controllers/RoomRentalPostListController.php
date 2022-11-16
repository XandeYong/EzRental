<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomRentalPostListController extends Controller
{

    public function index()
    {

        $rrpList = DB::table('room_rental_posts')
            ->join('contracts', 'contracts.post_id', '=', 'room_rental_posts.post_id')
            ->where('room_rental_posts.status', 'available')
            ->select('room_rental_posts.*', 'contracts.monthly_price')
            ->get();

        return view('rentalpost_list', [
            'roomRentalPostLists' => $rrpList
        ]);
    }

    //Auto Search-Match Recommendation Function
    public function autoSearchMatchRecommendation(Request $request)
    {
        $account = $request->session()->get('account');
        $id = $account->account_id;
        $user = $account->role;

        //get selected criterias from database 
        $selectedCriterias = DB::table('selected_criterias')
            ->join('criterias', 'criterias.criteria_id', '=', 'selected_criterias.criteria_id')
            ->where('selected_criterias.account_id', $id)
            ->select('criterias.criteria_id')
            ->get();


        //Define a collection variable to store all room rental post
        $roomRentalPostLists = collect();

        if (!$selectedCriterias->isEmpty()) {
            //Change selectedCriterias collection to array
            $selectedCriteriasArray = array();
            for ($i = 0; $i < count($selectedCriterias); $i++) {
                array_push($selectedCriteriasArray, $selectedCriterias[$i]->criteria_id);
            }

            //if got selected criteria then display filtered post list
            for ($i = count($selectedCriteriasArray); $i > 0; $i--) {

                //Get all the unique combination based on size
                $comparePair = $this->allSubsets($selectedCriteriasArray, $i);

                for ($h = 0; $h < count($comparePair); $h++) {

                    $rentalPost = DB::table('room_rental_posts')
                        ->join('contracts', 'contracts.post_id', '=', 'room_rental_posts.post_id')
                        ->join('post_criterias', 'post_criterias.post_id', '=', 'room_rental_posts.post_id')
                        ->join('criterias', 'criterias.criteria_id', '=', 'post_criterias.criteria_id')
                        ->join('selected_criterias', 'selected_criterias.criteria_id', '=', 'criterias.criteria_id')
                        ->where(
                            function ($query) use ($h, $comparePair) {
                                //loop all condition
                                for ($x = 0; $x < count($comparePair[$h]); $x++) {

                                    $query = $query
                                        ->where('selected_criterias.criteria_id', $comparePair[$h][$x]);
                                }
                                return $query;
                            }
                        )
                        ->where('room_rental_posts.status', 'available')
                        ->select('room_rental_posts.*', 'contracts.monthly_price')
                        ->get();

                    if (!$rentalPost->isEmpty()) {
                        $roomRentalPostLists->add($rentalPost[0]);
                    }
                }
            }
        }

        //get all random post list
        $allRentalPost = DB::table('room_rental_posts')
            ->join('contracts', 'contracts.post_id', '=', 'room_rental_posts.post_id')
            ->where('room_rental_posts.status', 'available')
            ->select('room_rental_posts.*', 'contracts.monthly_price')
            ->get();

        if (!$allRentalPost->isEmpty()) {
            for ($i = 0; $i < count($allRentalPost); $i++) {
                $roomRentalPostLists->add($allRentalPost[$i]);
            }
        }

        if (count($roomRentalPostLists) != 0) {
            //Remove duplicate object in collection
            $roomRentalPostLists = $roomRentalPostLists->unique('post_id');
        }


        return view('rentalpost_list', [
            'roomRentalPostLists' => $roomRentalPostLists
        ]);
    }



    //remove duplicate object in a array
    function unique_multi_array($array, $key)
    {
        $temp = array();
        $i = 0;
        $x = 0;
        $key_array = array();

        foreach ($array as $val) {
            // convert objects to arrays, in_array() does not support objects
            if (is_object($val))
                $val = (array)$val;


            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp[$x] = $val;
                $x++;
            }
            $i++;
        }
        return $temp;
    }


    //get unique pair of combination
    function allSubsets($set, $size)
    {
        $subsets = [];
        if ($size == 1) {
            return array_map(function ($v) {
                return [$v];
            }, $set);
        }
        foreach ($this->allSubsets($set, $size - 1) as $subset) {
            foreach ($set as $element) {
                if (!in_array($element, $subset)) {
                    $newSet = array_merge($subset, [$element]);
                    sort($newSet);
                    if (!in_array($newSet, $subsets)) {
                        $subsets[] = array_merge($subset, [$element]);
                    }
                }
            }
        }
        return $subsets;
    }


    public function searchRentalPost(Request $request)
    {

        //get search from search field in retal post list page
        $search = trim($request->input('search'));


        if (strlen($search) <= 255) {

            //get all room_rental_posts from database with id
            $roomRentalPostLists = DB::table('room_rental_posts')
                ->join('contracts', 'contracts.post_id', '=', 'room_rental_posts.post_id')
                ->where('room_rental_posts.post_id', $search)
                ->where('room_rental_posts.status', 'available')
                ->select('room_rental_posts.*', 'contracts.monthly_price')
                ->get();

            if ($roomRentalPostLists->isEmpty()) {
                //get all room_rental_posts from database  with title
                $roomRentalPostLists = DB::table('room_rental_posts')
                    ->join('contracts', 'contracts.post_id', '=', 'room_rental_posts.post_id')
                    ->where('room_rental_posts.title',  'LIKE', '%'.$search.'%') 
                    ->where('room_rental_posts.status', 'available')
                    ->select('room_rental_posts.*', 'contracts.monthly_price')
                    ->get();
            }

        } else {

            $errorMessage = "*Input cannot be more than 255 characters!";
            $request->session()->put('errorMessage', $errorMessage);
            
            return back()->withInput();
        }

        return view('rental_post_list', [
            'roomRentalPostLists' => $roomRentalPostLists
        ]);

    }

   


}
