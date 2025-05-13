@extends('layouts.master')

@section('pagetitle') 
    Deadline
@endsection

@section('content')
<div>
    <div class="w-[1200px] p-4 flex flex-col gap-5">

        <div class="bg-white border rounded shadow p-4 h-[100px] flex items-center justify-center">
            <p class="text-4xl font-semibold mt-5 border-b-2 border-black w-[50%] text-center pb-2">Paulus Frietpaleis</p>
        </div>

        <div class="grid grid-cols-2 gap-10">
            <div class="bg-white border rounded shadow p-4 h-[350px] flex flex-col justify-start items-center">
                <p class="text-3xl font-semibold mt-5">Selecteer je lunch</p>
            </div>
            <div class="bg-white border rounded shadow p-4 h-[350px] flex flex-col justify-start items-center relative">
                <p class="text-3xl font-semibold mt-5 border-b-2 border-black w-[75%] text-center pb-2">Jouw huidige bestelling</p>
                
                <button class="bg-blue-500 text-white py-2 px-6 rounded-full hover:bg-blue-600 transition-all absolute bottom-4 right-4">Rond bestelling af</button>
            </div>
        </div>

    </div>
</div>
@endsection
