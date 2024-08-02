@extends('layouts.app')

@section('title', 'Proposal')

@section('content')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h3 class="m-0">Arsip Proposal</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb" style="float: right;">
                <li class="breadcrumb-item">
                    <a href="{{ route('mahasiswa.proposal.index') }}"><i class="mdi mdi-arrow-split-vertical:"></i>Arsip Proposal</a>
                </li>
            </ol>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-end">
                    <div class="col-md-3 mb-3 mb-md-4">
                        <div class="form-group">
                            <label for="filter-status-dosen"><strong>Status Dosen</strong></label>
                            <select class="form-control select2" id="filter-status-dosen">
                                <option value="">Pilih Status</option>
                                <option value="diterima">Diterima</option>
                                <option value="menunggu">Menunggu</option>
                                <option value="ditolak">Ditolak</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-4">
                        <div class="form-group">
                            <label for="filter-status-dirmawa"><strong>Status Dirmawa</strong></label>
                            <select class="form-control select2" id="filter-status-dirmawa">
                                <option value="">Pilih Status</option>
                                <option value="diterima">Diterima</option>
                                <option value="menunggu">Menunggu</option>
                                <option value="ditolak">Ditolak</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-4">
                        <div class="form-group">
                            <label for="filter-tgl-kegiatan"><strong>Tanggal Kegiatan</strong></label>
                            <input type="date" class="form-control" id="filter-tgl-kegiatan">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table-proposal" class="table table-hover w-100">
                        <thead>
                            <tr class="text-center">
                                <th>Judul</th>
                                <th>Tanggal Kegiatan</th>
                                <th>Surat Pengantar</th>
                                <th>File Proposal</th>
                                <th>Lampiran</th>
                                <th>Status Pembimbing</th>
                                <th>Status Dirmawa</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap-5',
                placeholder: 'Pilih Status',
                allowClear: true
            });

            var table = $('#table-proposal').DataTable({
                ajax: {
                    url: "{{ route('mahasiswa.proposal.arsip') }}",
                    type: "GET",
                    data: function (d) {
                        d.status_dosen = $('#filter-status-dosen').val();
                        d.status_dirmawa = $('#filter-status-dirmawa').val();
                        d.tgl_kegiatan = $('#filter-tgl-kegiatan').val();
                    }
                },
                ordering: false,
                processing: true,
                columns: [{
                        targets: 0,
                        className: 'align-middle',
                        data: 'judul'
                    },
                    {
                        targets: 1,
                        className: 'align-middle',
                        data: 'tgl_kegiatan'
                    },
                    {
                        targets: 2,
                        width: '10%',
                        className: 'align-middle',
                        render: function(data, type, row, meta) {
                            return row.surat_pengantar_url ? `<a href="${row.surat_pengantar_url}" target="_blank"><i class="bx bxs-download"></i> Unduh</a>` : '<span class="badge bg-info">Belum Unggah</span>';
                        }
                    },
                    {
                        targets: 3,
                        width: '10%',
                        className: 'align-middle',
                        render: function(data, type, row, meta) {
                            return row.file_proposal_url ? `<a href="${row.file_proposal_url}" target="_blank"><i class="bx bxs-download"></i> Unduh</a>` : '<span class="badge bg-info">Belum Unggah</span>';
                        }
                    },
                    {
                        targets: 4,
                        width: '10%',
                        className: 'align-middle',
                        render: function(data, type, row, meta) {
                            return row.lampiran_proposal_url ? `<a href="${row.lampiran_proposal_url}" target="_blank"><i class="bx bxs-download"></i> Unduh</a>` : '<span class="badge bg-info">Belum Unggah</span>';
                        }
                    },
                    {
                        targets: 5,
                        width: '10%',
                        className: 'align-middle',
                        render: function(data, type, row, meta) {
                            let statusClass = 'warning';
                            let statusText = 'Menunggu';

                            if (row.status_dosen === 'diterima') {
                                statusClass = 'success';
                                statusText = 'Diterima';
                            } else if (row.status_dosen === 'ditolak') {
                                statusClass = 'danger';
                                statusText = 'Ditolak';
                            }

                            return `<span class="badge bg-${statusClass}">${statusText}</span>`;
                        }
                    },
                    {
                        targets: 6,
                        width: '10%',
                        className: 'align-middle',
                        render: function(data, type, row, meta) {
                            let statusClass = 'warning';
                            let statusText = 'Menunggu';

                            if (row.status_dirmawa === 'diterima') {
                                statusClass = 'success';
                                statusText = 'Diterima';
                            } else if (row.status_dirmawa === 'ditolak') {
                                statusClass = 'danger';
                                statusText = 'Ditolak';
                            }

                            return `<span class="badge bg-${statusClass}">${statusText}</span>`;
                        }
                    },
                ],
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Indonesian-Alternative.json"
                }
            });

            $('#filter-status-dosen, #filter-status-dirmawa, #filter-tgl-kegiatan').change(function() {
                table.ajax.reload();
            });

        });
    </script>
@endpush
