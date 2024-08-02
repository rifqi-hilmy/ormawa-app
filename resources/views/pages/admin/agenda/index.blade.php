@extends('layouts.app')

@section('title', 'Agenda')

@section('content')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h3 class="m-0">Agenda</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb" style="float: right;">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.agenda.index') }}">Agenda</a>
                </li>
            </ol>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-end">
                    <div class="col-md-4 mb-3 mb-md-4">
                        <div class="form-group">
                            <label for="filter-tanggal-mulai"><strong>Tanggal Mulai</strong></label>
                            <input type="date" id="filter-tanggal-mulai" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-4">
                        <div class="form-group">
                            <label for="filter-tanggal-selesai"><strong>Tanggal Selesai</strong></label>
                            <input type="date" id="filter-tanggal-selesai" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4 mb-3 mb-md-4">
                        <div class="d-flex align-items-end justify-content-end">
                            <a href="{{ route('admin.agenda.create') }}" class="btn btn-primary"><i
                                    class="bx bx-plus"></i>
                                Tambah Baru</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table-agenda" class="table table-hover w-100">
                        <thead>
                            <tr class="text-center">
                                <th>Agenda</th>
                                <th>Tanggal</th>
                                <th>Tempat</th>
                                <th>Waktu</th>
                                <th>Pembuat</th>
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
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                var startDate = $('#filter-tanggal-mulai').val();
                var endDate = $('#filter-tanggal-selesai').val();
                var tglMulai = data[1].split(' s/d ')[0];
                var tglSelesai = data[1].split(' s/d ')[1] || tglMulai;

                if (
                    (startDate === "" || tglMulai >= startDate) &&
                    (endDate === "" || tglSelesai <= endDate)
                ) {
                    return true;
                }
                return false;
            });

            var table = $('#table-agenda').DataTable({
                ajax: {
                    url: "{{ route('admin.agenda.index') }}",
                    type: "GET",
                },
                ordering: false,
                processing: true,
                columns: [{
                        targets: 0,
                        width: '15%',
                        className: 'align-middle',
                        data: 'nama_agenda'
                    },
                    {
                        targets: 1,
                        width: '20%',
                        className: 'align-middle',
                        render: function(data, type, row) {
                            return row.tgl_selesai ? row.tgl_mulai + ' s/d ' + row.tgl_selesai : row.tgl_mulai;
                        }
                    },
                    {
                        targets: 2,
                        className: 'align-middle',
                        data: 'tempat'
                    },
                    {
                        targets: 3,
                        width: '17%',
                        className: 'align-middle',
                        render: function(data, type, row) {
                            var jamMulai = row.jam_mulai.substring(0, 5);
                            var jamSelesai = row.jam_selesai ? row.jam_selesai.substring(0, 5) : null;
                            return jamSelesai ? jamMulai + ' - ' + jamSelesai : jamMulai;
                        }
                    },
                    {
                        targets: 4,
                        width: '10%',
                        className: 'align-middle',
                        data: 'user.name',
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

            $('#table-agenda tbody').on('click', '.btn-edit', function(event) {
                event.preventDefault();
                var data = table.row($(this).parents('tr')).data();

                var path = "{{ route('admin.agenda.edit', ':slug') }}";
                var link = path.replace(':slug', data.id);

                location.href = link;
            });

            $('#table-agenda tbody').on('click', '.btn-delete', function(event) {
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
                            url: "{{ route('admin.agenda.destroy') }}",
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

            $('#filter-tanggal-mulai, #filter-tanggal-selesai').change(function() {
                table.draw();
            });
        });
    </script>
@endpush
