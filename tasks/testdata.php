<?php

namespace Fuel\Tasks;

/**
 * Generates random log in logs for testing
 * 
 * @author Steve "uru" West <uruwolf@gmail.com>
 * @license http://philsturgeon.co.uk/code/dbad-license DbaD
 */
class TestData
{
	public function run()
	{
		\Ethanol\Model_Log_In_Attempt::query()
			->delete();
		
		$probs = array(
			'0',
			'1','1','1','1','1','1','1',
			'2','2','2','2','2','2','2',
		);
		
		//generate random log in entries.
		$time = time();
		$total = rand(25,50);
		for($i=0; $i<=$total; $i++)
		{
			$status = $probs[rand(0,count($probs)-1)];
			$model = new \Ethanol\Model_Log_In_Attempt;
			$model->status = $status;
			$model->email = 'test@test.com';
			$model->save();
			$model->time = $time;
			$model->save();
			
			echo "Creating:$status $i/$total\n";
			$time -= rand(500, 2000);
		}
	}
}
