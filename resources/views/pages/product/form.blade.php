@extends('layouts.dashboard')

@section('content')
    <h1>{{ $product->id ? 'Edit Product' : 'Create Product' }}</h1>
    @if ($product->id)
        <form action="{{ route('product.update', ['product' => $product->id]) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
        @else
            <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
    @endif
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" name="name" value="{{ $product->name }}">
        @error('name')
            <div class="text-muted text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" class="form-control" cols="30" rows="5">{{ $product->description }}</textarea>
        @error('description')
            <div class="text-muted text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="category" class="form-label">Category</label>
        <select name="category_id" class="form-select">
            @foreach ($categories as $category)
                @if ($category->status == 'active')
                    <option value="{{ $category->id }}" {{ $category->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}</option>
                @endif
            @endforeach
        </select>
        @error('category')
            <div class="text-muted text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="text" class="form-control" name="price" value="{{ $product->price }}">
        @error('price')
            <div class="text-muted text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="weight" class="form-label">Weight (Kg)</label>
        <input type="text" class="form-control" name="weight" value="{{ $product->weight }}">
        @error('weight')
            <div class="text-muted text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
            <option value="draft" {{ $product->status == 'draft' ? 'selected' : '' }}>Draft</option>
        </select>
        @error('status')
            <div class="text-muted text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        @if ($product->image != null)
            <br><img src="/storage/{{ $product->image }}" alt="" width="200px" class="img-thumbnail mb-2">
        @endif
        <input type="file" class="form-control" name="image">
        @error('image')
            <div class="text-muted text-danger">{{ $message }}</div>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
