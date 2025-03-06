// News DataTable
var newsTable = $('#newsTable').DataTable($.extend(true, {}, DataTableSettings, {
  ajax: baseUrl + 'dashboard/getAllNews',
  columns: [
    { 
      data: 'newsThumbnail',
      orderable: false,
      render: function (data, type, row) {
        return `<img src="${baseUrl}uploads/news/${data}" class="object-fit-cover border border-secondary-subtle rounded" style="width: 200px; height: 125px;">`;
      }
    },
    { 
      data: 'newsTitle',
      className: 'text-wrap fw-bold',
      render: function(data, type) {
          if (type === 'display' || type === 'filter') {
              return `<div class="text-wrap fs-5" style="min-width: 400px;">${data}</div>`;
          }
          return data;
      }
    },
    {
      data: 'newsViews',
      className: 'text-center',
      render: function (data, type, row) {
        if (type === 'display' || type === 'filter') {
          return `<i class="fa-solid fa-eye me-1"></i> ${data}`;
        }
        return data;
      }
    },
    { 
      data: 'newsTags',
      className: 'text-wrap',
      render: function (data, type, row) {
        if (type === 'display' || type === 'filter') {
          let allTags = data.split(',').map(tag => `<span class="badge bg-secondary fw-normal">#${tag}</span>`).join(' ');
          return `<div class="text-wrap" style="min-width: 250px;">${allTags}</div>`
        }
        return data;
      }
    },
    { 
      data: 'newsStatus',
      render: function (data, type, row) {
        if (type === 'display' || type === 'filter') {
          return generateStatusData([data]).find(d => d.id === data).text;
        }
        return data;
      }
    },
    { 
      data: 'createdAt',
      render: function (data, type, row) {
        if (type === 'display' || type === 'filter') {
          return moment(data).format('ddd, D MMMM YYYY HH:mm') + ' WITA';
        }
        return data;
      }
    },
    { 
      data: 'updatedAt',
      render: function (data, type, row) {
        if (type === 'display' || type === 'filter') {
          return moment(data).format('ddd, D MMMM YYYY HH:mm') + ' WITA';
        }
        return data;
      }
    },
    {
      data: null,
      className: "text-end user-select-none no-export no-visibility",
      orderable: false,
      defaultContent: `
        <button 
            type="button" 
            class="btn-view btn-primary rounded-2" 
            data-bs-toggle="modal" 
            data-bs-target="#viewNewsModal">
            <i class="fa-regular fa-eye"></i>
        </button>
        <button 
            type="button" 
            class="btn-edit btn-warning rounded-2" 
            data-bs-toggle="modal" 
            data-bs-target="#editNewsModal">
            <i class="fa-regular fa-pen-to-square"></i>
        </button>
        <button 
            type="button" 
            class="btn-delete btn-danger rounded-2" 
            data-bs-toggle="modal" 
            data-bs-target="#deleteNewsModal">
                <i class="fa-solid fa-trash-can"></i>
        </button>
    `,
    }
  ],
  order: [[4, 'desc']],
}));

function previewImage(event) {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function (e) {
      const img = document.getElementById("imagePreview");
      img.src = e.target.result;
      img.classList.remove("d-none"); // Tampilkan gambar
      document.querySelector(".overlay").classList.add("d-none"); // Sembunyikan teks
    };
    reader.readAsDataURL(file);
  }
}

var addNewsModal = new bootstrap.Modal(document.getElementById('addNewsModal'), {
  focus: false
});

