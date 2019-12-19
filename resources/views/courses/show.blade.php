@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Courses</div>

                    <div class="card-body">
                        <h2>{{ $course->name }}</h2>
                        <p><small>Expires on <span class="badge badge-success">{{ $course->expiry_date->diffForHumans() }}</span></small></p>
                        <p>{{ $course->description }}</p>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
