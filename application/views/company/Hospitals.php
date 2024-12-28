<div class="content-body py-3">
    <div id="#crudAlert" data-flashdata="" data-errorflashdata=""></div>
    <table id="hospitalsTables" class="table" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Action</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Action</th>
            </tr>
        </tfoot>
    </table>
</div>

<!-- Modal untuk menampilkan peta -->
<div class="modal fade" id="viewMapHospitalModal" tabindex="-1" aria-labelledby="viewMapHospitalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewMapHospitalModalLabel">View Hospital Location</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Peta -->
                <div id="hospitalMap" style="height: 400px;"></div>
            </div>
        </div>
    </div>
</div>

<!-- Di dalam file view_hospital.php atau file modal -->
<style>
    #hospitalMap {
        height: 400px;  /* Atur tinggi peta sesuai kebutuhan */
        width: 100%;    /* Pastikan peta memiliki lebar penuh */
    }
</style>

