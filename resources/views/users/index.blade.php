@extends('layouts.app')

@section('title', 'Manajemen User')

@section('page-title', 'Manajemen User')

@section('breadcrumb')
    <li class="breadcrumb-item active">Manajemen User</li>
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Jumlah Wishlist</th>
                    <th>Jumlah Ulasan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->wishes_count }}</td>
                        <td>{{ $user->reviews_count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
