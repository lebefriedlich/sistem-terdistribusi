  <!DOCTYPE html>
  <html lang="en">

  <head>
      <meta charset="UTF-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <link rel="icon" type="image/x-icon" href="/img/logo.png">
      <title>Rove Inn</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
      <link rel="stylesheet" href="{{ asset('css/styles.css') }}" />
  </head>

  <body>
      <header class="bg-white text-black py-3 sticky-top">
          <div class="container-fluid d-flex justify-content-between align-items-center">
              <a href="/" class="logo">
                  <img src="{{ asset('img/Rove_Inn.png') }}" alt="Rove Inn" class="w-25" />
              </a>
              <ul class="nav mx-auto mb-2 d-flex justify-content-center mb-md-0">
                  <li class="nav-item"><a href="#home" class="nav-link text-black fs-5">Home</a></li>
                  <li class="nav-item"><a href="#rooms_reservation" class="nav-link text-black fs-5">Rooms &
                          Reservations</a></li>
                  <li class="nav-item"><a href="#vehicle_rental" class="nav-link text-black fs-5">Vehicle Rental</a>
                  </li>
              </ul>
              @if (Auth::check())
                  <div class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                          role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          <div class="user-info me-2">
                              <div class="user-name text-dark">{{ Auth::user()->name }}</div>
                              <div class="user-role text-muted">{{ Auth::user()->role }}</div>
                          </div>
                          <img class="img-profile rounded-circle" src="img/undraw_profile.svg" alt="Profile Image">
                      </a>
                      <div class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                          <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                              <i class="fas fa-sign-out-alt fa-sm me-2 text-muted"></i>
                              Keluar
                          </a>
                      </div>
                  </div>
              @else
                  <div class="text-end">
                      <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Login</a>
                      <a href="{{ route('register.index') }}" class="btn btn-primary">Register</a>
                  </div>
              @endif
          </div>
      </header>

      @if (session('error'))
          <div class="position-fixed" style="top: 100px; right: 20px; z-index: 1050;">
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>{{ session('error') }}</strong>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
          </div>
      @endif

      @if (session('success'))
          <div class="position-fixed" style="top: 100px; right: 20px; z-index: 1050;">
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong>{{ session('success') }}</strong>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
          </div>
      @endif

      <div id="home"></div>

      <section class="hero text-center text-white d-flex align-items-center"
          style="
          background: url('{{ asset('img/hotel.jpeg') }}') no-repeat center center/cover;
          height: 95vh;
        ">
          <div class="container">
              <h1 style="font-size: 100px">Welcome to Rove Inn</h1>
              <p style="font-size: 25px">
                  Enjoy your stay with our exclusive room and vehicle rental services.
              </p>
              <a href="#rooms_reservation" class="btn btn-warning btn-lg mt-3">Book Now</a>
          </div>
      </section>

      <div id="rooms_reservation"></div>
      <section class="mt-5">
          <div class="container">
              <h1 class="text-center mb-5" style="font-size: 100px">Rooms & Reservation</h1>
              <div class="box">
                  <div class="row mb-5 pb-5">
                      <div class="col-md-6">
                          <img id="imagePreviewRoom" src="" alt="Room"
                              style="display: none; width: 350px; height: 300px" />
                      </div>
                      <div class="col-md-6">
                          <h3>Room Reservation</h3>
                          <form method="POST" action="{{ route('booking.hotel') }}">
                              @csrf
                              <div class="mb-3">
                                  <label for="checkin" class="form-label">Check-in:</label>
                                  <input type="date" class="form-control" id="checkin" name="check_in" required />
                              </div>
                              <div class="mb-3">
                                  <label for="checkout" class="form-label">Check-out:</label>
                                  <input type="date" class="form-control" id="checkout" name="check_out"
                                      required />
                              </div>
                              <div class="mb-3">
                                  <label for="room" class="form-label">Kategori Kamar:</label>
                                  <select id="room" class="form-select" name="room" required>
                                      <option value="empty">Pilih Kategori Kamar</option>
                                      @foreach ($categoriesHotel->data as $room)
                                          <option value="{{ $room->id }}">{{ $room->name }}</option>
                                      @endforeach
                                  </select>
                              </div>
                              <button id="checkAvailable" class="btn btn-primary w-100">Cek Kamar Kosong</button>
                              <div id="nextReservation" style="display: none">
                                  <div id="numberRoom" class="mb-3">
                                      <label for="number" class="form-label">Nomor Kamar:</label>
                                      <select id="roomDropdown" class="form-select" name="room_id" required>
                                          <option value="">Pilih Kamar</option>
                                      </select>
                                  </div>
                                  <div class="mb-3">
                                      <p id="harga"></p>
                                      <input type="hidden" name="total_price" id="price">
                                  </div>
                                  <button type="submit" class="btn btn-primary w-100">
                                      Bayar
                                  </button>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
      </section>

      <div id="vehicle_rental"></div>
      <section class="mt-5 mb-5">
          <div class="container">
              <h1 class="text-center mb-5" style="font-size: 100px">Vehicle Rental</h1>
              <div class="box">
                  <div class="row mb-5 pb-5">
                      <div class="col-md-6">
                          <h3>Vehicle Rental</h3>
                          <form action="{{ route('booking.vehicle') }}" method="post">
                              @csrf
                              <div class="mb-3">
                                  <label for="start" class="form-label">Start Rental:</label>
                                  <input type="date" class="form-control" id="start" name="start_date"
                                      required />
                              </div>
                              <div class="mb-3">
                                  <label for="finish" class="form-label">Finish Rental:</label>
                                  <input type="date" class="form-control" id="finish" name="end_date"
                                      required />
                              </div>
                              <div id="numberVehicle" class="mb-3">
                                  <label for="number" class="form-label">Unit:</label>
                                  <select id="vehicle" class="form-select" name="vehicle" required>
                                      <option value="empty">Pilih Kendaraan</option>
                                      @foreach ($categoriesVehicle->data as $vehicle)
                                          <option value="{{ $vehicle->id }}">{{ $vehicle->name }}</option>
                                      @endforeach
                                  </select>
                              </div>
                              <button id="checkAvailable1" class="btn btn-primary w-100">Cek Unit Kosong</button>
                              <div id="nextReservation1" style="display: none">
                                  <div id="numberPlate" class="mb-3">
                                      <label for="number" class="form-label">Plat Nomor:</label>
                                      <select id="plateDropdown" class="form-select" name="vehicle_id" required>
                                          <option value="">Pilih Plat Nomor</option>
                                      </select>
                                  </div>
                                  <div class="mb-3">
                                      <p id="priceV"></p>
                                      <input type="hidden" name="total_price" id="priceVehicle">
                                  </div>
                                  <button type="submit" class="btn btn-primary w-100">
                                      Bayar
                                  </button>
                              </div>
                          </form>
                      </div>
                      <div class="col-md-6">
                          <img id="imagePreviewVehicle" src="" alt="Vehicle"
                              style="display: none; width: 350px; height: 300px" />
                      </div>
                  </div>
              </div>
          </div>
      </section>

      <footer class="bg-dark text-white py-3 text-center">
          <div class="container">
              <p>© 2024 Rove Inn. All rights reserved.</p>
          </div>
      </footer>

      <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
          aria-hidden="true">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Keluar</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">Apakah anda ingin keluar?</div>
                  <div class="modal-footer">
                      <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
                      <form action="{{ route('logout-admin') }}" method="post">
                          @csrf
                          <button class="btn btn-primary" type="submit">Keluar</button>
                      </form>
                  </div>
              </div>
          </div>
      </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
      <script>
          const roomData = @json($categoriesHotel->data);
          const vehicleData = @json($categoriesVehicle->data);
          let rooms = [];
          let vehicles = [];
          let selectedPrice = 0;
          let selectedPriceVehicle = 0;

          document.getElementById('checkAvailable').addEventListener('click', function() {
              let checkin = document.getElementById('checkin').value;
              let checkout = document.getElementById('checkout').value;
              let room = document.getElementById('room').value;

              if (checkin && checkout && room) {
                  fetch(`http://127.0.0.1:8000/api/available-hotel/${room}/${checkin}/${checkout}`)
                      .then(response => response.json())
                      .then(data => {
                          rooms = data.data;
                          populateDropdown(data.data);
                          document.getElementById('nextReservation').style.display = 'block';
                          this.style.display = 'none';
                      })
                      .catch(error => {
                          console.error('Error fetching available room:', error);
                      });
              }
          });

          document.getElementById('checkAvailable1').addEventListener('click', function() {
              let start = document.getElementById('start').value;
              let finish = document.getElementById('finish').value;
              let vehicle = document.getElementById('vehicle').value;

              if (start && finish && vehicle) {
                  fetch(`http://127.0.0.1:8001/api/available-vehicle/${vehicle}/${start}/${finish}`)
                      .then(response => response.json())
                      .then(data => {
                          vehicles = data.data;
                          populateDropdownVehicle(data.data);
                          document.getElementById('nextReservation1').style.display = 'block';
                          this.style.display = 'none';
                      })
                      .catch(error => {
                          console.error('Error fetching available vehicle:', error);
                      });
              }
          });

          document.getElementById('room').addEventListener('change', function() {
              if (this.value === 'empty') {
                  document.getElementById('imagePreviewRoom').style.display = 'none';
                  return;
              }

              let selectedId = parseInt(this.value);

              let imageName = roomData.find(room => room.id === selectedId).image;
              document.getElementById('imagePreviewRoom').src = 'http://127.0.0.1:8000/storage/' + imageName;
              document.getElementById('imagePreviewRoom').style.display = 'block';
              document.getElementById('nextReservation').style.display = 'none';
              document.getElementById('checkAvailable').style.display = 'block';
          });

          document.getElementById('vehicle').addEventListener('change', function() {
              if (this.value === 'empty') {
                  document.getElementById('imagePreviewVehicle').style.display = 'none';
                  return;
              }

              let selectedId = parseInt(this.value);

              let imageName = vehicleData.find(vehicle => vehicle.id === selectedId).image;
              document.getElementById('imagePreviewVehicle').src = 'http://127.0.0.1:8001/storage/' + imageName;
              document.getElementById('imagePreviewVehicle').style.display = 'block';
              document.getElementById('nextReservation1').style.display = 'none';
              document.getElementById('checkAvailable1').style.display = 'block';
          });

          function populateDropdown(rooms) {
              let dropdown = document.getElementById('roomDropdown');
              dropdown.innerHTML = '<option value="">Pilih Kamar</option>';

              rooms.forEach(room => {
                  let option = document.createElement('option');
                  option.value = room.id;
                  option.text = room.room_number;
                  dropdown.appendChild(option);
              });

              if (rooms.length > 0) {
                  selectedPrice = rooms[0].price;
              }
          }

          function populateDropdownVehicle(vehicles) {
              let dropdown = document.getElementById('plateDropdown');
              dropdown.innerHTML = '<option value="">Pilih Plat Nomor</option>';

              vehicles.forEach(vehicle => {
                  let option = document.createElement('option');
                  option.value = vehicle.id;
                  option.text = vehicle.plate_number;
                  dropdown.appendChild(option);
              });

              if (vehicles.length > 0) {
                  selectedPriceVehicle = vehicles[0].price;
              }
          }

          document.getElementById('roomDropdown').addEventListener('change', function() {
              let selectedRoomId = parseInt(this.value);
              let selectedRoom = rooms.find(room => room.id == selectedRoomId);

              if (selectedRoom) {
                  selectedPriceVehicle = selectedRoom.price;
              } else {
                  selectedPriceVehicle = 0;
              }
              updateTotalPrice();
          });

          document.getElementById('plateDropdown').addEventListener('change', function() {
              let selectedVehicleId = parseInt(this.value);
              let selectedVehicle = vehicles.find(vehicle => vehicle.id == selectedVehicleId);

              if (selectedVehicle) {
                  selectedPriceVehicle = selectedVehicle.price;
              } else {
                  selectedPriceVehicle = 0;
              }
              updateTotalPriceVehicle();
          });

          document.getElementById('checkin').addEventListener('change', updateTotalPrice);
          document.getElementById('checkout').addEventListener('change', updateTotalPrice);
          document.getElementById('start').addEventListener('change', updateTotalPriceVehicle);
          document.getElementById('finish').addEventListener('change', updateTotalPriceVehicle);

          function updateTotalPrice() {
              let checkinDate = new Date(document.getElementById('checkin').value);
              let checkoutDate = new Date(document.getElementById('checkout').value);

              if (checkinDate && checkoutDate && checkoutDate > checkinDate) {
                  let timeDiff = checkoutDate - checkinDate;
                  let dayDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));

                  let totalPrice = selectedPrice * dayDiff;

                  let formattedPrice = new Intl.NumberFormat('id-ID', {
                      style: 'currency',
                      currency: 'IDR'
                  }).format(totalPrice);

                  document.getElementById('harga').innerHTML = `Harga: ${formattedPrice}`;
                  document.getElementById('price').value = totalPrice;
              } else {
                  document.getElementById('harga').innerHTML = 'Harga: Tidak tersedia';
              }
          }

          function updateTotalPriceVehicle() {
              let startDate = new Date(document.getElementById('start').value);
              let finishDate = new Date(document.getElementById('finish').value);

              if (startDate && finishDate && finishDate > startDate) {
                  let timeDiff = finishDate - startDate;
                  let dayDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));

                  let totalPrice = selectedPriceVehicle * dayDiff;

                  let formattedPrice = new Intl.NumberFormat('id-ID', {
                      style: 'currency',
                      currency: 'IDR'
                  }).format(totalPrice);

                  document.getElementById('priceV').innerHTML = `Harga: ${formattedPrice}`;
                  document.getElementById('priceVehicle').value = totalPrice;
              } else {
                  document.getElementById('priceV').innerHTML = 'Harga: Tidak tersedia';
              }
          }
      </script>
  </body>

  </html>
