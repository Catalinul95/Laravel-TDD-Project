@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <p>Class Title: <strong>{{ $class->title }}</strong></p>
                    <p>Scheduled Date: <strong>{{ $class->scheduled_date }}</strong></p>
                    <p>Start Time: <strong>{{ $class->start_time }}</strong></p>
                    <p>End Time: <strong>{{ $class->end_time }}</strong></p>
                    <p>Created at: <strong>{{ $class->created_at }}</strong></p>
                    <p>Updated at: <strong>{{ $class->updated_at }}</strong></p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Class <strong>{{ $class->title }}</strong> part of course <strong>{{ $course->name }}</strong></div>
                <div class="card-body">
                    @if (count($registrations))
                    <form>
                        <div class="form-group">
                            <select class="form-control col-md-5 mb-3">
                                <option selected>Add a user to this class</option>
                                @php $found = false @endphp
                                @foreach ($registrations as $registration)
                                    <option value="{{ $registration->user->id }}">{{ $registration->user->name }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-success">Save</button>
                        </div>
                    </form>
                    @endif
                    @if (count($class->users))
                                <table class="table">
                                    <thead>
                                        <th>Username</th>
                                        <th>Email</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($class->users as $userClass)
                                            <tr>
                                                <td>{{ $userClass->user->name }}</td>
                                                <td>{{ $userClass->user->email }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else 
                                There are no users currently assigned to this course.
                            @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
