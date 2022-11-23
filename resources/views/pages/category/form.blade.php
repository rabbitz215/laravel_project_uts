@extends('layouts.dashboard')

@section('content')
    <h1>{{ $category->id ? 'Edit Data' : 'Create Data' }}</h1>
    @if ($category->id)
        <form action="{{ route('category.update', ['category' => $category->id]) }}" method="POST">
            @method('PUT')
        @else
            <form action="{{ route('category.store') }}" method="POST">
    @endif
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Category Name</label>
        <input type="text" class="form-control" name="name" value="{{ $category->name }}">
        @error('name')
            <div class="text-muted text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Category Description</label>
        <textarea name="description" id="" class="form-control" cols="300" rows="5">{{ $category->description }}</textarea>
        @error('description')
            <div class="text-muted text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="active" {{ $category->status == 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ $category->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
        @error('status')
            <div class="text-muted text-danger">{{ $message }}</div>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
