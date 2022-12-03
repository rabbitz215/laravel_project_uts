@extends('admin.layouts.index')

@section('content')
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ $category->id ? 'Edit Data' : 'Create Data' }}</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            @if ($category->id)
                <form action="{{ route('category.update', ['category' => $category->id]) }}" method="POST"
                    enctype="multipart/form-data">
                    @method('PUT')
                @else
                    <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
            @endif
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Category Name</label>
                    <input type="text" class="form-control" placeholder="Enter name" name="name"
                        value="{{ $category->name }}">
                    @error('name')
                        <div class="text-muted text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Category Description</label>
                    <textarea name="description" class="form-control" cols="30" rows="10">{{ $category->description }}</textarea>
                    @error('description')
                        <div class="text-muted text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Status</label>
                    <select name="status" class="form-control">
                        <option value="active" {{ $category->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $category->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <div class="text-muted text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
        </div>
        <!-- /.card -->
    </div>
@endsection
