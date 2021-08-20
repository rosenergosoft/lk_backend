<?php

namespace App\Console\Commands;

use App\Models\Client;
use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class MakeUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    protected $rolesMap = [];

    protected $clients = [];

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
        $this->rolesMap = Role::all()->pluck('name', 'id')->toArray();
        $this->clients = Client::all()->pluck('name','id')->toArray();

        do {
            $details  = $this->askForUserDetails($details ?? null);
            $name     = $details['name'];
            $email    = $details['email'];
            $password = $details['password'];
            $role     = $details['role'];
            $client   = $details['client'];
        } while (!$this->confirm("Create user {$name} <{$email}>?", true));
        $clientId = array_search($client, $this->clients);
        $role = array_search($role, $this->rolesMap);
        $user = User::forceCreate(['name' => $name, 'email' => $email, 'password' => \Hash::make($password), 'client_id' => $clientId, 'type' => 'super', 'is_active' => 1]);
        $user->assignRole($this->rolesMap[$role]);
        $permissions = Role::findById($role)->permissions->pluck('name');
        $user->syncPermissions($permissions);
        $this->info("Created new user #{$user->id}");
    }

    /**
     * @param null $defaults
     * @return array
     */
    protected function askForUserDetails($defaults = null)
    {
        $name     = $this->ask('Full name of user?', $defaults['name'] ?? null);
        $email    = $this->askUniqueEmail('Email Address for user?', $defaults['email'] ?? null);
        $password = $this->ask('Password for user? (will be visible)', $defaults['password'] ?? null);
        $client     = $this->choice('For which client this user belongs to?', $this->clients, $defaults['client'] ?? null);
        $role     = $this->choice('Which role should this user have?', $this->rolesMap, $defaults['role'] ?? null);

        return compact('name', 'email', 'password', 'role', 'client');
    }

    /**
     * @param      $message
     * @param null $default
     * @return string
     */
    protected function askUniqueEmail($message, $default = null)
    {
        do {
            $email = $this->ask($message, $default);
        } while (!$this->checkEmailIsValid($email) || !$this->checkEmailIsUnique($email));

        return $email;
    }

    /**
     * @param $email
     * @return bool
     */
    protected function checkEmailIsValid($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Sorry, "' . $email . '" is not a valid email address!');
            return false;
        }

        return true;
    }

    /**
     * @param $email
     * @return bool
     */
    public function checkEmailIsUnique($email)
    {
        if ($existingUser = User::whereEmail($email)->first()) {
            $this->error('Sorry, "' . $existingUser->email . '" is already in use by ' . $existingUser->name . '!');
            return false;
        }

        return true;
    }
}
