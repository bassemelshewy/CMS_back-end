@extends('layouts.app')

@section('content')
    <div class="card card-default">
        <div class="card-header">
            Update Category
        </div>
        <div class="card-body">
        <form action="{{ route('categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="category">Category Name:</label>
                <input type="text" name="name" class="@error('name') is-invalid @enderror form-control" value="{{ $category->name }}">
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
