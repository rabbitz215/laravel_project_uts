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
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>RBA-{{ $transaction->id }}</td>
                                <td>{{ $transaction->customer }}</td>
                                <td>{{ @money($transaction->total_amount) }}</td>
                                @foreach ($status as $item)
                                    @if ($item->order_id == "RBA-$transaction->id")
                                        <td>
                                            @if ($item->transaction_status == 'pending')
                                                Pending
                                            @elseif($item->transaction_status == 'settlement')
                                                Settlement
                                            @elseif($item->transaction_status == 'success')
                                                Success
                                            @elseif($item->transaction_status == 'deny')
                                                Denied
                                            @elseif($item->transaction_status == 'expire')
                                                Expired
                                            @elseif($item->transaction_status == 'cancel')
                                                Cancelled
                                            @elseif($item->transaction_status == 'refund')
                                                Refunded
                                            @elseif($item->transaction_status == 'error')
                                                Error
                                            @else
                                                Unknown
                                            @endif
                                        </td>
                                    @endif
                                @endforeach
                                <td>
                                    <a href="{{ route('transaction.show', ['transaction' => $transaction->id]) }}"
                                        class="btn btn-primary">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Total</th>
                            <th>Status</th>
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
