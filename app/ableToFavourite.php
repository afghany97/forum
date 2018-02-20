<?php 

namespace App;

trait ableToFavourite{


  protected static function bootableToFavourite()
  {
      static::deleting(function($model){

        $model->favourites->each->delete();
        
      });

  }

  public function favourites()
  {
    return $this->morphMany(Favourite::class , 'favorited');
  }

  public function favourite()
  {
    // check if this user didn't favourite this reply

    if(! $this->favourites()->where('user_id' , auth()->id())->exists())
      
      $this->favourites()->create(['user_id' => auth()->id()]);
  }

  public function isFavourited()
  {
    return !! $this->favourites->where('user_id' , auth()->id())->count();
  }
}