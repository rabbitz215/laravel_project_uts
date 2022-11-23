@extends('layouts.dashboard')

@section('content')
    @if ($message = Session::get('notif'))
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
            <strong>{{ $message }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <a href="{{ route('category.create') }}" class="btn btn-primary mb-3">Input</a>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <th scope="row">{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</th>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['description'] }}</td>
                    <td>
                        @if ($item->status == 'active')
                            <h4><span class="badge bg-success text-wrap">Active
                                </span></h4>
                        @else
                            <h4><span class="badge bg-danger text-wrap">Inactive
                                </span></h4>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('category.show', ['category' => $item->id]) }}" class="btn btn-warning">List
                            Products</a>
                        <a href="{{ route('category.edit', ['category' => $item->id]) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('category.destroy', ['category' => $item->id]) }}" class="d-inline"
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
