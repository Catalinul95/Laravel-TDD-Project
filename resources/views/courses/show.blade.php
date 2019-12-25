@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        @if (!auth()->check() || $course->hasOwner(auth()->user()->id))
                            View Course
                        @else
                            @if (auth()->user()->hasCourseRegistrationRequest($course->id))
                                @if (auth()->user()->getCourseRegistrationStatus($course->id) == 'pending')
                                      <p><span class="btn btn-warning">Waiting for approval!</span></p>
                                @endif
                                @if (auth()->user()->getCourseRegistrationStatus($course->id) == 'approved')
                                      <p><span class="btn btn-success">Registered to course!</span></p>
                                @endif
                                @if (auth()->user()->getCourseRegistrationStatus($course->id) == 'denied')
                                      <p><span class="btn btn-danger">Registration denied!</span></p>
                                @endif
                            @else 
                                <form action="{{ route('course-registrations.store', ['course' => $course->id]) }}" method="POST">
                                    {{ csrf_field() }}
                                    <button class="btn btn-info">Register To Course</button>
                                </form>
                            @endif
                        @endif
                    </div>

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
