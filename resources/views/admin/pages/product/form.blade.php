@extends('admin.layouts.index')

@section('content')
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ $product->id ? 'Edit Product' : 'Create Product' }}</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            @if ($product->id)
                <form action="{{ route('product.update', ['product' => $product->id]) }}" method="POST"
                    enctype="multipart/form-data">
                    @method('PUT')
                @else
                    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
            @endif
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" class="form-control" placeholder="Enter name" name="name"
                        value="{{ $product->name }}">
                    @error('name')
                        <div class="text-muted text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Description</label>
                    <textarea name="description" class="form-control" cols="30" rows="10">{{ $product->description }}</textarea>
                    @error('description')
                        <div class="text-muted text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Category</label>
                    <select name="category_id" class="form-control">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ $category->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <div class="text-muted text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Price</label>
                    <input type="number" class="form-control" name="price" value="{{ $product->price }}">
                    @error('price')
                        <div class="text-muted text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Weight</label>
                    <input type="text" class="form-control" name="weight" value="{{ $product->weight }}">
                    @error('weight')
                        <div class="text-muted text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="draft" {{ $product->status == 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                    @error('status')
                        <div class="text-muted text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="image" class="form-label">Image</label>
                    @if ($product->image != null)
                        <br><img src="/storage/{{ $product->image }}" alt="" width="200px"
                            class="img-thumbnail mb-2">
                    @endif
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile" name="image">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                    </div>
                    @error('image')
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
