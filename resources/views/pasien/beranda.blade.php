@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Selamat Datang di Konsul-Dok</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-8">
                            <div class="alert alert-info" role="alert">
                                <h4 class="alert-heading">Layanan Konsultasi Dokter Online</h4>
                                <p>Temukan dokter terbaik untuk konsultasi kesehatan Anda. Kami menyediakan layanan konsultasi yang mudah dan terpercaya.</p>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="mb-4">Dokter yang Tersedia</h5>
                        </div>
                        @forelse($doctors as $doctor)
                        <div class="col-12 col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Dr. {{ $doctor->name }}</h5>
                                    <p class="card-text">
                                        <strong>Spesialisasi:</strong> {{ $doctor->specialization }}<br>
                                        <strong>Jadwal:</strong> {{ $doctor->schedule }}
                                    </p>
                                    <a href="{{ route('reservations.create', ['doctor' => $doctor->id]) }}" class="btn btn-primary">Buat Janji</a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="alert alert-warning">
                                Tidak ada dokter yang tersedia saat ini.
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 