<?php

namespace Fuel\Tasks;

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
			$model = new \Ethanol\Model_Log_In_Attempt;
			$model->status = $probs[rand(0,count($probs)-1)];
			$model->email = 'test';
			$model->save();
			$model->time = $time;
			$model->save();
			
			echo "Creating: $i/$total\n";
			$time -= rand(500, 2000);
		}
	}
}
