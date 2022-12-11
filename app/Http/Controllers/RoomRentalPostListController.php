<?php

namespace App\Http\Controllers;

use App\Models\RoomRentalPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class RoomRentalPostListController extends Controller
{

    public function index()
    {

        $rrpList = DB::table('room_rental_posts')
            ->join('contracts', 'contracts.post_id', '=', 'room_rental_posts.post_id')
            ->where('room_rental_posts.status', 'available')
            ->where('contracts.status', 'inactive')
            ->orderBy('room_rental_posts.created_at', 'desc')
            ->select('room_rental_posts.*', 'contracts.monthly_price')
            ->get();

        $criteriaLists = DB::table('criterias')
            ->select('criteria_id', 'name')
            ->get();


        //get all criterias related to post    
        $postCriterias = array();
        for ($i = 0; $i < count($rrpList); $i++) {

            $postCriteria = DB::table('room_rental_posts')
                ->join('post_criterias', 'post_criterias.post_id', '=', 'room_rental_posts.post_id')
                ->join('criterias', 'criterias.criteria_id', '=', 'post_criterias.criteria_id')
                ->where('room_rental_posts.post_id', $rrpList[$i]->post_id)
                ->select('room_rental_posts.post_id', 'criterias.criteria_id', 'criterias.name')
                ->get();

            if (!$postCriteria->isEmpty()) {
                foreach ($postCriteria as $criteria) {
                    array_push($postCriterias,  $criteria);
                }
            }
        }
        //Converting an array -> stdClass/Object
        $postCriterias = json_decode(json_encode($postCriterias));



        return view('rentalpost_list', [
            'roomRentalPostLists' => $rrpList,
            'criteriaLists' => $criteriaLists,
            'postCriterias' => $postCriterias
        ]);
    }

    public function ownerIndex()
    {

        $header = 'Room Rental Post List';
        $page = 'Room Rental Post';
        $account_id = session()->get('account')['account_id'];

        $rrpList = DB::table('room_rental_posts')
            ->where('room_rental_posts.account_id', $account_id)
            ->orderByDesc('created_at')
            ->get();

        return view('dashboard/owner/dashboard_rentalpost_list', [
            'page' => $page,
            'header' => $header,
            'button' => [
                'name' => 'Create Room Rental Post',
                'link' => '/dashboard/room_rental_post/create_room_rental_post',
            ],
            'posts' => $rrpList
        ]);
    }

    //Auto Search-Match Recommendation Function
    public function autoSearchMatchRecommendation(Request $request)
    {
        $account = $request->session()->get('account');
        $id = $account->account_id;

        //get selected criterias from database 
        $selectedCriterias = DB::table('selected_criterias')
            ->join('criterias', 'criterias.criteria_id', '=', 'selected_criterias.criteria_id')
            ->where('selected_criterias.account_id', $id)
            ->select('criterias.criteria_id')
            ->get();

        $wherein = array();
        foreach ($selectedCriterias as $criteria) {
            array_push($wherein,  $criteria->criteria_id);
        }

        //Match the room rental post with array of selected criteria
        $matchedPost = DB::table('room_rental_posts')
            ->join('contracts', 'contracts.post_id', '=', 'room_rental_posts.post_id')
            ->join('post_criterias', 'post_criterias.post_id', '=', 'room_rental_posts.post_id')
            ->where('room_rental_posts.status', 'available')
            ->where('contracts.status', 'inactive')
            ->whereIn('post_criterias.criteria_id', $wherein)
            ->orderByDesc('updated_at')
            ->select('room_rental_posts.*', 'contracts.monthly_price')
            ->get();

        //Sort post
        $sortedMatchedPost = collect();
        if (!$matchedPost->isEmpty()) {
            $sorted = $matchedPost->countBy('post_id')->sortDesc();

            foreach ($sorted as $key => $value) {
                foreach ($matchedPost as $rrp) {
                    if ($rrp->post_id == $key) {
                        $sortedMatchedPost->push($rrp);
                        break;
                    }
                }
            }
        }

        //get all random post list
        $allRentalPost = DB::table('room_rental_posts')
            ->join('contracts', 'contracts.post_id', '=', 'room_rental_posts.post_id')
            ->where('room_rental_posts.status', 'available')
            ->where('contracts.status', 'inactive')
            ->select('room_rental_posts.*', 'contracts.monthly_price')
            ->orderByDesc('updated_at')
            ->get();

        $unique = $sortedMatchedPost->merge($allRentalPost)->unique();
        $roomRentalPostLists = collect();
        foreach ($unique as $rrp) {
            $roomRentalPostLists->push($rrp);
        }

        $criteriaLists = DB::table('criterias')
            ->select('criteria_id', 'name')
            ->get();


        //get all criterias related to post    
        $postCriterias = array();
        for ($i = 0; $i < count($roomRentalPostLists); $i++) {

            $postCriteria = DB::table('room_rental_posts')
                ->join('post_criterias', 'post_criterias.post_id', '=', 'room_rental_posts.post_id')
                ->join('criterias', 'criterias.criteria_id', '=', 'post_criterias.criteria_id')
                ->where('room_rental_posts.post_id', $roomRentalPostLists[$i]->post_id)
                ->select('room_rental_posts.post_id', 'criterias.criteria_id', 'criterias.name')
                ->get();

            if (!$postCriteria->isEmpty()) {
                foreach ($postCriteria as $criteria) {
                    array_push($postCriterias,  $criteria);
                }
            }
        }
        //Converting an array -> stdClass/Object
        $postCriterias = json_decode(json_encode($postCriterias));


        return view('rentalpost_list', [
            'roomRentalPostLists' => $roomRentalPostLists,
            'criteriaLists' => $criteriaLists,
            'postCriterias' => $postCriterias
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
                ->where('contracts.status', 'inactive')
                ->select('room_rental_posts.*', 'contracts.monthly_price')
                ->get();

            if ($roomRentalPostLists->isEmpty()) {
                //get all room_rental_posts from database  with title
                $roomRentalPostLists = DB::table('room_rental_posts')
                    ->join('contracts', 'contracts.post_id', '=', 'room_rental_posts.post_id')
                    ->where('room_rental_posts.title',  'LIKE', '%' . $search . '%')
                    ->where('room_rental_posts.status', 'available')
                    ->where('contracts.status', 'inactive')
                    ->select('room_rental_posts.*', 'contracts.monthly_price')
                    ->get();
            }
        } else {

            $errorMessage = "*Input cannot be more than 255 characters!";
            $request->session()->put('errorMessage', $errorMessage);

            return back()->withInput();
        }

        //get all criterias related to post    
        $postCriterias = array();
        for ($i = 0; $i < count($roomRentalPostLists); $i++) {

            $postCriteria = DB::table('room_rental_posts')
                ->join('post_criterias', 'post_criterias.post_id', '=', 'room_rental_posts.post_id')
                ->join('criterias', 'criterias.criteria_id', '=', 'post_criterias.criteria_id')
                ->where('room_rental_posts.post_id', $roomRentalPostLists[$i]->post_id)
                ->select('room_rental_posts.post_id', 'criterias.criteria_id', 'criterias.name')
                ->get();

            if (!$postCriteria->isEmpty()) {
                foreach ($postCriteria as $criteria) {
                    array_push($postCriterias,  $criteria);
                }
            }
        }
        //Converting an array -> stdClass/Object
        $postCriterias = json_decode(json_encode($postCriterias));


        $criteriaLists = DB::table('criterias')
            ->select('criteria_id', 'name')
            ->get();

        return view('rentalpost_list', [
            'roomRentalPostLists' => $roomRentalPostLists,
            'criteriaLists' => $criteriaLists,
            'postCriterias' => $postCriterias
        ]);
    }

    public function sortRentalPost($sort)
    {
        //Decrypt the parameter
        try {
            $sort = Crypt::decrypt($sort);
        } catch (DecryptException $ex) {
            abort('500', $ex->getMessage());
        }

        //Get room rental post list based on sort
        if ($sort == "latest") {

            $roomRentalPostLists = DB::table('room_rental_posts')
                ->join('contracts', 'contracts.post_id', '=', 'room_rental_posts.post_id')
                ->orderBy('room_rental_posts.created_at', 'desc')
                ->where('room_rental_posts.status', 'available')
                ->where('contracts.status', 'inactive')
                ->select('room_rental_posts.*', 'contracts.monthly_price')
                ->get();
        } elseif ($sort == "oldest") {

            $roomRentalPostLists = DB::table('room_rental_posts')
                ->join('contracts', 'contracts.post_id', '=', 'room_rental_posts.post_id')
                ->orderBy('room_rental_posts.created_at')
                ->where('room_rental_posts.status', 'available')
                ->where('contracts.status', 'inactive')
                ->select('room_rental_posts.*', 'contracts.monthly_price')
                ->get();
        } elseif ($sort == "high price") {

            $roomRentalPostLists = DB::table('room_rental_posts')
                ->join('contracts', 'contracts.post_id', '=', 'room_rental_posts.post_id')
                ->orderBy('contracts.monthly_price', 'desc')
                ->where('room_rental_posts.status', 'available')
                ->where('contracts.status', 'inactive')
                ->select('room_rental_posts.*', 'contracts.monthly_price')
                ->get();
        } elseif ($sort == "low price") {

            $roomRentalPostLists = DB::table('room_rental_posts')
                ->join('contracts', 'contracts.post_id', '=', 'room_rental_posts.post_id')
                ->orderBy('contracts.monthly_price')
                ->where('room_rental_posts.status', 'available')
                ->where('contracts.status', 'inactive')
                ->select('room_rental_posts.*', 'contracts.monthly_price')
                ->get();
        }

        //get all criterias related to post    
        $postCriterias = array();
        for ($i = 0; $i < count($roomRentalPostLists); $i++) {

            $postCriteria = DB::table('room_rental_posts')
                ->join('post_criterias', 'post_criterias.post_id', '=', 'room_rental_posts.post_id')
                ->join('criterias', 'criterias.criteria_id', '=', 'post_criterias.criteria_id')
                ->where('room_rental_posts.post_id', $roomRentalPostLists[$i]->post_id)
                ->select('room_rental_posts.post_id', 'criterias.criteria_id', 'criterias.name')
                ->get();

            if (!$postCriteria->isEmpty()) {
                foreach ($postCriteria as $criteria) {
                    array_push($postCriterias,  $criteria);
                }
            }
        }
        //Converting an array -> stdClass/Object
        $postCriterias = json_decode(json_encode($postCriterias));


        $criteriaLists = DB::table('criterias')
            ->select('criteria_id', 'name')
            ->get();


        return view('rentalpost_list', [
            'roomRentalPostLists' => $roomRentalPostLists,
            'criteriaLists' => $criteriaLists,
            'postCriterias' => $postCriterias
        ]);
    }



    public function filterRentalPost()
    {
        //Get checkbox array from post
        if (isset($_POST["filter"])) {
            $filter = $_POST["filter"];
        } else {
            $filter = array();
        }


        //Define a array variable to store all room rental post    
        $roomRentalPostLists = array();

        if (count($filter) != 0) {
            //come here if there is something checked in form
            for ($i = 0; $i < count($filter); $i++) {

                $rentalPosts = DB::table('room_rental_posts')
                    ->join('contracts', 'contracts.post_id', '=', 'room_rental_posts.post_id')
                    ->join('post_criterias', 'post_criterias.post_id', '=', 'room_rental_posts.post_id')
                    ->join('criterias', 'criterias.criteria_id', '=', 'post_criterias.criteria_id')
                    ->where('criterias.criteria_id', $filter[$i])
                    ->where('room_rental_posts.status', 'available')
                    ->where('contracts.status', 'inactive')
                    ->orderBy('room_rental_posts.created_at', 'desc')
                    ->select('room_rental_posts.*', 'contracts.monthly_price')
                    ->get();

                if (!$rentalPosts->isEmpty()) {
                    foreach ($rentalPosts as $rentalPost) {
                        array_push($roomRentalPostLists,  $rentalPost);
                    }
                }
            }
        }


        if (count($roomRentalPostLists) != 0) {
            //Remove duplicate object in array
            $roomRentalPostLists = $this->unique_multi_array($roomRentalPostLists, 'post_id');
        }


        //Converting an array -> stdClass/Object
        $roomRentalPostLists = json_decode(json_encode($roomRentalPostLists));

        //Sort desc based on room rental post created_at
        usort($roomRentalPostLists, function ($first, $second) {
            return $first->created_at < $second->created_at;
        });

        //get all criterias related to post    
        $postCriterias = array();
        for ($i = 0; $i < count($roomRentalPostLists); $i++) {

            $postCriteria = DB::table('room_rental_posts')
                ->join('post_criterias', 'post_criterias.post_id', '=', 'room_rental_posts.post_id')
                ->join('criterias', 'criterias.criteria_id', '=', 'post_criterias.criteria_id')
                ->where('room_rental_posts.post_id', $roomRentalPostLists[$i]->post_id)
                ->select('room_rental_posts.post_id', 'criterias.criteria_id', 'criterias.name')
                ->get();

            if (!$postCriteria->isEmpty()) {
                foreach ($postCriteria as $criteria) {
                    array_push($postCriterias,  $criteria);
                }
            }
        }
        //Converting an array -> stdClass/Object
        $postCriterias = json_decode(json_encode($postCriterias));

        $criteriaLists = DB::table('criterias')
            ->select('criteria_id', 'name')
            ->get();

        return view('rentalpost_list', [
            'roomRentalPostLists' => $roomRentalPostLists,
            'criteriaLists' => $criteriaLists,
            'filters' => $filter,
            'postCriterias' => $postCriterias
        ]);
    }
}
