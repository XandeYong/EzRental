<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Account;
use App\Models\BanRecord;
use App\Models\Chat;
use App\Models\Contract;
use App\Models\GroupChat;
use App\Models\Notification;
use App\Models\PostCriteria;
use App\Models\RoomRentalPost;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * 
     * ID:
     *  Account: A1
     *  Contract: CT1
     *  PostCriteria: PC1
     *  Chat: C1
     *  GroupChat: GC1
     *  BanRecord: BR1
     *  Notification: NTF1
     *  RoomRentalPost: RRP1
     *  Renting: R1
     *  Comment: CMT1
     *  RentRequest: RR1
     *  VisitAppointment: VA1
     *  Negotiation: NGT1
     *  PostImage: PI1
     *  ChatMessage: CM1
     *  GroupMessage: GM1
     *  GroupUser: GU1
     *  SelectedCriteria: SC1
     *  Favorite: F1
     *  Payment: P1
     *  MaintenanceRequest: MR1
     *  MaintenanceImage: MI1
     *
     * @return void
     */
    public function run()
    {

        static $iA = 1;

        $masteradmin1 = Account::create([
            'account_id' => 'A' . strval($iA++),
            'name' => "Jon Strosin",
            'gender' => "M",
            'dob' => "1981-01-19",
            'mobile_number' => "0188550178",
            'email' => "jonstrosin@gmail.com",
            'password' => "KLEIgoXUKD",
            'image' => 'profile.png',
            'status' => 'offline',
            'role' => 'MA'
        ]);
        
        sleep(1);

        $a1 = Account::create([
            'account_id' => 'A' . strval($iA++),
            'name' => "Yolanda Fahey",
            'gender' => "F",
            'dob' => strval(rand(1950, 2010)) . "-" . strval(rand(1, 12)) . "-" . strval(rand(1, 28)),
            'mobile_number' => "01" . strval(rand(10000000, 99999999)),
            'email' => "pbrandt1@gmail.com",
            'password' => "I0pVObJcKH",
            'image' => 'profile.png',
            'status' => 'offline',
            'role' => 'A',
        ]);

        sleep(1);

        $a2 = Account::create([
            'account_id' => 'A' . strval($iA++),
            'name' => "Peter Greenholt",
            'gender' => "M",
            'dob' => strval(rand(1950, 2010)) . "-" . strval(rand(1, 12)) . "-" . strval(rand(1, 28)),
            'mobile_number' => "01" . strval(rand(10000000, 99999999)),
            'email' => "tmoss2@gmail.com",
            'password' => "ObJc0pVXUEIg",
            'image' => 'profile.png',
            'status' => 'offline',
            'role' => 'O',
        ]);

        sleep(1);

        $a3 = Account::create([
            'account_id' => 'A' . strval($iA++),
            'name' => "Janice Towne",
            'gender' => "F",
            'dob' => strval(rand(1950, 2010)) . "-" . strval(rand(1, 12)) . "-" . strval(rand(1, 28)),
            'mobile_number' => "01" . strval(rand(10000000, 99999999)),
            'email' => "vjanton6@gmail.com",
            'password' => 'DxiKRnJrLc',
            'image' => 'profile.png',
            'status' => 'offline',
            'role' => 'T',
        ]);

        sleep(1);

        $a4 = Account::create([
            'account_id' => 'A' . strval($iA++),
            'name' => "Lubowitz",
            'gender' => "F",
            'dob' => strval(rand(1950, 2010)) . "-" . strval(rand(1, 12)) . "-" . strval(rand(1, 28)),
            'mobile_number' => "01" . strval(rand(10000000, 99999999)),
            'email' => "sshegog9@gmail.com",
            'password' => Str::random(10),
            'image' => 'profile.png',
            'status' => 'banned',
            'role' => 'O',
        ]);

        sleep(1);

        $a5 = Account::create([
            'account_id' => 'A' . strval($iA++),
            'name' => "Angela Friesen",
            'gender' => "F",
            'dob' => strval(rand(1950, 2010)) . "-" . strval(rand(1, 12)) . "-" . strval(rand(1, 28)),
            'mobile_number' => "01" . strval(rand(10000000, 99999999)),
            'email' => "Kailey@gmail.com",
            'password' => Str::random(10),
            'image' => 'profile.png',
            'status' => 'banned',
            'role' => 'T',
        ]);


        static $iCT = 1;

        $ct1 = Contract::create([
            'contract_id' => 'CT' . strval($iCT),
            'content' => 'Sed quia minima nesciunt. Vero consequatur est labore dignissimos maiores blanditiis tempora. Id quisquam dolor laboriosam omnis. Voluptate blanditiis voluptatem.
Quo ut soluta laborum consequatur quam et deleniti. At ullam blanditiis nam. Sunt iste cumque porro qui asperiores animi officia et. Illum sit et natus in consequatur tempore. Et doloribus rerum quis alias vel officia. 
Corrupti at quasi ut et doloribus illum et cupiditate. Ut in vitae. Beatae reprehenderit laborum ex maxime sequi voluptatem minima.',

            'expired_date' => '2023-04-28',
            'owner_signature' => 'CT' . strval($iCT) . '_O_sign.jpg',
            'tenant_signature' => 'CT' . strval($iCT++) . '_T_sign.jpg',
            'deposit_price' => 2250,
            'monthly_price' => 900,
            'status' => 'active',
        ]);
        
        sleep(1);

        $ct2 = Contract::create([
            'contract_id' => 'CT' . strval($iCT),
            'content' => 'Sed quia minima nesciunt. Vero consequatur est labore dignissimos maiores blanditiis tempora. Id quisquam dolor laboriosam omnis. Voluptate blanditiis voluptatem.
Quo ut soluta laborum consequatur quam et deleniti. At ullam blanditiis nam. Sunt iste cumque porro qui asperiores animi officia et. Illum sit et natus in consequatur tempore. Et doloribus rerum quis alias vel officia. 
Corrupti at quasi ut et doloribus illum et cupiditate. Ut in vitae. Beatae reprehenderit laborum ex maxime sequi voluptatem minima.',

            'expired_date' => '2021-05-01',
            'owner_signature' => 'CT' . strval($iCT) . '_O_sign.jpg',
            'tenant_signature' => 'CT' . strval($iCT++) . '_T_sign.jpg',
            'deposit_price' => 1750,
            'monthly_price' => 700,
            'status' => 'expire',
        ]);
        
        sleep(1);
        
        $ct3 = Contract::create([
            'contract_id' => 'CT' . strval($iCT),
            'content' => 'Sed quia minima nesciunt. Vero consequatur est labore dignissimos maiores blanditiis tempora. Id quisquam dolor laboriosam omnis. Voluptate blanditiis voluptatem.
Quo ut soluta laborum consequatur quam et deleniti. At ullam blanditiis nam. Sunt iste cumque porro qui asperiores animi officia et. Illum sit et natus in consequatur tempore. Et doloribus rerum quis alias vel officia. 
Corrupti at quasi ut et doloribus illum et cupiditate. Ut in vitae. Beatae reprehenderit laborum ex maxime sequi voluptatem minima.',

            'expired_date' => null,
            'owner_signature' => null,
            'tenant_signature' => null,
            'deposit_price' => 1250,
            'monthly_price' => 500,
            'status' => 'inactive',
        ]);
        
        sleep(1);


        static $iPC = 1;

        $pc1 = PostCriteria::create([
            'criteria_id' => 'PC' . strval($iPC++),
            'name' => 'PV13',
            'selected_count' => '1'
        ]);
        
        sleep(1);

        $pc2 = PostCriteria::create([
            'criteria_id' => 'PC' . strval($iPC++),
            'name' => 'PV12',
            'selected_count' => '0'
        ]);
        
        sleep(1);

        $pc3 = PostCriteria::create([
            'criteria_id' => 'PC' . strval($iPC++),
            'name' => 'Fully Furnish',
            'selected_count' => '1'
        ]);
        
        sleep(1);

        $pc4 = PostCriteria::create([
            'criteria_id' => 'PC' . strval($iPC++),
            'name' => 'Master Room',
            'selected_count' => '1'
        ]);
        
        sleep(1);

        $pc5 = PostCriteria::create([
            'criteria_id' => 'PC' . strval($iPC++),
            'name' => 'Big Medium Room',
            'selected_count' => '0'
        ]);
        
        sleep(1);

        $pc6 = PostCriteria::create([
            'criteria_id' => 'PC' . strval($iPC++),
            'name' => 'Air Conditioner',
            'selected_count' => '1'
        ]);
        
        sleep(1);


        static $iC = 1;

        $c1 = Chat::create([
            'chat_id' => 'C' . strval($iC++),
            'status' => 'live'
        ]);

        sleep(1);

        $c2 = Chat::create([
            'chat_id' => 'C' . strval($iC++),
            'status' => 'blocked1'
        ]);

        sleep(1);
        
        $c3 = Chat::create([
            'chat_id' => 'C' . strval($iC++),
            'status' => 'blocked2'
        ]);

        sleep(1);


        static $iGC = 1;

        $gc1 = GroupChat::create([
            'group_id' => 'GC' . strval($iGC++),
            'name' => 'PV13-23-33 Main'
        ]);

        sleep(1);

        $gc2 = GroupChat::create([
            'group_id' => 'GC' . strval($iGC++),
            'name' => 'PV13-23-33 Side'
        ]);

        sleep(1);


        static $iBR =1;

        $br1 = BanRecord::create([
            'ban_id' => 'BR' . strval($iBR++),
            'reason' => 'for testing purpose (1 day ban)',
            'duration' => '1',
            'status' => 'banned',
            'account_id' => $a4->account_id
        ]);

        sleep(1);

        $br2 = BanRecord::create([
            'ban_id' => 'BR' . strval($iBR++),
            'reason' => 'for testing purpose (perma ban)',
            'duration' => '0',
            'status' => 'banned',
            'account_id' => $a5->account_id
        ]);

        sleep(1);


        static $iNTF = 1;

        $ntf1 = Notification::create([
            'notification_id' => 'BR' . strval($iNTF++),
            'title' => 'new message from ' . $a2->name,
            'message' => 'hello',
            'type' => 'chat',
            'status' => 'unread',
            'account_id' => $a3->account_id
        ]);

        sleep(1);


        static $iRRP = 1;

        $rrp1 = RoomRentalPost::create([
            'notification_id' => 'RRP' . strval($iRRP++),
            'title' => 'test',
            'description' => 'Totam ut hic quas consequatur voluptas. Eum at reiciendis. Quam quia voluptatibus sed mollitia accusamus consequatur optio. Omnis occaecati cumque excepturi.',
            'room_size' => 4,
            'address' => 'unread',
            'condominium_name' => 'PV13',
            'block' => 'A',
            'floor' => '3A',
            'unit' => 5,
            'status' => 'available',
            'contract_id' => $ct3->contract_id,
            'account_id' => $a2->account_id
        ]);
        
        sleep(1);




    }
}
