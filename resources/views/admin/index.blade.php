@extends('layouts.master')

@section('pagetitle')
    Admin
@endsection

@section('content')
    <div class="max-w-screen-xl w-full mx-auto p-4 flex flex-col gap-5">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-7 items-stretch">

            <div class="flex flex-col justify-between h-[650px] w-full gap-6">

                <div class="bg-white border rounded-lg shadow p-4 flex-1 flex flex-col">
                    <div class="border-b-4 border-black mb-4">
                        <p class="text-4xl font-bold flex justify-center">Deadlines</p>
                    </div>
                    <div class="flex-1 overflow-y-auto">
                    </div>
                </div>

                <div class="bg-white border rounded-lg shadow p-4 flex-1 flex flex-col">
                    <div class="border-b-4 border-black mb-4">
                        <p class="text-4xl font-bold flex justify-center">Gebruikers</p>
                    </div>
                    <div class="flex-1 overflow-y-auto">
                        @if($users->isEmpty())
                            <p class="text-center text-gray-500">Geen gebruikers gevonden</p>
                        @else
                            <ul class="space-y-2">
                                @foreach($users as $user)
                                    <li class="p-2 border-b">
                                        {{-- Hier moeten we nog even naar gaan kijken of we nou email of naam (of allebei) willen gaan tonen --}}
                                        <p class="font-bold">{{ $user->name }}</p>
                                        <p class="text-sm text-gray-600">{{ $user->email }}</p>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

            </div>

            <div class="bg-white border rounded-lg shadow p-4 h-[650px] w-full flex flex-col">
                <div class="border-b-4 border-black mb-4">
                    <p class="text-4xl font-bold flex justify-center">Locaties</p>
                </div>
                <div class="flex-1 overflow-y-auto relative">
                    @if($locations->isEmpty())
                        <p class="text-center text-gray-500">Geen locaties gevonden</p>
                    @else
                        <ul class="space-y-2">
                            @foreach($locations as $location)
                                <li class="p-4 border-b bg-gray-300 rounded-3xl flex justify-between items-center">
                                    <p class="font-bold text-lg">{{ $location->name }}</p>

                                    <div class="flex space-x-3 items-center">
                                        <a href="{{ route('locations.edit', ['location' => $location->id]) }}"
                                           class="bg-blue-500 hover:bg-blue-600 text-white text-base px-8 py-2 rounded-xl font-semibold">
                                            Edit
                                        </a>

                                        <form action="{{ route('locations.destroy', ['location' => $location->id]) }}"
                                              method="POST"
                                              onsubmit="return confirm('Are you sure you want to delete this location?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="bg-red-500 hover:bg-red-600 text-white text-xl px-3 py-1 rounded-full font-bold leading-none">
                                                &times;
                                            </button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                        <!-- Create button positioned bottom-right -->
                        <a href="{{ route('location.create') }}"
                           class="absolute bottom-0.5 right-0.5 bg-blue-500 hover:bg-blue-600 text-white text-base px-5 py-2 rounded-xl font-semibold shadow-lg">
                            maak nieuwe locatie
                        </a>
                    @endif
                </div>
            </div>

            <div class="bg-white border rounded-lg shadow p-4 h-[650px] w-full flex flex-col">
                <div class="border-b-4 border-black mb-4">
                    <p class="text-4xl font-bold flex justify-center">Overig</p>
                </div>
                <div class="flex-1 overflow-y-auto">
                </div>
            </div>

        </div>
    </div>
@endsection
