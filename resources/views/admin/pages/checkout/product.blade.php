@extends('admin.layouts.index')

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">DataTable with default features</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Weight</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <th scope="row">{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                                </th>
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
                                    <a href="{{ route('checkout.create', ['product_id' => $item->id, 'qty' => 1]) }}"
                                        class="btn btn-primary">Beli</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Weight</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
                <br>
                {{ $data->withQueryString()->links() }}
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
@endsection
