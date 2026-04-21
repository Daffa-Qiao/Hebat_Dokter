@extends('layouts.app')
@section('title', $menu->title)
@include('layouts.navbars.dashboardnav')
@section('content')
<div class="container py-5" style="background-color: white;">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h2 class="text-center" style="color: green;">{{ $menu->title }}</h2>
            <p class="text-muted">Kategori: {{ $menu->category ?? 'Umum' }}</p>
            <p class="text-muted">Spesialisasi: {{ $menu->specialization ?? 'Umum' }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <img src="{{ $menu->image ? asset('storage/' . $menu->image) : asset('img/logo.png') }}"
                 class="img-fluid rounded" alt="{{ $menu->title }}"
                 onerror="this.onerror=null;this.src='{{ asset('img/logo.png') }}' ">
        </div>
        <div class="col-md-6">
            <h4>Deskripsi</h4>
            <p>{{ $menu->description }}</p>

            <h4>Kalori</h4>
            <p>{{ $menu->calories ? $menu->calories . ' kkal' : 'Kalori belum diatur' }}</p>

            <h4>Resep</h4>
            <p>{{ $menu->recipe ?? 'Resep belum tersedia' }}</p>
            
            @if($menu->doctor)
                <h4>Disiapkan oleh</h4>
                <p>Dr. {{ $menu->doctor->name }}</p>
            @endif
        </div>
    </div>
</div>
@endsection