@extends('layouts.master')

@section('pagetitle') Kies een locatie om te eten @endsection

@section('content')


    <form method="POST" action="{{ route('vote.store') }}" x-data="{ selected: null }" class="relative">
        @csrf
        <input type="hidden" name="location_id" :value="selected">

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @foreach ($locations as $location)
                <button type="button"
                        @click="selected = {{ $location->id }}"
                        :class="selected === {{ $location->id }}
                    ? 'bg-gray-400 ring-2 ring-gray-800'
                    : 'bg-white hover:bg-gray-100'"
                        class="w-full rounded-xl shadow p-4 flex flex-col items-center justify-center aspect-square
                       transition-colors duration-200 cursor-pointer focus:outline-none">
                    <img
                        src="{{ asset('storage/images/' . $location->image) }}"
                        alt="{{ $location->name }}"
                        class="max-h-40 object-contain mb-2"
                    >
                    <h2 class="text-sm font-medium text-center">{{ $location->name }}</h2>
                </button>
            @endforeach
        </div>

        <button type="submit"
                class="fixed bottom-12 right-6 bg-blue-600 text-white font-semibold px-6 py-3 rounded-full shadow-lg hover:bg-blue-700 transition"
                :disabled="!selected"
                :class="{ 'opacity-50 cursor-not-allowed': !selected }">
            Confirm Vote
        </button>
    </form>






















@endsection
