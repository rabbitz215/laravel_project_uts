@extends('admin.layouts.index')

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Transaction detail #bf256bc4-dde2-4d8b-a754-acbd3a3b7c71</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <h5>Nama Pembeli : Joko</h5>
                <h5>Alamat : Indonesia</h5>
                <h5>Total Harga : Rp. xxxxxxxx</h5>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>QTY</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>1</td>
                            <td>Sampo</td>
                            <td>1</td>
                            <td>Rp. 20000</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>QTY</th>
                            <th>Total</th>
                        </tr>
                    </tfoot>
                </table>
                <br>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
@endsection
