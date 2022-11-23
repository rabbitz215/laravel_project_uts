@extends('layouts.dashboard')

@section('content')
    <h1>Category {{ $categories->name }}</h1>
    <h5>Jumlah Products : {{ $categories->products->count() }}</h5>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Product Name</th>
                <th scope="col">Price</th>
                <th scope="col">Weight</th>
                <th scope="col">Image</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories->products as $product)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->weight }}</td>
                    <td><img src="/storage/{{ $product->image }}" alt="" width="25"></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
