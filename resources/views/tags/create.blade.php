@extends('layouts.app-layouts')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-slate-700">
    <form action="{{route('tags.store')}}" method="POST" class="shadow-lg bg-slate-700 p-6 rounded-lg w-full max-w-lg">
        @csrf

        <h1 class="text-2xl text-cyan-300 mb-4 place-items-center">Create Tag</h1>

        {{-- Flash message for success --}}
        @if (session('success'))
            <div class="mt-4 bg-green-200 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                {{ session('success')}}
            </div>
        @endif
        <div class="mb-4 flex flex-col">
            <label for="tag_name" class="font-semibold">Tag Name <span class="text-sm text-red-500">*</span></label>
            <input type="text" name="tag_name" id="tag_name" value="{{old('tag_name')}}" class="focus:outline-none focus:ring-2 focus:ring-cyan-300 bg-slate-600 font-semibold rounded-lg p-2" autocomplete="off" required>
            @error('tag_name')
                <span class="text-red-500 text-sm">{{$message}}</span>
            @enderror
        </div>
                
        <div>
            <button type="submit" class="bg-cyan-300 text-slate-700 px-2 py-1.5 rounded-md">Post Job</button>
        </div>
    </form> 
</div> 
@endsection
