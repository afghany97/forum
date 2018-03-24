<?php 

namespace App\spam;

class spam 
{
	// spam class's

	protected $filters = [

		inValidKeyWords::class,

		keyHoldDown::class

	];

	public function detect($body)
	{
		// iterate for each spam class

		foreach ($this->filters as $filter ) {


			app($filter) // app method return object of given class in param
			
			->detect($body); // call detect method in each class
		}

		return false;
	}
}