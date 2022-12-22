<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Account;
use App\Models\Contract;
use App\Models\Criteria;
use App\Models\RoomRentalPost;

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
            'name' => "Arthur Kuphal",
            'gender' => "M",
            'dob' => "1981-01-19",
            'mobile_number' => "0188550178",
            'email' => "jonstrosin@gmail.com",
            'password' => "KLEIgoXUKD",
            'image' => 'A' . strval($iA++) . '.png',
            'status' => 'offline',
            'role' => 'MA'
        ]);

        $a2 = Account::create([
            'account_id' => 'A' . strval($iA),
            'name' => "Marcos Metz",
            'gender' => "M",
            'dob' => "1981-01-19",
            'mobile_number' => "0188550178",
            'email' => "marcosmetz@gmail.com",
            'password' => "123456",
            'image' => 'A' . strval($iA++) . '.png',
            'status' => 'offline',
            'role' => 'A'
        ]);

        $a3 = Account::create([
            'account_id' => 'A' . strval($iA),
            'name' => "Dexter Kling MD",
            'gender' => "M",
            'dob' => "1981-01-19",
            'mobile_number' => "0188550178",
            'email' => "dexterklingmd@gmail.com",
            'password' => "123456",
            'image' => 'A' . strval($iA++) . '.png',
            'status' => 'offline',
            'role' => 'O'
        ]);

        $a3 = Account::create([
            'account_id' => 'A' . strval($iA),
            'name' => "Kim Larkin",
            'gender' => "F",
            'dob' => "1981-01-19",
            'mobile_number' => "0188550178",
            'email' => "kimlarkin@gmail.com",
            'password' => "123456",
            'image' => 'A' . strval($iA++) . '.png',
            'status' => 'offline',
            'role' => 'T'
        ]);
        


        static $iCTR = 1;

        $ctr1 = Criteria::create([
            'criteria_id' => 'CTR' . strval($iCTR++),
            'name' => 'PV13',
            'type' => 'condominium',
            'selected_count' => 1,
            'post_count' => 1
        ]);
        
        sleep(1);

        $ctr2 = Criteria::create([
            'criteria_id' => 'CTR' . strval($iCTR++),
            'name' => 'PV12',
            'type' => 'condominium',
            'selected_count' => 1,
            'post_count' => 0
        ]);
        
        sleep(1);

        $ctr3 = Criteria::create([
            'criteria_id' => 'CTR' . strval($iCTR++),
            'name' => 'Master Room',
            'type' => 'room type',
            'selected_count' => 0,
            'post_count' => 0
        ]);
        
        sleep(1);

        $ctr4 = Criteria::create([
            'criteria_id' => 'CTR' . strval($iCTR++),
            'name' => 'Big Medium Room',
            'type' => 'room type',
            'selected_count' => 0,
            'post_count' => 0
        ]);
        
        sleep(1);
        
        $ctr5 = Criteria::create([
            'criteria_id' => 'CTR' . strval($iCTR++),
            'name' => 'Small Medium Room',
            'type' => 'room type',
            'selected_count' => 0,
            'post_count' => 0
        ]);
        
        sleep(1);
        
        $ctr6 = Criteria::create([
            'criteria_id' => 'CTR' . strval($iCTR++),
            'name' => 'Small Room',
            'type' => 'room type',
            'selected_count' => 0,
            'post_count' => 1
        ]);
        
        sleep(1);

        $ctr7 = Criteria::create([
            'criteria_id' => 'CTR' . strval($iCTR++),
            'name' => 'Fully Furnish',
            'type' => 'furnish type',
            'selected_count' => 0,
            'post_count' => 0
        ]);
        
        sleep(1);
        
        $ctr8 = Criteria::create([
            'criteria_id' => 'CTR' . strval($iCTR++),
            'name' => 'No Furnish',
            'type' => 'furnish type',
            'selected_count' => 0,
            'post_count' => 0
        ]);
        
        sleep(1);
        
        $ctr9 = Criteria::create([
            'criteria_id' => 'CTR' . strval($iCTR++),
            'name' => 'Ceiling Fan',
            'type' => 'equipment',
            'selected_count' => 0,
            'post_count' => 0
        ]);
        
        sleep(1);
        
        $ctr10 = Criteria::create([
            'criteria_id' => 'CTR' . strval($iCTR++),
            'name' => 'Air Conditioner',
            'type' => 'equipment',
            'selected_count' => 0,
            'post_count' => 0
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
            'account_id' => $a3->account_id
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
            'status' => 'available',
            'account_id' => $a3->account_id
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
            'status' => 'available',
            'account_id' => $a3->account_id
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
            'account_id' => $a3->account_id
        ]);
        
        sleep(1);

        $rrp5 = RoomRentalPost::create([
            'post_id' => 'RRP' . strval($iRRP++),
            'title' => 'PV12 small room for rent',
            'description' => 'Included all facility like Wifi, air-conditioner and many more.',
            'room_size' => "small",
            'address' => 'Sentral Station-Kl Sentral Jln Tun Sambanthan',
            'condominium_name' => 'PV12',
            'block' => 'A',
            'floor' => '1',
            'unit' => 3,
            'status' => 'avaialble',
            'account_id' => $a3->account_id
        ]);
        
        sleep(1);

        $rrp6 = RoomRentalPost::create([
            'post_id' => 'RRP' . strval($iRRP++),
            'title' => 'PV9 Medium room for rent',
            'description' => 'Included all facility like Wifi, air-conditioner and many more.',
            'room_size' => "medium",
            'address' => 'Sentral Station-Kl Sentral Jln Tun Sambanthan',
            'condominium_name' => 'PV9',
            'block' => 'B',
            'floor' => '13',
            'unit' => 31,
            'status' => 'avaialble',
            'account_id' => $a3->account_id
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
            'status' => 'expired',
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
            'status' => 'inactive',
            'post_id' => $rrp5->post_id
        ]);
        

    }
}
