<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\GroupChat;
use App\Models\GroupUser;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    //

    public function index() {
        
        $accountID = session()->get('account')['account_id'];

        //account get (chat Messages get(sender / receiver base on account_id) )
        $cmQ1 = ChatMessage::select('receiver_id as account_id')->where('sender_id', $accountID)->distinct();
        $cms = ChatMessage::select('sender_id as account_id')
            ->where('receiver_id', $accountID)
            ->union($cmQ1)
            ->distinct()
            ->get();

        $accounts = Account::where(function($query) use ($cms) {
                foreach ($cms as $cm) {
                    $query->orWhere('account_id', $cm->account_id);
                }
            })
            ->select('account_id', 'name')
            ->get();
        
        $gChats = DB::table('group_chats', 'GC')
            ->join('group_users as GU', 'GU.group_id', 'GC.group_id')
            ->where('GU.account_id', $accountID)
            ->where('GC.status', '!=', 'archive')
            ->select('GC.group_id', 'GC.name', 'GU.role')
            ->distinct()
            ->get();

        $return = [
            'accounts' => $accounts,
            'gChats' => $gChats
        ];
        
        return view('chat/chat', $return);
    }

    public function getMessage($id = "") {

        $user = "";
        $messages = [];
        if (!empty($id)) {
            $user = Account::find($id);
            $accountID = session()->get('account')['account_id'];

            $chatID = ChatMessage::
                where(function ($query) use ($accountID, $id) {
                    $query->where('sender_id', $accountID)
                        ->where('receiver_id', $id);
                })
                ->orWhere(function ($query) use ($accountID, $id) {
                    $query->where('receiver_id', $accountID)
                        ->where('sender_id', $id);
                })
                ->select('chat_id')
                ->first();

            if (!empty($chatID)) {
                $messages = Chat::find($chatID->chat_id)->messages()->orderBy('created_at')->get();
            }
            
        }

        $return = [
            'user' => $user,
            'messages' => $messages,
        ];
        
        return view('chat/message', $return);
    }

    public function sendMessage(Request $request) {
        $new = false;
        $status = 1;
        $receiverID = $request->input('id', "");
        $message = $request->input('message', "");
        $time = Carbon::now()->format('h:i A');

        if (!empty($receiverID) && !empty($message)) {
            $senderID = session()->get('account')['account_id'];
            
            $chatID = ChatMessage::
                where(function ($query) use ($senderID, $receiverID) {
                    $query->where('sender_id', $senderID)
                        ->where('receiver_id', $receiverID);
                })
                ->orWhere(function ($query) use ($senderID, $receiverID) {
                    $query->where('receiver_id', $senderID)
                        ->where('sender_id', $receiverID);
                })
                ->select('chat_id')
                ->first();
            
            if (empty($chatID)) {
                $chatID = $this->generateID(Chat::class);
                $insert = [
                    'chat_id' => $chatID,
                    'status' => 'live'
                ];
                Chat::insert($insert);
                $new = true;
            } else {
                $chatID = $chatID->chat_id;
            }

            $messageID = $this->generateID(ChatMessage::class);

            $insert = [
                'message_id' => $messageID,
                'message' => $message,
                'sender_id' => $senderID,
                'receiver_id' => $receiverID,
                'chat_id' => $chatID
            ];

            ChatMessage::insert($insert);
            $status = 0;
        }

        $return = json_encode([
            'message' => $message,
            'time' => $time,
            'status' => $status,
            'new' => $new
        ]);
        
        return $return;
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
}
