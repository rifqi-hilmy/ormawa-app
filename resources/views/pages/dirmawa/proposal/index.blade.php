@extends('layouts.app')

@section('title', 'Proposal')

@section('content')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h3 class="m-0">Pengajuan Proposal</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb" style="float: right;">
                <li class="breadcrumb-item">
                    <a href="{{ route('dirmawa.proposal.index') }}">Pengajuan Proposal</a>
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
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="verificationModal" tabindex="-1" role="dialog" aria-labelledby="verificationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verificationModalLabel">Verifikasi Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-verifikasi">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="status_dirmawa">Status Dirmawa</label>
                            <select class="form-control select2" id="status_dirmawa" name="status_dirmawa" required>
                                <option value=""></option>
                            </select>
                        </div>
                        <input type="hidden" id="id_proposal" name="id_proposal">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-success" id="verifikasi-status">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#filter-status-dosen, #filter-status-dirmawa').select2({
                theme: 'bootstrap-5',
                placeholder: 'Pilih Status',
                allowClear: true
            });

            var table = $('#table-proposal').DataTable({
                ajax: {
                    url: "{{ route('dirmawa.proposal.index') }}",
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
                    {
                        targets: 7,
                        width: '15%',
                        className: 'align-middle text-center',
                        render: function(data, type, row, meta) {
                            return `
                                <button class="btn btn-info btn-sm btn-confirm" type="button" data-id="${row.id}" data-status="${row.status_dirmawa}" data-bs-toggle="modal" data-bs-target="#verificationModal">
                                    <i class="bx bx-check-square"></i> Verifikasi
                                </button>`;
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

            $(document).on('click', '.btn-confirm', function() {
                const proposalId = $(this).data('id');
                $('#id_proposal').val(proposalId);
                $('#verificationModal').modal('show');
            });

            $('#verificationModal').on('shown.bs.modal', function() {
                $('#status_dirmawa').select2({
                    theme: 'bootstrap-5',
                    placeholder: 'Pilih Status',
                    allowClear: true,
                    dropdownParent: $('#verificationModal')
                });
            });

            $('#table-proposal').on('click', '.btn-confirm', function() {
                var statusDirmawa = $(this).data('status');
                var proposalId = $(this).data('id');

                $('#id_proposal').val(proposalId);

                var statusOptions = `
                    <option value="menunggu" ${statusDirmawa === 'menunggu' ? 'selected' : ''}>Menunggu</option>
                    <option value="diterima" ${statusDirmawa === 'diterima' ? 'selected' : ''}>Diterima</option>
                    <option value="ditolak" ${statusDirmawa === 'ditolak' ? 'selected' : ''}>Ditolak</option>
                `;

                $('#status_dirmawa').html(statusOptions);
            });

            $('#verifikasi-status').click(function() {
                var formData = $('#form-verifikasi').serialize();
                var proposalId = $('#id_proposal').val();
                var url = "{{ route('dirmawa.proposal.verifikasi', ':id') }}";

                $.ajax({
                    type: "POST",
                    url: url.replace(':id', proposalId),
                    data: formData,
                    success: function(response) {
                        $('#verificationModal').modal('hide');
                        Swal.hideLoading()
                        Swal.fire({
                            title: "Success!",
                            text: "Data berhasil disimpan",
                            icon: "success"
                        })
                        $('#table-proposal').DataTable().ajax.reload();
                    },
                    error: function(xhr, status, error) {
                        $('#verificationModal').modal('hide');
                        Swal.hideLoading()
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Gagal menyimpan data',
                            icon: 'error',
                        })
                    }
                });
            });

        });
    </script>
@endpush
