@extends('layouts.app')

@section('title', 'Mahasiswa')

@section('content')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h3 class="m-0">Mahasiswa</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb" style="float: right;">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.mahasiswa.index') }}">Mahasiswa</a>
                </li>
            </ol>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-end justify-content-between">
                    <div class="col-md-4 col-lg-3 mb-3 mb-md-4">
                        <div class="form-group">
                            <label for="filter-organisasi"><strong>Organisasi</strong></label>
                            <select id="filter-organisasi" class="form-control select2">
                                <option value="">Semua Organisasi</option>
                                @foreach ($organisasi as $org)
                                    <option value="{{ $org->id }}">{{ $org->nama_organisasi }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-5 mb-3 mb-md-4">
                        <div class="d-flex align-items-end justify-content-end">
                            <a href="{{ route('admin.mahasiswa.create') }}" class="btn btn-primary"><i
                                    class="bx bx-plus"></i>
                                Tambah Baru</a>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table-user-mahasiswa" class="table table-hover w-100">
                        <thead>
                            <tr class="text-center">
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Ormawa</th>
                                <th>Email</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
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
                placeholder: 'Pilih Organisasi',
                allowClear: true
            });

            var table = $('#table-user-mahasiswa').DataTable({
                ajax: {
                    url: "{{ route('admin.mahasiswa.index') }}",
                    type: "GET",
                    data: function(d) {
                        d.organisasi_id = $('#filter-organisasi').val();
                    }
                },
                ordering: false,
                processing: true,
                columns: [{
                        targets: 0,
                        className: 'align-middle',
                        data: 'mahasiswa.nim'
                    },
                    {
                        targets: 1,
                        className: 'align-middle',
                        data: 'name'
                    },
                    {
                        targets: 2,
                        className: 'align-middle',
                        data: 'mahasiswa.organisasi.nama_organisasi'
                    },
                    {
                        targets: 3,
                        className: 'align-middle',
                        data: 'email'
                    },
                    {
                        targets: 4,
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

            $('#table-user-mahasiswa tbody').on('click', '.btn-edit', function(event) {
                event.preventDefault();
                var data = table.row($(this).parents('tr')).data();

                var path = "{{ route('admin.mahasiswa.edit', ':slug') }}";
                var link = path.replace(':slug', data.id);

                location.href = link;
            });

            $('#table-user-mahasiswa tbody').on('click', '.btn-delete', function(event) {
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
                            url: "{{ route('admin.mahasiswa.destroy') }}",
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

            $('#filter-organisasi').change(function() {
                table.ajax.reload();
            });

        });
    </script>
@endpush
