<?php 

namespace App\filters;


use App\User;

class ThreadsFilters extends Filters
{
	protected $filters = ['by' , 'for'];
	
	protected function by($username)
	{
		
		$user = User::where('name' , $username)->firstOrFail();
		
		return $this->bulider->where('user_id' , $user->id);
	}

	public function foor($username)
	{
		$user = User::where('name' , $username)->firstOrFail();
		
		return $this->bulider->where('user_id' , $user->id);
		
	}
}
 ?>