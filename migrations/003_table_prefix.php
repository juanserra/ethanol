<?php
namespace Fuel\Migrations;

class Table_prefix
{
	public function up()
	{
		$tables = array(
			'bans',
			'groups_users',
			'group_permissions',
			'log_in_attempt',
			'users',
			'user_groups',
			'user_metadata',
			'user_oauth',
			'user_security',
		);
		
		foreach($tables as $table)
		{
			\DBUtil::rename_table($table, 'ethanol_'.$table);
		}
	}
	
	public function down()
	{
		$tables = array(
			'bans',
			'groups_users',
			'group_permissions',
			'log_in_attempt',
			'users',
			'user_groups',
			'user_metadata',
			'user_oauth',
			'user_security',
		);
		
		foreach($tables as $table)
		{
			\DBUtil::rename_table('ethanol_'.$table, $table);
		}
	}
}
