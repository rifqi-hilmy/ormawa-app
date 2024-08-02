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
                                    <option value="{{ $org->id }}" {{ request('organisasi') == $org->id ? 'selected' : '' }}>{{ $org->nama_organisasi }}</option>
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
                            @foreach ($mahasiswa as $mhs )
                            <tr>
                                    <td>{{ $mhs->mahasiswa->nim }}</td>
                                    <td>{{ $mhs->name }}</td>
                                    <td>{{ $mhs->mahasiswa->organisasi->nama_organisasi }}</td>
                                    <td>{{ $mhs->email }}</td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle btn-sm" type="button"
                                                id="dropdownMenuButton{{ $mhs->id }}" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                Aksi
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $mhs->id }}">
                                                <li><a class="dropdown-item btn-edit" href="{{ route('admin.mahasiswa.edit', $mhs->id) }}"
                                                        data-id="{{ $mhs->id }}"><i class="bx bx-edit"></i> Edit</a></li>
                                                <li><a class="dropdown-item btn-delete" href=" #"
                                                        data-id="{{ $mhs->id }}"><i class="bx bx-trash"></i> Delete</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
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

            $('#table-user-mahasiswa').DataTable({
                "language": {
                            "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Indonesian.json"
                        }
            });

            $('#filter-organisasi').change(function() {
                var organisasiId = $(this).val();
                window.location.href = "{{ route('admin.mahasiswa.index') }}" + "?organisasi=" + organisasiId;
            });

            $('#table-user-mahasiswa tbody').on('click', '.btn-delete', function(event) {
                event.preventDefault();
                var mahasiswaId = $(this).data('id');

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
                                id: mahasiswaId,
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
                                }).then(function() {
                                    location.reload();
                                });
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

            // $('#filter-organisasi').change(function() {
            //     table.ajax.reload();
            // });

        });
    </script>
@endpush
