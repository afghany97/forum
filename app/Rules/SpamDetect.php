<?php 

namespace App\Rules;

use App\spam\spam;

class SpamDetect
{
	
	public function passes($attribute,$value)
	{
		try {

			// check if the value contains any spam "throw exception if contains"

			return ! resolve(spam::class)->detect($value);
		
		} catch (\Exception $e) {
			
			return false;
		}
	}
}


