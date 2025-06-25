@extends('layouts.master')

@php use Illuminate\Support\Str; @endphp

@section('pagetitle')
    Home
@endsection

@section('content')

    <div class="w-full max-w-screen-2xl mx-auto p-4 flex flex-col gap-5">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-7">
            {{-- Huidige Bestelling --}}
            <div class="bg-white border rounded-lg shadow p-4 h-auto lg:h-[650px] overflow-auto w-full">
                <div class="flex flex-col h-full">
                    <div class="border-b-4 border-black pb-2">
                        <p class="text-2xl md:text-4xl font-bold text-center">Huidige bestelling</p>
                    </div>

                    <div class="flex-1 overflow-y-auto mt-4">
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
                                <div class="bg-gray-300 rounded-lg shadow p-2 flex items-center justify-between mb-2">
                                    <span class="text-lg md:text-2xl font-semibold">{{ $item['aantal'] }}<span class="text-sm align-bottom">x</span></span>
                                    <span class="text-lg md:text-2xl font-semibold ml-2">{{ $item['naam'] }}</span>
                                    <span class="text-lg md:text-2xl font-semibold ml-auto">€
                                        {{ number_format($itemTotaal, 2, ',', '.') }},-</span>
                                </div>
                            @endforeach
                        @else
                            <p class="text-center text-gray-600 mt-10">Geen huidige bestelling</p>
                        @endif
                    </div>

                    <div class="border-t-4 border-black pt-4 flex items-center flex-wrap justify-between gap-4">
                        <p class="text-xl md:text-2xl font-semibold">
                            Totaal: € {{ isset($totaal) ? number_format($totaal, 2, ',', '.') : '0,00' }},-
                        </p>
                        @if($order && $order->items)
                            <a href="{{ route('bestelling', ['location_id' => $location_id]) }}"
                               class="bg-teal-900 text-white text-sm md:text-lg font-bold py-2 px-4 rounded-lg shadow hover:bg-teal-800">
                                Pas Bestelling aan
                            </a>
                        @else
                            <button
                                class="bg-teal-900 text-white text-sm md:text-lg font-bold py-2 px-4 rounded-lg shadow opacity-50 cursor-not-allowed"
                                disabled>Pas Bestelling aan</button>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Timer & Status --}}
            <div class="bg-white border rounded-lg shadow p-4 h-auto lg:h-[650px] flex flex-col justify-between">
                <div class="border-b-4 border-black pb-2">
                    @if($status === 'wachten')
                        <x-countdown-timer class="text-5xl md:text-7xl font-bold text-center" :deadline="$locatiestart" id="home-timer" />
                        <p class="text-3xl md:text-5xl font-bold text-center">Resterende tot volgende lunch</p>
                    @elseif($status === 'locatie-stemmen')
                        <x-countdown-timer class="text-5xl md:text-7xl font-bold text-center" :deadline="$locatiedeadline" id="home-timer" />
                        <p class="text-3xl md:text-5xl font-bold text-center">Resterende om te stemmen</p>
                    @elseif($status === 'bestellen')
                        <x-countdown-timer class="text-5xl md:text-7xl font-bold text-center" :deadline="$orderdeadline" id="home-timer" />
                        <p class="text-3xl md:text-5xl font-bold text-center">Resterende om te bestellen</p>
                    @else
                        <x-countdown-timer class="text-5xl md:text-7xl font-bold text-center" :deadline="$locatiestart" id="home-timer" />
                        <p class="text-3xl md:text-5xl font-bold text-center">Resterende tot volgende lunch</p>
                    @endif
                </div>

                <div class="text-center mt-4">
                    @if($status === 'wachten')
                        <p class="text-2xl md:text-4xl font-bold">Nog even geduld...</p>
                        <img src="{{ asset('images/wait-lunch.png') }}" alt="Wachten" class="mx-auto h-48 object-contain" />
                    @elseif($status === 'locatie-stemmen')
                        <p class="text-2xl md:text-4xl font-bold">Er wordt nu gestemd voor locatie:</p>
                        <img src="{{ asset('images/unknownlocation.png') }}" alt="Stem voor locatie" class="mx-auto h-48 object-contain" />
                    @elseif($status === 'bestellen')
                        <p class="text-2xl md:text-4xl font-bold">Er wordt nu besteld bij: {{ $winning_location_name ?? 'Onbekend' }}</p>
                        <img src="{{ asset('images/' . Str::slug($winning_location_name ?? 'unknownlocation') . '.png') }}"
                             alt="{{ $winning_location_name ?? 'Onbekend' }}"
                             class="mx-auto h-48 object-contain" />
                    @else
                        <p class="text-2xl md:text-4xl font-bold">Nog even geduld...</p>
                        <img src="{{ asset('images/wait-lunch.png') }}" alt="Wachten" class="mx-auto h-48 object-contain" />
                    @endif
                </div>

                <div class="border-t-4 border-black pt-4 flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-10 h-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                        </svg>
                        <p class="text-xl md:text-3xl font-semibold">@livewire('vote-counter')</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <svg class="w-10 h-10" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
                        </svg>
                        <p class="text-xl md:text-3xl font-semibold">@livewire('order-counter')</p>
                    </div>

                    <div>
                        @if($status === 'locatie-stemmen')
                            <a href="{{ route('locations.index') }}"
                               class="bg-teal-900 text-white text-lg md:text-2xl font-bold py-2 px-6 rounded-lg shadow hover:bg-teal-800 whitespace-nowrap">
                                Stem nu
                            </a>
                        @elseif($status === 'bestellen')
                            <a href="{{ route('bestelling', $winning_location_id ?? 1) }}"
                               class="bg-teal-900 text-white text-lg md:text-2xl font-bold py-2 px-6 rounded-lg shadow hover:bg-teal-800 whitespace-nowrap">
                                Bestel nu
                            </a>
                        @else
                            <a href="#"
                               class="bg-gray-500 text-white text-lg md:text-2xl font-bold py-2 px-6 rounded-lg shadow opacity-50 cursor-not-allowed whitespace-nowrap"
                               onclick="return false;">
                                Nog niet beschikbaar
                            </a>
                        @endif
                    </div>

                </div>
            </div>

            {{-- Schulden --}}
            <div class="bg-white border rounded-lg shadow p-4 h-auto lg:h-[650px] overflow-auto w-full">
                <div class="flex flex-col h-full">
                    <div class="border-b-4 border-black pb-2">
                        <p class="text-2xl md:text-4xl font-bold text-center">Schulden</p>
                    </div>

                    <div class="flex-1 mt-4">
                        <div class="flex flex-col gap-4">
                            <div class="flex justify-between items-center bg-gray-300 rounded-lg shadow-md p-4">
                                <p class="text-xl md:text-2xl font-semibold text-gray-800">Milan Sebes</p>
                                <div class="flex gap-4 text-sm">
                                    <div class="text-white bg-cyan-900 p-2 rounded">
                                        <p class="font-bold">Te ontvangen</p>
                                        <p class="text-green-500 font-semibold">€ 55.40,-</p>
                                    </div>
                                    <div class="text-white bg-cyan-900 p-2 rounded">
                                        <p class="font-bold">Te betalen</p>
                                        <p class="text-red-500 font-semibold">€ 20.50,-</p>
                                    </div>
                                </div>
                            </div>
                            {{-- Meer schulden hier indien nodig --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
