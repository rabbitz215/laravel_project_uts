@extends('layouts.dashboard')

@section('content')
    @if ($message = Session::get('notif'))
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
            <strong>{{ $message }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <a href="{{ route('product.create') }}" class="btn btn-primary mb-3">Input</a>
    <form class="row g-3" action="{{ route('product.index') }}" method="GET">
        <div class="col-auto">
            <select name="filter" id="filter" class="form-select">
                <option value="">All</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('filter') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <label for="search" class="visually-hidden"></label>
            <input type="text" name="search" class="form-control" id="search" placeholder="Search"
                value="{{ request('search') }}">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3">Cari</button>
        </div>
    </form>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Weight (Kg)</th>
                <th scope="col">Price</th>
                <th scope="col">Category</th>
                <th scope="col">Status</th>
                <th scope="col">Image</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <th scope="row">{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</th>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->weight }}</td>
                    <td>{{ @money($item->price) }}</td>
                    <td>{{ $item->category->name }}</td>
                    <td>
                        @if ($item->status == 'active')
                            <h4><span class="badge bg-success text-wrap">Active
                                </span></h4>
                        @elseif ($item->status == 'inactive')
                            <h4><span class="badge bg-danger text-wrap">Inactive
                                </span></h4>
                        @else
                            <h4><span class="badge bg-warning text-wrap">Draft
                                </span></h4>
                        @endif
                    </td>
                    <td><img src="/storage/{{ $item->image }}" alt="" width="75px"></td>
                    <td>
                        <a href="{{ route('product.edit', ['product' => $item->id]) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('product.destroy', ['product' => $item->id]) }}" class="d-inline"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $data->withQueryString()->links() }}
@endsection
