@extends('layouts.master')

@section('pagetitle')
    @php
        use App\Models\Order;
        $orders = Order::with('user')->get();
        $deadline = Carbon\Carbon::parse(config('lunch.order_deadline'));

        $victim = \DB::table('lunchgetter')->latest('id')->value('name_victim');
        $randomUser = 'Geen slachtoffer';

        if (now()->greaterThan($deadline) && !$victim && $orders->isNotEmpty()) {
            $randomOrder = $orders->random();
            $randomUser = $randomOrder->user->name ?? 'Geen slachtoffer';
            \DB::table('lunchgetter')->insert([
                'name_victim' => $randomUser,
            ]);
            $victim = $randomUser;
        } elseif (!$victim && now()->lessThanOrEqualTo($deadline)) {
            $randomUser = 'Geen slachtoffer, deadline is nog niet voorbij';
        } elseif ($victim) {
            $randomUser = $victim;
        }
    @endphp
    <span class="font-semibold">De slachtoffer om de bestelling op te halen is: </span> {{ $randomUser }}
@endsection

@section('content')
    <div>
        <div class="w-[1700px] p-4 flex flex-col gap-5">

            <h2 class="text-2xl font-bold mb-4 flex justify-center">Alle bestellingen</h2>

            @if(!$orders || $orders->isEmpty())
                {{-- We hoeven hier eigenlijk niets te laten zien --}}
                {{-- <p>Geen bestellingen gevonden</p> --}}
            @else
            <div class="flex justify-evenly flex-wrap gap-5">
                @foreach($orders as $order)
                    <div class="w-[500px] border border-gray-300 p-4 rounded-lg shadow-sm bg-white">
                        <div class="mb-2">
                            <span class="font-semibold">Naam:</span> {{ $order->user && $order->user->name ? $order->user->name : 'Naam onbekend' }}
                        </div>

                        @php
                            $items = isset($order->items) ? json_decode($order->items, true) : [];
                        @endphp

                        <div class="mt-4">
                            <span class="font-semibold">Bestelling #{{ $order->id ?? 'Onbekend' }}</span>
                            @if(!empty($items))
                                @php
                                    $totaalPrijsOrder = 0;
                                @endphp
                                <ul class="ml-4 mt-1 space-y-1">
                                    @foreach($items as $item)
                                        <li class="border-b pb-1">
                                            <div><span class="font-medium">Naam:</span> {{ isset($item['naam']) ? $item['naam'] : 'Naam niet bekend' }}</div>
                                            <div><span class="font-medium">Aantal:</span> {{ isset($item['aantal']) ? $item['aantal'] : 'Aantal niet Onbekend' }}</div>
                                            <div><span class="font-medium">Prijs: €</span> {{ isset($item['prijs']) ? $item['prijs'] : 'Prijs niet Onbekend' }}</div>
                                        </li>
                                        @php
                                            $totaalPrijsOrder += isset($item['prijs']) ? (float)$item['prijs'] : 0;
                                        @endphp
                                    @endforeach
                                </ul>
                                <div><span class="font-medium">Totaal prijs: €</span> {{ $totaalPrijsOrder }}</div>
                            @else
                                <div class="ml-4">N/A</div>
                            @endif
                        </div>
                    </div>
                @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
