<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\LunchItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function show($location_id)
    {
        $location = Location::findOrFail($location_id);
        $lunchItems = LunchItem::where('location_id', $location_id)->get();

        return view('order.show', compact('location', 'lunchItems'));
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
}
