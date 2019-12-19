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
