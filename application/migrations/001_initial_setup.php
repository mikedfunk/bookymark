<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * initial migration
 *
 * @author Mike Funk
 * @email mfunk@christianpublishing.com
 *
 * @file 001_initial_setup.php
 */

/**
 * Migration_initial_setup class.
 *
 * @extends MY_Migration
 */
class Migration_initial_setup extends MY_Migration
{
	// --------------------------------------------------------------------------

	/**
	 * up function.
	 *
	 * @access public
	 * @return void
	 */
	public function up()
	{
		// --------------------------------------------------------------------------
		// api_clients

		$this->dbforge->add_key('id', true);
		$fields = array(
			'access_token' => array(
				'type' => 'varchar',
				'constraint' => 40,
				'null' => true
			),
			'shared_secret' => array(
				'type' => 'varchar',
				'constraint' => 40,
				'null' => true
			),
			'throttle_count' => array(
				'type' => 'int',
				'constraint' => 11,
				'null' => true
			),
			'throttled_at' => array(
				'type' => 'datetime',
				'null' => true
			)
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->create_table('api_clients');

		// insert data
		$data = array(
			array(
				'access_token' => '4395dd07a3cfe84d9655bb2542907f3acd0024fe',
				'shared_secret' => '3c697e1314808f56bd44bc5ccb4765607b433715',
				'throttle_count' => 6,
				'throttled_at' => '2012-10-07 21:46:08'
			)
		);
		$this->db->insert_batch('api_clients', $data);


		// --------------------------------------------------------------------------
		// users

		$this->dbforge->add_key('id', true);
		$fields = array(
			'email_address' => array(
				'type' => 'varchar',
				'constraint' => 300,
				'null' => true
			),
			'password' => array(
				'type' => 'varchar',
				'constraint' => 300,
				'null' => true
			),
			'role_id' => array(
				'type' => 'int',
				'constraint' => 11,
				'null' => true
			),
			'confirm_string' => array(
				'type' => 'int',
				'constraint' => 100,
				'null' => true
			),
			'status' => array(
				'type' => 'int',
				'constraint' => 50,
				'null' => true
			),
			'created_at' => array(
				'type' => 'datetime',
				'null' => true
			),
			'updated_at' => array(
				'type' => 'datetime',
				'null' => true
			)
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->create_table('users');

		// insert data
		$data = array(
			array(
				'email_address' => 'test123@test.com',
				'password' => 'QLbtpr5L043DLnopIt7HfCFgUbH0Ldi5Gs9znlte7JtctOVMWJLXykzMpDH7ngQu6b5c893bf7bd92376f6603f953a0013717f373b7b799adef945d5ba2953e6052',
				'role_id' => '1',
				'confirm_string' => 'EP15VDxdCwluNNa8WnnZ'
			),
			array(
				'email_address' => 'test1234@test.com',
				'password' => 'QLbtpr5L043DLnopIt7HfCFgUbH0Ldi5Gs9znlte7JtctOVMWJLXykzMpDH7ngQu6b5c893bf7bd92376f6603f953a0013717f373b7b799adef945d5ba2953e6052',
				'role_id' => '1',
				'confirm_string' => 'EP15VDxdCwluNNa8WnnZ'
			)
		);
		$this->db->insert_batch('users', $data);

		// --------------------------------------------------------------------------
		// roles

		$this->dbforge->add_key('id', true);
		$fields = array(
			'title' => array(
				'type' => 'varchar',
				'constraint' => 50,
				'null' => true
			),
			'home_page' => array(
				'type' => 'varchar',
				'constraint' => 100,
				'null' => true
			),
			'can_list_bookmarks' => array(
				'type' => 'tinyint',
				'constraint' => 1,
				'default' => 0
			),
			'can_view_bookmarks' => array(
				'type' => 'tinyint',
				'constraint' => 1,
				'default' => 0
			),
			'can_edit_bookmarks' => array(
				'type' => 'tinyint',
				'constraint' => 1,
				'default' => 0
			),
			'can_add_bookmarks' => array(
				'type' => 'tinyint',
				'constraint' => 1,
				'default' => 0
			),
			'can_delete_bookmarks' => array(
				'type' => 'tinyint',
				'constraint' => 1,
				'default' => 0
			),
			'can_migrate' => array(
				'type' => 'tinyint',
				'constraint' => 1,
				'default' => 0
			),
			'created_at' => array(
				'type' => 'datetime',
				'null' => true
			),
			'updated_at' => array(
				'type' => 'datetime',
				'null' => true
			)
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->create_table('roles');

		// insert data
		$data = array(
			array(
				'title' => 'Superuser',
				'home_page' => 'bookmarks',
				'can_list_bookmarks' => '1',
				'cab_view_bookmarks' => '1',
				'can_list_bookmarks' => '1',
				'can_edit_bookmarks' => '1',
				'can_add_bookmarks' => '1',
				'can_delete_bookmarks' => '1',
				'can_migrate_bookmarks' => '1'
			),
			array(
				'title' => 'User',
				'home_page' => 'bookmarks',
				'can_list_bookmarks' => '1',
				'cab_view_bookmarks' => '1',
				'can_list_bookmarks' => '1',
				'can_edit_bookmarks' => '1',
				'can_add_bookmarks' => '1',
				'can_delete_bookmarks' => '1',
				'can_migrate_bookmarks' => '0'
			)
		);
		$this->db->insert_batch('roles', $data);

		// --------------------------------------------------------------------------
		// bookmarks

		$this->dbforge->add_key('id', true);
		$fields = array(
			'url' => array(
				'type' => 'varchar',
				'constraint' => 300,
				'null' => true
			),
			'description' => array(
				'type' => 'varchar',
				'constraint' => 1000,
				'null' => true
			),
			'user_id' => array(
				'type' => 'int',
				'constraint' => 5,
				'null' => true
			),
			'created_at' => array(
				'type' => 'datetime',
				'null' => true
			),
			'updated_at' => array(
				'type' => 'datetime',
				'null' => true
			)
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->create_table('bookmarks');

		// insert data
		$data = array(
			array(
				'url' => 'http://yahoo.com',
				'description' => 'dummy description',
				'user_id' => '1'
			),
			array(
				'url' => 'http://google.com',
				'description' => 'dummy google description',
				'user_id' => '2'
			)
		);
		$this->db->insert_batch('bookmarks', $data);
	}

	// --------------------------------------------------------------------------

	/**
	 * down function.
	 *
	 * @access public
	 * @return void
	 */
	public function down()
	{
		$this->dbforge->drop_table('api_clients');
		$this->dbforge->drop_table('bookmarks');
		$this->dbforge->drop_table('roles');
		$this->dbforge->drop_table('users');
	}

	// --------------------------------------------------------------------------
}
/* End of file 001_initial_setup.php */
/* Location: ./applicatin/migrations/001_initial_setup.php */