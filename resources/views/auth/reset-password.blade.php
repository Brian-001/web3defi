@extends('layouts.app-layouts')

@section('title', 'web3Defi| Reset Password')

@section('content')
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white p-10 rounded-lg shadow-md w-96">
            <div class="mt-4 mb-4 flex items-center justify-end">
                <a href="/" class="flex gap-1 hover:gap-2"><x-icons.arrow-uturn />Back</a>
            </div>
            <div class="mt-4 mb-2">
                @if(@session('status'))
                    <div class="alert alert-success">
                        <span class="text-sm text-green-500">{{session ('status')}}</span>
                    </div>
                @endif
            </div>
            
            <h1 class="text-2xl font-bold mb-6 text-center">Reset Password</h1>
            <form action="{{route('password.update')}}" method="POST" >
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                <input type="hidden" name="email" value="{{ $request->email }}">

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" required class="mt-1 p-2 w-full rounded-md border border-slate-500 focus:ring-slate-700">
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required class="mt-1 p-2 w-full rounded-md border border-slate-500 focus:ring-slate-700">
                </div>
                <div class="flex items-center justify-between mb-6">
                    <button type="submit" class="bg-slate-500 hover:bg-slate-700 text-white font-bold py-2 px-4 w-full rounded">Update Password</button>
                </div>
            </form>
        </div>
    </div>
@endsection