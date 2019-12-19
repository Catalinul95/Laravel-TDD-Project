@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">All Courses</div>

                    <div class="card-body">
                        <h2>{{ $course->name }}</h2>
                        <p>{{ $course->description }}</p>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
