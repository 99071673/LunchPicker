@extends('layouts.master')

@section('pagetitle')
    Edit
@endsection

@section('content')
    <div class="px-4 sm:px-8 py-6 bg-gray-300 min-h-screen">
        <div class="bg-gray-200 rounded-xl p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Locatie informatie --}}
            <div class="bg-white p-6 rounded-xl shadow">
                <form action="{{ route('locations.update', $location->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xl font-bold mb-1 text-gray-800">Naam</label>
                        <input type="text" name="name" value="{{ old('name', $location->name) }}"
                               class="w-full px-4 py-2 rounded-xl border border-gray-400 focus:ring-2 focus:ring-blue-400">
                    </div>

                    <div>
                        <label class="block text-xl font-bold mb-1 text-gray-800">Adres</label>
                        <input type="text" name="address" value="{{ old('address', $location->address) }}"
                               class="w-full px-4 py-2 rounded-xl border border-gray-400 focus:ring-2 focus:ring-blue-400">
                    </div>

                    <div>
                        <label class="block text-xl font-bold mb-1 text-gray-800">Afbeelding</label>
                        @if ($location->image)
                            <img src="{{ asset('images/' . $location->image) }}" alt="Locatie afbeelding" class="w-48 rounded-lg mb-2">
                        @endif
                        <input type="file" name="image" accept="image/*"
                               class="w-full px-4 py-2 rounded-xl border border-gray-400 bg-white focus:outline-none">
                    </div>

                    <div class="flex flex-col sm:flex-row justify-between gap-3 sm:gap-0">
                        <a href="{{ route('admin') }}"
                           class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-xl font-semibold text-center">
                            Annuleren
                        </a>
                        <button type="submit"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-xl font-semibold">
                            Opslaan
                        </button>
                    </div>
                </form>
            </div>

            {{-- Lunchitems van locatie --}}
            <div class="bg-white p-6 rounded-xl shadow flex flex-col">
                <h2 class="text-xl font-bold mb-4 text-gray-800">Lunchitems</h2>
                <ul class="w-full mb-4 max-h-[240px] overflow-y-auto px-2">
                    @foreach ($location->lunchItems as $item)
                        <li class="flex justify-between items-center py-2 border-b last:border-none flex-wrap gap-y-2">
                            <span class="w-full sm:w-auto">{{ $item->naam }}</span>
                            <div class="flex flex-wrap gap-2 items-center justify-end">
                                <span class="whitespace-nowrap">€{{ number_format($item->prijs, 2) }}</span>

                                <a href="{{ route('lunchitem.edit',["location" => $location->id, "LunchItem" => $item->id ]) }}"
                                   class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-500 transition text-sm">
                                    Wijzigen
                                </a>
                                <form method="POST" action="{{ route('lunchitems.destroy', $item->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-600 text-white px-2 py-1 rounded-full font-bold hover:bg-red-500 transition text-sm">
                                        &times;
                                    </button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <a href="{{ route('lunchitems.create', ['location_id' => $location->id]) }}"
                   class="self-end mt-auto bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded font-semibold text-sm">
                    Lunchitem toevoegen
                </a>
            </div>
        </div>
    </div>
@endsection
