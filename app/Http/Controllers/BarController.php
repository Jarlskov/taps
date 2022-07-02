<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreBarRequest;
use App\Http\Requests\UpdateBarRequest;
use App\Models\Bar;

class BarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Bar::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): Void
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBarRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBarRequest $request): Void
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bar  $bar
     * @return \Illuminate\Http\Response
     */
    public function show(Bar $bar)
    {
        return $bar->load('taps')
                   ->load(['taps.beer' => function ($query) {
                       $query->where('on_to', null);
                   }])
                   ->load(['taps.beer.beer']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bar  $bar
     * @return \Illuminate\Http\Response
     */
    public function edit(Bar $bar): Void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBarRequest  $request
     * @param  \App\Models\Bar  $bar
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBarRequest $request, Bar $bar): Void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bar  $bar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bar $bar): Void
    {
        //
    }
}
