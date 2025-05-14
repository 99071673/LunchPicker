@extends('layouts.master')

@section('pagetitle') Home @endsection

@section('content')
    <div>
        <div class="w-[1700px] p-4 flex flex-col gap-5">

            <div class="grid grid-cols-[1fr_2fr_1fr] gap-10">
                <div class="bg-white border rounded-lg rounded shadow p-4 h-[650px] w-full">

                </div>
                <div class="bg-white border rounded-lg shadow p-4 h-[650px] w-full">
                    <div class="grid grid-rows-3 h-full">
                        <div class="border-b-4 border-black row-span-1 ">
                            <p class="text-7xl font-bold flex justify-center">00: 12 : 54</p>
                            <p class="text-5xl font-bold flex justify-center">Resterende om te stemmen</p>

                        </div>

                        <div class="row-span-2 pt-4 flex-col flex items-center">
                            <p class="text-5xl font-bold">Er wordt nu besteld bij:</p>

                            <div class="mt-4">
                                <img src="{{ asset('images/placeholder.png') }}" alt="Bestelling logo" class="w-auto h-[15rem] object-contain" />
                            </div>

                        </div>

                        <div class="border-t-4 border-black flex row-span-1">

                            <div class="w-25 flex-1 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-16">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>

                                <p class="text-5xl font-semibold">5</p>

                            </div>

                            <div class="w-32 flex-1 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-16">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>

                                <p class="text-5xl font-semibold">3</p>

                            </div>

                            <div class="w-80 flex-none flex  items-center justify-center pt-4  pb-4">
                                <button class="bg-teal-900 text-white text-2xl font-bold py-4 px-12 rounded-lg shadow hover:bg-teal-800"> Doe mee </button>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="bg-white border rounded-lg rounded shadow p-4 h-[650px] w-full">

                </div>
            </div>
        </div>
    </div>
@endsection