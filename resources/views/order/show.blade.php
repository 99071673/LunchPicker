@extends('layouts.master')

@section('pagetitle')
    <div class="flex flex-col items-center">
        @if($status === 'bestellen')
            <x-countdown-timer class="text-3xl font-bold" :deadline="$orderdeadline" id="home-timer" />
        @endif
    </div>
@endsection

@section('content')
    <div class="max-w-7xl w-full p-4 mx-auto flex flex-col gap-5">

        <div class="bg-white border rounded shadow p-4 min-h-[80px] flex items-center justify-center">
            <p class="text-2xl md:text-4xl font-semibold border-b-2 border-black w-full md:w-[50%] text-center pb-2">
                {{ $location->name }}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-10">
            {{-- Selectieblok --}}
            <div class="bg-white border rounded shadow p-4 min-h-[350px] h-auto flex flex-col justify-start items-center relative">
                <p class="text-2xl md:text-3xl font-semibold mt-1 text-center">Selecteer je lunch</p>

                <form method="GET" action="{{ url()->current() }}" class="w-full mt-4">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Zoek lunchitem..."
                        class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-teal-900"
                    >
                </form>

                <ul class="w-full mt-4 px-2 md:px-4 max-h-[240px] overflow-y-auto">
                    @foreach ($lunchItems as $item)
                        <li class="flex justify-between items-center py-2 border-b last:border-none text-sm md:text-base">
                            <span>{{ $item->naam }}</span>
                            <div class="flex items-center gap-4">
                                <span>€{{ number_format($item->prijs, 2) }}</span>
                                <form method="POST" action="{{ route('order.add') }}">
                                    @csrf
                                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                                    <button type="submit" class="bg-teal-900 text-white py-1 px-3 rounded hover:bg-teal-800 transition text-xs md:text-sm">
                                        Toevoegen
                                    </button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <a href="{{ route('lunchitems.create', ['location_id' => $location->id]) }}"
                   class="bg-teal-900 text-white py-2 px-6 rounded-full hover:bg-teal-800 transition-all mt-4 self-end text-sm md:text-base">
                    Voeg nieuw item toe
                </a>
            </div>

            {{-- Bestellingblok --}}
            <div class="bg-white border rounded shadow p-4 min-h-[350px] h-auto flex flex-col justify-start items-center relative">
                <p class="text-2xl md:text-3xl font-semibold mt-1 border-b-2 border-black w-full md:w-[75%] text-center pb-2">Jouw huidige bestelling</p>

                <ul class="w-full mt-4 px-2 max-h-[200px] overflow-y-auto flex flex-col gap-2">
                    @forelse ($order as $key => $item)
                        <li class="bg-gray-200 rounded-lg px-4 py-2 flex justify-between items-center text-sm md:text-base">
                            <div class="flex flex-col">
                                <span class="font-medium">{{ $item['naam'] }}</span>
                            </div>

                            <div class="flex items-center gap-2 md:gap-4">
                            <span class="font-medium">
                                €{{ number_format(($item['aantal'] ?? 1) * $item['prijs'], 2) }},-
                            </span>

                                <form method="POST" action="{{ route('order.update') }}" class="flex items-center">
                                    @csrf
                                    <input type="hidden" name="key" value="{{ $key }}">
                                    <input
                                        type="number"
                                        name="aantal"
                                        min="1"
                                        value="{{ $item['aantal'] ?? 1 }}"
                                        class="w-14 border rounded px-2 py-1 text-center text-sm"
                                        onchange="this.form.submit()"
                                    >
                                </form>

                                <form method="POST" action="{{ route('order.remove') }}">
                                    @csrf
                                    <input type="hidden" name="key" value="{{ $key }}">
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white w-8 h-8 rounded-full text-center text-xl leading-6 font-bold">
                                        &times;
                                    </button>
                                </form>
                            </div>
                        </li>
                    @empty
                        <p class="mt-6 text-gray-500">Nog geen items toegevoegd.</p>
                    @endforelse
                </ul>

                <form method="POST" action="{{ route('order.save') }}" class="mt-6 md:absolute md:bottom-4 md:right-4">
                    @csrf
                    <input type="hidden" name="location_id" value="{{ $location->id }}">
                    <button type="submit"
                            class="bg-teal-900 text-white py-2 px-6 rounded-full hover:bg-teal-800 transition-all text-sm md:text-base">
                        Rond bestelling af
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
