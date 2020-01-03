@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create a new class</div>

                    <div class="card-body">
                        @if (session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                   <div> {{ $error }}</div>
                                @endforeach
                            </div>
                        @endif
                        <form action="{{ route('courses-classes.store', ['course' => $courseId]) }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" name="title" placeholder="The title of your class.." class="form-control"  value="{{ old('title')}}">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" rows="6" class="form-control">{{ old('description') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Start Time</label>
                                <input type="text" name="start_time" placeholder="12:00:00" class="form-control" value="{{ old('start_time')}}">
                            </div>
                            <div class="form-group">
                                <label>End Time</label>
                                <input type="text" name="end_time" placeholder="16:00:00" class="form-control" value="{{ old('end_time')}}">
                            </div>
                            <div class="form-group">
                                <label>Scheduled Date</label>
                                <input type="text" name="scheduled_date" placeholder="2020-01-22" class="form-control" value="{{ old('scheduled_date')}}">
                            </div>
                            <button type="submit" class="btn btn-success">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
