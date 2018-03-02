<?php 

namespace App\spam;

use Exception;

class keyHoldDown
{
	
	public function detect($body)
	{
		if(preg_match('/(.)\\1{5,}/', $body)){

			throw new Exception("spam detected , key hold down ....");
		}
	}
} 