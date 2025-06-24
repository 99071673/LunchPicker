<?php

namespace App\Http\Controllers;

use App\Models\Lunchgetter;
use App\Models\Order;
use App\Models\DeadlineSetting;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LunchgetterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orders = Order::all();

        return view('lunchgetter', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Lunchgetter $lunchgetter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lunchgetter $lunchgetter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lunchgetter $lunchgetter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lunchgetter $lunchgetter)
    {
        //
    }
}