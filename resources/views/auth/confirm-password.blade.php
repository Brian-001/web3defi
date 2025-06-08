@extends('layouts.dashboard')

@section('title', 'Confirm Password')

@section('content')
<div class="flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded shadow w-96">
        <h2 class="text-xl font-bold mb-4">Please confirm your password</h2>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" required
                       class="w-full mt-1 border rounded p-2 border-gray-300">
            </div>

            <button type="submit"
                    class="w-full bg-cyan-600 text-white py-2 rounded hover:bg-cyan-700 transition">
                Confirm
            </button>
        </form>
    </div>
</div>
@endsection
