@extends('layouts.app')

@section('title', 'Dosen')

@section('content')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h3 class="m-0">Dosen Pembimbing</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb" style="float: right;">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dosen.index') }}">Dosen Pembimbing</a>
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
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="nip">NIP<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nip" id="nip" required>
                            <span class="invalid-feedback">
                                <strong id="nip_msg"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="nidn">NIDN<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nidn" id="nidn" required>
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
                            <input type="text" class="form-control" name="name" id="name" required>
                            <span class="invalid-feedback">
                                <strong id="name_msg"></strong>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label for="id_prodi">Prodi<span class="text-danger">*</span></label>
                            <select class="form-control select2" name="id_prodi" id="id_prodi" required>
                                <option value="">Pilih Prodi</option>
                                @foreach ($prodi as $org)
                                    <option value="{{ $org->id }}">{{ $org->nama_prodi }}</option>
                                @endforeach

                            </select>
                            <span class="invalid-feedback">
                                <strong id="prodi_msg"></strong>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label for="email">Email<span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" id="email" required>
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
                            <input type="text" class="form-control" name="no_hp" id="no_hp" required>
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
                                        value="L" required>
                                    <label class="form-check-label" for="laki_laki">
                                        Laki-laki
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan"
                                        value="P" required>
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
                            <textarea class="form-control" name="alamat" id="alamat" rows="10"></textarea>
                            <span class="invalid-feedback">
                                <strong id="alamat_msg"></strong>
                            </span>
                        </div>
                    </div>
                </div>
        </div>
        <div class="card-footer" style="text-align: right;">
            <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-secondary mr-5"><i
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
            $('.select2').select2({
                theme: 'bootstrap-5',
                placeholder: 'Pilih Prodi',
                allowClear: true
            });

            $('#form-tambah').submit(function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.dosen.store') }}",
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
                            window.location = "{{ route('admin.dosen.index') }}";
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
