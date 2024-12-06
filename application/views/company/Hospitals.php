<div class="content-body py-3">
    <div id="#crudAlert" data-flashdata="" data-errorflashdata=""></div>
    <table id="hospitalsTables" class="table" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Admin</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Coordinate</th>
                <th>Action</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Admin</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Coordinate</th>
                <th>Action</th>
            </tr>
        </tfoot>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="viewMapHospitalModal" tabindex="-1" aria-labelledby="viewMapHospitalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewMapHospitalModalLabel">Hospital Location</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Map container -->
                <div id="hospitalMap" style="height: 400px;"></div>
            </div>
        </div>
    </div>
</div>
