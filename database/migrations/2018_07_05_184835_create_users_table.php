<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->rememberToken();
            $table->text('photo_url')->nullable();
            $table->tinyInteger('uses_two_factor_auth')->default(0);
            $table->string('authy_id')->nullable();
            $table->string('country_code', 10)->nullable();
            $table->string('phone', 25)->nullable();
            $table->string('two_factor_reset_code', 100)->nullable();
            $table->integer('current_team_id')->nullable();
            $table->string('stripe_id')->nullable();
            $table->string('current_billing_plan')->nullable();
            $table->string('card_brand')->nullable();
            $table->string('card_last_four')->nullable();
            $table->string('card_country')->nullable();
            $table->string('billing_address')->nullable();
            $table->string('billing_address_line_2')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_state')->nullable();
            $table->string('billing_zip', 25)->nullable();
            $table->string('billing_country', 2)->nullable();
            $table->string('vat_id', 50)->nullable();
            $table->text('extra_billing_information')->nullable();
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('last_read_announcements_at')->nullable();
            $table->timestamps();

            $table->text('info')->nullable();
            $table->text('message')->nullable();
            $table->string('assets_url')->nullable();
            $table->string('project_name')->nullable();
            $table->string('tracking_number')->nullable();
            $table->string('gdrive_folder_id')->nullable();
            $table->enum('type', ['customer', 'admin'])->default('customer');
        });

        factory(\App\User::class)->create([
            'email' => 'ktnaneri@gmail.com',
            'name'  => 'Kanat Tabaldiev',
            'password'  => bcrypt('secret'),
            'type'      => 'admin',
        ]);

        factory(\App\User::class)->create([
            'email' => 'mike@launchboom.com',
            'name'  => 'Mike Revie',
            'password'  => bcrypt('secret'),
            'type'      => 'admin',
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
