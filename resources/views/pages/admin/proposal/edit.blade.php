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
                <li class="breadcrumb-item active">Ubah</li>
                </li>
            </ol>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form id="form-edit" class="mt-3" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label for="judul">Judul Proposal<span class="text-danger">*</span></label>
                            <input type="hidden" name="id" id="id" value="{{ $proposal->id }}">
                            <input type="text" class="form-control" name="judul" id="judul" value="{{ $proposal->judul }}" required>
                            <span class="invalid-feedback">
                                <strong id="judul_msg"></strong>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="tgl_kegiatan">Tanggal Kegiatan<span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="tgl_kegiatan" id="tgl_kegiatan" value="{{ $proposal->tgl_kegiatan }}" required>
                            <span class="invalid-feedback">
                                <strong id="tgl_kegiatan_msg"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="surat_pengantar">Surat Pengantar</label>
                            <input type="file" class="form-control" name="surat_pengantar" id="surat_pengantar">
                            @if ($proposal->surat_pengantar)
                                <a href="{{ asset('storage/' . $proposal->surat_pengantar) }}" target="_blank">Download Current</a>
                            @endif
                            <span class="invalid-feedback">
                                <strong id="surat_pengantar_msg"></strong>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="file_proposal">File Proposal</label>
                            <input type="file" class="form-control" name="file_proposal" id="file_proposal">
                            @if ($proposal->file_proposal)
                                <a href="{{ asset('storage/' . $proposal->file_proposal) }}" target="_blank">Download Current</a>
                            @endif
                            <span class="invalid-feedback">
                                <strong id="file_proposal_msg"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="lampiran_proposal">Lampiran Proposal</label>
                            <input type="file" class="form-control" name="lampiran_proposal" id="lampiran_proposal">
                            @if ($proposal->lampiran_proposal)
                                <a href="{{ asset('storage/' . $proposal->lampiran_proposal) }}" target="_blank">Download Current</a>
                            @endif
                            <span class="invalid-feedback">
                                <strong id="lampiran_proposal_msg"></strong>
                            </span>
                        </div>
                    </div>
                </div>
        </div>
        <div class="card-footer" style="text-align: right;">
            <a href="{{ route('admin.proposal.index') }}" class="btn btn-secondary mr-5"><i
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
                    url: "{{ route('admin.proposal.update', ':id') }}".replace(':id', id),
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
                            window.location = "{{ route('admin.proposal.index') }}";
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
