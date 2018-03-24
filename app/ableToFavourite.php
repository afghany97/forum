<?php 

namespace App;

trait ableToFavourite{


  protected static function bootableToFavourite()
  {
      // this part will added automatically into each model in boot function 

      static::deleting(function($model){

        $model->favourites->each->delete();
        
      });

  }

  public function favourites() // create relation with favourites table
  {
    return $this->morphMany(Favourite::class , 'favorited');
  }

  public function favourite()
  {
    // check if this user didn't favourite this reply

    if(! $this->favourites()->where('user_id' , auth()->id())->exists())
      
      $this->favourites()->create(['user_id' => auth()->id()]);
  }

  public function isFavourited() // check if the authenticated user favourite this object
  {
    return !! $this->favourites->where('user_id' , auth()->id())->count();
  }
}