var newsTags;
var newsType;
$('#addNewsModal').on('show.bs.modal', function () {
  $.ajax({
    url: baseUrl + 'dashboard/getAllNewsTags',
    method: 'GET',
    success: function (response) {
      var newsTagsData = JSON.parse(response).data;
      var tagsArray = Object.values(newsTagsData);
      newsTags = document.querySelector('#addNewsForm [name="newsTags[]"]');
  
      if (newsTags.tagify) {
        newsTags.tagify.destroy();
        newsTags.tagify = null;
      }
  
      newsTags.tagify = new Tagify(newsTags, {
        whitelist: tagsArray,
        maxTags: 10,
        dropdown: {
          maxItems: 20,
          classname: 'tags-look',
          enabled: 0,
          closeOnSelect: false
        },
        transformTag: function(tagData) {
          tagData.value = tagData.value.toUpperCase();
        },
        validate: function(tagData) {
          if (tagData.value.length > 100) {
              return false;
          }
          return true;
        }
      }).on('invalid', function(e) {
        displayAlert('tagify max 100 chars');
      });
    
    }
  });

  $.ajax({
    url: baseUrl + 'dashboard/getAllNewsTypes',
    method: 'GET',
    success: function (response) {
      var newsTypesData = JSON.parse(response).data;
      var typesArray = Object.values(newsTypesData);
      newsType = document.querySelector('#addNewsForm [name="newsType"]');
  
      if (newsType.tagify) {
        newsType.tagify.destroy();
        newsType.tagify = null;
      }
  
      newsType.tagify = new Tagify(newsType, {
        whitelist: typesArray,
        maxTags: 1,
        dropdown: {
          maxItems: 20,
          classname: 'tags-look',
          enabled: 0,
          closeOnSelect: false
        },
        validate: function(typeData) {
          if (typeData.value.length > 20) {
              return false;
          }
          return true;
        }
      }).on('invalid', function(e) {
        displayAlert('tagify max 20 chars and only one value');
      });
    
    }
  });

  tinymce.remove('#newsEditor');
  tinymce.init({
    selector: 'textarea#newsEditor',
    placeholder: 'Type your content here...',
    skin: $.cookie('colorPreference') === 'light' ? 'oxide' : 'oxide-dark',
    content_css: $.cookie('colorPreference') === 'light' ? 'default' : 'dark',
    width: '100%',
    plugins: 'autosave advlist autolink lists link image charmap preview anchor autoresize emoticons',
    toolbar: 'restoredraft | undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat',
    image_dimensions: false,
    content_style: 'img { max-width: 100%; height: auto; }',
    branding: false,
    statusbar: false,
    autoresize_bottom_margin: 10,
    autoresize_on_init: true,
    autosave_ask_before_unload: true,
    autosave_interval: "30s",
    autosave_retention: "30m",
    image_class_list: [
      {title: 'Responsive', value: 'img-responsive'},
      {title: 'Free Size', value: ''}
    ],
    content_style: `
      img { max-width: 100%; height: auto; } 
      ${($.cookie('colorPreference') === 'dark') ? '.mce-content-body[data-mce-placeholder]:not(.mce-visualblocks)::before {color: #aaa}' : ''}
    `,
  });
});

$('#addNewsModal').on('hidden.bs.modal', function() {
  $('#addNewsModal #imagePreview').addClass('d-none');
  $('#addNewsModal .overlay').removeClass('d-none');
});

var submitNewsAction;
$('#addNewsForm [type="submit"]').on('click', function (e) {
  submitNewsAction = $(this).data('action');
});

// Add Data
$('#addNewsForm').on('submit', function (e) {
  e.preventDefault();
  const formData = new FormData(this);
  formData.append('newsStatus', submitNewsAction);
  formData.append('newsTags', JSON.stringify(newsTags.tagify.value.map(tag => tag.value)));
  formData.append('newsType', JSON.stringify(newsType.tagify.value));
  formData.append('newsContent', tinymce.get('newsEditor').getContent());
  $.ajax({
    url: baseUrl + 'dashboard/news/addNews',
    type: 'POST',
    data: formData,
    contentType: false,
    processData: false,
    success: function (response) {
      console.log(response);
      let res = JSON.parse(response);
      console.log(res);
      res.csrfToken && $(`[name="${csrfName}"]`).val(res.csrfToken);
      if (res.status === 'success') {
        $('#addNewsForm')[0].reset();
        tinymce.get('newsEditor').setContent('');
        reloadTableData(newsTable);
        displayAlert('add success');
      } else if (res.status === 'failed') {
        $(".error-message").remove();
				$(".is-invalid").removeClass("is-invalid");
				displayAlert(res.failedMsg, res.errorMsg ?? null);
      } else if (res.status === 'invalid') {
        displayFormValidation("#addNewsForm", res.errors);
      }
    }
  });
});



