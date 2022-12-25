<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Renting;
use App\Models\Contract;
use App\Models\Negotiation;
use App\Models\RentRequest;
use App\Models\Notification;
use App\Models\PostImage;
use Illuminate\Http\Request;
use App\Models\RoomRentalPost;
use App\Models\VisitAppointment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class RoomRentalPostController extends Controller
{

    // Public
    function index($post_id)
    {

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

        if (session()->has('account') && (session()->get('account')['role'] == 'A' || session()->get('account')['role'] == 'MA')) {
            $comments = DB::table('comments')
                ->join('accounts', 'accounts.account_id', '=', 'comments.account_id')
                ->join('room_rental_posts', 'room_rental_posts.post_id', '=', 'comments.post_id')
                ->where('room_rental_posts.post_id', $post_id)
                ->orderBy('created_at')
                ->select(
                    'comments.*',
                    'accounts.name'
                )
                ->get();
        } else {
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
        }


        if (session()->has('account')) {
            $access = $this->validateAccess($post_id, session()->get('account')['account_id']);

            $account = session()->get('account');
            $id = $account->account_id;

            $favorite = DB::table('favorites')
                ->join('room_rental_posts', 'room_rental_posts.post_id', '=', 'favorites.post_id')
                ->where('favorites.account_id', $id)
                ->where('room_rental_posts.post_id', $post_id)
                ->select('room_rental_posts.post_id')
                ->get();
        } else {

            $access = [
                'comment' => 'forbidden',
                'appointment' => 'forbidden',
                'negotiate' => 'forbidden',
                'rent' => 'forbidden'
            ];

            $favorite = collect();
        }

        if ($post[0]->status != 'available') {
            $message = 'You have been redirect to homepage as the post you are trying to access is not accessible at the moment.';

            session()->put('access_message_status', 'alert-danger');
            session()->put('access_message', $message);

            return redirect('/');
        }



        return view('rentalpost', [
            'back' => "rental_post_list",
            'post' => $post,
            'images' => $images,
            'criterias' => $criterias,
            'contract' => $contract,
            'comments' => $comments,
            'favorite' => $favorite,
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
    function validateAccess($post_id, $account_id)
    {

        $comment = $this->validateComment($post_id, $account_id);
        $appointment = $this->validateAppointment($post_id, $account_id);
        $negotiate = $this->validateNegotiate($post_id, $account_id);
        $rent = $this->validateRentRequest($post_id, $account_id);

        return [
            'comment' => $comment,
            'appointment' => $appointment,
            'negotiate' => $negotiate,
            'rent' => $rent
        ];
    }

    function validateComment($post_id, $account_id)
    {
        $comment = Comment::where('account_id', $account_id)
            ->where('post_id', $post_id)
            ->where('status', 'show')
            ->get();

        if ($comment->isEmpty()) {
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

    function validateAppointment($post_id, $account_id)
    {
        $appointment = DB::table('visit_appointments')
            ->where('account_id', $account_id)
            ->where('post_id', $post_id)
            ->where('status', '!=', 'rejected')
            ->where('status', '!=', 'canceled')
            ->where('status', '!=', 'success')
            ->where('status', '!=', 'expired')
            ->get();

        if ($appointment->isEmpty()) {
            $appointment = "allow";
        } else {
            $appointment = "forbidden";
        }

        return $appointment;
    }

    function validateNegotiate($post_id, $account_id)
    {
        $negotiation = DB::table('negotiations')
            ->where('account_id', $account_id)
            ->where('post_id', $post_id)
            ->where('status', '!=', 'accepted')
            ->where('status', '!=', 'rejected')
            ->where('status', '!=', 'canceled')
            ->get();

        if ($negotiation->isEmpty()) {
            $negotiation = "allow";
        } else {
            $negotiation = "forbidden";
        }

        return $negotiation;
    }

    function validateRentRequest($post_id, $account_id)
    {
        $rent = DB::table('rent_requests')
            ->where('account_id', $account_id)
            ->where('post_id', $post_id)
            ->where('status', '!=', 'expired')
            ->where('status', '!=', 'rejected')
            ->where('status', '!=', 'canceled')
            ->where('status', '!=', 'success')
            ->get();

        if ($rent->isEmpty()) {
            $rent = "allow";
        } else {
            $rent = "forbidden";
        }

        return $rent;
    }

    // Create Function
    // Visit Appointment
    function createVisitAppointment(Request $request)
    {
        //Laravel validation
        $request->validate([
            'datetime' => ['required', 'after:today'],
            'note' => ['required', 'string', 'max:255']
        ]);


        $account_id = session()->get('account')['account_id'];
        $post_id = $request->input('id');
        $datetime = $request->input('datetime');
        $note = $request->input('note');
        $status = "pending";

        $date = substr($datetime, 0, 10);
        $time = substr($datetime, -5) . ":00";
        $datetime = $date . " " . $time;


        $appointment_id = $this->generateID(VisitAppointment::class);

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
        //get room rental post details from database 
        $rrp = DB::table('room_rental_posts')
            ->where('post_id', $post_id)
            ->select('account_id', 'title')
            ->get();
        $title = 'Room Visit Appointment Received';
        $message = session()->get('account')['name'] . 'have created a room visit appointment for <b>' . $rrp[0]->title . '</b>.';
        $type = 'visit_appointment';
        $receiver = $rrp[0]->account_id;


        $this->notify($title, $message, $type, $receiver);

        if (count($rrp) > 0) {
            $request->session()->put('successMessage', 'Visit appointment created.');
        } else {
            $request->session()->put('failMessage', 'Visit appointment fail to created.');
        }

        return redirect(URL('/dashboard/roomvisitappointment/getRoomVisitAppoitmentDetails/' . Crypt::encrypt($appointment_id)));
    }

    // Negotiation
    function createNegotiation(Request $request)
    {

        $insert['negotiation_id'] = $negotiation_id = $this->generateID(Negotiation::class);
        $insert['deposit_price'] = $deposit = $request->input('deposit_payment', '');
        $insert['monthly_price'] = $monthly = $request->input('monthly_payment', '');
        $insert['message'] = $message = $request->input('message', '');
        $insert['status'] = $status = "tenant_offer";
        $insert['post_id'] = $post_id = $request->input('id', '');
        $insert['account_id'] = $account_id = session()->get('account')['account_id'];

        Negotiation::insert($insert);


        // Notification
        $rrp = RoomRentalPost::select('account_id', 'title')
            ->where("post_id", $post_id)    
            ->get($post_id);


        $title = 'Negotiation Received';
        $message = session()->get('account')['name'] . 'have created a negotiation for <b>' . $rrp[0]['title'] . '</b>.';
        $type = 'negotiation';
        $receiver = $rrp[0]['account_id'];

        $this->notify($title, $message, $type, $receiver);
        $accountID = $rrp[0]->account_id;

        return redirect("/chat#$accountID");
    }


    // Rent Request
    function createRentRequest(Request $request)
    {
        //Laravel validation
        $request->validate([
            'start_date' => ['required', 'date', 'before:end_date'],
            'end_date' => ['required', 'date', 'after:start_date']
        ]);


        $account_id = session()->get('account')['account_id'];
        $post_id = $request->input('id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $status = "pending";

        $startDate = substr($startDate, 0, 10);
        $endDate = substr($endDate, 0, 10);

        $rent_request_id = $this->generateID(RentRequest::class);


        $insert = [
            'rent_request_id' => $rent_request_id,
            'rent_date_start' => $startDate,
            'rent_date_end' => $endDate,
            'status' => $status,
            'post_id' => $post_id,
            'account_id' => $account_id
        ];

        RentRequest::insert($insert);


        // Notification
        //get room rental post details from database 
        $rrp = DB::table('room_rental_posts')
        ->where('post_id', $post_id)
        ->select('account_id', 'title')
        ->get();

        $title = 'Renting Request Received';
        $message = session()->get('account')['name'] . 'have created a renting request for <b>' . $rrp[0]->title . '</b>.';
        $type = 'renting_request';
        $receiver = $rrp[0]->account_id;


        $this->notify($title, $message, $type, $receiver);

        if (count($rrp) > 0) {
            $request->session()->put('successMessage', 'Rent request created.');
        } else {
            $request->session()->put('failMessage', 'Rent request fail to created.');
        }

        return redirect(URL('/dashboard/rentrequest/getRentRequestDetails/' . Crypt::encrypt($rent_request_id)));
    }


    // Comment
    function createComment(Request $request)
    {

        $account_id = session()->get('account')['account_id'];
        $post_id = $request->input('id');
        $rating = $request->input('rating');
        $message = $request->input('message');
        $status = "show";

        $comment_id = $this->generateID(Comment::class);

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
        $rrp = RoomRentalPost::select('account_id', 'title')
            ->where("post_id", $post_id)    
            ->get($post_id);

        $title = 'You have received a Comment on a rental post';
        $message = '<b>' . session()->get('account')['name'] . '</b> has leave a rating and comment on your "<b>' . $rrp[0]['title'] . '</b>".';
        $type = 'comment';
        $receiver = $rrp[0]['account_id'];

        $this->notify($title, $message, $type, $receiver);

        return redirect(route('rental_post_list.rental_post', ['post_id' => $post_id, '#comment_section']));
    }


    function updateComment(Request $request)
    {

        $post_id = $request->input('id');
        $comment_id = $request->input('cid');
        $rating = $request->input('rating');
        $message = $request->input('message');

        $comment = Comment::find($comment_id);
        $comment->rating = $rating;
        $comment->message = $message;

        $comment->save();


        // Notification
        $rrp = RoomRentalPost::select('account_id', 'title')
            ->where("post_id", $post_id)    
            ->get($post_id);

        $title = 'Someone has updated their comment in your rental post';
        $message = '<b>' . session()->get('account')['name'] . '</b> has updated a rating and comment on your "<b>' . $rrp[0]['title'] . '</b>".';
        $type = 'comment';
        $receiver = $rrp[0]['account_id'];

        $this->notify($title, $message, $type, $receiver);

        return redirect(route('rental_post_list.rental_post', ['post_id' => $post_id, '#comment_section']));
    }


    function deleteComment($comment_id)
    {
        $post_id = Comment::find($comment_id)->post()->get()[0]['post_id'];
        $status = "hide";

        $comment = Comment::find($comment_id);
        $comment->status = $status;

        $comment->save();

        $role = session()->get('account')['role'];
        if ($role == 'A' || $role == 'MA') {
            $message = 'You have hide a comment from public.';
        } else {
            $message = 'You have deleted a comment.';
        }

        session()->put('access_message_status', 'alert-success');
        session()->put('access_message', $message);

        return redirect(route('rental_post_list.rental_post', ['post_id' => $post_id, '#comment_section']));
    }



    //Owner 
    function ownerIndex($postID)
    {

        try {
            $postID = Crypt::decrypt($postID);
        } catch (DecryptException $ex) {
            abort('500', $ex->getMessage());
        }

        $post = DB::table('room_rental_posts')
            ->join('accounts', 'accounts.account_id', '=', 'room_rental_posts.account_id')
            ->join('contracts', 'contracts.post_id', '=', 'room_rental_posts.post_id')
            ->where('room_rental_posts.post_id', $postID)
            ->select(
                'room_rental_posts.*',
                'accounts.name',
                'contracts.contract_id',
                'contracts.deposit_price',
                'contracts.monthly_price'
            )
            ->first();

        $images = RoomRentalPost::findOrFail($postID)
            ->images()->where('status', 'show')->get();

        $criterias = RoomRentalPost::findOrFail($postID)
            ->criterias()->get();

        $contract = RoomRentalPost::findOrFail($postID)
            ->contracts()
            ->where('status', 'inactive')
            ->get();

        $comments = DB::table('comments')
            ->join('accounts', 'accounts.account_id', '=', 'comments.account_id')
            ->join('room_rental_posts', 'room_rental_posts.post_id', '=', 'comments.post_id')
            ->where('room_rental_posts.post_id', $postID)
            ->where('comments.status', 'show')
            ->orderBy('created_at')
            ->select(
                'comments.*',
                'accounts.name'
            )
            ->get();

        $renting = RoomRentalPost::find($postID)
            ->rentings()
            ->where('status', 'active')
            ->first();

        return view('dashboard/owner/dashboard_rentalpost', [
            'page' => 'Room Rental Post',
            'header' => 'Room Rental Post',
            'back' => '/dashboard/room_rental_post_list',
            'post' => $post,
            'images' => $images,
            'criterias' => $criterias,
            'contract' => $contract,
            'comments' => $comments,
            'renting' => $renting
        ]);
    }

    //Create Room Rental Post
    function createPost(Request $request)
    {

        // Room rental post
        $title = $request->input('title');
        $description = $request->input('description');
        $condominium_name = $request->input('condominium');
        $room_size = $request->input('size');
        $block = $request->input('block');
        $floor = $request->input('floor');
        $unit = $request->input('unit');
        $address = $request->input('address');

        // Contract
        $content = $request->input('content');
        $deposit_price = $request->input('deposit');
        $monthly_price = $request->input('monthly');

        $post_id = $this->generateID(RoomRentalPost::class);
        $account_id = session()->get('account')['account_id'];

        $rrp = [
            'post_id' => $post_id,
            'title' => $title,
            'description' => $description,
            'room_size' => $room_size,
            'address' => $address,
            'condominium_name' => $condominium_name,
            'block' => $block,
            'floor' => $floor,
            'unit' => $unit,
            'status' => "available",
            'account_id' => $account_id
        ];


        $contract_id = $this->generateID(Contract::class);

        $contract = [
            'contract_id' => $contract_id,
            'content' => $content,
            'deposit_price' => $deposit_price,
            'monthly_price' => $monthly_price,
            'status' => 'inactive',
            'post_id' => $post_id
        ];

        RoomRentalPost::insert($rrp);
        Contract::insert($contract);

        return redirect(route('dashboard.owner.room_rental_post.list'));
    }

    //Display Edit Post Form
    function editPostForm($postID = "")
    {
        $back = "/dashboard/room_rental_post_list/$postID";
        try {
            $postID = Crypt::decrypt($postID);
        } catch (DecryptException $ex) {
            abort('500', $ex->getMessage());
        }

        $rrp = RoomRentalPost::find($postID);
        $pi = RoomRentalPost::find($postID)->images()->where('status', 'show')->get();

        $return = [
            'page' => 'Room Rental Post',
            'header' => 'Edit Room Rental Post',
            'back' => $back,
            'post' => $rrp,
            'postImages' => $pi
        ];

        return view('/dashboard/owner/dashboard_rentalpost_edit', $return);
    }

    //Update Room Rental Post
    function updatePost(Request $request, $postID)
    {
        try {
            $postID = Crypt::decrypt($postID);
        } catch (DecryptException $ex) {
            abort('500', $ex->getMessage());
        }

        /* Image */

        //Laravel validation
        $request->validate(
            [ // 1st array is field rules
                'images.*' => 'required|distinct|image|mimes:jpeg,png,jpg|max:2048'
            ],
            [],
            [ // 3rd array is the fields custom name
                'images.*' => 'image'
            ]
        );

        $images = $request->file('images');
        $saved_images = $request->input('saved_images');
        $db_images = RoomRentalPost::find($postID)->images()->get();

        if (!$db_images->isEmpty() && !empty($saved_images)) {
            foreach ($db_images as $i => $image) {
                foreach ($saved_images as $j => $v) {
                    if ($v == $image->post_image_id) {
                        $db_images->pull($i);
                    }
                }
            }
        }

        $images = collect($images);
        while ($image = $images->shift()) {
            if (!$db_images->isEmpty()) {
                $postImage = $db_images->shift();
                $postImageID = $postImage->post_image_id;
            } else {
                $postImageID = $this->generateID(PostImage::class);
            }

            $imageName = $postImageID . "." . $image->getClientOriginalExtension();
            $image->move(public_path() . '/image/post/', $imageName);

            if (isset($postImage)) {
                $postImage->image = $imageName;
                $postImage->status = 'show';
                $postImage->save();
            } else {
                $insert = [
                    'post_image_id' => $postImageID,
                    'image' => $imageName,
                    'post_id' => $postID,
                    'status' => 'show'
                ];

                PostImage::insert($insert);
            }
        }

        if (!$db_images->isEmpty()) {
            foreach ($db_images as $image) {
                $image->status = "hide";
                $image->save();
            }
        }

        // End Image

        $title = $request->input('title');
        $description = $request->input('description');
        $condominium_name = $request->input('condominium');
        $room_size = $request->input('size');
        $block = $request->input('block');
        $floor = $request->input('floor');
        $unit = $request->input('unit');
        $address = $request->input('address');


        $post = RoomRentalPost::find($postID);
        $post->title = $title;
        $post->description = $description;
        $post->condominium_name = $condominium_name;
        $post->room_size = $room_size;
        $post->block = $block;
        $post->floor = $floor;
        $post->unit = $unit;
        $post->address = $address;

        $post->save();

        return redirect(route('dashboard.owner.room_rental_post', ['postID' => Crypt::encrypt($postID)]));
    }

    function deletePost($postID)
    {
        try {
            $postID = Crypt::decrypt($postID);
        } catch (DecryptException $ex) {
            abort('500', $ex->getMessage());
        }

        $post = RoomRentalPost::find($postID);
        $post->status = 'archived';
        $post->save();

        return redirect(route('dashboard.owner.room_rental_post', ['postID' => Crypt::encrypt($postID)]));
    }


    //Custom fucntion
    function generateID($model)
    {
        $table = $model::$tableName;
        $idCol = $model::$idColumn;
        $idCode = $model::$idCode;
        $idCodeLength = strlen($idCode);

        $newID = $model::select($idCol)
            ->whereRaw("CHAR_LENGTH($idCol) = (SELECT MAX(CHAR_LENGTH($idCol)) from $table)")
            ->orderByDesc($idCol)
            ->distinct()
            ->first();

        if (empty($newID)) {
            return $idCode . '1';
        } else {
            $newID = $newID->$idCol;
            $idCode = substr($newID, 0, $idCodeLength);
            $id = intval(substr($newID, $idCodeLength) + 1);
            $newID = $idCode . $id;
        }

        return $newID;
    }


    function notify($title, $message, $type, $receiver)
    {

        //getLatestNotificationID
        $latestNotificationID = $this->getLatestNotificationID();

        //make new NotificationID
        $notification_id = $this->notificationID($latestNotificationID);

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

    public function getLatestNotificationID()
    {
        $notificationID = DB::table('notifications')
            ->select('notification_id')
            ->whereRaw("CHAR_LENGTH(notification_id) = (SELECT MAX(CHAR_LENGTH(notification_id)) from notifications)")
            ->orderByDesc('notification_id')
            ->distinct()
            ->select('notification_id')
            ->get();

        if ($notificationID->isEmpty()) {
            return "NTF0";
        }
        return $notificationID[0]->notification_id;
    }

    //add 1 to ID to make new ID 
    private function notificationID($value)
    {
        $result = substr($value, 3);

        //parse result to int
        $ans = ((int)$result) + 1;

        //combine char and int into string
        $result = "NTF" . ((string)$ans);

        return $result;
    }



    public function addOrRemoveFavorite($postID, $process)
    {

        $account = session()->get('account');
        $id = $account->account_id;

        //Decrypt the parameter
        try {
            $postID = Crypt::decrypt($postID);
            $process = Crypt::decrypt($process);
        } catch (DecryptException $ex) {
            abort('500', $ex->getMessage());
        }

        if ($process == "add") {
            DB::table('favorites')->insert([
                'account_id' => $id,
                'post_id' => $postID
            ]);
        } else {
            DB::table('favorites')
                ->where('account_id', $id)
                ->where('post_id', $postID)
                ->delete();
        }

        return redirect(route('rental_post_list.rental_post', ['post_id' => $postID]));
    }
}
