@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Your registrations for course <strong>{{ $course->name }}</strong></div>

                    <div class="card-body">
                        @if ($registrations->count())
                            <table class="table">
                            <thead>
                                <tr>
                                    <th>User</th>
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
                                            @if ($registration->status == 'pending')
                                            <form action="{{ route('course-registrations.update', ['courseRegistrationId' => $registration->id]) }}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('PATCH')   }}
                                                <input type="hidden" name="status" value="approved">
                                                <button class="btn btn-success">Approve</button>
                                            </form>
                                            <form action="{{ route('course-registrations.update', ['courseRegistrationId' => $registration->id]) }}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('PATCH')   }}
                                                <input type="hidden" name="status" value="denied">
                                                <button class="btn btn-danger">Deny</button>
                                            </form>
                                            @else
                                                <form action="{{ route('course-registrations.delete', ['courseRegistrationId' => $registration->id]) }}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE')   }}
                                                <button class="btn btn-danger">Delete</button>
                                            </form>
                                            @endif
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
