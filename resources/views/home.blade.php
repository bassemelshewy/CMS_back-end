@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row text-center">
                    <div class="col-md-4">
                        <div class="card text-white bg-info">
                            <div class="card-header">Users</div>
                            <div class="card-body">{{ $users_count }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-danger">
                            <div class="card-header">Posts</div>
                            <div class="card-body">{{ $posts_count }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-success">
                            <div class="card-header">Categories</div>
                            <div class="card-body">{{ $categories_count }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
