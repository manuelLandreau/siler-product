<?php

use App\Models\User;
use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        User::create([
            'username' => getenv('USERNAME'),
            'password' => password_hash(geten('PASSWORD'), PASSWORD_BCRYPT),
        ]);
    }
}
