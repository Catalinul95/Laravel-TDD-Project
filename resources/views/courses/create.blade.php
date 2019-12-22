@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create a new course</div>

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
                        <form action="{{ route('courses.store') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" placeholder="The name of your course.." class="form-control"  value="{{ old('name')}}">
                            </div>
                            <div class="form-group">
                                <label>Category</label>
                                <select name="category_id" class="form-control">
                                    <option value="">Please choose a category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @if (old('category_id') == $category->id) selected @endif>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Short Description</label>
                                <textarea name="short_description" rows="3" class="form-control">{{ old('short_description') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" rows="6" class="form-control">{{ old('description') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Available Seats</label>
                                <input type="text" name="seats" placeholder="Enter a signed numeric value..." class="form-control" value="{{ old('seats')}}">
                            </div>
                            <div class="form-group">
                                <label>Expiry Date</label>
                                <input type="text" name="expiry_date" placeholder="2020-01-22" class="form-control" value="{{ old('expiry_date')}}">
                            </div>
                            <button type="submit" class="btn btn-success">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
