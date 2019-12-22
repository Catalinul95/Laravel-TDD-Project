@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create a new course</div>

                    <div class="card-body">
                        <form action="{{ route('courses.store') }}" method="POST">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" placeholder="The name of your course.." class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Category</label>
                                <select name="category" class="form-control">
                                    <option value="">Please choose a category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Short Description</label>
                                <textarea name="short_description" rows="3" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="short_description" rows="6" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Available Seats</label>
                                <input type="text" name="seats" placeholder="Enter a signed numeric value..." class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Expiry Date</label>
                                <input type="date" name="expiry_date" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-success">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
