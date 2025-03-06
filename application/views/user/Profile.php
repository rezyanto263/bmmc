<!-- Profile Section Start -->
<section class="profile px-1 px-md-3 px-lg-4 w-100">
  <div class="container-xxl pb-5 pt-3">
    <div class="row gy-4">
      <div class="col-12 col-md-5 d-flex justify-content-center align-items-center order-2 order-md-0">
        <?php 
        $userPhoto = $this->session->userdata('userPhoto') 
          ? base_url('uploads/profiles/' . $this->session->userdata('userPhoto')) 
          : base_url('assets/images/user-placeholder.png'); 
        ?>
        <img class="profile-photo border border-1 rounded-circle object-fit-cover" src="<?= $userPhoto; ?>" alt="" width="250px" height="250px" draggable="false" data-bs-toggle="tooltip" data-bs-title="Profile Picture">
      </div>
      <div class="col-2 d-flex justify-content-center px-0 order-1">
        <div class="vr p-0 h-75 align-self-center d-none d-md-flex" style="width: 1px;"></div>
      </div>
      <div class="col-12 col-md-5 d-flex justify-content-center order-0 order-md-2">
        <?php $blur = in_array($insurance['companyStatus'], ['on hold', 'discontinued', 'unverified']); ?>
        <img class="profile-qr p-1" style="<?= $blur ? 'filter: blur(3px);' : ''; ?>" src="<?= 'data:image/png;base64,' . base64_encode($qr) ?>" alt="" width="250px" height="250px" draggable="false" data-bs-toggle="tooltip" data-bs-title="Insurance QR Code">
      </div>
    </div>

    <hr class="hr">

    <div class="row g-4 profile-details">
      <div class="col-12 col-lg-6 order-1 order-lg-0">
        <div class="card bg-transparent">
          <div class="card-body">
            <div class="row g-2">
              <div class="col-12 d-md-flex align-items-center justify-content-between mb-2">
                <h3 class="mb-0">Profile Information</h3>
                <button class="btn-warning px-2 py-1 d-flex gap-1 align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#profileEditModal">
                  <i class="fa-regular fa-pen-to-square text-white fs-6"></i>
                  EDIT ACCOUNT
                </button>
              </div>
              <div class="col-12 col-md-8">
                <div class="input-group p-0">
                  <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Full Name">
                      <i class="las la-user-tie fs-4"></i>
                  </span>
                  <div class="form-control bg-transparent text-truncate" id="userName">
                    <?= $this->session->userdata('userName'); ?>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-4">
                <div class="input-group p-0">
                  <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Status">
                      <i class="las la-tag fs-4"></i>
                  </span>
                  <div class="form-control bg-transparent text-truncate"id="userStatus">
                    <div class="<?= $this->session->userdata('userStatus') === 'active' ? 'bg-success' : 'bg-warning'; ?> status-circle"></div> <?= ucwords($this->session->userdata('userStatus')); ?>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6">
                  <div class="input-group p-0">
                      <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="NIK">
                          <i class="las la-id-card fs-4"></i>    
                      </span>
                      <div class="form-control bg-transparent text-truncate" id="userNIK">
                      <?= $this->session->userdata('userNIK'); ?>
                      </div>
                  </div>
              </div>
              <div class="col-12 col-md-6">
                  <div class="input-group p-0">
                      <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Date of Birth">
                          <i class="las la-birthday-cake fs-4"></i>
                      </span>
                      <div class="form-control bg-transparent text-truncate" id="userBirth">
                        <?= date('D, j F Y', strtotime($this->session->userdata('userBirth'))); ?>
                      </div>
                  </div>
              </div>
              <div class="col-12 col-md-4">
                  <div class="input-group p-0">
                      <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Gender">
                          <i class="las la-transgender fs-4"></i>
                      </span>
                      <div class="form-control bg-transparent text-truncate" id="userGender">
                        <?= ucwords($this->session->userdata('userGender')); ?>
                      </div>
                  </div>
              </div>
              <div class="col-12 col-md-8">
                  <div class="input-group p-0">
                      <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Department">
                          <i class="las la-sitemap fs-4"></i>
                      </span>
                      <div class="form-control bg-transparent text-truncate" id="userDepartment">
                        <?= $this->session->userdata('userDepartment'); ?>
                      </div>
                  </div>
              </div>
              <div class="col-12 col-md-6">
                  <div class="input-group p-0">
                      <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Band">
                          <i class="las la-layer-group fs-4"></i>
                      </span>
                      <div class="form-control bg-transparent text-truncate" id="userBand">
                        <?= $this->session->userdata('userBand'); ?>
                      </div>
                  </div>
              </div>
              <div class="col-12 col-md-6">
                  <div class="input-group p-0">
                      <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Phone Number">
                          <i class="las la-phone fs-4"></i>
                      </span>
                      <div class="form-control bg-transparent text-truncate" id="userPhone">
                        <?= $this->session->userdata('userPhone'); ?>
                      </div>
                  </div>
              </div>
              <div class="col-12 col-md-8">
                <div class="input-group p-0">
                    <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Email">
                        <i class="las la-envelope fs-4"></i>
                    </span>
                    <div class="form-control bg-transparent text-truncate" id="userEmail">
                      <?= $this->session->userdata('userEmail'); ?>
                    </div>
                </div>
              </div>
              <div class="col-12 col-md-4">
                <div class="input-group p-0">
                    <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Relationship">
                        <i class="las la-link fs-4"></i>
                    </span>
                    <div class="form-control bg-transparent text-truncate" id="userRelationship">
                      <?= ucwords($this->session->userdata('userRelationship')); ?>
                    </div>
                </div>
              </div>
              <div class="col-12">
                  <div class="input-group p-0">
                      <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Address">
                          <i class="las la-map-marked-alt fs-4"></i>
                      </span>
                      <div class="form-control bg-transparent text-truncate" id="userAddress">
                        <?= $this->session->userdata('userAddress'); ?>
                      </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-6 order-0 order-lg-1">
        <div class="row g-4">
          <div class="col-12 col-md-6">
            <div class="card bg-transparent">
              <div class="card-header bg-primary">
                <h5 class="card-title mb-0 text-center text-white fs-6">
                  Insurance Remaining
                </h5>
              </div>
              <div class="card-body">
                <h4 class="mb-0 text-center" id="insuranceRemaining">
                  <?= 'Rp ' . number_format(($insurance['insuranceAmount'] - $insurance['totalBillingUsedThisMonth']), 0, ',', '.'); ?>
                </h4>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="card bg-transparent">
              <div class="card-header bg-danger">
                <h5 class="card-title mb-0 text-center text-white fs-6">
                  Insurance Used
                </h5>
              </div>
              <div class="card-body">
                <h4 class="mb-0 text-center" id="insuranceUsed">
                  <?= 'Rp ' . number_format($insurance['totalBillingUsedThisMonth'], 0, ',', '.'); ?>
                </h4>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="card bg-transparent">
              <div class="card-body">
                <div class="row g-2">
                  <div class="col-12">
                    <h3 class="mb-0">Insurance Information</h3>
                  </div>
                  <div class="col-12 col-md-6">
                    <div class="input-group p-0">
                      <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Insurance Tier">
                        <i class="las la-shield-alt fs-4"></i>
                      </span>
                      <div class="form-control bg-transparent text-truncate" id="insuranceTier">
                        <?= $insurance['insuranceTier']; ?>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-md-6">
                    <div class="input-group p-0">
                      <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Insurance Amount">
                        <i class="las la-wallet fs-4"></i>
                      </span>
                      <div class="form-control bg-transparent text-truncate" id="insuranceAmount">
                        <?= 'Rp ' . number_format($insurance['insuranceAmount'], 0, ',', '.'); ?>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-md-6">
                    <div class="input-group p-0">
                      <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Insurance Used By">
                        <i class="las la-users fs-4"></i>
                      </span>
                      <div class="form-control bg-transparent text-truncate" id="insuranceUsedBy">
                        <?= $insurance['insuranceMembers'] ?> Members
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-md-6">
                    <div class="input-group p-0">
                      <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Insurance Status">
                        <i class="las la-tag fs-4"></i>
                      </span>
                      <div class="form-control bg-transparent text-truncate" id="insuranceStatus">
                        <div class="<?= $insurance['companyStatus'] === 'active' ? 'bg-success' : 'bg-warning'; ?> status-circle"></div> <?= ucwords($insurance['companyStatus']); ?>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <h5>Notes :</h5>
                    <p class="mb-0 fst-italic text-primary">
                      *Insurance status may change anytime. Please refresh to see updates.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php if ($this->session->userdata('userRole') === 'employee'): ?>
    <hr class="hr">

    <div class="row g-4 family-members">
      <div class="col-12">
        <h2 class="mb-0">Family Members</h2>
      </div>
      <?php foreach($families as $family):  ?>
      <div class="col-12 col-md-6 col-lg-4">
        <button class="card w-100" data-bs-toggle="modal" data-bs-target="#viewFamilyModal<?= $family['familyNIK']; ?>">
          <div class="card-body d-flex flex-column align-items-center py-4">
            <?php 
            $familyPhoto = $family['familyPhoto'] 
              ? base_url('uploads/profiles/' . $family['familyPhoto']) 
              : base_url('assets/images/user-placeholder.png'); 
            ?>
            <img class="rounded-circle object-fit-cover border border-1" src="<?= $familyPhoto; ?>" alt="Family Photo" style="width: 100px; height: 100px;">
            <h5 class="mt-3 mb-0"><?= $family['familyName']; ?></h5>
            <p class="mb-0"><?= ucwords($family['familyRelationship']); ?></p>
          </div>
        </button>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <hr class="hr">

    <div class="row g-4">
      <h2 class="mb-0">Health History</h2>
      <table class="table w-100" id="healthhistoriesProfilesTable">
        <thead>
          <tr>
            <th>Treatments Date</th>
            <th class="text-start">NIK</th>
            <th>Name</th>
            <th>Department</th>
            <th>Band</th>
            <th>Relationship</th>
            <th>Gender</th>
            <th>Status</th>
            <th>Invoice Status</th>
            <th class="text-end">Doctor Fee</th>
            <th class="text-end">Medicine Fee</th>
            <th class="text-end">Lab Fee</th>
            <th class="text-end">Action Fee</th>
            <th class="text-end">Discount</th>
            <th class="text-end">Total Bill</th>
            <th>Hospital</th>
            <th>Doctor</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</section>
