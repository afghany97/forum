<?php 

namespace App\spam;

class spam 
{
	protected $filters = [

		inValidKeyWords::class,

		keyHoldDown::class

	];

	public function detect($body)
	{
		foreach ($this->filters as $filter ) {
		
			app($filter)->detect($body);
		}

		return false;
	}
}