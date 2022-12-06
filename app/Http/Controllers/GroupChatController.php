<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\GroupChat;
use App\Models\GroupMessage;
use App\Models\GroupUser;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class GroupChatController extends Controller
{
    //

    public function createGroup(Request $request) {
        $name = $request->input('name', '');

        //Laravel validation
        $request->validate([
            'name' => ['required', 'max:255', 'min:5']
        ]);

        
        $master = session()->get('account')['account_id'];
        $groupID = $this->generateID(GroupChat::class);

        $insert = [
            'group_id' => $groupID,
            'name' => $name,
            'status' => 'live'
        ];

        GroupChat::insert($insert);
        
        $insert = [
            'group_id' => $groupID,
            'account_id' => $master,
            'role' => 'Master'
        ];

        GroupUser::insert($insert);

        return redirect(route('chat'));
    }

    public function getMessage($id = "") {

        $messages = [];
        if (!empty($id)) {
            $accountID = session()->get('account')['account_id'];

            //verify group user
            $groupID = GroupUser::where(['account_id' => $accountID, 'group_id' => $id])
                ->first();

            if (!empty($groupID)) {

                $messages = DB::table('group_messages', 'GM')
                    ->join('accounts as A', 'A.account_id', 'GM.sender_id')
                    ->where('GM.group_id', $groupID->group_id)
                    ->select('A.name', 'A.account_id', 'GM.*')
                    ->get();

            }
            
        }

        $return = [
            'messages' => $messages,
        ];
        
        return view('chat/group_message', $return);
    }

    public function sendMessage(Request $request) {
        $status = 1;
        $groupID = $request->input('id', "");
        $message = $request->input('message', "");
        $time = Carbon::now()->format('h:i A');

        if (!empty($groupID) && !empty($message)) {
            $senderID = session()->get('account')['account_id'];

            $groupID = GroupUser::where(['account_id' => $senderID, 'group_id' => $groupID])
                ->first();

            if (!empty($groupID)) {
                $messageID = $this->generateID(GroupMessage::class);

                $insert = [
                    'group_message_id' => $messageID,
                    'message' => $message,
                    'sender_id' => $senderID,
                    'group_id' => $groupID->group_id,
                ];
            
                GroupMessage::insert($insert);
                $status = 0;
            }
        }

        $return = json_encode([
            'message' => $message,
            'time' => $time,
            'status' => $status
        ]);
        
        return $return;
    }


    // Group User
    public function displayGroupUser($groupID = "") {

        $groupUsers = [];
        if (!empty($groupID)) {
            $accountID = session()->get('account')['account_id'];
            $user = GroupUser::where(['group_id' => $groupID, 'account_id' => $accountID])->first();

            if (!empty($user)) {
                $groupUsers = DB::table('group_users', 'GU')
                    ->join('accounts as A', 'A.account_id', 'GU.account_id')
                    ->where('group_id', $groupID)
                    ->select('A.account_id', 'A.name', 'GU.role')
                    ->get();
            }
    
        }

        $return = [
            'groupUsers' => $groupUsers
        ];

        return view('chat/group_user', $return);
    }

    public function addUser(Request $request) {
        $groupID = $request->input('groupID', '');
        $accountID = $request->input('accountID', '');

        if (!empty($groupID) && !empty($accountID)) {
            if (!empty(Account::find($accountID)) && $accountID != session()->get('account')['account_id']) {

                if (empty(GroupUser::where(['group_id' => $groupID, 'account_id' => $accountID])->first())) {
                    $insert = [
                        'group_id' => $groupID,
                        'account_id' => $accountID,
                        'role' => 'Member'
                    ];

                    GroupUser::insert($insert);
                }
    
            }
        }

        return redirect("/chat#$groupID");
    }

    public function removeUser(Request $request) {
        $groupID = $request->input('groupID', '');
        $accountID = $request->input('accountID', '');

        if (!empty($groupID) && !empty($accountID)) {
            if (!empty(Account::find($accountID)) && $accountID != session()->get('account')['account_id']) {
                $user = GroupUser::where(['group_id' => $groupID, 'account_id' => $accountID])->first();
                $myRole = GroupUser::where(['group_id' => $groupID, 'account_id' => session()->get('account')['account_id']])->first();

                if ((!empty($user) && $user->role == "Member") || $myRole->role == 'Master') {
                    GroupUser::where(['group_id' => $groupID, 'account_id' => $accountID])->delete();
                }
    
            }
        }

        return redirect("/chat#$groupID");
    }

    public function leaveGroup(Request $request) {
        $groupID = $request->input('groupID', '');
        $accountID = session()->get('account')['account_id'];

        if (!empty($groupID)) {
            $user = GroupUser::where(['group_id' => $groupID, 'account_id' => $accountID])->first();

            if (!empty($user)) {
                GroupUser::where(['group_id' => $groupID, 'account_id' => $accountID])->delete();
            }
        }

        return redirect(route('chat'));
    }

    public function promoteUser(Request $request) {
        $groupID = $request->input('groupID', '');
        $accountID = $request->input('accountID', '');

        if (!empty($groupID) && !empty($accountID)) {
            if (!empty(Account::find($accountID)) && $accountID != session()->get('account')['account_id']) {
                $user = GroupUser::where(['group_id' => $groupID, 'account_id' => $accountID])->first();

                if (!empty($user) && $user->role == 'Member') {
                    GroupUser::where(['group_id' => $groupID, 'account_id' => $accountID])->update(['role' => 'Admin']);
                }
            }
        }

        return redirect("/chat#$groupID");
    }

    public function demoteUser(Request $request) {
        $groupID = $request->input('groupID', '');
        $accountID = $request->input('accountID', '');

        if (!empty($groupID) && !empty($accountID)) {
            if (!empty(Account::find($accountID)) && $accountID != session()->get('account')['account_id']) {
                $user = GroupUser::where(['group_id' => $groupID, 'account_id' => $accountID])->first();

                if (!empty($user) && $user->role == 'Admin') {
                    GroupUser::where(['group_id' => $groupID, 'account_id' => $accountID])->update(['role' => 'Member']);
                }
            }
        }

        return redirect("/chat#$groupID");
    }

    public function transferOwnership(Request $request) {
        $groupID = $request->input('groupID', '');
        $accountID = $request->input('accountID', '');

        if (!empty($groupID) && !empty($accountID)) {
            if (!empty(Account::find($accountID)) && $accountID != session()->get('account')['account_id']) {
                $user = GroupUser::where(['group_id' => $groupID, 'account_id' => $accountID])->first();

                if (!empty($user) && $user->role != 'Master') {
                    GroupUser::where(['group_id' => $groupID, 'account_id' => $accountID])->update(['role' => 'Master']);

                    $accountID = session()->get('account')['account_id'];
                    GroupUser::where(['group_id' => $groupID, 'account_id' => $accountID])->update(['role' => 'Admin']);
                }
            }
        }

        return redirect("/chat#$groupID");
    }

    public function deleteGroup(Request $request) {
        $groupID = $request->input('groupID', '');

        if (!empty($groupID)) {
            $accountID = session()->get('account')['account_id'];
            $user = GroupUser::where(['group_id' => $groupID, 'account_id' => $accountID])->first();
            if (!empty($user) && $user->role == 'Master') {
                $group = GroupChat::find($groupID);
                $group->status = "archive";
                $group->save();
            }
        }

        return redirect("/chat");
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
