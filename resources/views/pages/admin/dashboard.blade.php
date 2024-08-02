@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <i class="bx bx-check rounded text-bg-success" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                    <span class="fw-medium d-block mb-1">Proposal Diterima</span>
                    <h3 class="card-title mb-2">{{ $proposalDiterima }}</h3>
                    <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> {{ $proposalDiterima }}/{{ $totalProposals }}</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <i class="bx bx-loader rounded text-bg-warning" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                    <span class="fw-medium d-block mb-1">Proposal Menunggu</span>
                    <h3 class="card-title mb-2">{{ $proposalMenunggu }}</h3>
                    <small class="text-warning fw-medium"><i class="bx bx-up-arrow-alt"></i> {{ $proposalMenunggu }}/{{ $totalProposals }}</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <i class="bx bx-x rounded text-bg-danger" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                    <span class="fw-medium d-block mb-1">Proposal Ditolak</span>
                    <h3 class="card-title mb-2">{{ $proposalDitolak }}</h3>
                    <small class="text-danger fw-medium"><i class="bx bx-up-arrow-alt"></i> {{ $proposalDitolak }}/{{ $totalProposals }}</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <i class="bx bx-calendar-event rounded text-bg-info" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                    <span class="fw-medium d-block mb-1">Jumlah Agenda</span>
                    <h3 class="card-title mb-2">{{ $jumlahAgenda }}</h3>
                    <small class="text-info fw-medium"><i class="bx bx-up-arrow-alt"></i> {{ $jumlahAgenda }}</small>
                </div>
            </div>
        </div>
    </div>
@endsection