<!-- Profile Section End -->


<!-- Profile Edit Modal -->
<div class="modal fade" id="profileEditModal">
  <div class="modal-dialog modal-dialog-centered modal-md modal-fullscreen-md-down">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title fs-4 text-primary fw-bold">EDIT PROFILE</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editProfileForm" enctype="multipart/form-data">
      <div class="modal-body">
        <div class="row gy-4">
          <div class="col-12 my-auto mb-4 mb-xl-auto d-flex flex-column align-items-center justify-content-center">
              <div class="imgContainer my-auto rounded-circle" style="width: 300px; height: 300px;">
                  <?php 
                  $userPhoto = $this->session->userdata('userPhoto') 
                  ? base_url('uploads/profiles/' . $this->session->userdata('userPhoto')) 
                  : base_url('assets/images/user-placeholder.png'); 
                  ?>
                  <img class="object-fit-cover" src="<?= $userPhoto; ?>" data-originalsrc="<?= base_url('assets/images/user-placeholder.png'); ?>" id="imgPreview" alt="User Photo"  draggable="false">
              </div>
              <label class="btn-warning mt-3 text-center w-50" for="addImgFile">UPLOAD PHOTO</label>
              <input type="file" accept="image/jpg, image/jpeg, image/png" name="userPhoto" class="imgFile" id="addImgFile" hidden>
          </div>
          <div class="col-12 d-flex justify-content-between w-100">
              <div>
                  <input class="form-check-input" type="checkbox" id="newPasswordCheck" data-bs-toggle="tooltip" data-bs-title="Change Password Checkbox">
                  <label class="form-check-label">Change password?</label>
              </div>
          </div>
          <div class="col-12 changePasswordInput">
              <div class="input-group p-0">
                  <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="User Current Password">
                      <i class="las la-key fs-4"></i>
                  </span>
                  <input type="password" class="form-control" placeholder="Current Password" name="currentPassword">
                  <span type="button" class="input-group-text bg-transparent" id="btnShowPassword" data-bs-toggle="tooltip" data-bs-title="Show/Hide Password">
                      <i class="las la-eye-slash fs-4"></i>
                  </span>
              </div>
          </div>
          <div class="col-12 changePasswordInput">
              <div class="input-group p-0">
                  <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="User New Password">
                      <i class="las la-key fs-4"></i>
                  </span>
                  <input type="password" class="form-control" placeholder="New Password" name="newPassword">
                  <span type="button" class="input-group-text bg-transparent" id="btnShowPassword" data-bs-toggle="tooltip" data-bs-title="Show/Hide Password">
                      <i class="las la-eye-slash fs-4"></i>
                  </span>
              </div>
          </div>
          <div class="col-12 changePasswordInput">
              <div class="input-group p-0">
                  <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="User Password Confirmation">
                      <i class="las la-key fs-4"></i>
                  </span>
                  <input type="password" class="form-control" placeholder="Password Confirmation" name="confirmPassword">
                  <span type="button" class="input-group-text bg-transparent" id="btnShowPassword" data-bs-toggle="tooltip" data-bs-title="Show/Hide Password">
                      <i class="las la-eye-slash fs-4"></i>
                  </span>
              </div>
          </div>
          <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        </div>
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn-danger" data-bs-dismiss="modal">CANCEL</button>
        <button type="submit" class="btn-primary">SAVE</button>
      </div>
      </form>
    </div>
  </div>
