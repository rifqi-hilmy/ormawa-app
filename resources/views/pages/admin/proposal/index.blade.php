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
                    <a href="{{ route('admin.proposal.index') }}">Pengajuan Proposal</a>
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

                    <div class="col-md-6 col-lg-3 mb-3 mb-md-4">
                        <div class="d-flex align-items-end justify-content-end">
                            <a href="{{ route('admin.proposal.create') }}" class="btn btn-primary"><i
                                    class="bx bx-plus"></i>
                                Tambah Baru</a>
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
                    url: "{{ route('admin.proposal.index') }}",
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
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton${row.id}" data-bs-toggle="dropdown" aria-expanded="false">
                                    Aksi
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton${row.id}">
                                    <li><a class="dropdown-item btn-edit" href="#" data-id="${row.id}"><i class="bx bx-edit"></i> Edit</a></li>
                                    <li><a class="dropdown-item btn-delete" href="#" data-id="${row.id}"><i class="bx bx-trash"></i> Delete</a></li>
                                </ul>
                            </div>`;
                        }
                    },
                ],
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Indonesian-Alternative.json"
                }
            });

            $('#table-proposal tbody').on('click', '.btn-edit', function(event) {
                event.preventDefault();
                var data = table.row($(this).parents('tr')).data();

                var path = "{{ route('admin.proposal.edit', ':slug') }}";
                var link = path.replace(':slug', data.id);

                location.href = link;
            });

            $('#table-proposal tbody').on('click', '.btn-delete', function(event) {
                event.preventDefault();
                var data = table.row($(this).parents('tr')).data();

                Swal.fire({
                    title: 'Apakah anda yakin ingin menghapus data?',
                    text: '',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus data!',
                    cancelButtonText: 'Tidak',
                    customClass: {
                        confirmButton: 'btn btn-danger',
                        cancelButton: 'btn btn-secondary'
                    },
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('admin.proposal.destroy') }}",
                            data: {
                                id: data.id,
                                _token: "{{ csrf_token() }}"
                            },
                            dataType: "JSON",
                            beforeSend: function() {
                                Swal.showLoading();
                            },
                            success: function(response) {
                                Swal.hideLoading();

                                Swal.fire({
                                    title: 'Sukses!',
                                    text: response.meta.message,
                                    icon: 'success',
                                });

                                table.ajax.reload();
                            },
                            error: function(xhr, status, error) {
                                Swal.hideLoading();

                                var response = xhr.responseJSON;

                                Swal.fire({
                                    title: 'Gagal!',
                                    text: response.meta.message,
                                    icon: 'error',
                                });

                                if (response.data) {
                                    $.each(response.data, function(i, v) {
                                        $("#" + i + "_msg").html(v);
                                        $(`[id='${i}']`).addClass("is-invalid");
                                    });
                                }
                            }
                        });
                    }
                });
            });

            $('#filter-status-dosen, #filter-status-dirmawa, #filter-tgl-kegiatan').change(function() {
                table.ajax.reload();
            });

        });
    </script>
@endpush
