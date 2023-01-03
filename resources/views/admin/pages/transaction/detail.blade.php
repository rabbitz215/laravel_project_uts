@extends('admin.layouts.index')

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Transaction detail #RBA-{{ $transaction->id }}</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <h5>Nama Pembeli : {{ $transaction->customer }}</h5>
                <h5>No Hp : {{ $transaction->phone }}</h5>
                <h5>Alamat : {{ $transaction->address }}</h5>
                <h5>Total Harga : {{ @money($transaction->total_amount) }}</h5>
                <h5>Status :
                    @if ($status->transaction_status == 'pending')
                        Pending
                    @elseif($status->transaction_status == 'settlement')
                        Settlement
                    @elseif($status->transaction_status == 'success')
                        Success
                    @elseif($status->transaction_status == 'deny')
                        Denied
                    @elseif($status->transaction_status == 'expire')
                        Expired
                    @elseif($status->transaction_status == 'cancel')
                        Cancelled
                    @elseif($status->transaction_status == 'refund')
                        Refunded
                    @elseif($status->transaction_status == 'error')
                        Error
                    @else
                        Unknown
                    @endif
                </h5>
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
                        @foreach ($details as $detail)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $detail->product_id }}</td>
                                <td>{{ $detail->product->name }}</td>
                                <td>{{ $detail->quantity }}</td>
                                <td>{{ @money($detail->amount) }}</td>
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
                        </tr>
                    </tfoot>
                </table>
                <a href="{{ route('transaction.index') }}" class="btn btn-danger mt-3">Back</a>
                <br>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
@endsection
