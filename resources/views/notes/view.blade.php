@extends('layouts.app')

@section('content')
    <h1>Notes</h1>
    <a href="{{ route('notes.create') }}">Create Note</a>

    @if (session('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Content</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($notes as $note)
                <tr>
                    <td>{{ $note->title }}</td>
                    <td>{{ $note->content }}</td>
                    <td>
                        <a href="{{ route('notes.show', $note) }}">View</a>
                        <a href="{{ route('notes.edit', $note) }}">Edit</a>
                        <form action="{{ route('notes.destroy', $note) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
