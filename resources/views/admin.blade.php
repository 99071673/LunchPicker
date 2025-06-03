@extends('layouts.master')

@section('pagetitle') Admin @endsection

@section('content')
    <div class="max-w-screen-xl w-full mx-auto p-4 flex flex-col gap-5">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-7 items-stretch">

            <div class="flex flex-col justify-between h-[650px] w-full gap-6">

                <form method="POST" action="admin/deadlines">
                    @csrf
                    <div class="bg-white border rounded-lg shadow p-4 flex-1 flex flex-col">
                        <div class="border-b-4 border-black mb-4">
                            <p class="text-4xl font-bold flex justify-center">Deadlines</p>
                        </div>

                        <div class="flex flex-col gap-4 flex-1">
                            <div class="flex items-center justify-between">
                                <label for="locatie-deadline" class="text-lg text-gray-700">Locatie deadline</label>
                                <input type="time" id="locatie-deadline" name="locatie_deadline"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-lg"
                                    value="{{ old('locatie_deadline', $locatie_deadline) }}" required />
                            </div>

                            <div class="flex items-center justify-between">
                                <label for="order-deadline" class="text-lg text-gray-700">Order deadline</label>
                                <input type="time" id="order-deadline" name="order_deadline"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-lg"
                                    value="{{ old('order_deadline', $order_deadline) }}" required />
                            </div>
                        </div>

                        <div class="mt-4 flex justify-end">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Bevestig</button>
                        </div>
                    </div>
                </form>


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
                                        {{-- Hier moeten we nog even naar gaan kijken of we nou email of naam (of allebei) willen
                                        gaan tonen --}}
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
                <div class="flex-1 overflow-y-auto">
                    @if($locations->isEmpty())
                        <p class="text-center text-gray-500">Geen locaties gevonden</p>
                    @else
                        <ul class="space-y-2">
                            @foreach($locations as $location)
                                <li class="p-2 border-b">
                                    <p class="font-bold">{{ $location->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $location->address }}</p>
                                </li>
                            @endforeach
                        </ul>
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