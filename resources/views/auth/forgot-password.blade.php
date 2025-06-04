@extends('layouts.app-layouts')

@section('title', 'web3Defi | Password Reset')
@section('content')
<div class="flex items-center justify-center min-h-screen">
        <div class="bg-white p-10 rounded-lg shadow-md w-96">
            <div class="mt-4 mb-4 flex items-center justify-end">
                <a href="{{ route('login') }}" class="flex gap-1 hover:gap-2"><x-icons.arrow-uturn />Back</a>
            </div>
            <div class="mt-4 mb-2">
                @if(@session('status'))
                <div class="alert alert-success">
                    <span class="text-sm text-green-500">{{session ('status')}}</span>
                </div>
                @endif
            </div>
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-center">Password Request Link</h1>
                <p class="text-sm text-gray-600 text-center">Enter your email address below and we'll send you a link to reset your password.</p>
            </div>

            <form action="{{ route('password.email') }}" method="POST" >
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" required autocomplete="off" class="mt-1 p-2 w-full rounded-md border border-slate-500 focus:ring-slate-700">
                    @error('email')
                        <span class="text-sm text-red-500">{{$message}}</span>
                    @enderror
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-slate-500 hover:bg-slate-700 text-white font-bold py-2 w-full rounded">Request Link</button>
                </div>
            </form>
        </div>
    </div>
@endsection