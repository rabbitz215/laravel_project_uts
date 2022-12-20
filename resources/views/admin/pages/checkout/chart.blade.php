@extends('admin.layouts.index')

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">My Charts</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>QTY</th>
                            <th>Total</th>
                            <th>Image</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['products'] as $product)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $product['id'] }}</td>
                                <td>Nama Productnya</td>
                                <td>{{ $product['qty'] }}</td>
                                <td>Harga diDB x QTY</td>
                                <td>Gambar</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>QTY</th>
                            <th>Total</th>
                            <th>Image</th>
                        </tr>
                    </tfoot>
                </table>
                <br>
                <h5>Total Harga : Rp. xxxxxxxx</h5>
            </div>
            <!-- /.card-body -->
            <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" class="form-control" placeholder="Enter name" name="name"
                        value="">
                    @error('name')
                        <div class="text-muted text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Alamat</label>
                    <textarea name="address" class="form-control" cols="30" rows="10"></textarea>
                    @error('address')
                        <div class="text-muted text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button class="btn btn-danger">Bayar</button>
            </div>
        </div>
        <!-- /.card -->
    </div>
@endsection
