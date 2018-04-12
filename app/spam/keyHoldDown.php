<?php 

namespace App\spam;

use Exception;

class keyHoldDown
{
	
	public function detect($body)
	{
	    // check if any char repeated more than 4 times in body of given string

		if(preg_match('/(.)\\1{5,}/', $body)){

		    // throw exception

			throw new Exception("spam detected , key hold down ....");
		}
	}
} 