@extends('layouts.master')

@section('title', 'Lunchgetter')

@section('pagetitle')
    Lunchgetter
@endsection

@section('content')
    <div>
        <div class="w-[1700px] p-4 flex flex-col gap-5">

            <h2 class="text-2xl font-bold mb-4 flex justify-center">All Orders</h2>

            @if($orders->isEmpty())
                <p>No orders found.</p>
            @else
            <div class="flex justify-evenly flex-wrap gap-5">
                @foreach($orders as $order)
                    <div class="w-[500px] border border-gray-300 p-4 rounded-lg shadow-sm bg-white">
                        <div class="mb-2">
                            <span class="font-semibold">Naam:</span> {{ $order->user->name ?? 'Unknown' }}
                        </div>

                        @php
                            $items = json_decode($order->items, true);
                        @endphp

                        <div class="mt-4">
                            <span class="font-semibold">Items:</span>
                            @if(!empty($items))
                                <ul class="ml-4 mt-1 space-y-1">
                                    @foreach($items as $item)
                                        <li class="border-b pb-1">
                                            <div><span class="font-medium">Name:</span> {{ $item['naam'] ?? '—' }}</div>
                                            <div><span class="font-medium">Quantity:</span> {{ $item['aantal'] ?? '—' }}</div>
                                        </li>
                                    @endforeach
                                </ul>
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
