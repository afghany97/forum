<?php 

namespace App\Rules;

use App\spam\spam;

class SpamDetect
{
	
	public function passes($attribute,$value)
	{
		try {

			// check if the value contians any spam "throw exception if contians"

			return ! resolve(spam::class)->detect($value);
		
		} catch (\Exception $e) {
			
			return false;
		}
	}
}


