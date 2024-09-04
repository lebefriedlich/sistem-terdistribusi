@extends('partials.app')

@section('title', 'Dashboard - Kendaraan')

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
    <h1 class="h3 mb-2 text-gray-800">Dashboard</h1>
    <!-- Data Reservasi Hotel -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Reservasi Hotel</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Customer</th>
                            <th>Nomer Telepon</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Tipe Kamar</th>
                            <th>Nomer Kamar</th>
                            <th>Total Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservasiHotel->data as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->user->name }}</td>
                                <td>{{ $data->user->phone }}</td>
                                <td>{{ $data->check_in }}</td>
                                <td>{{ $data->check_out }}</td>
                                <td>{{ $data->room->category->name }}</td>
                                <td>{{ $data->room->room_number }}</td>
                                <td>{{ 'Rp' . number_format($data->total_price, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        @if ($data->status == 'paid')
                                            <button class="btn btn-info" data-toggle="modal" style="margin-right: 20px"
                                                data-target="#CheckInModal{{ $data->id }}">
                                                Check In</button>

                                            <div class="modal fade" id="CheckInModal{{ $data->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Check In</h5>
                                                            <button class="close" type="button" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-left">Apakah Pelanggan sudah melakukan
                                                            Check In</div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-secondary" type="button"
                                                                data-dismiss="modal">Belum</button>

                                                            <form action="{{ route('hotel.checkin', $data->id) }}"
                                                                method="post">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="btn btn-primary">Sudah</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif ($data->status == 'checked_in')
                                            <button class="btn btn-secondary" data-toggle="modal" style="margin-right: 20px"
                                                data-target="#CheckOutModal{{ $data->id }}">
                                                Check Out</button>
                                            <div class="modal fade" id="CheckOutModal{{ $data->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Check Out</h5>
                                                            <button class="close" type="button" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-left">Apakah Pelanggan sudah melakukan
                                                            Check Out</div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-secondary" type="button"
                                                                data-dismiss="modal">Belum</button>
                                                            <form action="{{ route('hotel.checkout', $data->id) }}"
                                                                method="post">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="btn btn-primary">Sudah</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif ($data->status == 'checked_out')
                                            <button class="btn btn-dark" disabled>Check Out</button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Data Sewa Kendaraan --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Penyewaan Kendaraan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Customer</th>
                            <th>Nomer Telepon</th>
                            <th>Mulai Sewa</th>
                            <th>Selesai Sewa</th>
                            <th>Unit</th>
                            <th>Plat Nomer</th>
                            <th>Total Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rentalVehicle->data as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->customer->name }}</td>
                                <td>{{ $data->customer->phone }}</td>
                                <td>{{ $data->start_date }}</td>
                                <td>{{ $data->end_date }}</td>
                                <td>{{ $data->vehicle->category->name }}</td>
                                <td>{{ $data->vehicle->plate_number }}</td>
                                <td>{{ 'Rp' . number_format($data->total_price, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        @if ($data->status == 'paid')
                                            <button class="btn btn-info" data-toggle="modal" style="margin-right: 20px"
                                                data-target="#start-rent{{ $data->id }}">
                                                Unit Diambil</button>

                                            <div class="modal fade" id="start-rent{{ $data->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Start Rent</h5>
                                                            <button class="close" type="button" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-left">Apakah Pelanggan sudah mengambil
                                                            unit?</div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-secondary" type="button"
                                                                data-dismiss="modal">Belum</button>
                                                            <form action="{{ route('vehicle.start-rent', $data->id) }}"
                                                                method="post">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="btn btn-primary">Sudah</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif ($data->status == 'started')
                                            <button class="btn btn-secondary" data-toggle="modal"
                                                style="margin-right: 20px"
                                                data-target="#end-rent{{ $data->id }}">
                                                Sudah Dikembalikan</button>

                                            <div class="modal fade" id="end-rent{{ $data->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">End Rent</h5>
                                                            <button class="close" type="button" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-left">Apakah Pelanggan sudah
                                                            mengembalikan unit</div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-secondary" type="button"
                                                                data-dismiss="modal">Belum</button>
                                                            <form action="{{ route('vehicle.end-rent', $data->id) }}"
                                                                method="post">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="btn btn-primary">Sudah</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif ($data->status == 'finished')
                                            <button class="btn btn-dark" disabled>Selesai</button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
