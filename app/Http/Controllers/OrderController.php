<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\LunchItem;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function show($location_id, Request $request)
    {
        $location = Location::findOrFail($location_id);

        $query = LunchItem::where('location_id', $location_id);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('naam', 'LIKE', '%' . $search . '%');
        }

        $lunchItems = $query->get();

        $order = session('order', []);

        return view('order.show', compact('location', 'lunchItems', 'order'));
    }

    public function add(Request $request)
    {
        $item = LunchItem::findOrFail($request->input('item_id'));

        $order = session()->get('order', []);
        
        $bestaat = false;
        foreach ($order as &$orderItem) {
            if ($orderItem['id'] == $item->id) {
                $orderItem['aantal'] = ($orderItem['aantal'] ?? 1) + 1;
                $bestaat = true;
                break;
            }
        }

        if (!$bestaat) {
            $order[] = [
                'id' => $item->id,
                'naam' => $item->naam,
                'prijs' => $item->prijs,
                'aantal' => 1,
            ];
        }

        session()->put('order', $order);

        return back();
    }

    public function remove(Request $request)
    {
        $order = session()->get('order', []);
        $key = $request->input('key');

        if (isset($order[$key])) {
            unset($order[$key]);
            $order = array_values($order);
            session()->put('order', $order);
        }

        return back();
    }

    public function update(Request $request)
    {
        $key = $request->input('key');
        $aantal = (int) $request->input('aantal');

        $order = session()->get('order', []);

        if (isset($order[$key]) && $aantal > 0) {
            $order[$key]['aantal'] = $aantal;
            session()->put('order', $order);
        }

        return back();
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Je moet eerst inloggen om een bestelling te plaatsen.');
        }

        $orderData = session('order', []);

        if (empty($orderData)) {
            return redirect()->back()->with('error', 'Geen bestelling om op te slaan.');
        }

        $locationId = $request->input('location_id');

        Order::create([
            'location_id' => $locationId,
            'user_id' => Auth::id(),
            'items' => json_encode($orderData),
        ]);

        session()->forget('order');

        return redirect('/')->with('success', 'Bestelling succesvol opgeslagen!');
    }
}
