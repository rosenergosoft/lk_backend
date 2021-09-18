<?php

namespace Database\Seeders;

use App\Models\Messages;
use Illuminate\Database\Seeder;

class TruncateMessages extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Messages::truncate();
    }
}
