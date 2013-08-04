<?php

class UsersTableSeeder extends Seeder {

    public function run()
    {
        // Uncomment the below to wipe the table clean before populating
        DB::table('users')->delete();

        $users = array(
            array(
                'email'    => 'test@test.com',
                'password' => Hash::make('abc123'),
            ),
            array(
                'email'    => 'test2@test.com',
                'password' => Hash::make('abc123'),
            ),
        );

        // Uncomment the below to run the seeder
        DB::table('users')->insert($users);
    }

}
