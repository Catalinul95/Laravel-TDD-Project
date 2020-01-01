@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Your classes for course <strong>{{ $course->name }}</strong></div>

                    <div class="card-body">
                        @if ($classes->count())
                            <table class="table">
                            <thead>
                                <tr>
                                    <th>Course Name</th>
                                    <th>Scheduled Date</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Created at</th>
                                    <th>Updated at</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($classes as $class)
                                    <tr>
                                        <td>
                                            {{ $class->title }}
                                        </td>
                                        <td>
                                            {{ $class->scheduled_date->format('Y-m-d') }}
                                        </td>
                                        <td>
                                            {{ $class->start_time }}
                                        </td>
                                        <td>
                                            {{ $class->end_time }}
                                        </td>
                                        <td>
                                            {{ $class->created_at->format('Y-m-d') }}
                                        </td>
                                        <td>
                                            {{ $class->updated_at->format('Y-m-d h:i:s') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                            There are no classes at this time for this course.
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
