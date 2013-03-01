<?php
namespace Fuel\Migrations;

class Create_oauth_table
{

	public function up()
	{
		echo('Creating table oauth');
		\DBUtil::create_table('user_oauth',array(
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
			'driver'         => array(
				'type'       => 'varchar',
				'constraint' => 100,
				'default'    => null
			),
			'user_id' => array(
				'type'       => 'int',
				'constraint' => 11,
				'null'       => false
			),
		),array('id'));
	}
	
	public function down()
	{
		echo('Dropping table oauth');
		\DBUtil::drop_table('user_oauth');
	}
	
}
