<?php 

namespace App;

trait RecordsActivites
{
	public static function bootRecordsActivites()
	{
		foreach (static::getActivites() as $activity) {
			
			// this part will added automatically into each model in boot function 
			 
			static::$activity(function($model) use ($activity){

				$model->recordActivity($activity);
			});
		}

		static::deleting(function($model)
		{
		    // delete the related activites for deleted model

			$model->activites()->delete();
		});
	}

	public static function getActivites()
	{
		// return the activites 

		return ['created'];
	}

	public function recordActivity($event) // function to store the activity 
    {
        // check if there is not authenticated user

    	if(auth()->guest())

    		return;

    	// store the activity

         $this->activites()->create([

         	'user_id' => auth()->id(),

         	'type' => $this->getActivtyType($event)

         ]);

    }

    public function activites() // create relation with activites table
    {
    	return $this->morphMany('App\Activity','subject');
    }

	public function getActivtyType($event)
    {
		// return this string format event_classname like ['created_thread' , 'deleted_reply'] to save into activites table
    	
    	return $event . '_' . strtolower((new \ReflectionClass($this))->getShortName());
	}
}
