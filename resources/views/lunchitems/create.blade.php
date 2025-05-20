@extends('layouts.master')

@section('pagetitle')
    Nieuw Lunchitem
@endsection

@section('content')
<div class="w-[1200px] mx-auto p-4">
    <div class="bg-white border rounded shadow p-6 max-w-xl mx-auto">
        <h1 class="text-3xl font-semibold mb-6">
            Voeg een nieuw lunchitem toe voor {{ $location->name }}
        </h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('lunchitems.store') }}" class="flex flex-col gap-4">
            @csrf

            <input type="hidden" name="location_id" value="{{ $location->id }}">

            <div>
                <label for="naam" class="block font-medium">Naam</label>
                <input type="text" name="naam" id="naam" class="border rounded p-2 w-full" required>
                @error('naam') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="prijs" class="block font-medium">Prijs (€)</label>
                <input type="number" step="0.01" name="prijs" id="prijs" class="border rounded p-2 w-full" required>
                @error('prijs') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="bg-teal-900 text-white py-2 px-4 rounded hover:bg-teal-800">
                Toevoegen
            </button>
        </form>
    </div>
</div>
@endsection
