@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">View Course</div>

                    <div class="card-body">
                        <h2>{{ $course->name }}</h2>
                        <p>Expires <span class="badge badge-info">{{ $course->expiry_date->diffForHumans() }}</span></p>
                        <p>{{ $course->description }}</p>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
