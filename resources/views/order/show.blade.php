@extends('layouts.master')

@section('pagetitle')
    Deadline
@endsection

@section('content')
<div class="w-[1200px] p-4 mx-auto flex flex-col gap-5">

    <div class="bg-white border rounded shadow p-4 h-[100px] flex items-center justify-center">
        <p class="text-4xl font-semibold mt-5 border-b-2 border-black w-[50%] text-center pb-2">
            {{ $location->name }}
        </p>
    </div>

    <div class="grid grid-cols-2 gap-10">
        <div class="bg-white border rounded shadow p-4 h-[350px] flex flex-col justify-start items-center relative">
            <p class="text-3xl font-semibold mt-5">Selecteer je lunch</p>

            <ul class="w-full mt-4 px-4 max-h-[200px] overflow-y-auto">
                @foreach ($lunchItems as $item)
                    <li class="flex justify-between items-center py-2 border-b last:border-none">
                        <span>{{ $item->naam }}</span>
                        <div class="flex items-center gap-4">
                            <span>€{{ number_format($item->prijs, 2) }}</span>
                            <button class="bg-teal-900 text-white py-1 px-3 rounded hover:bg-teal-800 transition">
                                Toevoegen
                            </button>
                        </div>
                    </li>
                @endforeach
            </ul>

            <a href="{{ route('lunchitems.create', ['location_id' => $location->id]) }}"
               class="bg-teal-900 text-white py-2 px-6 rounded-full hover:bg-teal-800 transition-all absolute bottom-4 right-4">
                Voeg nieuw item toe
            </a>
        </div>
        <div class="bg-white border rounded shadow p-4 h-[350px] flex flex-col justify-start items-center relative">
            <p class="text-3xl font-semibold mt-5 border-b-2 border-black w-[75%] text-center pb-2">Jouw huidige bestelling</p>

            <button class="bg-teal-900 text-white py-2 px-6 rounded-full hover:bg-teal-800 transition-all absolute bottom-4 right-4">
                Rond bestelling af
            </button>
        </div>

    </div>
</div>
@endsection
