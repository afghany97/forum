<?php

namespace App\filters;


use App\User;
use Carbon\Carbon;

class ThreadsFilters extends Filters
{
    // accepted filters

    protected $filters = ['by', 'populair', 'unanswered', 'archive'];


    protected function by($username)
    {
        // fetch the user that have the name passing for the function

        $user = User::where('name', $username)->firstOrFail();

        // return the query after add filter on it

        return $this->bulider->where('user_id', $user->id);
    }

    protected function populair($populair)
    {
        if ($populair) {
            // remove the orders for the incoming query

            $this->bulider->getQuery()->orders = [];

            // return the query after add filter on it

            return $this->bulider->orderBy('replies_count', 'desc');
        }

    }

    protected function unanswered($unanswered)
    {
        if ($unanswered) {
            // return the query after add filter on it

            return $this->bulider->where('replies_count', 0);
        }
    }

    protected function archive(array $data)
    {
        if ($data['archive'])

            return $this->bulider

                ->whereMonth('created_at', Carbon::parse($data['month'])->month)

                ->whereYear('created_at', $data['year']);
    }
}