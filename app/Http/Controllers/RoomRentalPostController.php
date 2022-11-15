<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Negotiation;
use App\Models\Notification;
use App\Models\Renting;
use App\Models\RentRequest;
use App\Models\RoomRentalPost;
use App\Models\VisitAppointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomRentalPostController extends Controller
{
    
    function index($post_id) {

        $post = DB::table('room_rental_posts')
            ->join('accounts', 'accounts.account_id', '=', 'room_rental_posts.account_id')
            ->join('contracts', 'contracts.post_id', '=', 'room_rental_posts.post_id')
            ->where('room_rental_posts.post_id', $post_id)
            ->select(
                'room_rental_posts.*',
                'accounts.name', 
                'contracts.contract_id', 
                'contracts.deposit_price', 
                'contracts.monthly_price'
            )
            ->get();

        $images = RoomRentalPost::findOrFail($post_id)
            ->images()->get();

        $criterias = RoomRentalPost::findOrFail($post_id)
            ->criterias()->get();

        $contract = RoomRentalPost::findOrFail($post_id)
            ->contracts()
            ->where('status', 'inactive')
            ->get();

        $comments = DB::table('comments')
            ->join('accounts', 'accounts.account_id', '=', 'comments.account_id')
            ->join('room_rental_posts', 'room_rental_posts.post_id', '=', 'comments.post_id')
            ->where('room_rental_posts.post_id', $post_id)
            ->where('comments.status', 'show')
            ->orderBy('created_at')
            ->select(
                'comments.*',  
                'accounts.name'
            )
            ->get();

        $access = $this->validateAccess($post_id, session()->get('account')['account_id']);

        return view('rentalpost', [
            'back' => "rental_post_list",
            'post' => $post,
            'images' => $images,
            'criterias' => $criterias,
            'contract' => $contract,
            'comments' => $comments,
            'access' => $access
        ]);

    }

    // Validation 
    /*
    *  Prevent user from using control panel's function,
    *  if they already have an on-going process of that function.
    *
    *  Cancelation for the process in here is optional, won't be implement now
    *
    *  status:         able      disable       update
    *    comment:     "allow", "forbidden",   collection{}
    *    appointment: "allow", "forbidden"
    *    negotiate:   "allow", "forbidden"
    *    rent:        "allow", "forbidden"
    */
    function validateAccess($post_id, $account_id) {

        $comment = $this->validateComment($post_id, $account_id);

        

        return [
            'comment' => $comment,
            'appointment' => 'true',
            'negotiate' => 'true',
            'rent' => 'true'
        ];
    }

    function validateComment($post_id, $account_id) {
        $comment = Comment::where('account_id', $account_id)
            ->where('post_id', $post_id)
            ->where('status', 'show')
            ->get();
        
        if($comment->isEmpty()) {
            $check = Renting::where('account_id', $account_id)
                ->where('post_id', $post_id)
                ->where('status', 'expired')
                ->get();
            if (!$check->isEmpty()) {
                $comment = "allow";
            } else {
                $comment = "forbidden";
            }
        }

        return $comment;
    }

    
    // Create Function
    // Visit Appointment
    function createVisitAppointment(Request $request) {
        
        $account_id = session()->get('account')['account_id'];
        $post_id = $request->input('id');
        $datetime = $request->input('datetime');
        $note = $request->input('note');
        $status = "pending";

        $date = substr($datetime, 0, 10);
        $time = substr($datetime, -5) . ":00";
        $datetime = $date . " " . $time;


        $appointment_id = $this->createID(VisitAppointment::class, "appointment_id", 3);

        $insert = [
            'appointment_id' => $appointment_id,
            'datetime' => $datetime,
            'note' => $note,
            'status' => $status,
            'post_id' => $post_id,
            'account_id' => $account_id
        ];

        VisitAppointment::create($insert);


        // Notification
        $rrp = RoomRentalPost::findOrFail($post_id)
            ->select('account_id', 'title')->get();

        $title = 'You received a Visit Appointment';
        $message = '<b>' . session()->get('account')['name'] . '</b> has booked a visit appointment with you on "<b>' . $rrp[0]['title'] .'</b>".';
        $type = 'visit_appointment';
        $receiver = $rrp[0]['account_id'];

        $this->notify($title, $message, $type, $receiver);

        return redirect(route('rental_post_list.rental_post', ['post_id' => $post_id]));
    }

    // Negotiation
    function createNegotiation(Request $request) {

        $account_id = session()->get('account')['account_id'];
        $post_id = $request->input('id');
        $price = $request->input('price');
        $message = $request->input('message');
        $status = "tenant_offer";

        $negotiation_id = $this->createID("Negotiation", "negotiation_id", 3);

        $insert = [
            'negotiation_id' => $negotiation_id,
            'price' => $price,
            'message' => $message,
            'status' => $status,
            'post_id' => $post_id,
            'account_id' => $account_id
        ];

        Negotiation::insert($insert);


        // Notification
        $rrp = RoomRentalPost::findOrFail($post_id)
            ->select('account_id', 'title')->get();

        $title = 'You received a negotiation';
        $message = '<b>' . session()->get('account')['name'] . '</b> has started a negotiate session with you on "<b>' . $rrp[0]['title'] .'</b>".';
        $type = 'negotiation';
        $receiver = $rrp[0]['account_id'];

        $this->notify($title, $message, $type, $receiver);

        return redirect(route('rental_post_list.rental_post', ['post_id' => $post_id]));
    }


    // Rent Request
    function createRentRequest(Request $request) {

        $account_id = session()->get('account')['account_id'];
        $post_id = $request->input('id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $status = "pending";
        
        $startDate = substr($startDate, 0, 10);
        $endDate = substr($endDate, 0, 10);

        $rent_request_id = $this->createID(RentRequest::class, "rent_request_id", 2);

        $price = RoomRentalPost::findOrFail($post_id)
            ->contracts()
            ->where('status', 'inactive')
            ->select('monthly_price')
            ->get();

        $insert = [
            'rent_request_id' => $rent_request_id,
            'price' => $price[0]['monthly_price'],
            'rent_date_start' => $startDate,
            'rent_date_end' => $endDate,
            'status' => $status,
            'post_id' => $post_id,
            'account_id' => $account_id
        ];

        RentRequest::insert($insert);


        // Notification
        $rrp = RoomRentalPost::findOrFail($post_id)
            ->select('account_id', 'title')->get();

        $title = 'You received a rent request';
        $message = '<b>' . session()->get('account')['name'] . '</b> has sent a rent request to you on "<b>' . $rrp[0]['title'] .'</b>".';
        $type = 'renting_request';
        $receiver = $rrp[0]['account_id'];

        $this->notify($title, $message, $type, $receiver);

        return redirect(route('rental_post_list.rental_post', ['post_id' => $post_id]));
    }


    // Comment
    function createComment(Request $request) {

        $account_id = session()->get('account')['account_id'];
        $post_id = $request->input('id');
        $rating = $request->input('rating');
        $message = $request->input('message');
        $status = "show";

        $comment_id = $this->createID(Comment::class, "comment_id", 3);

        $insert = [
            'comment_id' => $comment_id,
            'rating' => $rating,
            'message' => $message,
            'status' => $status,
            'account_id' => $account_id,
            'post_id' => $post_id
        ];

        Comment::insert($insert);


        // Notification
        $rrp = RoomRentalPost::findOrFail($post_id)
            ->select('account_id', 'title')->get();

        $title = 'You have received a Comment on a rental post';
        $message = '<b>' . session()->get('account')['name'] . '</b> has leave a rating and comment on your "<b>' . $rrp[0]['title'] .'</b>".';
        $type = 'comment';
        $receiver = $rrp[0]['account_id'];

        $this->notify($title, $message, $type, $receiver);

        return redirect(route('rental_post_list.rental_post', ['post_id' => $post_id, '#comment_section']));
    }

    
    function updateComment(Request $request) {

        $post_id = $request->input('id');
        $comment_id = $request->input('cid');
        $rating = $request->input('rating');
        $message = $request->input('message');

        $comment = Comment::find($comment_id);
        $comment->rating = $rating;
        $comment->message = $message;

        $comment->save();


        // Notification
        $rrp = RoomRentalPost::findOrFail($post_id)
            ->select('account_id', 'title')->get();

        $title = 'Someone has updated their comment in your rental post';
        $message = '<b>' . session()->get('account')['name'] . '</b> has updated a rating and comment on your "<b>' . $rrp[0]['title'] .'</b>".';
        $type = 'comment';
        $receiver = $rrp[0]['account_id'];

        $this->notify($title, $message, $type, $receiver);

        return redirect(route('rental_post_list.rental_post', ['post_id' => $post_id, '#comment_section']));
    }


    function deleteComment($comment_id) {

        $post_id = Comment::find($comment_id)->post()->get()[0]['post_id'];
        $status = "hide";

        $comment = Comment::find($comment_id);
        $comment->status = $status;

        $comment->save();

        return redirect(route('rental_post_list.rental_post', ['post_id' => $post_id, '#comment_section']));
    }


    //Custom fucntion
    function createID($model, $idName, $idCodeLength) {
        $newID = $model::select($idName)
            ->orderByDesc('created_at')
            ->first()->$idName;

        $id_code = substr($newID, 0, $idCodeLength);
        $id = intval(substr($newID, $idCodeLength) + 1);
        $newID = $id_code . $id;

        return $newID;
    }


    function notify($title, $message, $type, $receiver) {

        $notification_id = $this->createID(Notification::class, 'notification_id', 3);

        $insert = [
            'notification_id' => $notification_id,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'status' => 'unread',
            'account_id' => $receiver
        ];
        
        Notification::insert($insert);
    }
}
