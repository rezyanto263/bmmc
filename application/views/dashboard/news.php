<div class="content-body py-3">
    <div id="#crudAlert" data-flashdata="" data-errorflashdata=""></div>
    <button type="button" class="btn-primary w-100 my-3 d-flex align-items-center justify-content-center gap-2" data-bs-toggle="modal" data-bs-target="#addNewsModal">
        <i class="las la-plus-circle fs-4"></i>    
        ADD NEWS
    </button>
    <table id="newsTable" class="table" style="width:100%;">
        <thead>
            <tr>
                <th class="text-center">Thumbnail</th>
                <th class="text-center">Title</th>
                <th class="text-center">Views</th>
                <th class="text-center">Tags</th>
                <th class="text-center">Status</th>
                <th class="text-center">Created At</th>
                <th class="text-center">Updated At</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
    </table>
</div>



<!-- Modal Add -->
<div class="modal fade" id="addNewsModal" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-lg-down" style="height: unset;">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h1 class="modal-title fs-4">ADD NEWS</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addNewsForm" enctype="multipart/form-data">
            <div class="modal-body border-0">
              <div class="row gy-3">
                <div class="col-12 mt-0">
                  <input class="fs-2 fw-bold w-100 px-1" name="newsTitle" placeholder="News Title">
                </div>
                <div class="col-12">
                  <input type="text" class="w-100 border border-0 tagify--custom-dropdown" name="newsType" placeholder="News Type (Announcement, News, etc)">
                  <hr class="hr mt-2">
                </div>
                <div class="col-12 d-flex flex-column justify-content-center align-items-center">
                  <div class="image-container rounded-3 w-100 border-secondary ratio ratio-16x9 position-relative overflow-hidden" style="border: 2px dashed;">
                    <div class="overlay text-center position-absolute d-flex flex-column justify-content-center w-100 h-100">
                      <i class="las la-image fs-1"></i>
                      <p class="fs-6 mb-0">Click to Upload an Image</p>
                    </div>
                    <img id="imagePreview" class="img-fluid position-absolute w-100 h-100 object-fit-cover d-none" />
                    <input type="file" class="position-absolute top-0 start-0 w-100 h-100 opacity-0" name="newsThumbnail" accept="image/jpg, image/jpeg, image/png" style="cursor: pointer;" onchange="previewImage(event)">
                  </div>
                </div>
                <div class="col-12">
                  <textarea name="newsContent" id="newsEditor"></textarea>
                </div>
                <div class="col-12">
                  <input type="text" class="w-100 border border-0 tagify--custom-dropdown" name="newsTags[]" placeholder="News Tags (Penyakit, Kesehatan, Virus) - Optional">
                </div>  
              </div>
              <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
            </div>
            <div class="modal-footer border-0">
              <button type="button" class="btn-danger" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn-secondary" data-action="draft">Save as Draft</button>
              <button type="submit" class="btn-primary" data-action="published">Publish</button>
            </div>
            </form>
        </div>
    </div>
</div>



<!-- Modal View -->
<div class="modal fade" id="viewNewsModal" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-lg-down" style="height: unset;">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h1 class="modal-title fs-4">NEWS DETAILS</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body border-0">
              <div class="row gy-3">
                <div class="col-12 mt-0">
                  <div class="fs-2 fw-bold w-100 px-1" id="newsTitle"></div>
                </div>
                <div class="col-12">
                  <div class="d-flex gap-2 mb-1">
                    <div class="badge bg-success d-flex align-items-center gap-2">
                      <i class="las la-history fs-6"></i>
                      <span id="newsCreatedAt"></span>
                    </div>
                    <div class="badge bg-info d-flex align-items-center gap-2">
                      <i class="las la-newspaper fs-6"></i>
                      <span id="newsType"></span>
                    </div>
                    <div class="badge bg-warning d-flex align-items-center gap-2">
                      <i class="las la-eye fs-6"></i>
                      <span id="newsViews"></span>
                    </div>
                    <div class="bg-transparent d-flex align-items-center gap-2 border border-secondary rounded-2 px-2">
                      <span id="newsStatus"></span>
                    </div>
                  </div>
                  <hr class="hr mt-3 mb-3">
                </div>
                <div class="col-12">
                  <div class="ratio ratio-16x9 d-flex align-items-center">
                    <img id="newsThumbnail" class="w-100 h-100 object-fit-cover rounded border border-secondary" />
                  </div>
                </div>
                <div class="col-12">
                  <div id="newsContent"></div>
                </div>
                <div class="col-12 py-3">
                  <div class="w-100" id="newsTags"></div>
                </div>
                <div class="col-12 d-flex justify-content-between flex-column flex-lg-row order-5">
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



<!-- Modal Edit -->
<div class="modal fade" id="editNewsModal" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-xl-down" style="height: unset;">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h1 class="modal-title fs-4">EDIT NEWS</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editNewsForm" enctype="multipart/form-data">
            <div class="modal-body border-0">
              <input type="hidden" name="newsId">
              <div class="row gy-3">
                <div class="col-12 mt-0 newsTitleInput">
                  <input class="fs-2 fw-bold w-100 px-1" name="newsTitle" placeholder="News Title">
                  <input name="currentNewsTitle" type="hidden">
                </div>
                <div class="col-12">
                  <input type="text" class="w-100 border border-0 tagify--custom-dropdown" name="newsType" placeholder="News Type (Announcement, News, etc)">
                  <hr class="hr mt-2">
                </div>
                <div class="col-12 d-flex flex-column justify-content-center align-items-center">
                  <div class="image-container rounded-3 w-100 border-secondary ratio ratio-21x9 position-relative overflow-hidden" style="border: 2px dashed;">
                    <div class="overlay text-center position-absolute d-flex flex-column justify-content-center w-100 h-100">
                      <i class="las la-image fs-1"></i>
                      <p class="fs-6 mb-0">Click to Upload an Image</p>
                    </div>
                    <img id="imagePreview" src="" class="img-fluid position-absolute w-100 h-100 object-fit-cover" />
                    <input type="file" class="position-absolute top-0 start-0 w-100 h-100 opacity-0" name="newsThumbnail" accept="image/jpg, image/jpeg, image/png" style="cursor: pointer;" onchange="previewImage(event)">
                  </div>
                </div>
                <div class="col-12">
                  <textarea name="newsContent" id="newsEditor"></textarea>
                </div>
                <div class="col-12">
                  <input type="text" class="w-100 border border-0 tagify--custom-dropdown" name="newsTags[]" placeholder="News Tags (Penyakit, Kesehatan, Virus) - Optional">
                </div>
                <div class="col-12 d-flex justify-content-between flex-column flex-lg-row order-5">
                  <small class="text-secondary">
                      Created At: <span id="createdAt"></span>
                  </small>
                  <small class="text-secondary">
                      Updated At: <span id="updatedAt"></span>
                  </small>
                </div>
              </div>
              <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
            </div>
            <div class="modal-footer border-0 d-flex justify-content-between">
              <div>
                <select class="form-control" name="newsStatus"></select>
              </div>
              <div>
                <button type="button" class="btn-danger" data-bs-dismiss="modal">CANCEL</button>
                <button type="submit" class="btn-primary">SAVE</button>
              </div>
            </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Delete -->
<div class="modal fade" id="deleteNewsModal" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form id="deleteNewsForm">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">
                        DELETE NEWS
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    Are you sure want to delete "<span class="fw-bold" id="newsTitle"></span>" News?
                    <input type="number" name="newsId" hidden>
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-primary" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn-danger" id="deleteNewsButton">DELETE</button>
                </div>
            </form>
        </div>
    </div>
</div>