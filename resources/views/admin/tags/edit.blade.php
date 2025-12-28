@extends('layouts.app')

@section('content')
    <div class="col-lg-6 mx-auto my-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h1 class="h5 mb-0">Edit Kategori</h1>
                    <a href="{{ route('admin.tags.index') }}" class="text-secondary small text-decoration-none">Kembali</a>
                </div>

                <form action="{{ route('admin.tags.update', $tag) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label small">Nama Kategori</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $tag->name) }}" placeholder="Masukkan nama kategori..." autofocus>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('admin.tags.index') }}" class="btn btn-light btn-sm text-secondary">Batal</a>
                        <button type="submit" class="btn btn-gradient-orange btn-sm">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
