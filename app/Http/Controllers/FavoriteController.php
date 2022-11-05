<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class FavoriteController extends Controller
{
    //
    public $name = 'Favorite';

    public function index(Request $request)
    {
 
        $account = $request->session()->get('account'); 
        $id = $account->account_id;
        $user = $account->role;

        //get favourite from database 
        $favoritePosts = DB::table('favorites')
        ->join('room_rental_posts', 'room_rental_posts.post_id', '=', 'favorites.post_id')
        ->where('favorites.account_id', $id)
        ->where('room_rental_posts.status', '!=', "archived")
        ->select('room_rental_posts.post_id', 'room_rental_posts.title', 'room_rental_posts.status')
        ->get();
        
        return view('dashboard/tenant/dashboard_favorite', [
            'user' => $user,
            'page' => $this->name,
            'header' => $this->name,
            'favoritePosts' => $favoritePosts,
        ]);
    }

    //need remove
    public function test($postID)
    {
        
        //Decrypt the parameter
        try {
            $postID = Crypt::decrypt($postID);
        } catch (DecryptException $ex) {
            abort('500', $ex->getMessage());
        }
        
        dd( $postID);
    }

    public function removeFavorite($postID) {

        $account = session()->get('account'); 
        $id = $account->account_id;

        //Decrypt the parameter
        try {
            $postID = Crypt::decrypt($postID);
        } catch (DecryptException $ex) {
            abort('500', $ex->getMessage());
        }


            DB::table('favorites')
            ->where('account_id', $id)
            ->where('post_id', $postID)
            ->delete();
            
            return redirect(route("dashboard.tenant.favorite"));

    }

    public function addFavorite($postID) {

        $account = session()->get('account'); 
        $id = $account->account_id;

        //Decrypt the parameter
        try {
            $postID = Crypt::decrypt($postID);
        } catch (DecryptException $ex) {
            abort('500', $ex->getMessage());
        }

            DB::table('favorites')->insert([
                'account_id' => $id,
                'post_id' => $postID
            ]);
            

            return redirect(route("dashboard.tenant.favorite")); //edit to route to post details

    }


}
