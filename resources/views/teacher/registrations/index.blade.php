@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Your course registrations</div>

                    <div class="card-body">
                        @if ($registrations->count())
                            <table class="table">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Course</th>
                                    <th>Status</th>
                                    <th>Created at</th>
                                    <th>Updated at</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($registrations as $registration)
                                    <tr>
                                        <td>
                                            <strong>{{ $registration->user->name }}</strong>
                                        </td>
                                        <td>
                                            <strong>{{ $registration->course->name }}</strong>
                                        </td>
                                        <td>
                                            @if ($registration->status == 'pending')
                                                <p><span class="btn btn-warning">Pending</span></p>
                                            @endif
                                            @if ($registration->status == 'approved')
                                                <p><span class="btn btn-success">Approved</span></p>
                                            @endif
                                            @if ($registration->status == 'denied')
                                                <p><span class="btn btn-danger">Denied</span></p>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $registration->created_at->format('Y-m-d') }}
                                        </td>
                                        <td>
                                            {{ $registration->created_at->format('Y-m-d h:i:s') }}
                                        </td>
                                        <td>
                                            <a href="" class="btn btn-success">Accept</a>
                                            <a href="#" class="btn btn-danger">Deny</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                            There are no registrations at this time for this course.
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