// View Data
$('#newsTable').on('click', '.btn-view', function () {
  let data = newsTable.row($(this).parents('tr')).data();
  let newsTagsHtml;
  if (data.newsTags) {
    newsTagsHtml = data.newsTags.split(',').map(tag => `<span class="badge bg-secondary fw-normal">#${tag}</span>`).join(' ');
  }

  $('#viewNewsModal #newsThumbnail').attr('src', baseUrl + 'uploads/news/' + data.newsThumbnail);
  $('#viewNewsModal #newsTitle').text(data.newsTitle);
  $('#viewNewsModal #newsType').text(data.newsType);
  $('#viewNewsModal #newsCreatedAt').text(moment(data.createdAt).format('ddd, D MMMM YYYY HH:mm') +' WITA');
  $('#viewNewsModal #newsViews').text(data.newsViews);
  $('#viewNewsModal #newsStatus').html(generateStatusData([data.newsStatus]).find(d => d.id === data.newsStatus).text);
  $('#viewNewsModal #newsTags').html(newsTagsHtml);
  $('#viewNewsModal #newsContent').html(data.newsContent);
  $('#viewNewsModal #createdAt').html(moment(data.createdAt).format('ddd, D MMMM YYYY HH:mm') +' WITA');
  $('#viewNewsModal #updatedAt').html(moment(data.updatedAt).format('ddd, D MMMM YYYY HH:mm') +' WITA');
});


// Edit Data
var editNewsModal = new bootstrap.Modal(document.getElementById('editNewsModal'), {
  focus: false
});

var inputEditNewsTags;
var inputEditNewsType;
$('#newsTable').on('click', '.btn-edit', function () {
  let data = newsTable.row($(this).parents('tr')).data();

  $('#editNewsForm [name="newsId"]').val(data.newsId);
  $('#editNewsForm [name="newsTitle"]').val(data.newsTitle);
  $('#editNewsForm [name="currentNewsTitle"]').val(data.newsTitle);
  $('#editNewsForm #imagePreview').attr('src', `${baseUrl}uploads/news/${data.newsThumbnail}`);
  $('#editNewsForm #createdAt').text(moment(data.createdAt).format('ddd, D MMMM YYYY HH:mm') +' WITA');
  $('#editNewsForm #updatedAt').text(moment(data.updatedAt).format('ddd, D MMMM YYYY HH:mm') +' WITA');
  
  $('#editNewsForm [name="newsStatus"]').select2({
    width: '150px',
    data: generateStatusData(['draft', 'published', 'archived']),
    dropdownParent: $('#editNewsModal .modal-footer'),
    escapeMarkup: function(markup) {
      return markup;
    }
  })
  $('#editNewsForm [name="newsStatus"]').val(data.newsStatus).trigger('change');

  $.ajax({
    url: baseUrl + 'dashboard/getAllNewsTags',
    method: 'GET',
    success: function (response) {
      var newsTagsData = JSON.parse(response).data;
      var tagsArray = Object.values(newsTagsData);
      inputEditNewsTags = document.querySelector('#editNewsForm [name="newsTags[]"]');
  
      if (inputEditNewsTags.tagify) {
        inputEditNewsTags.tagify.destroy();
        inputEditNewsTags.tagify = null;
      }
  
      inputEditNewsTags.tagify = new Tagify(inputEditNewsTags, {
        whitelist: tagsArray,
        maxTags: 10,
        dropdown: {
          maxItems: 20,
          classname: 'tags-look',
          enabled: 0,
          closeOnSelect: false
        },
        transformTag: function(tagData) {
          tagData.value = tagData.value.toUpperCase();
        },
        validate: function(tagData) {
          if (tagData.value.length > 100) {
              return false;
          }
          return true;
        }
      }).on('invalid', function(e) {
        displayAlert('tagify max 100 chars');
      });
  
      if (data.newsTags && data.newsTags.trim() !== '') {
        let selectedTags = data.newsTags.split(',').map(tag => tag.trim());
        inputEditNewsTags.tagify.addTags(selectedTags);
      }
    }
  });

  $.ajax({
    url: baseUrl + 'dashboard/getAllNewsTypes',
    method: 'GET',
    success: function (response) {
      var newsTypesData = JSON.parse(response).data;
      var typesArray = Object.values(newsTypesData);
      inputEditNewsType = document.querySelector('#editNewsForm [name="newsType"]');
  
      if (inputEditNewsType.tagify) {
        inputEditNewsType.tagify.destroy();
        inputEditNewsType.tagify = null;
      }
  
      inputEditNewsType.tagify = new Tagify(inputEditNewsType, {
        whitelist: typesArray,
        maxTags: 1,
        dropdown: {
          maxItems: 20,
          classname: 'tags-look',
          enabled: 0,
          closeOnSelect: false
        },
        validate: function(tagData) {
          if (tagData.value.length > 20) {
              return false;
          }
          return true;
        }
      }).on('invalid', function(e) {
        displayAlert('tagify max 20 chars and only one value');
      });
  
      if (data.newsType && data.newsType.trim() !== '') {
        inputEditNewsType.tagify.addTags(data.newsType);
      }
    }
  });

  tinymce.remove('#editNewsForm #newsEditor'); 
  tinymce.init({
    selector: '#editNewsForm #newsEditor',
    placeholder: 'Type your content here...',
    skin: $.cookie('colorPreference') === 'light' ? 'oxide' : 'oxide-dark',
    content_css: $.cookie('colorPreference') === 'light' ? 'default' : 'dark',
    width: '100%',
    plugins: 'autosave advlist autolink lists link image charmap preview anchor autoresize emoticons',
    toolbar: 'restoredraft | undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat emoticons',
    image_dimensions: false,
    content_style: 'img { max-width: 100%; height: auto; }',
    branding: false,
    statusbar: false,
    autoresize_bottom_margin: 10,
    autoresize_on_init: true,
    autosave_ask_before_unload: true,
    autosave_interval: "30s",
    autosave_retention: "30m",
    image_class_list: [
      {title: 'Responsive', value: 'img-responsive'},
      {title: 'Free Size', value: ''}
    ],
    content_style: `
      img { max-width: 100%; height: auto; } 
      ${($.cookie('colorPreference') === 'dark') ? '.mce-content-body[data-mce-placeholder]:not(.mce-visualblocks)::before {color: #aaa}' : ''}
    `,
    setup: function (editor) {
      editor.on('init', function () {
        editor.setContent(data.newsContent);
      });
    }
  });
});

