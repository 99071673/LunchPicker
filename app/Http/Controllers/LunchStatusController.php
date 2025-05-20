<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LunchStatusController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'wachten');

        $allowedStatuses = ['wachten', 'locatie-stemmen', 'bestellen'];

        if (!in_array($status, $allowedStatuses)) {
            $status = 'wachten';
        }

        return view('home', ['status' => $status]);
    }
}
