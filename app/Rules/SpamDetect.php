<?php 

namespace App\Rules;

use App\spam\spam;

class SpamDetect
{
	
	public function passes($attribute,$value)
	{
		try {
		
			return ! resolve(spam::class)->detect($value);
		
		} catch (\Exception $e) {
			
			return false;
		}
	}
}


