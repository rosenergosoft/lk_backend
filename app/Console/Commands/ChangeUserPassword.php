<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class ChangeUserPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:password';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        do {
            $details  = $this->askForPassword();
            $email = $details['email'];
            $password = $details['password'];
        }
        while (!$this->confirm("Change password for {$email}?", true));
        $user = User::where('email', $email)->first();
        if(!isset($user)) {
            $this->info("User doesn't exist");
            return 0;
        }
        $user->password = \Hash::make($password);
        $user->save();
        $this->info("Password has changed for user #{$user->id}");
    }

    protected function askForPassword($defaults = null)
    {
        $email = $this->ask('User email');
        $password = $this->ask('New password');
        return compact('email', 'password');

    }
}
