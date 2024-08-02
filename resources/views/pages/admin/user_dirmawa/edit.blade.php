@extends('layouts.app')

@section('title', 'Dirmawa')

@section('content')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h3 class="m-0">Dirmawa</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb" style="float: right;">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dosen.index') }}">Dirmawa</a>
                <li class="breadcrumb-item active">Ubah</li>
                </li>
            </ol>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form id="form-edit" class="mt-3">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="nip">NIP<span class="text-danger">*</span></label>
                            <input type="hidden" name="id" id="id" value="{{ $dirmawa->id }}">
                            <input type="text" class="form-control" name="nip" id="nip"
                                value="{{ $dirmawa->dirmawa->nip }}" required>
                            <span class="invalid-feedback">
                                <strong id="nip_msg"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="nidn">NIDN<span class="text-danger">*</span></label>
                            <input type="hidden" name="id" id="id" value="{{ $dirmawa->id }}">
                            <input type="text" class="form-control" name="nidn" id="nidn"
                                value="{{ $dirmawa->dirmawa->nidn }}" required>
                            <span class="invalid-feedback">
                                <strong id="nidn_msg"></strong>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label for="name">Nama<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" id="name"
                                value="{{ $dirmawa->name }}" required>
                            <span class="invalid-feedback">
                                <strong id="name_msg"></strong>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label for="email">Email<span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" id="email"
                                value="{{ $dirmawa->email }}" required>
                            <span class="invalid-feedback">
                                <strong id="email_msg"></strong>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="no_hp">Nomor Telepon<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="no_hp" id="no_hp"
                                value="{{ $dirmawa->dirmawa->no_hp }}" required>
                            <span class="invalid-feedback">
                                <strong id="no_hp_msg"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="jenis_kelamin">Jenis Kelamin<span class="text-danger">*</span></label>
                            <div class="d-flex mt-2">
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki_laki"
                                        value="L" {{ $dirmawa->dirmawa->jenis_kelamin === 'L' ? 'checked' : '' }}
                                        required>
                                    <label class="form-check-label" for="laki_laki">
                                        Laki-laki
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan"
                                        value="P" {{ $dirmawa->dirmawa->jenis_kelamin === 'P' ? 'checked' : '' }}
                                        required>
                                    <label class="form-check-label" for="perempuan">
                                        Perempuan
                                    </label>
                                </div>
                                <span class="invalid-feedback">
                                    <strong id="jenis_kelamin_msg"></strong>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label for="alamat">Alamat<span class="text-danger">*</span></label>
                            <textarea class="form-control" name="alamat" id="alamat" rows="10">{{ $dirmawa->dirmawa->alamat }}</textarea>
                            <span class="invalid-feedback">
                                <strong id="alamat_msg"></strong>
                            </span>
                        </div>
                    </div>
                </div>
        </div>
        <div class="card-footer" style="text-align: right;">
            <a href="{{ route('admin.dirmawa.index') }}" class="btn btn-secondary mr-5"><i
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
            $('#form-edit').submit(function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                var id = $('#id').val();

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.dirmawa.update', ':id') }}".replace(':id', id),
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
                            window.location = "{{ route('admin.dirmawa.index') }}";
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
