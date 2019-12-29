@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Courses created by me</div>

                    <div class="card-body">
                      @if (count($courses))
                         @foreach ($courses as $course)
                             <div class="row">
                                 <div class="col-md-12">
                                      <div class="text-right">
                                        <a href="#" class="btn btn-sm btn-secondary">Update</a>
                                        <a href="#" class="btn btn-sm btn-info">Registrations</a>
                                      </div>
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
                        @else
                          <p>You don't have any course created.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
