<?php 

namespace App\filters;

use Illuminate\Http\Request;

abstract class Filters 
{
	protected $request , $bulider , $filters = [];

	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	public function apply($bulider)
	{
		$this->bulider = $bulider;

		foreach ($this->filters as $filter) {
			
			if(method_exists($this, $filter) && $this->request->has($filter)){

				$this->$filter($this->request->$filter);
			}
		}
		return $this->bulider;
	}
	
}

 ?>