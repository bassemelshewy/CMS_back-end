@extends('layouts.app')

@section('stylesheets')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.0/trix.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="card card-default">
        <div class="card-header">
            {{ isset($post) ? 'Update Post' : 'Add a new Post' }}
        </div>
        <div class="card-body">
            <form action="{{ isset($post) ? route('posts.update', $post->id) : route('posts.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @if (isset($post))
                    @method('PUT')
                    <input type="hidden" name="id" value="{{$post->id}}">
                @endif
                <div class="form-group">
                    <label for="post title">Title:</label>
                    <input type="text" class="form-control" name="title" placeholder="Add a new post"
                        value="{{ isset($post) ? $post->title : old('title') }}">
                    @error('title')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="post description">Description:</label>
                    <textarea class="form-control" rows="2" name="description" placeholder="Add a description">{{ isset($post) ? $post->description : old('description')}}</textarea>
                    @error('description')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="post content">content:</label>
                    {{-- <textarea class="form-control" rows="3" name="content" placeholder="Add a content"></textarea> --}}
                    <input id="x" type="hidden" name="content" value="{{ isset($post) ? $post->content : old('content') }}">
                    <trix-editor input="x" ></trix-editor>
                    @error('content')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                @if (isset($post))
                    <div class="form-group">
                        <img src="{{ $post->image }}" style="height: 50%" />
                    </div>
                @endif
                <div class="form-group">
                    <label for="post image">Image:</label>
                    <input type="file" class="form-control" name="image">
                    @error('image')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="selectCategory">Select a category</label>
                    <select name="categoryID" class="form-control" id="selectCategory">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('categoryID')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                @if ($tags->count() )
                    <div class="form-group">
                        <label for="selectTag">Select a tag</label>
                        <select name="tags[]" class="form-control tags" id="selectTag" multiple>
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->id }}"
                                    @if(isset($post) && $post->hasTag($tag->id)) selected @endif
                                    @if(in_array($tag->id, old('tags', []))) selected @endif>
                                    {{ $tag->name }}
                                </option>
                            @endforeach
                        </select>
                    @error('tags')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                    @enderror
                    </div>
                @endif
                <div class="form-group">
                    <button type="submit" class="btn btn-success">
                        {{ isset($post) ? 'Update' : 'Add' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.0/trix.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.tags').select2();
        });
    </script>
@endsection
