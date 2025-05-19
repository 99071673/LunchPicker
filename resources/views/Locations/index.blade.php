@extends('layouts.master')

@section('pagetitle')
    Kies een locatie om te eten
@endsection

@section('content')

    <div class="relative">
        <form method="post" action="{{route("locations.submit")}}">
            @csrf
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @foreach ($locations as $location)
                    <div>
                        <input class="peer hidden" type="radio" hidden="true" id="{{ $location->id }}" name="location"
                               value="{{$location->id}}">

                        <label for="{{$location->id}}" class="location-btn w-full rounded-xl shadow p-4 flex flex-col items-center justify-center aspect-square
                           transition-colors duration-200 cursor-pointer focus:outline-none bg-white hover:bg-neutral-200 peer-checked:bg-gray-700 ">
                            <img
                                src="{{ asset('images/' . $location->image) }}"
                                alt="{{ $location->name }}"
                                class="max-h-40 object-contain mb-2">

                            <h2 class="text-sm font-medium text-center">{{ $location->name }}</h2>
                        </label>
                    </div>
                @endforeach
            </div>

            <input type="submit"
                   id="submitBtn"
                   class="fixed bottom-12 right-6 bg-blue-600 text-white font-semibold px-6 py-3 rounded-full shadow-lg
              hover:bg-blue-700 transition
              opacity-50 cursor-not-allowed pointer-events-none"
                   value="verstuur">

        </form>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const radios = document.querySelectorAll('input[name="location"]');
            const submitBtn = document.getElementById('submitBtn');

            radios.forEach(radio => {
                radio.addEventListener('change', () => {
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed', 'pointer-events-none');
                    submitBtn.classList.add('opacity-100', 'cursor-pointer');
                });
            });
        });
    </script>

@endsection
