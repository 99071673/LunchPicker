@extends('layouts.master')

@php use Illuminate\Support\Str; @endphp

@section('pagetitle')
    Home
@endsection

@section('content')

    @if (session('error'))
        <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div>
        <div class="w-[1700px] p-4 flex flex-col gap-5">

            <div class="grid grid-cols-[1fr_2fr_1fr] gap-7">
                <div class="bg-white border rounded-lg rounded shadow p-4 h-[650px] w-full">
                    <div class="grid grid-rows-8 h-full">

                        <div class="row-span-1 border-b-4 border-black">
                            <p class="text-4xl font-bold flex justify-center">Huidige bestelling</p>
                        </div>

                        <div class="row-span-6 overflow-y-auto">
                            @if($order && $order->items)
                                @php
                                    $items = json_decode($order->items, true);
                                    $totaal = 0;
                                @endphp

                                @foreach($items as $item)
                                    @php
                                        $itemTotaal = $item['prijs'] * $item['aantal'];
                                        $totaal += $itemTotaal;
                                    @endphp
                                    <div class="bg-gray-300 rounded-lg shadow p-2 flex items-center justify-between mb-2 mt-2">
                                        <span class="text-2xl font-semibold">{{ $item['aantal'] }}<span
                                                class="text-sm align-bottom">x</span></span>
                                        <span class="text-2xl font-semibold ml-2">{{ $item['naam'] }}</span>
                                        <span class="text-2xl font-semibold ml-auto">€
                                            {{ number_format($itemTotaal, 2, ',', '.') }},-</span>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-center text-gray-600 mt-10">Geen huidige bestelling</p>
                            @endif
                        </div>

                        <div class="row-span-1 border-t-4 border-black flex items-center ">

                            <div class="w-25 flex-1 ">
                                <p class="text-2xl font-semibold">
                                    Totaal: € {{ isset($totaal) ? number_format($totaal, 2, ',', '.') : '0,00' }},-
                                </p>
                            </div>
                            <div class="w-50 flex-none">
                                @if($order && $order->items)
                                    <a href="{{ route('bestelling', ['location_id' => $location_id]) }}"
                                        class="bg-teal-900 text-white text-1xl font-bold py-2 px-5 rounded-lg shadow hover:bg-teal-800">
                                        Pas Bestelling aan
                                    </a>
                                @else
                                    <button
                                        class="bg-teal-900 text-white text-1xl font-bold py-2 px-5 rounded-lg shadow opacity-50 cursor-not-allowed" disabled>
                                        Pas Bestelling aan
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white border rounded-lg shadow p-4 h-[650px] w-full">
                    <div class="grid grid-rows-3 h-full">
                        <div class="border-b-4 border-black row-span-1">
                            @if($status === 'wachten')
                                <x-countdown-timer class="text-7xl font-bold flex justify-center" :deadline="$locatiestart"
                                    id="home-timer" />
                            @elseif($status === 'locatie-stemmen')
                                <x-countdown-timer class="text-7xl font-bold flex justify-center" :deadline="$locatiedeadline"
                                    id="home-timer" />
                            @elseif($status === 'bestellen')
                                <x-countdown-timer class="text-7xl font-bold flex justify-center" :deadline="$orderdeadline"
                                    id="home-timer" />
                            @else
                                <x-countdown-timer class="text-7xl font-bold flex justify-center" :deadline="$locatiestart"
                                                   id="home-timer" />
                            @endif

                            @if($status === 'wachten')
                                <p class="text-5xl font-bold flex justify-center">Resterende tot volgende lunch</p>
                            @elseif($status === 'locatie-stemmen')
                                <p class="text-5xl font-bold flex justify-center">Resterende om te stemmen</p>
                            @elseif($status === 'bestellen')
                                <p class="text-5xl font-bold flex justify-center">Resterende om te bestellen</p>
                            @else
                                    <p class="text-5xl font-bold flex justify-center">Resterende tot volgende lunch</p>
                                @endif
                        </div>

                        <div class="row-span-2 pt-4 flex-col flex items-center">
                            @if($status === 'wachten')
                                <p class="text-5xl font-bold">Nog even geduld...</p>
                            @elseif($status === 'locatie-stemmen')
                                <p class="text-5xl font-bold">Er wordt nu gestemd voor locatie:</p>
                            @elseif($status === 'bestellen')

                                <p class="text-5xl font-bold">Er wordt nu besteld bij: {{ $winning_location_name ?? 'Onbekend' }}</p>
                            @else
                                <p class="text-5xl font-bold">Nog even geduld...</p>
                            @endif

                            <div class="mt-4">
                                @if($status === 'wachten')
                                    <img src="{{ asset('images/wait-lunch.png') }}" alt="Wachten"
                                        class="w-auto h-[15rem] object-contain" />
                                @elseif($status === 'locatie-stemmen')
                                    <img src="{{ asset('images/unknownlocation.png') }}" alt="Stem voor locatie"
                                        class="w-auto h-[15rem] object-contain" />
                                @elseif($status === 'bestellen')
                                    @if(isset($winning_location_name))
                                        <img src="{{ asset('images/' . Str::slug($winning_location_name) . '.png') }}"
                                             alt="{{ $winning_location_name }}"
                                             class="w-auto h-[15rem] object-contain" />
                                    @else
                                        <img src="{{ asset('images/unknownlocation.png') }}" alt="Bestellen"
                                             class="w-auto h-[15rem] object-contain" />
                                    @endif
                                @else
                                    <img src="{{ asset('images/wait-lunch.png') }}" alt="Wachten"
                                         class="w-auto h-[15rem] object-contain" />
                                @endif
                            </div>

                        </div>

                        <div class="border-t-4 border-black flex row-span-1">

                            <div class="w-25 flex-1 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="size-16">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>

                                <p class="text-5xl font-semibold"> @livewire('vote-counter') </p>

                            </div>

                            <div class="w-32 flex-1 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="size-16">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>

                                <p class="text-5xl font-semibold">3</p>

                            </div>

                            <div class="w-80 flex-none flex items-center justify-center pt-4 pb-4">
                                @if($status === 'locatie-stemmen')
                                    <a href="{{ route('locations.index') }}"
                                        class="bg-teal-900 text-white text-2xl font-bold py-4 px-12 rounded-lg shadow hover:bg-teal-800">
                                        Stem nu
                                    </a>
                                @elseif($status === 'bestellen')
                                    <a href="{{ route('bestelling', $winning_location_id ?? 1) }}"
                                       class="bg-teal-900 text-white text-2xl font-bold py-4 px-12 rounded-lg shadow hover:bg-teal-800">
                                        Bestel nu
                                    </a>

                                @elseif($status === 'wachten')
                                    <a href="#"
                                        class="bg-gray-500 text-white text-2xl font-bold py-4 px-12 rounded-lg shadow cursor-not-allowed opacity-50"
                                        onclick="return false;">
                                        Nog niet beschikbaar
                                    </a>
                                @else
                                    <a href="#"
                                       class="bg-gray-500 text-white text-2xl font-bold py-4 px-12 rounded-lg shadow cursor-not-allowed opacity-50"
                                       onclick="return false;">
                                        Nog niet beschikbaar
                                    </a>
                                @endif
                            </div>

                        </div>

                    </div>

                </div>
                <div class="bg-white border rounded-lg rounded shadow p-4 h-[650px] w-full">
                    <div class="grid grid-rows-8 h-full">

                        <div class="row-span-1 border-b-4 border-black">
                            <p class="text-4xl font-bold flex justify-center">Schulden</p>
                        </div>

                        <div class="row-span-7">
                            <div class="flex justify-between items-center bg-gray-300 rounded-lg shadow-md p-2 mb-2 mt-2">
                                <p class="text-2xl font-semibold text-gray-800">Milan Sebes</p>
                                <div class="flex bg-cyan-900 rounded shadow-md text-sm text-center p-1 space-x-2">
                                    <div class="text-white">
                                        <p class="font-bold">Te ontvangen</p>
                                        <p class="text-green-500 font-semibold">€ 55.40,-</p>
                                    </div>
                                    <div class="text-white">
                                        <p class="font-bold">Te betalen</p>
                                        <p class="text-red-500 font-semibold">€ 20.50,-</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
