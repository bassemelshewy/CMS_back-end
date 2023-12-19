@extends('layouts.app')

@section('content')
    <div class="card card-default">
        <div class="card-header">
            Update Tag
        </div>
        <div class="card-body">
        <form action="{{ route('tags.update', $tag->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" value="{{$tag->id}}" name="id">
                <div class="form-group">
                    <label for="tag">Tag Name:</label>
                <input type="text" name="name" class="@error('name') is-invalid @enderror form-control" value="{{ $tag->name }}">
                @error('name')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                @enderror
                </div>
                <div class="form-group">
                    <button class="btn btn-success">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
