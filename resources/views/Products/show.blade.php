@extends('layouts.apperance')

@section('title', $product->name)

@section('content')
<div class="card">
    <img src="{{ asset('storage/' . $product->main_image) }}" class="card-img-top" alt="{{ $product->name }}">
    <div class="card-body">
        <h3>{{ $product->name }}</h3>
        <p>{{ $product->description }}</p>
        <p><strong>Dilihat:</strong> {{ $product->visits }} kali</p>
    </div>
</div>
@endsection
