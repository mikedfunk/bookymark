<?php

class BookmarksTableSeeder extends Seeder {

    public function run()
    {
        // Uncomment the below to wipe the table clean before populating
        DB::table('bookmarks')->delete();

        $bookmarks = array(
            array(
                'title'       => 'bookmark1',
                'description' => 'bookmark1',
                'url'         => 'http://www.yahoo.com',
                'user_id'     => 1,
            ),
            array(
                'title'       => 'bookmark2',
                'description' => 'bookmark2',
                'url'         => 'http://www.yahoo.com',
                'user_id'     => 1,
            ),

        );

        // Uncomment the below to run the seeder
        DB::table('bookmarks')->insert($bookmarks);
    }

}