</div>

<?php if ($this->session->userdata('userRole') === 'employee'): ?>
<!-- View Family Modal -->
<?php foreach($families as $family): ?>
<div class="modal fade" id="viewFamilyModal<?= $family['familyNIK']; ?>">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-lg-down">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title fs-4 text-primary fw-bold">Family Member Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row g-4">
          <div class="col-12 d-flex align-item-center justify-content-center">
            <?php 
            $familyPhoto = $family['familyPhoto'] 
              ? base_url('uploads/profiles/' . $family['familyPhoto']) 
              : base_url('assets/images/user-placeholder.png'); 
            ?>
            <img class="rounded-circle object-fit-cover border border-1" src="<?= $familyPhoto ?>" alt="Family Photo" draggable="false" width="200px" height="200px">
          </div>
          <div class="col-12 col-md-6">
            <div class="input-group p-0">
              <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="NIK">
                <i class="las la-id-card fs-4"></i>
              </span>
              <div class="form-control bg-transparent text-truncate">
                <?= $family['familyNIK']; ?>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="input-group p-0">
              <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Name">
                <i class="las la-user fs-4"></i>
              </span>
              <div class="form-control bg-transparent text-truncate">
                <?= $family['familyName']; ?>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="input-group p-0">
              <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Email">
                <i class="las la-envelope fs-4"></i>
              </span>
              <div class="form-control bg-transparent text-truncate">
                <?= $family['familyEmail']; ?>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="input-group p-0">
              <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Phone">
                <i class="las la-phone fs-4"></i>
              </span>
              <div class="form-control bg-transparent text-truncate">
                <?= $family['familyPhone']; ?>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="input-group p-0">
              <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Gender">
                <i class="las la-transgender fs-4"></i>
              </span>
              <div class="form-control bg-transparent text-truncate">
                <?= ucwords($family['familyGender']); ?>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="input-group p-0">
              <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Birth">
                <i class="las la-birthday-cake fs-4"></i>
              </span>
              <div class="form-control bg-transparent text-truncate">
                <?= date('D, j F Y', strtotime($family['familyBirth'])); ?>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="input-group p-0">
              <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Relationship">
                <i class="las la-link fs-4"></i>
              </span>
              <div class="form-control bg-transparent text-truncate">
                <?= ucwords($family['familyRelationship']); ?>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="input-group p-0">
              <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Status">
                <i class="las la-tag fs-4"></i>
              </span>
              <div class="form-control bg-transparent text-truncate">
                <?php 
                  switch ($family['familyStatus']) {
                    case 'active':
                      $statusColor = 'bg-success';
                      break;
                    case 'unverified':
                      $statusColor = 'bg-secondary-subtle';
                      break;
                    case 'on hold':
                      $statusColor = 'bg-warning';
                      break;
                    default:
                      $statusColor = 'bg-secondary';
                      break;
                  }
                ?>
                <div class="status-circle <?= $statusColor; ?>"></div> <?= ucwords($family['familyStatus']); ?>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="input-group p-0">
              <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Address">
                <i class="las la-map-marked-alt fs-4"></i>
              </span>
              <div class="form-control bg-transparent text-truncate">
                <?= $family['familyAddress']; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endforeach; ?>
