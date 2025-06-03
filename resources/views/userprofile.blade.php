@extends('layouts.master')

@section('pagetitle') User Profile @endsection

@section('content')
<div>
    <div class="w-[1700px] p-4 flex flex-col gap-5">

        <div class="grid grid-cols-[1fr_2fr_1fr] gap-7">
            <div class="bg-white border rounded-lg shadow p-4 h-[650px] w-full flex flex-col items-center">
                <h1 class="text-3xl font-bold text-gray-800 mb-6">
                    {{ $user->name }}
                    <button class="ml-2"><i class="fas fa-pen"></i></button>
                </h1>
                <p class="text-lg text-gray-600 mb-4">Rol: {{ $user->role }}</p>
                {{-- even lopen testen hier met de variablen deze kunnen later mooier gemaakt worden  --}}

                <div class="w-[250px] h-[150px] bg-gray-200 rounded-lg flex items-center justify-center mb-2">
                    <img src="{{ asset('images/placeholder.png') }}" alt="Profielfoto" class="w-[200px] h-[100px] rounded border-1 border-black object-contain">
                </div>

                <button class="bg-blue-700 text-white text-sm rounded px-3 py-1 mb-6">Wijzig afbeelding</button>

                <div class="w-full px-4">
                    <p class="text-md font-semibold mb-2">Wachtwoord resetten</p>
                    <input type="password" placeholder="Nieuw Wachtwoord" class="w-full p-2 border rounded mb-3">
                    <input type="password" placeholder="Herhaal Nieuw Wachtwoord" class="w-full p-2 border rounded mb-5">
                    <button class="bg-blue-700 text-white w-full py-2 rounded text-sm">Wachtwoord toepassen</button>
                </div>
                <div class="mt-5">
                        @if($user->role == 'admin')
                    <a class="m-auto mt-20 bg-blue-700 text-white w-full py-2 rounded text-sm" href="{{route('admin')}}"> go to admin page</a>
                    @endif
                </div>
            </div>

            <div class="bg-white border rounded-lg shadow p-4 h-[650px] w-full">
                <h2 class="text-3xl font-bold text-center text-gray-800 mb-4">Schulden:</h2>
            </div>

            <div class="bg-white border rounded-lg shadow p-4 h-[650px] w-full">
                <h2 class="text-3xl font-bold text-center text-gray-800 mb-4">Nog tegoed:</h2>
            </div>
        </div>
    </div>
</div>
@endsection
