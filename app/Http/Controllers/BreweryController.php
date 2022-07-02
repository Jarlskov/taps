<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBreweryRequest;
use App\Http\Requests\UpdateBreweryRequest;
use App\Models\Brewery;

class BreweryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Void
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Void
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBreweryRequest  $request
     */
    public function store(StoreBreweryRequest $request): Void
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brewery  $brewery
     */
    public function show(Brewery $brewery): Void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brewery  $brewery
     */
    public function edit(Brewery $brewery): Void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBreweryRequest  $request
     * @param  \App\Models\Brewery  $brewery
     */
    public function update(UpdateBreweryRequest $request, Brewery $brewery): Void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brewery  $brewery
     */
    public function destroy(Brewery $brewery): Void
    {
        //
    }
}
