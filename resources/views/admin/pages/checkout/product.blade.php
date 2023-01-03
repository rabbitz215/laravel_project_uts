@extends('admin.layouts.index')

@section('content')
    @if (session('alert-type'))
        <script>
            Swal.fire({
                type: '{{ session('alert-type') }}',
                title: '{{ session('alert-message') }}'
            }).then(() => {
                window.open('{{ session('paymentUrl') }}', '_blank');
            });
        </script>
    @endif
    <div class="col-3">
        <form method="GET" action="{{ route('checkout.index') }}">
            <div class="input-group mb-3">
                <input type="text" name="search" class="form-control" placeholder="Search products..."
                    value="{{ request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </div>
        </form>
    </div>
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
                                    <form>
                                        <button type="button" class="btn btn-primary"
                                            onclick="showPrompt({{ $item->id }})">Beli</button>
                                    </form>
                                </td>
                            </tr>
                            <script>
                                function showPrompt(productId) {
                                    Swal.fire({
                                        title: 'Masukkan jumlah barang',
                                        input: 'number',
                                        inputAttributes: {
                                            min: 1,
                                            max: 100
                                        },
                                        inputValue: '1',
                                        showCancelButton: true,
                                        cancelButtonText: 'Batal',
                                        confirmButtonText: 'Beli',
                                        inputValidator: (value) => {
                                            if (value < 1) {
                                                return "<strong>Jumlah barang tidak boleh kurang dari 1</strong>";
                                            }
                                        }
                                    }).then((result) => {
                                        if (result.value) {
                                            // Use the value entered by the user
                                            var qty = result.value;
                                            // Submit the form
                                            window.location.href = "{{ route('checkout.create') }}?product_id=" + productId + "&qty=" +
                                                qty;
                                        }
                                    });
                                }
                            </script>
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
