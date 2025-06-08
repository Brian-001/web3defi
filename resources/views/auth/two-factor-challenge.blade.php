@extends('layouts.app-layouts')

@section('title', 'web3Defi| Two-Factor Authentication')

@section('content')
    
        {{-- <x-slot name="logo">
            <h2 class="text-xl font-semibold">Two-Factor Authentication</h2>
        </x-slot> --}}

        <form method="POST" action="{{ route('two-factor.login') }}">
            @csrf

            <div>
                <label for="code" class="block text-sm font-medium">Authentication Code</label>
                <input id="code" type="text" name="code" required autofocus class="mt-1 block w-full border rounded px-3 py-2">
                @error('code')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="mt-4">
                <button class="bg-cyan-600 text-white px-4 py-2 rounded">Confirm</button>
            </div>
        </form>
@endsection
