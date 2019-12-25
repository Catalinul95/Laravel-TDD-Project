@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">All Courses</div>

                    <div class="card-body">
                       @foreach ($courses as $course)
                           <div class="row">
                               <div class="col-md-12">
                                   <h2><a href="{{ route('courses.show', ['course' => $course->slug]) }}">{{ $course->name }}</a></h2>
                                   <p>{{ $course->short_description }}</p>
                                   <p>Expires <span class="badge badge-info">{{ $course->expiry_date->diffForHumans() }}</span></p>
                                   @if (auth()->check() && auth()->user()->hasCourseRegistrationRequest($course->id))
                                      @if (auth()->user()->getCourseRegistrationStatus($course->id) == 'pending')
                                          <p><span class="btn btn-warning">Waiting for approval!</span></p>
                                      @endif
                                      @if (auth()->user()->getCourseRegistrationStatus($course->id) == 'approved')
                                          <p><span class="btn btn-success">Registered to course!</span></p>
                                      @endif
                                      @if (auth()->user()->getCourseRegistrationStatus($course->id) == 'denied')
                                          <p><span class="btn btn-danger">Registration denied!</span></p>
                                      @endif
                                   @endif
                                   <hr>
                               </div>
                           </div>
                       @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
