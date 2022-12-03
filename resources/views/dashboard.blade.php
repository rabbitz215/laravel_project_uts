@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @auth
                        <h1>Anda Telah Login</h1>
                    @else
                        <h1>Anda Belum Login</h1>
                    @endauth
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
