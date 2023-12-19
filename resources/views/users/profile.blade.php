@extends('layouts.app')

@section('content')
    <div class="card card-default">
        <div class="card-header">
            Profile
        </div>
        <div class="card-body">
            <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $user->id }}">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                    @error('name')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" name="email" class="form-control" value="{{ $user->email }}">
                    @error('email')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="about">About:</label>
                    <textarea class="form-control" rows="2" name="about" placeholder="Tell us about you">{{ $profile->about ?? '' }}</textarea>
                    @error('about')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="facebook">Facebook:</label>
                    <input type="text" name="facebook" class="form-control" placeholder="Enter facebook link"
                        value="{{ $profile->facebook ?? '' }}">
                    @error('facebook')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="twitter">Twitter:</label>
                    <input type="text" name="twitter" class="form-control" placeholder="Enter twitter link"
                        value="{{ $profile->twitter ?? '' }}">
                    @error('twitter')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="picture">Picture:</label><br>
                    <img src="{{ $user->hasPicture() ? asset('uploads/profilesPicture/'. $user->getPicture()) : $user->getGravatar() }}"
                        width="80px" height="80px">
                    <input type="file" name="picture" class="form-control mt-2">
                    @error('picture')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <button class="btn btn-success">
                        Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
