@extends('layouts.dashboard')

@section('title', 'Tags')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h1 class="font-semibold text-2xl mb-2">Tags</h1>
    <div class="mx-auto my-4">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-300">
                    <th class="py-2 text-left">Tag Id</th>
                    <th class="py-2 text-left">Tag Name</th>
                    <th class="py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tags as $tag)
                    <tr class="border-b border-gray-200">
                        <td class="py-2">{{$tag->id}}</td>
                        <td class="py-2">{{$tag->tag_name}}</td>
                        <td class="py-2 px-4 flex gap-4">
                            <a href="{{ route('tags.edit', $tag->id) }}">Edit</a>
                            <form action="{{ route('tags.destroy', $tag->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="hover:underline hover:text-red-300 underline-offset-2">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection