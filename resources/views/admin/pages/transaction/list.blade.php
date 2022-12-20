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
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>xx</td>
                            <td>Gafri</td>
                            <td>RP. 30000</td>
                            <td>
                                <a href="{{ route('transaction.show', ['transaction' => 'bf256bc4-dde2-4d8b-a754-acbd3a3b7c71']) }}"
                                    class="btn btn-primary">detail</a>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Total</th>
                            <th>Action</th>
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
