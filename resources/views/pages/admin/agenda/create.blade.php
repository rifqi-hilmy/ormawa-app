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
                <li class="breadcrumb-item active">Tambah</li>
                </li>
            </ol>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form id="form-tambah" class="mt-3">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label for="nama_agenda">Agenda<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama_agenda" id="nama_agenda" required>
                            <span class="invalid-feedback">
                                <strong id="nama_agenda_msg"></strong>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="tgl_mulai">Tanggal Mulai<span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="tgl_mulai" id="tgl_mulai" required>
                            <span class="invalid-feedback">
                                <strong id="tgl_mulai_msg"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="tgl_selesai">Tanggal Selesai</label>
                            <input type="date" class="form-control" name="tgl_selesai" id="tgl_selesai">
                            <span class="invalid-feedback">
                                <strong id="tgl_selesai_msg"></strong>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label for="tempat">Tempat<span class="text-danger">*</span></label>
                            <textarea class="form-control" name="tempat" id="tempat" rows="3"></textarea>
                            <span class="invalid-feedback">
                                <strong id="tempat_msg"></strong>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="jam_mulai">Jam Mulai<span class="text-danger">*</span></label>
                            <input type="time" class="form-control" name="jam_mulai" id="jam_mulai" required>
                            <span class="invalid-feedback">
                                <strong id="jam_mulai_msg"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="jam_selesai">Jam Selesai</label>
                            <input type="time" class="form-control" name="jam_selesai" id="jam_selesai">
                            <span class="invalid-feedback">
                                <strong id="jam_selesai_msg"></strong>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" name="keterangan" id="keterangan" rows="10"></textarea>
                            <span class="invalid-feedback">
                                <strong id="keterangan_msg"></strong>
                            </span>
                        </div>
                    </div>
                </div>
        </div>
        <div class="card-footer" style="text-align: right;">
            <a href="{{ route('admin.agenda.index') }}" class="btn btn-secondary mr-5"><i
                    class="bx bx-arrow-back"></i>
                Kembali</a>
            <button type="submit" class="btn btn-success align-middle"> <i class="bx bx-paper-plane"></i>
                Simpan</button>
        </div>
        </form>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#form-tambah').submit(function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                console.log(formData);
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.agenda.store') }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "JSON",
                    beforeSend: function() {
                        Swal.showLoading()
                    },
                    success: function(response) {
                        Swal.hideLoading()
                        Swal.fire({
                            title: "Success!",
                            text: "Data berhasil disimpan",
                            icon: "success"
                        }).then(function() {
                            window.location = "{{ route('admin.agenda.index') }}";
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.hideLoading()
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Gagal menyimpan data',
                            icon: 'error',
                        })
                        $.each(xhr.responseJSON.data, function(i, v) {
                            $("#" + i + "_msg").html(v);
                            $(`[id='${i}']`).addClass("is-invalid");
                        });
                    }
                });
            });
        });
    </script>
@endpush
