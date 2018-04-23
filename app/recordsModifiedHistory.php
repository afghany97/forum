<?php
/**
 * Created by PhpStorm.
 * User: Afghany
 * Date: 17/04/2018
 * Time: 01:10 م
 */

namespace App;


use function PHPSTORM_META\type;

trait recordsModifiedHistory
{
    public  static  function bootrecordsModifiedHistory()
    {
        static::updating(function ($model){

            if(request()->path() !== "threads")

                $model->modifyHistory()->create([

                    'user_id' => auth()->id(),

                    'before' => json_encode(array_intersect_key($model->fresh()->toArray(),$model->getDirty())),

                    'after' => json_encode($model->getDirty())
                ]);
        });
    }

    public function modifyHistory()
    {
        return $this->morphMany('App\modifyHistory','modified');
    }

    public function fetchHistory($objectId)
    {
        return modifyHistory::where(['modified_type' => static::class , 'modified_id' => $objectId])->latest()->get();
    }
}