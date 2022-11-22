<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Account;
use App\Models\BanRecord;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\Comment;
use App\Models\Contract;
use App\Models\Criteria;
use App\Models\Favorite;
use App\Models\GroupChat;
use App\Models\GroupMessage;
use App\Models\GroupUser;
use App\Models\MaintenanceImage;
use App\Models\MaintenanceRequest;
use App\Models\Negotiation;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\PostCriteria;
use App\Models\PostImage;
use App\Models\Renting;
use App\Models\RentRequest;
use App\Models\RoomRentalPost;
use App\Models\SelectedCriteria;
use App\Models\VisitAppointment;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * 
     * ID:
     *  Account: A1
     *  Criteria: CTR1
     *  Chat: C1
     *  GroupChat: GC1
     *  BanRecord: BR1
     *  Notification: NTF1
     *  RoomRentalPost: RRP1
     *  Contract: CT1
     *  Renting: R1
     *  Comment: CMT1
     *  RentRequest: RR1
     *  VisitAppointment: VA1
     *  Negotiation: NGT1
     *  PostImage: PI1
     *  ChatMessage: CM1
     *  GroupMessage: GM1
     *  Payment: P1
     *  MaintenanceRequest: MR1
     *  MaintenanceImage: MI1
     * 
     * ID-less:
     *  SelectedCriteria: SC
     *  PostCriteria: PC
     *  GroupUser: GU
     *  Favorite: F
     *  
     *
     * @return void
     */
    public function run()
    {

        static $iA = 1;

        $ma1 = Account::create([
            'account_id' => 'A' . strval($iA),
            'name' => "Jon Strosin",
            'gender' => "M",
            'dob' => "1981-01-19",
            'mobile_number' => "0188550178",
            'email' => "jonstrosin@gmail.com",
            'password' => "KLEIgoXUKD",
            'image' => 'A' . strval($iA++) . '.png',
            'status' => 'offline',
            'role' => 'MA'
        ]);
        
        sleep(1);

        $a1 = Account::create([
            'account_id' => 'A' . strval($iA),
            'name' => "Yolanda Fahey",
            'gender' => "F",
            'dob' => strval(rand(1950, 2010)) . "-" . strval(rand(1, 12)) . "-" . strval(rand(1, 28)),
            'mobile_number' => "01" . strval(rand(10000000, 99999999)),
            'email' => "pbrandt1@gmail.com",
            'password' => "I0pVObJcKH",
            'image' => 'A' . strval($iA++) . '.png',
            'status' => 'offline',
            'role' => 'A',
        ]);

        sleep(1);

        $a2 = Account::create([
            'account_id' => 'A' . strval($iA),
            'name' => "Peter Greenholt",
            'gender' => "M",
            'dob' => strval(rand(1950, 2010)) . "-" . strval(rand(1, 12)) . "-" . strval(rand(1, 28)),
            'mobile_number' => "01" . strval(rand(10000000, 99999999)),
            'email' => "tmoss2@gmail.com",
            'password' => "ObJc0pVXUEIg",
            'image' => 'A' . strval($iA++) . '.png',
            'status' => 'offline',
            'role' => 'O',
        ]);

        sleep(1);

        $a3 = Account::create([
            'account_id' => 'A' . strval($iA),
            'name' => "Janice Towne",
            'gender' => "F",
            'dob' => strval(rand(1950, 2010)) . "-" . strval(rand(1, 12)) . "-" . strval(rand(1, 28)),
            'mobile_number' => "01" . strval(rand(10000000, 99999999)),
            'email' => "vjanton6@gmail.com",
            'password' => 'DxiKRnJrLc',
            'image' => 'A' . strval($iA++) . '.png',
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
            'password' => "Vruqm3C6j4",
            'image' => 'profile.png',
            'status' => 'offline',
            'role' => 'T',
        ]);
        
        sleep(1);

        $a6 = Account::create([
            'account_id' => 'A' . strval($iA++),
            'name' => "Danial Siow",
            'gender' => "M",
            'dob' => strval(rand(1950, 2010)) . "-" . strval(rand(1, 12)) . "-" . strval(rand(1, 28)),
            'mobile_number' => "01" . strval(rand(10000000, 99999999)),
            'email' => "Danial@gmail.com",
            'password' => Str::random(10),
            'image' => 'profile.png',
            'status' => 'online',
            'role' => 'T',
        ]);
        
        sleep(1);

        $a7 = Account::create([
            'account_id' => 'A' . strval($iA++),
            'name' => "Sylvester Cremin",
            'gender' => "M",
            'dob' => strval(rand(1950, 2010)) . "-" . strval(rand(1, 12)) . "-" . strval(rand(1, 28)),
            'mobile_number' => "01" . strval(rand(10000000, 99999999)),
            'email' => "Oberbrunner@gmail.com",
            'password' => Str::random(10),
            'image' => 'profile.png',
            'status' => 'banned',
            'role' => 'T',
        ]);
        
        sleep(1);


        static $iCTR = 1;

        $ctr1 = Criteria::create([
            'criteria_id' => 'CTR' . strval($iCTR++),
            'name' => 'PV13',
            'selected_count' => 1,
            'post_count' => 1
        ]);
        
        sleep(1);

        $ctr2 = Criteria::create([
            'criteria_id' => 'CTR' . strval($iCTR++),
            'name' => 'PV12',
            'selected_count' => 1,
            'post_count' => 0
        ]);
        
        sleep(1);

        $ctr3 = Criteria::create([
            'criteria_id' => 'CTR' . strval($iCTR++),
            'name' => 'Fully Furnish',
            'selected_count' => 0,
            'post_count' => 1
        ]);
        
        sleep(1);

        $ctr4 = Criteria::create([
            'criteria_id' => 'CTR' . strval($iCTR++),
            'name' => 'Master Room',
            'selected_count' => 0,
            'post_count' => 0
        ]);
        
        sleep(1);

        $ctr5 = Criteria::create([
            'criteria_id' => 'CTR' . strval($iCTR++),
            'name' => 'Big Medium Room',
            'selected_count' => 0,
            'post_count' => 0
        ]);
        
        sleep(1);

        $ctr6 = Criteria::create([
            'criteria_id' => 'CTR' . strval($iCTR++),
            'name' => 'Air Conditioner',
            'selected_count' => 0,
            'post_count' => 0
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
            'account_id' => $a7->account_id
        ]);

        sleep(1);


        static $iNTF = 1;

        $ntf1 = Notification::create([
            'notification_id' => 'NTF' . strval($iNTF++),
            'title' => 'new message from ' . $a2->name,
            'message' => 'hello',
            'type' => 'chat',
            'status' => 'read',
            'account_id' => $a3->account_id
        ]);

        sleep(1);

        $ntf2 = Notification::create([
            'notification_id' => 'NTF' . strval($iNTF++),
            'title' => 'new message from ' . $a2->name,
            'message' => 'hello',
            'type' => 'chat',
            'status' => 'unread',
            'account_id' => $a3->account_id
        ]);

        sleep(1);


        static $iRRP = 1;

        $rrp1 = RoomRentalPost::create([
            'post_id' => 'RRP' . strval($iRRP++),
            'title' => 'PV13 small room for rent',
            'description' => 'Included all facility like Wifi, air-conditioner and many more.',
            'room_size' => 'small',
            'address' => 'G16,PV13 Platinum Lake Condominium, 9, Jalan Danau Saujana 1, Setapak, 53300 Kuala Lumpur',
            'condominium_name' => 'PV13',
            'block' => 'A',
            'floor' => '3A',
            'unit' => 10,
            'status' => 'available',
            'account_id' => $a2->account_id
        ]);
        
        sleep(1);

        $rrp2 = RoomRentalPost::create([
            'post_id' => 'RRP' . strval($iRRP++),
            'title' => 'PV15 small medium room for rent',
            'description' => 'Included all facility like Wifi, air-conditioner and many more.',
            'room_size' => "small medium",
            'address' => 'PV15 Platinum Lake Condominium, Taman Danau Kota, 53300 Kuala Lumpur, Wilayah Persekutuan Kuala Lumpur',
            'condominium_name' => 'PV15',
            'block' => 'A',
            'floor' => '16',
            'unit' => 66,
            'status' => 'reserve',
            'account_id' => $a4->account_id
        ]);
        
        sleep(1);

        $rrp3 = RoomRentalPost::create([
            'post_id' => 'RRP' . strval($iRRP++),
            'title' => 'PV16 big medium room for rent',
            'description' => 'Included all facility like Wifi, air-conditioner and many more.',
            'room_size' => "big medium",
            'address' => '2, Jalan Danau Saujana, Taman Danau Kota, 53000 Kuala Lumpur, Wilayah Persekutuan Kuala Lumpur',
            'condominium_name' => 'PV16',
            'block' => 'A',
            'floor' => '17',
            'unit' => 70,
            'status' => 'renting',
            'account_id' => $a2->account_id
        ]);
        
        sleep(1);

        $rrp4 = RoomRentalPost::create([
            'post_id' => 'RRP' . strval($iRRP++),
            'title' => 'PV18 master room for rent',
            'description' => 'Included all facility like Wifi, air-conditioner and many more.',
            'room_size' => "master",
            'address' => 'Jalan Langkawi, Taman Setapak, 53000 Kuala Lumpur, Wilayah Persekutuan Kuala Lumpur',
            'condominium_name' => 'PV18',
            'block' => 'A',
            'floor' => '1',
            'unit' => 2,
            'status' => 'archived',
            'account_id' => $a4->account_id
        ]);
        
        sleep(1);

        $rrp5 = RoomRentalPost::create([
            'post_id' => 'RRP' . strval($iRRP++),
            'title' => 'PV12 small room for rent',
            'description' => 'Included all facility like Wifi, air-conditioner and many more.',
            'room_size' => "small",
            'address' => 'Jalan Langkawi, Taman Danau Kota, 53100 Kuala Lumpur, Wilayah Persekutuan Kuala Lumpur',
            'condominium_name' => 'PV12',
            'block' => 'A',
            'floor' => '1',
            'unit' => 3,
            'status' => 'archived',
            'account_id' => $a2->account_id
        ]);
        
        sleep(1);


        static $iCT = 1;

        $ct1 = Contract::create([
            'contract_id' => 'CT' . strval($iCT++),
            'content' => 'Sed quia minima nesciunt. Vero consequatur est labore dignissimos maiores blanditiis tempora. Id quisquam dolor laboriosam omnis. Voluptate blanditiis voluptatem.
Quo ut soluta laborum consequatur quam et deleniti. At ullam blanditiis nam. Sunt iste cumque porro qui asperiores animi officia et. Illum sit et natus in consequatur tempore. Et doloribus rerum quis alias vel officia. 
Corrupti at quasi ut et doloribus illum et cupiditate. Ut in vitae. Beatae reprehenderit laborum ex maxime sequi voluptatem minima.',

            'expired_date' => null,
            'owner_signature' => null,
            'tenant_signature' => null,
            'deposit_price' => 2250,
            'monthly_price' => 900,
            'status' => 'inactive',
            'post_id' => $rrp1->post_id
        ]);
        
        sleep(1);

        $ct2 = Contract::create([
            'contract_id' => 'CT' . strval($iCT++),
            'content' => 'Sed quia minima nesciunt. Vero consequatur est labore dignissimos maiores blanditiis tempora. Id quisquam dolor laboriosam omnis. Voluptate blanditiis voluptatem.
Quo ut soluta laborum consequatur quam et deleniti. At ullam blanditiis nam. Sunt iste cumque porro qui asperiores animi officia et. Illum sit et natus in consequatur tempore. Et doloribus rerum quis alias vel officia. 
Corrupti at quasi ut et doloribus illum et cupiditate. Ut in vitae. Beatae reprehenderit laborum ex maxime sequi voluptatem minima.',

            'expired_date' => null,
            'owner_signature' => null,
            'tenant_signature' => null,
            'deposit_price' => 1750,
            'monthly_price' => 700,
            'status' => 'inactive',
            'post_id' => $rrp2->post_id
        ]);
        
        sleep(1);
        
        $ct3 = Contract::create([
            'contract_id' => 'CT' . strval($iCT),
            'content' => 'Sed quia minima nesciunt. Vero consequatur est labore dignissimos maiores blanditiis tempora. Id quisquam dolor laboriosam omnis. Voluptate blanditiis voluptatem.
Quo ut soluta laborum consequatur quam et deleniti. At ullam blanditiis nam. Sunt iste cumque porro qui asperiores animi officia et. Illum sit et natus in consequatur tempore. Et doloribus rerum quis alias vel officia. 
Corrupti at quasi ut et doloribus illum et cupiditate. Ut in vitae. Beatae reprehenderit laborum ex maxime sequi voluptatem minima.',

            'expired_date' => '2023-04-28',
            'owner_signature' => 'CT' . strval($iCT) . '_O_sign.png',
            'tenant_signature' => 'CT' . strval($iCT++) . '_T_sign.png',
            'deposit_price' => 1250,
            'monthly_price' => 500,
            'status' => 'active',
            'post_id' => $rrp3->post_id
        ]);
        
        sleep(1);

        $ct4 = Contract::create([
            'contract_id' => 'CT' . strval($iCT),
            'content' => 'Sed quia minima nesciunt. Vero consequatur est labore dignissimos maiores blanditiis tempora. Id quisquam dolor laboriosam omnis. Voluptate blanditiis voluptatem.
Quo ut soluta laborum consequatur quam et deleniti. At ullam blanditiis nam. Sunt iste cumque porro qui asperiores animi officia et. Illum sit et natus in consequatur tempore. Et doloribus rerum quis alias vel officia. 
Corrupti at quasi ut et doloribus illum et cupiditate. Ut in vitae. Beatae reprehenderit laborum ex maxime sequi voluptatem minima.',

            'expired_date' => '2021-05-01',
            'owner_signature' => 'CT' . strval($iCT) . '_O_sign.png',
            'tenant_signature' => 'CT' . strval($iCT++) . '_T_sign.png',
            'deposit_price' => 1550,
            'monthly_price' => 600,
            'status' => 'expire',
            'post_id' => $rrp4->post_id
        ]);
        
        sleep(1);

        $ct5 = Contract::create([
            'contract_id' => 'CT' . strval($iCT++),
            'content' => 'Sed quia minima nesciunt. Vero consequatur est labore dignissimos maiores blanditiis tempora. Id quisquam dolor laboriosam omnis. Voluptate blanditiis voluptatem.
Quo ut soluta laborum consequatur quam et deleniti. At ullam blanditiis nam. Sunt iste cumque porro qui asperiores animi officia et. Illum sit et natus in consequatur tempore. Et doloribus rerum quis alias vel officia. 
Corrupti at quasi ut et doloribus illum et cupiditate. Ut in vitae. Beatae reprehenderit laborum ex maxime sequi voluptatem minima.',

            'expired_date' => null,
            'owner_signature' => null,
            'tenant_signature' => null,
            'deposit_price' => 1550,
            'monthly_price' => 600,
            'status' => 'expire',
            'post_id' => $rrp5->post_id
        ]);
        
        sleep(1);


        static $iR = 1;

        $r1 = Renting::create([
            'renting_id' => 'R' . strval($iR++),
            'account_id' => $a3->account_id,
            'post_id' => $rrp3->post_id,
            'contract_id' => $ct3->contract_id,
            'status' => 'active',
        ]);
        
        sleep(1);

        $r2 = Renting::create([
            'renting_id' => 'R' . strval($iR++),
            'account_id' => $a4->account_id,
            'post_id' => $rrp4->post_id,
            'contract_id' => $ct4->contract_id,
            'status' => 'expired',
        ]);
        
        sleep(1);


        static $iCMT = 1;

        $cmt1 = Comment::create([
            'comment_id' => 'CMT' . strval($iCMT++),
            'message' => 'It was quite dirty.',
            'rating' => 3.0,
            'status' => 'show',
            'account_id' => $a5->account_id,
            'post_id' => $rrp4->post_id,
        ]);
        
        sleep(1);

        $cmt1 = Comment::create([
            'comment_id' => 'CMT' . strval($iCMT++),
            'message' => 'Not bad.',
            'rating' => 4.0,
            'status' => 'hide',
            'account_id' => $a5->account_id,
            'post_id' => $rrp5->post_id,
        ]);
        
        sleep(1);


        static $iRR = 1;

        $rr1 = RentRequest::create([
            'rent_request_id' => 'RR' . strval($iRR++),
            'price' => 600.00,
            'rent_date_start' => '2023-04-28',
            'rent_date_end' => '2023-08-28',
            'status' => 'pending',
            'post_id' => $rrp1->post_id,
            'account_id' => $a5->account_id,
        ]);
        
        sleep(1);

        $rr2 = RentRequest::create([
            'rent_request_id' => 'RR' . strval($iRR++),
            'price' => 700.00,
            'rent_date_start' => '2022-04-28',
            'rent_date_end' => '2022-08-28',
            'status' => 'approved',
            'post_id' => $rrp2->post_id,
            'account_id' => $a6->account_id,
        ]);
        
        sleep(1);

        $rr3 = RentRequest::create([
            'rent_request_id' => 'RR' . strval($iRR++),
            'price' => 800.00,
            'rent_date_start' => '2022-04-28',
            'rent_date_end' => '2022-08-28',
            'status' => 'rejected',
            'post_id' => $rrp2->post_id,
            'account_id' => $a5->account_id,
        ]);
        
        sleep(1);

        $rr4 = RentRequest::create([
            'rent_request_id' => 'RR' . strval($iRR++),
            'price' => 500.00,
            'rent_date_start' => '2021-06-27',
            'rent_date_end' => '2021-12-20',
            'status' => 'expired',
            'post_id' => $rrp2->post_id,
            'account_id' => $a5->account_id,
        ]);
        
        sleep(1);

        $rr5 = RentRequest::create([
            'rent_request_id' => 'RR' . strval($iRR++),
            'price' => 600.00,
            'rent_date_start' => '2023-06-27',
            'rent_date_end' => '2023-12-20',
            'status' => 'canceled',
            'post_id' => $rrp1->post_id,
            'account_id' => $a5->account_id,
        ]);
        
        sleep(1);

        $rr6 = RentRequest::create([
            'rent_request_id' => 'RR' . strval($iRR++),
            'price' => 500.00,
            'rent_date_start' => '2024-04-28',
            'rent_date_end' => '2024-08-28',
            'status' => 'success',
            'post_id' => $rrp1->post_id,
            'account_id' => $a5->account_id,
        ]);
        
        sleep(1);


        static $iVA = 1;

        $va1 = VisitAppointment::create([
            'appointment_id' => 'VA' . strval($iVA++),
            'datetime' => '2022-05-28 01:10:20',
            'note' => 'Will be late 5 minutes.',
            'status' => 'pending',
            'post_id' => $rrp1->post_id,
            'account_id' => $a5->account_id,
        ]);
        
        sleep(1);

        $va2 = VisitAppointment::create([
            'appointment_id' => 'VA' . strval($iVA++),
            'datetime' => '2021-04-20 11:20:55',
            'note' => 'Will be late 6 minutes.',
            'status' => 'rescheduled',
            'post_id' => $rrp1->post_id,
            'account_id' => $a5->account_id,
        ]);
        
        sleep(1);

        $va3 = VisitAppointment::create([
            'appointment_id' => 'VA' . strval($iVA++),
            'datetime' => '2021-03-21 15:33:41',
            'note' => 'Will arrived early minutes.',
            'status' => 'approved',
            'post_id' => $rrp1->post_id,
            'account_id' => $a6->account_id,
        ]);
        
        sleep(1);

        $va4 = VisitAppointment::create([
            'appointment_id' => 'VA' . strval($iVA++),
            'datetime' => '2021-03-21 11:33:41',
            'note' => 'Will arrived early minutes.',
            'status' => 'rejected',
            'post_id' => $rrp1->post_id,
            'account_id' => $a6->account_id,
        ]);
        
        sleep(1);

        $va5 = VisitAppointment::create([
            'appointment_id' => 'VA' . strval($iVA++),
            'datetime' => '2021-02-21 02:14:41',
            'note' => 'Hope to see you soon.',
            'status' => 'canceled',
            'post_id' => $rrp1->post_id,
            'account_id' => $a6->account_id,
        ]);
        
        sleep(1);

        $va6 = VisitAppointment::create([
            'appointment_id' => 'VA' . strval($iVA++),
            'datetime' => '2021-02-21 03:15:41',
            'note' => 'Hope to see you soon.',
            'status' => 'success',
            'post_id' => $rrp2->post_id,
            'account_id' => $a5->account_id,
        ]);
        
        sleep(1);


        static $iNGT = 1;

        $ngt1 = Negotiation::create([
            'negotiation_id' => 'NGT' . strval($iNGT++),
            'price' => 500.00,
            'message' => 'Can negotiate.',
            'status' => 'tenant_offer',
            'post_id' => $rrp1->post_id,
            'account_id' => $a5->account_id,
        ]);
        
        sleep(1);

        $ngt2 = Negotiation::create([
            'negotiation_id' => 'NGT' . strval($iNGT++),
            'price' => 600.00,
            'message' => 'Can negotiate.',
            'status' => 'owner_offer',
            'post_id' => $rrp1->post_id,
            'account_id' => $a5->account_id,
        ]);
        
        sleep(1);

        $ngt3 = Negotiation::create([
            'negotiation_id' => 'NGT' . strval($iNGT++),
            'price' => 400.00,
            'message' => 'Can negotiate.',
            'status' => 'accepted',
            'post_id' => $rrp5->post_id,
            'account_id' => $a6->account_id,
        ]);
        
        sleep(1);

        $ngt4 = Negotiation::create([
            'negotiation_id' => 'NGT' . strval($iNGT++),
            'price' => 500.00,
            'message' => 'Can negotiate.',
            'status' => 'rejected',
            'post_id' => $rrp4->post_id,
            'account_id' => $a6->account_id,
        ]);
        
        sleep(1);

        $ngt5 = Negotiation::create([
            'negotiation_id' => 'NGT' . strval($iNGT++),
            'price' => 600.00,
            'message' => 'Can negotiate.',
            'status' => 'canceled',
            'post_id' => $rrp3->post_id,
            'account_id' => $a6->account_id,
        ]);
        
        sleep(1);


        static $iPI = 1;

        $pi1 = PostImage::create([
            'post_image_id' => 'PI' . strval($iPI),
            'image' => 'PI' . strval($iPI++) . '.png',
            'post_id' => $rrp1->post_id,
            'status' => 'show'
        ]);
        
        sleep(1);

        $pi2 = PostImage::create([
            'post_image_id' => 'PI' . strval($iPI),
            'image' => 'PI' . strval($iPI++) . '.png',
            'post_id' => $rrp2->post_id,
            'status' => 'show'
        ]);
        
        sleep(1);

        $pi3 = PostImage::create([
            'post_image_id' => 'PI' . strval($iPI),
            'image' => 'PI' . strval($iPI++) . '.jpg',
            'post_id' => $rrp3->post_id,
            'status' => 'show'
        ]);
        
        sleep(1);

        $pi4 = PostImage::create([
            'post_image_id' => 'PI' . strval($iPI),
            'image' => 'PI' . strval($iPI++) . '.jpeg',
            'post_id' => $rrp4->post_id,
            'status' => 'show'
        ]);
        
        sleep(1);

        $pi5 = PostImage::create([
            'post_image_id' => 'PI' . strval($iPI),
            'image' => 'PI' . strval($iPI++) . '.jpg',
            'post_id' => $rrp5->post_id,
            'status' => 'show'
        ]);
        
        sleep(1);


        static $iCM = 1;

        $cm1 = ChatMessage::create([
            'message_id' => 'CM' . strval($iCM++),
            'message' => 'Hi',
            'sender_id' => $a6->account_id,
            'receiver_id' => $a4->account_id,
            'chat_id' => $c1->chat_id,
        ]);
        
        sleep(1);

        $cm2 = ChatMessage::create([
            'message_id' => 'CM' . strval($iCM++),
            'message' => 'Bye',
            'sender_id' => $a4->account_id,
            'receiver_id' => $a6->account_id,
            'chat_id' => $c1->chat_id,
        ]);
        
        sleep(1);


        static $iGM = 1;

        $gm1 = GroupMessage::create([
            'group_message_id' => 'GM' . strval($iGM++),
            'message' => 'Hi, everyone.',
            'sender_id' => $a5->account_id,
            'group_id' => $gc1->group_id,
        ]);
        
        sleep(1);

        $gm2 = GroupMessage::create([
            'group_message_id' => 'GM' . strval($iGM++),
            'message' => 'Nice to meet you.',
            'sender_id' => $a2->account_id,
            'group_id' => $gc1->group_id,
        ]);
        
        sleep(1);


        static $iGU = 1;

        $gu1 = GroupUser::create([
            'group_id' => $gc1->group_id,
            'account_id' => $a2->account_id,
            'role' => 'Master',
        ]);
        
        sleep(1);

        $gu2 = GroupUser::create([
            'group_id' => $gc1->group_id,
            'account_id' => $a3->account_id,
            'role' => 'Admin',
        ]);
        
        sleep(1);

        $gu3 = GroupUser::create([
            'group_id' => $gc1->group_id,
            'account_id' => $a5->account_id,
            'role' => 'Member',
        ]);
        
        sleep(1);


        static $iSC = 1;

        $sc1 = SelectedCriteria::create([
            'criteria_id' => $ctr1->criteria_id,
            'account_id' => $a5->account_id,
        ]);
        
        sleep(1);

        $sc2 = SelectedCriteria::create([
            'criteria_id' => $ctr2->criteria_id,
            'account_id' => $a6->account_id,
        ]);
        
        sleep(1);


        static $iPC = 1;

        $pc1 = PostCriteria::create([
            'criteria_id' => $ctr1->criteria_id,
            'post_id' => $rrp1->post_id,
        ]);
        
        sleep(1);

        $pc2 = PostCriteria::create([
            'criteria_id' => $ctr3->criteria_id,
            'post_id' => $rrp1->post_id,
        ]);
        
        sleep(1);


        static $iF = 1;

        $f1 = Favorite::create([
            'post_id' => $rrp1->post_id,
            'account_id' => $a5->account_id,
        ]);
        
        sleep(1);



        static $iP = 1;

        $p1 = Payment::create([
            'payment_id' => 'P' . strval($iP++),
            'payment_method' => 'PayPal',    
            'payment_type' => 'Monthly',    
            'paid_date' => null,    
            'amount' => 500.00,    
            'status' => 'unpaid',
            'renting_id' => $r1->renting_id,
        ]);
        
        sleep(1);

        $p2 = Payment::create([
            'payment_id' => 'P' . strval($iP++),
            'payment_method' => 'PayPal',    
            'payment_type' => 'Deposit',    
            'paid_date' => '2022-04-22',    
            'amount' => 1250.00,    
            'status' => 'paid',
            'renting_id' => $r1->renting_id,
        ]);
        
        sleep(1);


        static $iMR = 1;

        $mr1 = MaintenanceRequest::create([
            'maintenance_id' => 'MR' . strval($iMR++),
            'title' => 'Toilet Light Bulb Burn Out',    
            'description' => 'Urgent!',    
            'fullfill_date' => null,  
            'status' => 'pending',   
            'renting_id' => $r1->renting_id,
        ]);
        
        sleep(1);


        $mr2 = MaintenanceRequest::create([
            'maintenance_id' => 'MR' . strval($iMR++),
            'title' => 'Toilet Door Break',    
            'description' => 'Urgent!',    
            'fullfill_date' => null,  
            'status' => 'approved',   
            'renting_id' => $r1->renting_id,
        ]);
        
        sleep(1);


        $mr3 = MaintenanceRequest::create([
            'maintenance_id' => 'MR' . strval($iMR++),
            'title' => 'Air-conditioner Not Working',    
            'description' => 'Urgent!',    
            'fullfill_date' => null,  
            'status' => 'rejected',   
            'renting_id' => $r2->renting_id,
        ]);
        
        sleep(1);

        $mr4 = MaintenanceRequest::create([
            'maintenance_id' => 'MR' . strval($iMR++),
            'title' => 'Wall Fan Not Working',    
            'description' => 'Urgent!',    
            'fullfill_date' => '2022-11-12',  
            'status' => 'success',   
            'renting_id' => $r2->renting_id,
        ]);
        
        sleep(1);


        static $iMI = 1;

        $mi1 = MaintenanceImage::create([
            'maintenance_image_id' => 'MI' . strval($iMI),
            'image' => 'MI' . strval($iMI++) . '.jpg',     
            'maintenance_id' => $mr1->maintenance_id,
        ]);
        
        sleep(1);

        $mi2 = MaintenanceImage::create([
            'maintenance_image_id' => 'MI' . strval($iMI),
            'image' => 'MI' . strval($iMI++) . '.jpg',     
            'maintenance_id' => $mr2->maintenance_id,
        ]);
        
        sleep(1);

        $mi3 = MaintenanceImage::create([
            'maintenance_image_id' => 'MI' . strval($iMI),
            'image' => 'MI' . strval($iMI++) . '.png',     
            'maintenance_id' => $mr3->maintenance_id,
        ]);
        
        sleep(1);

        $mi4 = MaintenanceImage::create([
            'maintenance_image_id' => 'MI' . strval($iMI),
            'image' => 'MI' . strval($iMI++) . '.png',     
            'maintenance_id' => $mr4->maintenance_id,
        ]);

    }
}
