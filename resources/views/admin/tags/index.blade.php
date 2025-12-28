@extends('layouts.app')

@section('content')
    <div class="col-lg-10 col-xl-8 mx-auto my-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h1 class="h5 mb-0">Kelola Kategori</h1>
                    <a href="{{ route('admin.tags.create') }}" class="btn btn-sm btn-gradient-orange">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
                    </a>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="w-25">Nama Kategori</th>
                                <th scope="col" class="w-25">Slug</th>
                                <th scope="col" class="w-25">Jumlah Resep</th>
                                <th scope="col" class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tags as $tag)
                                <tr>
                                    <td class="fw-bold">{{ $tag->name }}</td>
                                    <td class="text-muted small">{{ $tag->slug }}</td>
                                    <td>
                                        <span class="badge bg-secondary-subtle text-secondary rounded-pill">
                                            {{ $tag->recipes_count ?? 0 }} Resep
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('admin.tags.edit', $tag) }}" class="btn btn-sm btn-outline-secondary">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="bi bi-tags display-6 d-block mb-3 opacity-50"></i>
                                        Belum ada kategori yang ditambahkan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $tags->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
