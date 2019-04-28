<?php

namespace App\Console\Commands;

use App\Mail\Reminder;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Spark;

class WeeklyReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends a notification for users who have not been online for a week';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        User::query()->where('is_archived', false)->where('type', '!=', 'admin')->where('last_login_at', '<', Carbon::now()->subWeek())->chunk(10, function($users){
           foreach($users as $user){
                Mail::to($user)->send(new Reminder());

                echo "Reminder sent to {$user->id} \n";
           }
        });
    }
}
