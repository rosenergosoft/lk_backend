<?php

namespace App\Console\Commands;

use App\Models\Client;
use Illuminate\Console\Command;

class NewClientCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:client';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make new client';

    protected $types = [
        Client::TYPE_ELECTRICITY => 'Electricity',
        Client::TYPE_WARM => 'Warm',
        Client::TYPE_WATER => 'Water',
        Client::TYPE_SEWERAGE => 'Sewerage'
    ];

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
            $details  = $this->askForUserDetails($details ?? null);
            $name     = $details['name'];
            $host     = $details['host'];
            $type     = $details['type'];
        } while (!$this->confirm("Create client {$name} <{$host}>?", true));

        $client = new Client();
        $client->name = $name;
        $client->host = $host;
        $client->type = [$type];
        $client->save();

        $this->info("Created new client #{$client->id}");
        return 0;
    }

    /**
     * @param null $defaults
     * @return array
     */
    protected function askForUserDetails($defaults = null)
    {
        $name     = $this->ask('Name of client?', $defaults['name'] ?? null);
        $host     = $this->ask('Which domain this client uses?', $defaults['host'] ?? null);
        $type     = $this->choice('Which type of this client?', $this->types, $defaults['type'] ?? null);

        return compact('name', 'host', 'type');
    }
}
