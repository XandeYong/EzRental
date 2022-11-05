<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->string('account_id')->primary();
            $table->string('name');
            $table->string('gender');
            $table->date('dob');
            $table->integer('mobile_number');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('image');
            $table->string('status');
            $table->string('role');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('contracts', function (Blueprint $table) {
            $table->string('contract_id')->primary();
            $table->longText('content');
            $table->date('expired_date')->nullable();
            $table->string('owner_signature')->nullable();
            $table->string('tenant_signature')->nullable();
            $table->double('deposit_price');
            $table->double('monthly_price');
            $table->string('status');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('criterias', function (Blueprint $table) {
            $table->string('criteria_id')->primary();
            $table->string('name');
            $table->integer('selected_count');
            $table->integer('post_count');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
        
        Schema::create('chats', function (Blueprint $table) {
            $table->string('chat_id')->primary();
            $table->string('status');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
        
        Schema::create('group_chats', function (Blueprint $table) {
            $table->string('group_id')->primary();
            $table->string('name');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });



        Schema::create('ban_records', function (Blueprint $table) {
            $table->string('ban_id')->primary();
            $table->text('reason');
            $table->integer('duration');
            $table->string('status');
            $table->string('account_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->string('notification_id')->primary();
            $table->string('title');
            $table->text('message');
            $table->string('type');
            $table->string('status');
            $table->string('account_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('room_rental_posts', function (Blueprint $table) {
            $table->string('post_id')->primary();
            $table->string('title');
            $table->mediumText('description');
            $table->string('room_size');
            $table->text('address');
            $table->string('condominium_name')->unique();
            $table->string('block');
            $table->string('floor');
            $table->integer('unit');
            $table->string('status');
            $table->string('contract_id');
            $table->string('account_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('rentings', function (Blueprint $table) {
            $table->string('renting_id')->primary();
            $table->string('account_id');
            $table->string('post_id');
            $table->string('contract_id');
            $table->string('status');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
        
        Schema::create('comments', function (Blueprint $table) {
            $table->string('comment_id')->primary();
            $table->mediumText('message');
            $table->double('rating');
            $table->string('status');
            $table->string('account_id');
            $table->string('post_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('rent_requests', function (Blueprint $table) {
            $table->string('rent_request_id')->primary();
            $table->double('price');
            $table->date('rent_date_start');
            $table->date('rent_date_end');
            $table->string('status');
            $table->string('post_id');
            $table->string('account_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('visit_appointments', function (Blueprint $table) {
            $table->string('appointment_id')->primary();
            $table->dateTime('datetime');
            $table->text('note');
            $table->string('status');
            $table->string('post_id');
            $table->string('account_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('negotiations', function (Blueprint $table) {
            $table->string('negotiation_id')->primary();
            $table->double('price');
            $table->text('message');
            $table->string('status');
            $table->string('post_id');
            $table->string('account_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('post_images', function (Blueprint $table) {
            $table->string('post_image_id')->primary();
            $table->string('image');
            $table->string('post_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
                
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->string('message_id')->primary();
            $table->text('message');
            $table->string('sender_id');
            $table->string('receiver_id');
            $table->string('chat_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('group_messages', function (Blueprint $table) {
            $table->string('group_message_id')->primary();
            $table->text('message');
            $table->string('sender_id');
            $table->string('group_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
        
        Schema::create('group_users', function (Blueprint $table) {
            $table->string('group_id');
            $table->string('account_id');
            $table->string('role');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->primary(['group_id', 'account_id']);
        });

        Schema::create('selected_criterias', function (Blueprint $table) {
            $table->string('criteria_id');
            $table->string('account_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->primary(['criteria_id', 'account_id']);
        });

        Schema::create('post_criterias', function (Blueprint $table) {
            $table->string('criteria_id');
            $table->string('post_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->primary(['criteria_id', 'post_id']);
        });

        Schema::create('favorites', function (Blueprint $table) {
            $table->string('post_id');
            $table->string('account_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->primary(['post_id', 'account_id']);
        });



        Schema::create('payments', function (Blueprint $table) {
            $table->string('payment_id')->primary();
            $table->string('payment_method');
            $table->string('payment_type');
            $table->string('paid_date')->nullable();
            $table->double('amount');
            $table->string('status');
            $table->string('renting_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('maintenance_requests', function (Blueprint $table) {
            $table->string('maintenance_id')->primary();
            $table->string('title');
            $table->mediumText('description');
            $table->date('fullfill_date')->nullable();
            $table->string('status');
            $table->string('renting_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('maintenance_images', function (Blueprint $table) {
            $table->string('maintenance_image_id')->primary();
            $table->string('image');
            $table->string('maintenance_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });


        // Foreign key
        
        Schema::table('ban_records', function (Blueprint $table) {
            $table->foreign('account_id')->references('account_id')->on('accounts');
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->foreign('account_id')->references('account_id')->on('accounts');
        });

        Schema::table('room_rental_posts', function (Blueprint $table) {
            $table->foreign('contract_id')->references('contract_id')->on('contracts');
            $table->foreign('account_id')->references('account_id')->on('accounts');
        });

        Schema::table('rentings', function (Blueprint $table) {
            $table->foreign('account_id')->references('account_id')->on('accounts');
            $table->foreign('post_id')->references('post_id')->on('room_rental_posts');
            $table->foreign('contract_id')->references('contract_id')->on('contracts');
        });
        
        Schema::table('comments', function (Blueprint $table) {
            $table->foreign('account_id')->references('account_id')->on('accounts');
            $table->foreign('post_id')->references('post_id')->on('room_rental_posts');
        });

        Schema::table('rent_requests', function (Blueprint $table) {
            $table->foreign('post_id')->references('post_id')->on('room_rental_posts');
            $table->foreign('account_id')->references('account_id')->on('accounts');
        });

        Schema::table('visit_appointments', function (Blueprint $table) {
            $table->foreign('post_id')->references('post_id')->on('room_rental_posts');
            $table->foreign('account_id')->references('account_id')->on('accounts');
        });

        Schema::table('negotiations', function (Blueprint $table) {
            $table->foreign('post_id')->references('post_id')->on('room_rental_posts');
            $table->foreign('account_id')->references('account_id')->on('accounts');
        });

        Schema::table('post_images', function (Blueprint $table) {
            $table->foreign('post_id')->references('post_id')->on('room_rental_posts');
        });

        Schema::table('chat_messages', function (Blueprint $table) {
            $table->foreign('sender_id')->references('account_id')->on('accounts');
            $table->foreign('receiver_id')->references('account_id')->on('accounts');
            $table->foreign('chat_id')->references('chat_id')->on('chats');
        });

        Schema::table('group_messages', function (Blueprint $table) {
            $table->foreign('sender_id')->references('account_id')->on('accounts');
            $table->foreign('group_id')->references('group_id')->on('group_chats');
        });

        Schema::table('group_users', function (Blueprint $table) {
            $table->foreign('group_id')->references('group_id')->on('group_chats');
            $table->foreign('account_id')->references('account_id')->on('accounts');
        });

        Schema::table('selected_criterias', function (Blueprint $table) {
            $table->foreign('criteria_id')->references('criteria_id')->on('criterias');
            $table->foreign('account_id')->references('account_id')->on('accounts');
        });

        Schema::table('post_criterias', function (Blueprint $table) {
            $table->foreign('criteria_id')->references('criteria_id')->on('criterias');
            $table->foreign('post_id')->references('post_id')->on('room_rental_posts');
        });

        Schema::table('favorites', function (Blueprint $table) {
            $table->foreign('post_id')->references('post_id')->on('room_rental_posts');
            $table->foreign('account_id')->references('account_id')->on('accounts');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->foreign('renting_id')->references('renting_id')->on('rentings');
        });

        Schema::table('maintenance_requests', function (Blueprint $table) {
            $table->foreign('renting_id')->references('renting_id')->on('rentings');
        });

        Schema::table('maintenance_images', function (Blueprint $table) {
            $table->foreign('maintenance_id')->references('maintenance_id')->on('maintenance_requests');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maintenance_images');
        Schema::dropIfExists('maintenance_requests');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('favorites');
        Schema::dropIfExists('post_criterias');
        Schema::dropIfExists('selected_criterias');
        Schema::dropIfExists('group_users');
        Schema::dropIfExists('group_messages');
        Schema::dropIfExists('chat_messages');
        Schema::dropIfExists('post_images');
        Schema::dropIfExists('negotiations');
        Schema::dropIfExists('visit_appointments');
        Schema::dropIfExists('rent_requests');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('rentings');
        Schema::dropIfExists('room_rental_posts');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('ban_records');
        Schema::dropIfExists('group_chats');
        Schema::dropIfExists('chats');
        Schema::dropIfExists('criterias');
        Schema::dropIfExists('contracts');
        Schema::dropIfExists('accounts');
    }

};