// Edit Data
$('#editNewsForm').on('submit', function (e) {
  e.preventDefault();
  const formData = new FormData(this);
  formData.append('newsTags', JSON.stringify(inputEditNewsTags.tagify.value.map(tag => tag.value)));
  formData.append('newsType', JSON.stringify(inputEditNewsType.tagify.value));
  formData.append('newsContent', tinymce.get('newsEditor').getContent());
  $.ajax({
    url: baseUrl + 'dashboard/news/editNews',
    type: 'POST',
    data: formData,
    contentType: false,
    processData: false,
    success: function (response) {
      console.log(response);
      let res = JSON.parse(response);
      res.csrfToken && $(`[name="${csrfName}"]`).val(res.csrfToken);
      if (res.status ==='success') {
        reloadTableData(newsTable);
        displayAlert('edit success');
      } else if (res.status === 'failed') {
        $(".error-message").remove();
        $(".is-invalid").removeClass("is-invalid");
        displayAlert(res.failedMsg, res.errorMsg?? null);
      } else if (res.status === 'invalid') {
        displayFormValidation("#editNewsForm", res.errors);
      }
    }
  });
});




// Delete Data
$('#newsTable').on('click', '.btn-delete', function () {
  let data = newsTable.row($(this).parents('tr')).data();
  $('#deleteNewsModal #newsTitle').text(data.newsTitle);
  $('#deleteNewsModal [name="newsId"]').val(data.newsId);
});


$('#deleteNewsForm').on('submit', function (e) {
  e.preventDefault();
  $.ajax({
    url: baseUrl + 'dashboard/news/deleteNews',
    type: 'POST',
    data: $(this).serialize(),
    success: function (response) {
      let res = JSON.parse(response);
      res.csrfToken && $(`[name="${csrfName}"]`).val(res.csrfToken);
      if (res.status ==='success') {
        reloadTableData(newsTable);
        displayAlert('delete success');
      } else if (res.status === 'failed') {
        displayAlert(res.failedMsg, res.errorMsg?? null);
      }
    }
  });
});