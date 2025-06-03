@extends('layouts.master')

@section('content')
    <div class="max-w-xl mx-auto p-6 bg-white rounded-3xl shadow-lg mt-10">
        <h1 class="text-2xl font-bold mb-6 text-center">Nieuwe Locatie Aanmaken</h1>

        <form action="{{ route('location.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block font-semibold mb-1">Naam</label>
                <input type="text" name="name" id="name" required
                       class="w-full px-4 py-2 rounded-xl border border-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Address -->
            <div>
                <label for="address" class="block font-semibold mb-1">Adres</label>
                <input type="text" name="address" id="address" required
                       class="w-full px-4 py-2 rounded-xl border border-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Image -->
            <div>
                <label for="image" class="block font-semibold mb-1">Afbeelding</label>
                <input type="file" name="image" id="image" accept="image/*"
                       class="w-full px-4 py-2 rounded-xl border border-gray-400 bg-white focus:outline-none">
            </div>

            <!-- Buttons -->
            <div class="flex justify-between">
                <a href="{{ route('admin') }}"
                   class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-xl font-semibold">
                    Annuleren
                </a>
                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-xl font-semibold">
                    Opslaan
                </button>
            </div>
        </form>

    </div>
@endsection
