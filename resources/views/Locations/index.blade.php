@extends('layouts.master')

@section('pagetitle') Kies een locatie om te eten @endsection

@section('content')


    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
        @foreach ($locations as $location)
            <form method="POST" action="{{ route('vote.store') }}">
                @csrf
                <input type="hidden" name="location_id" value="{{ $location->id }}">

                <button type="submit"
                        class="w-full bg-white rounded-xl shadow p-4 flex flex-col items-center justify-center aspect-square
                       hover:bg-gray-100 transition-colors duration-200 cursor-pointer
                       @if (isset($votedLocationId) && $votedLocationId == $location->id) bg-gray-400 @endif">
                    <img
                        src="{{ asset('storage/images/' . $location->image) }}"
                        alt="{{ $location->name }}"
                        class="max-h-40 object-contain mb-2"
                    >
                    <h2 class="text-sm font-medium text-center">{{ $location->name }}</h2>
                </button>
            </form>
        @endforeach
    </div>
























@endsection
