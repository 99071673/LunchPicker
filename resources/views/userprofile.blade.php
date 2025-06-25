@extends('layouts.master')

@section('pagetitle') User Profile @endsection

@section('content')
    <div>
        <div class="max-w-full px-4 py-6 flex flex-col gap-5">

            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-7">
                {{-- Profielkolom (1/6 op grote schermen) --}}
                <div class="col-span-1 lg:col-span-1 bg-white border rounded-lg shadow p-4 w-full flex flex-col items-center h-auto lg:h-[650px]">
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800 mb-4 text-center">
                        {{ $user->name }}
                        <button class="ml-2"><i class="fas fa-pen"></i></button>
                    </h1>
                    <p class="text-base lg:text-lg text-gray-600 mb-4">Rol: {{ $user->role }}</p>

                    <div class="w-full max-w-[250px] h-[150px] bg-gray-200 rounded-lg flex items-center justify-center mb-2">
                        <img src="{{ asset('images/placeholder.png') }}" alt="Profielfoto" class="w-[200px] h-[100px] rounded border border-black object-contain">
                    </div>

                    <button class="bg-blue-700 text-white text-sm rounded px-3 py-1 mb-6">Wijzig afbeelding</button>

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="bg-blue-700 text-white w-full py-2 rounded text-sm">{{ __('Log Out') }}</button>
                    </form>

                    @if($user->role == 'admin')
                        <div class="mt-5 w-full">
                            <a class="block bg-blue-700 text-white w-full py-2 rounded text-sm text-center" href="{{ route('admin') }}">Go to admin page</a>
                        </div>
                    @endif
                </div>

                {{-- Schulden (2/6 op grote schermen) --}}
                <div class="col-span-1 md:col-span-1 lg:col-span-2 bg-white border rounded-lg shadow p-4 w-full h-auto lg:h-[650px]">
                    <h2 class="text-2xl lg:text-3xl font-bold text-center text-gray-800 mb-4">Schulden:</h2>
                </div>

                {{-- Tegoed (3/6 op grote schermen) --}}
                <div class="col-span-1 md:col-span-1 lg:col-span-3 bg-white border rounded-lg shadow p-4 w-full h-auto lg:h-[650px]">
                    <h2 class="text-2xl lg:text-3xl font-bold text-center text-gray-800 mb-4">Nog tegoed:</h2>
                </div>
            </div>
        </div>
    </div>
@endsection
