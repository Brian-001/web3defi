@extends('layouts.dashboard')

@section('title', 'Create Tag')
@section('content')
<div class="flex items-center justify-center">
    <form action="{{route('tags.store')}}" method="POST" class="shadow-lg p-6 rounded-lg w-full max-w-lg">
        @csrf

        <div class="flex items-center justify-between">
            <h1 class="text-2xl text-slate-700 font-semibold mb-4 place-items-center">Create Tag</h1>
            <a href="{{ route('dashboard.job-management') }}" class="flex  gap-4">
                <span class="text-slate-700 order-2">Back</span> 
                <x-icons.arrow-uturn class="w-6 h-6 order-1 text-slate-700" />
            </a>
        </div>
        

        {{-- Flash message for success --}}
        @if (session('success'))
            <div class="mt-4 bg-green-200 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                {{ session('success')}}
            </div>
        @endif
        <div class="mb-4 flex flex-col">
            <label for="tag_name" class="font-semibold mb-2">Tag Name <span class="text-sm text-red-500">*</span></label>
            <input type="text" name="tag_name" id="tag_name" value="{{old('tag_name')}}" class="focus:outline-none focus:ring-2 focus:ring-cyan-300 rounded-lg p-2"
            placeholder="JavaScript, PHP, Python, etc." autocomplete="off" required>
            @error('tag_name')
                <span class="text-red-500 text-sm">{{$message}}</span>
            @enderror
        </div>
                
        <div>
            <button type="submit" class="bg-cyan-300 text-slate-700 px-2 py-1.5 rounded-md">Add Tag</button>
        </div>
    </form> 
</div> 
@endsection
