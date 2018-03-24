<?php 

namespace App\filters;


use App\User;

class ThreadsFilters extends Filters
{
	// accepted filters

	protected $filters = ['by' , 'populair' , 'unanswered'];

	
	protected function by($username)
	{
		// fetch the user that have the name passing for the function	

		$user = User::where('name' , $username)->firstOrFail();

		// return the query after add filter on it
		
		return $this->bulider->where('user_id' , $user->id);
	}

	protected function populair($populair)
	{
		if($populair)
		{
			// remove the orders for the incoming query
	
			$this->bulider->getQuery()->orders = [];
	
			// return the query after add filter on it
			
			return $this->bulider->orderBy('replies_count' , 'desc');
		}
		
	}

	protected function unanswered($unanswered)
	{
		if($unanswered) 
		{
			// return the query after add filter on it
			
			return $this->bulider->where('replies_count' , 0);
		}
	}
}