<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'createuser';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new user that can access admin panel';

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
        $username = $this->ask('What should the user\'s username be?');
        if ($username == '' || $username == null){
            $this->error('Invalid input');
            return;
        }
        $password = $this->secret("What should the password of user {$username} be?");
        if ($password == '' || $password == null){
            $this->error('Invalid input');
            return;
        }
        try{
            DB::beginTransaction();
            if (User::where('username',$username)->exists()){
                throw new \Exception('User with that username already exists');
            }
            $user = new User();
            $user->username = $username;
            $user->password = Hash::make($password);
            $user->save();
            DB::commit();
            $this->info("User with username {$username} has been created successfully");
        } catch ( \Exception $exception){
            DB::rollBack();
            $this->error('Could not create user with username '.$username);
            return;
        }


    }
}