<?php endif; ?>


<!-- Modal View Health History -->
<div class="modal fade" id="viewHealthHistoryModal" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h1 class="modal-title fs-4 text-primary fw-bold">HEALTH HISTORY DETAILS</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body border-0">
                <div class="row gy-4 gx-3">
                    <h5 class="m-0">Patient Details</h5>
                    <div class="col-12">
                        <div class="imgContainer mx-auto">
                            <img src="<?= base_url('assets/images/user-placeholder.png'); ?>" data-originalsrc="<?= base_url('assets/images/user-placeholder.png'); ?>" class="object-fit-cover w-100 h-100" draggable="false" alt="Patient Photo" id="patientPhoto">
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Patient NIK">
                            <i class="las la-id-card fs-4"></i>
                            </span>
                            <div class="form-control" id="patientNIK"></div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Patient Name">
                            <i class="las la-user fs-4"></i>
                            </span>
                            <div class="form-control" id="patientName"></div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-6">
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Patient Relationship">
                            <i class="las la-user-tag fs-4"></i>
                            </span>
                            <div class="form-control" id="patientRelationship"></div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-6">
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Patient Gender">
                            <i class="las la-transgender fs-4"></i>
                            </span>
                            <div class="form-control" id="patientGender"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-7 col-lg-6">
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Patient Department">
                            <i class="las la-sitemap fs-4"></i>
                            </span>
                            <div class="form-control" id="patientDepartment"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-5 col-lg-6">
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Patient Band">
                            <i class="las la-layer-group fs-4"></i>
                            </span>
                            <div class="form-control" id="patientBand"></div>
                        </div>
                    </div>
                    <input type="hidden" name="patientRole">
                    <h5 class="mb-0">Treatment Details</h5>
                    <div class="col-12">
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Hospital">
                            <i class="las la-hospital fs-4"></i>
                            </span>
                            <div class="form-control" id="hospitalName"></div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Status">
                            <i class="las la-tag fs-4"></i>
                            </span>
                            <div class="form-control" id="healthhistoryStatus"></div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Invoice Status">
                            <i class="las la-file-invoice-dollar fs-4"></i>
                            </span>
                            <div class="form-control" id="invoiceStatus"></div>
                        </div>
                    </div>
                    <div class="col-12 referredInput" style="display: none;">
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Referred To">
                                <i class="lab la-telegram-plane fs-4"></i>
                            </span>
                            <div class="form-control" id="healthhistoryReferredTo"></div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Date">
                            <i class="las la-calendar-day fs-4"></i>
                            </span>
                            <div class="form-control" id="healthhistoryDate"></div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Doctor">
                            <i class="las la-stethoscope fs-4"></i>
                            </span>
                            <div class="form-control" id="doctorName"></div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="input-group p-0 flex-nowrap">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Disease">
                                <i class="las la-heartbeat fs-4"></i>
                            </span>
                            <div class="form-control" id="diseaseNames"></div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Description">
                                <i class="las la-notes-medical fs-4"></i>
                            </span>
                            <textarea class="form-control" placeholder="Description (e.g., Diagnoses, Notes, Referrals) – Optional" name="healthhistoryDescription" readonly></textarea>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Doctor Fee">
                                <i class="las la-stethoscope fs-4"></i>
                            </span>
                            <div class="form-control currency-input" id="healthhistoryDoctorFee"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">   
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Medicine Fee">
                                <i class="las la-capsules fs-4"></i>
                            </span>
                            <div class="form-control currency-input" id="healthhistoryMedicineFee"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Lab Fee">
                                <i class="las la-flask fs-4"></i>
                            </span>
                            <div class="form-control currency-input" id="healthhistoryLabFee"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Action Fee">
                                <i class="las la-briefcase-medical fs-4"></i>
                            </span>
                            <div class="form-control currency-input" id="healthhistoryActionFee"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Discount">
                                <i class="las la-percent fs-4"></i>
                            </span>
                            <div class="form-control currency-input discount text-danger" id="healthhistoryDiscount"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Total Bill">
                                <i class="las la-money-bill-wave fs-4"></i>
                            </span>
                            <div class="form-control currency-input text-info" id="healthhistoryTotalBill"></div>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-between flex-column flex-lg-row">
                        <small class="text-secondary">
                            Created At: <span id="createdAt"></span>
                        </small>
                        <small class="text-secondary">
                            Updated At: <span id="updatedAt"></span>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>