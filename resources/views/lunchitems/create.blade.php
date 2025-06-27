@extends('layouts.master')

@section('title', 'Nieuw Lunchitem')

@section('pagetitle')
    Nieuw Lunchitem
@endsection

@section('content')
    <div class="max-w-lg mx-auto mt-10 bg-white p-6 rounded-xl shadow">
        <h2 class="text-2xl font-bold mb-5 text-gray-800 text-center">Voeg een nieuw lunchitem toe voor {{ $location->name }}</h2>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('lunchitems.store') }}" class="space-y-5">
            @csrf

                <input type="hidden" name="location_id" value="{{ $location->id }}">

            <div>
                <label for="naam" class="block text-xl font-bold mb-1 text-gray-800">Naam</label>
                <input type="text" name="naam" id="naam"
                       class="w-full px-4 py-2 rounded-xl border border-gray-400 focus:ring-2 focus:ring-blue-400"
                       placeholder="Bijv. Broodje Gezond"
                       required>
                @error('naam')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="prijs" class="block text-xl font-bold mb-1 text-gray-800">Prijs (€)</label>
                <input type="number" step="0.01" min="0" name="prijs" id="prijs"
                       class="w-full px-4 py-2 rounded-xl border border-gray-400 focus:ring-2 focus:ring-blue-400"
                       placeholder="Bijv. 3.95"
                       required>
                @error('prijs')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col sm:flex-row justify-between gap-3 sm:gap-0">
                <a href="{{ route('admin') }}"
                   class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-xl font-semibold text-center">
                    Annuleren
                </a>
                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-xl font-semibold">
                    Toevoegen
                </button>
            </div>
        </form>
    </div>
@endsection
