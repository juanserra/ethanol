<?php
namespace Fuel\Migrations;

class Create_ethanol_tables {

	public function up() {
		/* Bans Table */
		echo('Creating table users');
		\DBUtil::create_table('bans',array(
			'id'         => array(
				'type'           => 'int',
				'constraint'     => 11,
				'null'           => 0,
				'auto_increment' => true
			),
			'email'      => array(
				'type'       => 'varchar',
				'constraint' => 100,
				'default'    => null
			),
			'ip'         => array(
				'type'       => 'varchar',
				'constraint' => 100,
				'default'    => null
			),
			'created_at' => array(
				'type'       => 'int',
				'constraint' => 11,
				'null'       => false
			),
			'expires'    => array(
				'type'       => 'int',
				'constraint' => 11,
				'null'       => false
			)
		),array('id'));
		/* groups_users table */
		echo('Creating tables groups_users');
		\DBUtil::create_table('groups_users',array(
			'user_id'  => array(
				'type'       => 'int',
				'constraint' => 11
			),
			'group_id' => array(
				'type'       => 'int',
				'constraint' => 11
			)
		),array('user_id','group_id'));
		/* groups_permissions table */
		echo('Creating tables group_permissions');
		\DBUtil::create_table('group_permissions',array(
 			'id'         => array(
				'type'       => 'int',
				'constraint' => 11,
				'auto_increment' => true
			),
			'identifier' => array(
				'type'       => 'varchar',
				'constraint' => 100,
				'null'       => false
                        ),
			'group_id' => array(
				'type'       => 'int',
				'constraint' => 11,
				'null'       => false
			)
		),array('id'));
		/* log_in_attempt table */
		\DBUtil::create_table('log_in_attempt',array(
	 		'id'         => array(
				'type'       => 'int',
				'constraint' => 11,
				'auto_increment' => true
			),
			'status'  => array(
				'type'       => 'int',
				'constraint' => 11,
				'null'       => false
			),
			'email'   => array(
				'type' => 'varchar',
				'constraint' => 100,
				'null' => false
			),
			'ip' => array(
				'type' => 'varchar',
				'constraint' => 100,
				'null' => false
			),
			'time' => array(
				'type' => 'int',
				'constraint' => 11,
				'null' => false
			)
		),array('id'));
		/* users table */
		echo('Creating table users');
		\DBUtil::create_table('users',array(
			'id' => array(
				'type' => 'int',
				'constraint' => 11,
				'auto_increment' => true
			),
			'email' => array(
				'type' => 'varchar',
				'constraint' => 100,
				'null' => false
			),
			'activated' => array(
				'type' => 'int',
				'constraint' => 11,
				'null' => false,
				'default' => '0'
			),
			'created_at' => array(
				'type' => 'int',
				'constraint' => 11,
				'null' => false,
				'default' => '0'
			),
			'updated_at' => array(
				'type' => 'int',
				'constraint' => 11,
				'null' => false,
				'default' => '0'
			)
		),array('id'));
		/*user_groups table */
		echo('Creating user_groups table');
		\DBUtil::create_table('user_groups',array(
			'id' => array(
				'type' => 'int',
				'constraint' => 11,
				'auto_increment' => true
			),
			'name' => array(
				'type' => 'varchar',
				'constraint' => 100,
				'null' => false
			)
		),array('id'));
		/* user_metadata table */
		echo('Creating user_metadata table');
		\DBUtil::create_table('user_metadata',array(
			'id' => array(
				'type' => 'int',
				'constraint' => 11,
				'auto_increment' => true
			),
			'user_id' => array(
				'type' => 'int',
				'constraint' => 11,
				'null' => false
			)
		),array('id'));
		/* user_security table */
		echo('Creating user_security table');
		\DBUtil::create_table('user_security',array(
			'id' => array(
				'type' => 'int',
				'constraint' => 11,
				'auto_increment' => true
			),
			'user_id' => array(
				'type' => 'int',
				'constraint' => 11,
				'null' => false
			),
			'password' => array(
				'type' => 'varchar',
				'constraint' => 100,
				'null' => false
			),
			'salt' => array(
				'type' => 'varchar',
				'constraint' => 100,
				'null' => false
			),
			'activation_hash' => array(
				'type' => 'varchar',
				'constraint' => 100,
				'null' => false
			)
		),array('id'));

		/* Sample user */
		echo('Creating basic user assignments.');
		$query = \DB::insert('groups_users')->set(array(
			'user_id'  => 1,
			'group_id' => 2
			));
		$query->execute();
		$query2 = \DB::insert('group_permissions')->set(array(
			'identifier'  => 'admin',
			'group_id' => 2
			));
		$query2->execute();
		$query3 = \DB::insert('users')->set(array(
			'id'  => 1,
			'email' => 'admin@test.com',
			'activated' => 1,
			'created_at' => 1353420651,
			'updated_at' => 1353420651
			));
		$query3->execute();
		$q_data = array(
			array(3, 'registered'),
			array(2, 'admin'),
			array(1, 'guest')
		);
		$query5 = \DB::insert('user_groups');
		$query5->columns(array('id','name'));
		foreach($q_data as $data) {
			$query5->values($data);
		}
		$query5->execute();
		$query6 = \DB::insert('user_metadata');
		$query6->columns(array('id','user_id'));
		$query6->values(array(1,1));
		$query6->execute();
		$query7 = \DB::insert('user_security');
		$query7->columns(array(`id`, `user_id`, `password`, `salt`, `activation_hash`));
		$query7->values(array(1, 1, 'bfbc948b4e0fb6f1a353d5b4d4d7132cde9153eb', 'ed61a660a0eaf7b070999967058085b818dadcd3', ''));
		$query7->execute();
	}

	public function down() 
	{
		$tables = array(
			'bans',
			'user_metadata',
			'user_security',
			'user_groups',
			'users',
			'group_permissions',
			'groups_users'
		);
		foreach($tables as $table) {
			\DBUtil::drop_table($table);
		}
	}
}
