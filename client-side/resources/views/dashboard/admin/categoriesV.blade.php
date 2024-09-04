@extends('partials.app')

@section('title', 'Dashboard - Kategori Kendaraan')

@section('content')
    @if ($errors->any())
        <div class="position-fixed" style="top: 100px; right: 20px; z-index: 1050;">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ $errors->first('api') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif

    @if (session('success'))
        <div class="position-fixed" style="top: 100px; right: 20px; z-index: 1050;">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session('success') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Kategori Kendaraan</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Kategori Kendaraan</h6>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-end mb-3">
                <button class="btn btn-primary" data-toggle="modal" data-target="#TambahModel"><i
                        class="bi bi-plus-circle"></i>
                    Tambah Kategori Kendaraan</button>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Tipe</th>
                            <th>Gambar</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories->data as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->name }}</td>
                                <td>
                                    @if ($data->type == 'car')
                                        {{ 'Mobil' }}
                                    @elseif ($data->type == 'motorcycle')
                                        {{ 'Sepeda Motor' }}
                                    @endif
                                </td>
                                <td><img src="{{ 'http://127.0.0.1:8001/storage/' . $data->image }}"
                                        alt="{{ $data->name }}" width="150px"></td>
                                <td>{{ $data->description }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <button class="btn btn-success" data-toggle="modal" style="margin-right: 20px"
                                            data-target="#EditModal{{ $data->id }}"><i class="bi bi-pencil-square"></i>
                                            Edit</button>
                                        <button class="btn btn-danger" data-toggle="modal"
                                            data-target="#HapusModal{{ $data->id }}"><i class="bi bi-trash3"></i>
                                            Hapus</button>
                                    </div>
                                </td>

                                <div class="modal fade" id="HapusModal{{ $data->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Kategori Kamar</h5>
                                                <button class="close" type="button" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body text-left">Apakah anda yakin menghapus kategori tersebut?
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button"
                                                    data-dismiss="modal">Tidak</button>
                                                <a href="{{ route('categoriesV.delete', $data->id) }}"
                                                    class="btn btn-danger">Iya</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="EditModal{{ $data->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit Kategori</h5>
                                                <button class="close" type="button" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('categoriesV.edit', $data->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="name">Nama Kategori</label>
                                                        <input type="text" class="form-control" id="name"
                                                            name="name" value="{{ $data->name }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="type">Tipe</label>
                                                        <select class="form-control" id="type" name="type" required>
                                                            <option value="car" {{ $data->type == 'car' ? 'selected' : '' }}>Mobil</option>
                                                            <option value="motorcycle" {{ $data->type == 'motorcycle' ? 'selected' : '' }}>Sepeda Motor</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="image">Gambar</label>
                                                        <input type="file" class="form-control" id="image" name="image">
                                                    <div class="form-group">
                                                        <label for="description">Deskripsi</label>
                                                        <textarea class="form-control" id="description" name="description">{{ $data->description }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" type="button"
                                                        data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Edit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="TambahModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori Kendaraan</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('categoriesV.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nama Kategori</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="type">Tipe</label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="car">Mobil</option>
                                <option value="motorcycle">Sepeda Motor</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="image">Gambar</label>
                            <input type="file" class="form-control" id="image" name="image" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
