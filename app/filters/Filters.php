<?php

namespace App\filters;

use Illuminate\Http\Request;

abstract class Filters
{
    protected $request, $bulider, $filters = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($bulider)
    {
        // initialize the query

        $this->bulider = $bulider;

        // iterate for each filter in filters array

        foreach ($this->filters as $filter) {

            // check if this filter have method and this filter coming in the request data

            if (method_exists($this, $filter) && $this->request->has($filter)) {

                // call the filter method and pass for it this filter value coming from request data

                $this->$filter($this->prepaerParams($filter));

            }
        }

        // return the query

        return $this->bulider;
    }

    private function prepaerParams($filter)
    {
        return $filter === 'archive' ? $prams = ['archive' => $this->request->$filter, 'year' => $this->request->year, 'month' => $this->request->month] : $prams = $this->request->$filter;

    }

}