<div class="content-body py-3">
<div class="container mt-5">
        <!-- Hotel Card -->
        <div class="card">
            <div class="card-header text-center">
                <img  src="<?= base_url('assets/images/tst.jpeg'); ?>" alt="Hotel Logo" class="img-fluid mb-3" style="max-height: 150px;">
                <h4>Hotel Name</h4>
            </div>
            <div class="card-body">
                <table class="table">
                    <tbody>
                        <tr>
                            <th>Alamat:</th>
                            <td>Jalan Contoh No.123, Kota ABC</td>
                        </tr>
                        <tr>
                            <th>Telepon:</th>
                            <td>+62 123 4567 890</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>info@hotel.com</td>
                        </tr>
                        <tr>
                            <th>Fasilitas:</th>
                            <td>WiFi, Kolam Renang, Restoran, Gym</td>
                        </tr>
                    </tbody>
                </table>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editHotelModal">Edit</button>
            </div>
        </div>

        <!-- Modal for Editing Hotel -->
        <div class="modal fade" id="editHotelModal" tabindex="-1" aria-labelledby="editHotelModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editHotelModalLabel">Edit Data Hotel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editHotelForm">
                            <!-- Logo -->
                            <div class="d-flex flex-column justify-content-center align-items-center mb-3">
                                <div class="imgContainer">
                                    <img src="path_to_logo.png" alt="Hotel Logo" id="hotelLogoPreview" class="img-thumbnail" style="max-width: 150px;">
                                </div>
                                <label class="btn btn-warning mt-3 text-center w-50" for="uploadHotelLogo">UPLOAD LOGO</label>
                                <input type="file" accept="image/jpg, image/jpeg, image/png" name="hotelLogo" id="uploadHotelLogo" hidden>
                            </div>
                            <!-- Hotel Name -->
                            <div class="form-group mb-3">
                                <label for="hotelName">Nama Hotel</label>
                                <input type="text" class="form-control" id="hotelName" value="Hotel Name">
                            </div>
                            <!-- Address -->
                            <div class="form-group mb-3">
                                <label for="hotelAddress">Alamat</label>
                                <textarea class="form-control" id="hotelAddress" rows="2">Jalan Contoh No.123, Kota ABC</textarea>
                            </div>
                            <!-- Phone -->
                            <div class="form-group mb-3">
                                <label for="hotelPhone">Telepon</label>
                                <input type="text" class="form-control" id="hotelPhone" value="+62 123 4567 890">
                            </div>
                            <!-- Email -->
                            <div class="form-group mb-3">
                                <label for="hotelEmail">Email</label>
                                <input type="email" class="form-control" id="hotelEmail" value="info@hotel.com">
                            </div>
                            <!-- Facilities -->
                            <div class="form-group mb-3">
                                <label for="hotelFacilities">Fasilitas</label>
                                <textarea class="form-control" id="hotelFacilities" rows="2">WiFi, Kolam Renang, Restoran, Gym</textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn btn-primary" form="editHotelForm">SAVE</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>