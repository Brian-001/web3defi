@extends('layouts.app-layouts')

@section('title', 'Two-Factor Authentication')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white p-6 rounded-xl shadow-lg max-w-md mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Two-Factor Authentication</h2>

        @if (session('status'))
            <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-r-lg" role="alert">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-r-lg" role="alert">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('two-factor.login') }}" class="space-y-6">
            @csrf

            <div class="space-y-2">
                <label for="code" class="block text-sm font-semibold text-gray-800">Authentication Code</label>
                <input type="text" name="code" id="code" placeholder="Enter 6-digit code or recovery code" 
                       class="w-full p-2 text-sm text-gray-700 border rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500">
                @error('code')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" 
                        class="bg-cyan-500 text-white text-sm font-semibold px-6 py-2 rounded-md hover:bg-cyan-600 transition-colors duration-200">
                    Verify
                </button>
            </div>
        </form>
    </div>
</div>
@endsection