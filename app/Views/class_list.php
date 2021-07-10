<?= $this->extend('template') ?>
<?= $this->section('vendorCSS') ?>
<link rel="stylesheet" href="<?= base_url('app-assets/vendors/css/tables/datatable/datatables.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/forms/select/select2.min.css') ?>">
<?= $this->endSection() ?>
<?= $this->section('customCSS') ?>
<style>
   @media (min-width: 1200px) {
      .dataTables_wrapper .dataTables_filter label {
         display: flex;
         align-items: center;
      }

      .dataTables_wrapper .dataTables_filter input {
         display: block !important;
         width: 100% !important;
      }
   }

   .is-invalid~.select2 .select2-selection {
      border-color: #ea5455;
   }

   .form-control.is-invalid~.select2 .select2-selection {
      border-color: #ea5455;
      padding-right: calc(1.45em + 0.876rem);
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23ea5455' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23ea5455' stroke='none'/%3e%3c/svg%3e");
      background-repeat: no-repeat;
      background-position: right calc(0.3625em + 0.219rem) center;
      background-size: calc(0.725em + 0.438rem) calc(0.725em + 0.438rem);
   }
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="modal fade" id="modal-add-class" role="dialog" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h2 class="modal-title">
               Tambah Kelas
            </h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form id="add-class" enctype="multipart/form-data" onsubmit="return false;">
            <div class="modal-body">
               <div class="form-group">
                  <label>Nama Kelas <span class="text-danger font-small-4">*</span></label>
                  <input type="text" class="form-control" name="class_name" placeholder="Nama Kelas" required>
                  <div class="invalid-feedback"></div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
               <button type="submit" class="btn btn-primary">Tambahkan</button>
            </div>
         </form>
      </div>
   </div>
</div>
<div class="modal fade" id="modal-edit-class" role="dialog" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h2 class="modal-title">
               Edit Kelas
            </h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form id="edit-class" enctype="multipart/form-data" onsubmit="return false;">
            <div class="modal-body">
               <div class="form-group">
                  <label>Nama Kelas <span class="text-danger font-small-4">*</span></label>
                  <input type="hidden" class="form-control" name="class_id" disabled>
                  <input type="text" class="form-control" name="class_name" placeholder="Nama Kelas" required>
                  <div class="invalid-feedback"></div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
               <button type="submit" class="btn btn-primary">Simpan perubahan</button>
            </div>
         </form>
      </div>
   </div>
</div>
<div class="modal fade" id="modal-add-class-group" role="dialog" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h2 class="modal-title">
               Tambah Grup Kelas
            </h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form id="add-class-group" enctype="multipart/form-data" onsubmit="return false;">
            <div class="modal-body">
               <div class="form-group">
                  <label>Kelas <span class="text-danger font-small-4">*</span></label>
                  <select name="class" class="form-control select2-class" required>
                     <option selected disabled></option>
                     <?php foreach ($class as $v) { ?>
                        <option value="<?= $v->class_id ?>"><?= $v->class_name ?></option>
                     <?php } ?>
                  </select>
                  <div class="invalid-feedback"></div>
               </div>
               <div class="form-group">
                  <label>Jurusan <span class="text-danger font-small-4">*</span></label>
                  <select name="major" class="form-control select2-major" required>
                     <option selected disabled></option>
                     <?php foreach ($major as $v) { ?>
                        <option value="<?= $v->major_id ?>"><?= $v->major_name ?></option>
                     <?php } ?>
                  </select>
                  <div class="invalid-feedback"></div>
               </div>
               <div class="form-group">
                  <label>Unit Jurusan <span class="text-danger font-small-4">*</span></label>
                  <input type="text" name="unit_major" class="form-control" placeholder="Unit Jurusan" required>
                  <div class="invalid-feedback"></div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
               <button type="submit" class="btn btn-primary">Tambahkan</button>
            </div>
         </form>
      </div>
   </div>
</div>
<div class="modal fade" id="modal-edit-class-group" role="dialog" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h2 class="modal-title">
               Edit Grup Kelas
            </h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form id="edit-class-group" enctype="multipart/form-data" onsubmit="return false;">
            <div class="modal-body">
               <div class="form-group">
                  <label>Kelas <span class="text-danger font-small-4">*</span></label>
                  <input type="hidden" name="class_group_code" disabled>
                  <select name="class" class="form-control select2-class" required>
                     <option selected disabled></option>
                     <?php foreach ($class as $v) { ?>
                        <option value="<?= $v->class_id ?>"><?= $v->class_name ?></option>
                     <?php } ?>
                  </select>
                  <div class="invalid-feedback"></div>
               </div>
               <div class="form-group">
                  <label>Jurusan <span class="text-danger font-small-4">*</span></label>
                  <select name="major" class="form-control select2-major" required>
                     <option selected disabled></option>
                     <?php foreach ($major as $v) { ?>
                        <option value="<?= $v->major_id ?>"><?= $v->major_name ?></option>
                     <?php } ?>
                  </select>
                  <div class="invalid-feedback"></div>
               </div>
               <div class="form-group">
                  <label>Unit Jurusan <span class="text-danger font-small-4">*</span></label>
                  <input type="text" name="unit_major" class="form-control" placeholder="Unit Jurusan" required>
                  <div class="invalid-feedback"></div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
               <button type="submit" class="btn btn-primary">Simpan perubahan</button>
            </div>
         </form>
      </div>
   </div>
</div>
<div class="row">
   <div class="col-xl-5">
      <div class="card">
         <div class="card-header">
            <div class="card-title">Daftar Kelas</div>
         </div>
         <div class="card-datatable table-responsive">
            <table class="table table-sm table-hover table-striped table-borderless" id="tb_class_list">
               <thead>
                  <tr>
                     <th>No</th>
                     <th>Nama Kelas</th>
                     <th>Aksi</th>
                  </tr>
               </thead>
            </table>
         </div>
      </div>
   </div>
   <div class="col-xl-7">
      <div class="card">
         <div class="card-header">
            <div class="card-title">Daftar Grup Kelas</div>
         </div>
         <table class="table table-hover table-striped table-borderless" id="tb_class_group_list">
            <thead>
               <tr>
                  <th>No</th>
                  <th>Kode Kelas</th>
                  <th>Nama Kelas</th>
                  <th>Aksi</th>
               </tr>
            </thead>
         </table>
      </div>
   </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('vendorJS') ?>
<script src="<?= base_url('app-assets/vendors/js/tables/datatable/datatables.min.js') ?>"></script>
<script src="<?= base_url('app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('app-assets/vendors/js/tables/datatable/datatables.buttons.min.js') ?>"></script>
<script src="<?= base_url('app-assets/vendors/js/forms/select/select2.full.min.js') ?>"></script>
<?= $this->endSection() ?>
<?= $this->section('customJS') ?>
<script>
   $(document).ready(function() {
      var csrf_token = "<?= csrf_hash() ?>";
      var tb_class_list = $('#tb_class_list').DataTable({
         dom: '<"card-header py-0"<"dt-action-buttons"B>><"d-flex justify-content-between align-items-center mx-1 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-1 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
         order: [
            [1, 'asc']
         ],
         serverSide: true,
         processing: true,
         ajax: {
            url: "<?= base_url('classes/get_classes') ?>",
            type: "post",
            dataType: "json",
            data: function(data) {
               data.<?= csrf_token() ?> = csrf_token;
            },
            dataSrc: function(result) {
               csrf_token = result.<?= csrf_token() ?>;
               return result.data;
            }
         },
         columns: [{
               "data": "class_id",
               "mRender": function(data, row, type, meta) {
                  return meta.row + meta.settings._iDisplayStart + 1;
               },
               "className": "text-center"
            },
            {
               "data": "class_name",
               "className": "text-center"
            },
            {
               "data": "class_id",
               "mRender": function(class_id, row, data) {
                  return '<div class="btn-actions" data-class_id="' + class_id + '"><button class="btn btn-flat-info btn-icon rounded-circle edit-class" title="Edit" data-toggle="modal" data-target="#modal-edit-class">' + feather.icons['edit'].toSvg({
                     class: 'font-medium-2'
                  }) + '</button><button class="btn btn-flat-danger btn-icon rounded-circle delete-class" title="Hapus">' + feather.icons['trash'].toSvg({
                     class: 'font-medium-2'
                  }) + '</button></div>';
               },
               "className": "text-center",
               "orderable": false
            }
         ],
         buttons: [{
            className: 'btn btn-primary',
            text: 'Tambah Kelas',
            attr: {
               "data-toggle": "modal",
               "data-target": "#modal-add-class"
            }
         }]
      })
      var tb_class_group_list = $('#tb_class_group_list').DataTable({
         dom: '<"card-header py-0"<"dt-action-buttons"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
         order: [
            [2, 'asc']
         ],
         serverSide: true,
         processing: true,
         ajax: {
            url: "<?= base_url('classes/get_class_groups') ?>",
            type: "post",
            dataType: "json",
            data: function(data) {
               data.<?= csrf_token() ?> = csrf_token;
            },
            dataSrc: function(result) {
               csrf_token = result.<?= csrf_token() ?>;
               return result.data;
            }
         },
         columns: [{
               "data": "class_group_id",
               "mRender": function(data, row, type, meta) {
                  return meta.row + meta.settings._iDisplayStart + 1;
               },
               "className": "text-center"
            },
            {
               "data": "class_group_code",
               "className": "text-center"
            },
            {
               "data": "class_group_name",
               "className": "text-center"
            },
            {
               "data": "class_group_code",
               "mRender": function(class_group_code, row, data) {
                  return '<div class="btn-actions" data-class_group_code="' + class_group_code + '"><button class="btn btn-flat-info btn-icon rounded-circle edit-class-group" title="Edit" data-toggle="modal" data-target="#modal-edit-class-group">' + feather.icons['edit'].toSvg({
                     class: 'font-medium-2'
                  }) + '</button><button class="btn btn-flat-danger btn-icon rounded-circle delete-class-group" title="Hapus">' + feather.icons['trash'].toSvg({
                     class: 'font-medium-2'
                  }) + '</button></div>';
               },
               "className": "text-center",
               "orderable": false
            }
         ],
         buttons: [{
            className: 'btn btn-primary',
            text: 'Tambah Grup Kelas',
            attr: {
               "data-toggle": "modal",
               "data-target": "#modal-add-class-group"
            }
         }]
      })
      $('.select2-class').select2({
         placeholder: ' -- Pilih Kelas -- '
      });
      $('.select2-major').select2({
         placeholder: ' -- Pilih Jurusan -- '
      });
      // Class
      $(document).on('click', '.edit-class', function() {
         var data = tb_class_list.row($(this).parents('tbody tr')).data();
         $('#edit-class [name=class_id]').val(data.class_id);
         $('#edit-class [name=class_name]').val(data.class_name);
      })
      $(document).on('submit', '#add-class', function(e) {
         e.preventDefault();
         $(this).find('.is-invalid').removeClass('is-invalid');
         $(this).find('.invalid-feedback').text(null);
         var form = $(this);
         var data = $(this).serialize();
         $.ajax({
            url: "<?= base_url('api/classes') ?>",
            type: "post",
            dataType: "json",
            data: data,
            headers: {
               Authorization: "<?= session()->token ?>"
            },
            beforeSend: function() {
               $.blockUI(set_blockUI);
            },
            success: function(result) {
               $.unblockUI();
               if (result.error == false) {
                  $('#modal-add-class').modal('hide');
                  Swal.fire({
                     title: "Success!",
                     text: result.message,
                     icon: "success",
                     showConfirmButton: false,
                     timer: 3000
                  }).then(function() {
                     tb_class_list.ajax.reload();
                  })
               } else if (result.error == true) {
                  Swal.fire({
                     title: "Failed!",
                     text: result.message,
                     icon: "error",
                     showConfirmButton: false,
                     timer: 3000
                  })
               } else {
                  Object.entries(result.errors).forEach(function(key, value) {
                     form.find('[name=' + key[0] + ']').addClass('is-invalid');
                     form.find('[name=' + key[0] + ']').closest('.form-group').find('.invalid-feedback').text(key[1]);
                  })
               }
            },
            error: function() {
               $.unblockUI();
               Swal.fire({
                  title: "Error!",
                  text: "An error occurred on the server.",
                  icon: "error",
                  showConfirmButton: false,
                  timer: 3000
               })
            }
         })
         return false;
      })
      $(document).on('submit', '#edit-class', function(e) {
         e.preventDefault();
         $(this).find('.is-invalid').removeClass('is-invalid');
         $(this).find('.invalid-feedback').text(null);
         var form = $(this);
         var data = $(this).serialize();
         var class_id = $(this).find('[name=class_id]').val();
         $.ajax({
            url: "<?= base_url('api/classes') ?>/" + class_id,
            type: "put",
            dataType: "json",
            data: data,
            headers: {
               Authorization: "<?= session()->token ?>"
            },
            beforeSend: function() {
               $.blockUI(set_blockUI);
            },
            success: function(result) {
               $.unblockUI();
               if (result.error == false) {
                  $('#modal-edit-class').modal('hide');
                  Swal.fire({
                     title: "Success!",
                     text: result.message,
                     icon: "success",
                     showConfirmButton: false,
                     timer: 3000
                  }).then(function() {
                     tb_class_list.ajax.reload();
                  })
               } else if (result.error == true) {
                  Swal.fire({
                     title: "Failed!",
                     text: result.message,
                     icon: "error",
                     showConfirmButton: false,
                     timer: 3000
                  })
               } else {
                  Object.entries(result.errors).forEach(function(key, value) {
                     form.find('[name=' + key[0] + ']').addClass('is-invalid');
                     form.find('[name=' + key[0] + ']').closest('.form-group').find('.invalid-feedback').text(key[1]);
                  })
               }
            },
            error: function() {
               $.unblockUI();
               Swal.fire({
                  title: "Error!",
                  text: "An error occurred on the server.",
                  icon: "error",
                  showConfirmButton: false,
                  timer: 3000
               })
            }
         })
         return false;
      })
      $(document).on('click', '.delete-class', function() {
         var class_id = $(this).parents('.btn-actions').data('class_id');
         Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
            customClass: {
               confirmButton: "btn btn-primary",
               cancelButton: "btn btn-outline-danger ml-1"
            },
            buttonsStyling: false
         }).then((result) => {
            if (result.value) {
               $.ajax({
                  url: "<?= base_url('api/classes') ?>/" + class_id,
                  type: "delete",
                  dataType: "json",
                  headers: {
                     Authorization: "<?= session()->token ?>"
                  },
                  beforeSend: function() {
                     $.blockUI(set_blockUI);
                  },
                  success: function(result) {
                     $.unblockUI();
                     if (result.error == false) {
                        Swal.fire({
                           title: "Success!",
                           text: result.message,
                           icon: "success",
                           showConfirmButton: false,
                           timer: 3000
                        }).then(function() {
                           tb_class_list.ajax.reload();
                        })
                     } else {
                        Swal.fire({
                           title: "Failed!",
                           text: result.message,
                           icon: "error",
                           showConfirmButton: false,
                           timer: 3000
                        })
                     }
                  },
                  error: function() {
                     $.unblockUI();
                     Swal.fire({
                        title: "Error!",
                        text: "An error occurred on the server.",
                        icon: "error",
                        showConfirmButton: false,
                        timer: 3000
                     })
                  }
               })
            }
         })
      })
      // Class Group
      $(document).on('click', '.edit-class-group', function() {
         var class_group_code = $(this).parents('.btn-actions').data('class_group_code');
         $.ajax({
            url: "<?= base_url('api/classgroup') ?>/" + class_group_code,
            type: "get",
            dataType: "json",
            headers: {
               Authorization: "<?= session()->token ?>"
            },
            success: function(result) {
               if (result.error === false) {
                  $('#edit-class-group [name=class_group_code]').val(result.data.class_group_code);
                  $('#edit-class-group [name=class]').val(result.data.class_id).trigger('change');
                  $('#edit-class-group [name=major]').val(result.data.major_id).trigger('change');
                  $('#edit-class-group [name=unit_major]').val(result.data.unit_major);
               } else if (result.error === true) {

               } else {

               }
            },
            error: function() {

            }
         })
      })
      $(document).on('submit', '#add-class-group', function(e) {
         e.preventDefault();
         $(this).find('.is-invalid').removeClass('is-invalid');
         $(this).find('.invalid-feedback').text(null);
         var form = $(this);
         var data = $(this).serialize();
         $.ajax({
            url: "<?= base_url('api/classgroup') ?>",
            type: "post",
            dataType: "json",
            data: data,
            headers: {
               Authorization: "<?= session()->token ?>"
            },
            beforeSend: function() {
               $.blockUI(set_blockUI);
            },
            success: function(result) {
               $.unblockUI();
               if (result.error == false) {
                  $('#modal-add-class-group').modal('hide');
                  Swal.fire({
                     title: "Success!",
                     text: result.message,
                     icon: "success",
                     showConfirmButton: false,
                     timer: 3000
                  }).then(function() {
                     tb_class_group_list.ajax.reload();
                  })
               } else if (result.error == true) {
                  Swal.fire({
                     title: "Failed!",
                     text: result.message,
                     icon: "error",
                     showConfirmButton: false,
                     timer: 3000
                  })
               } else {
                  Object.entries(result.errors).forEach(function(key, value) {
                     form.find('[name=' + key[0] + ']').addClass('is-invalid');
                     form.find('[name=' + key[0] + ']').closest('.form-group').find('.invalid-feedback').text(key[1]);
                  })
               }
            },
            error: function() {
               $.unblockUI();
               Swal.fire({
                  title: "Error!",
                  text: "An error occurred on the server.",
                  icon: "error",
                  showConfirmButton: false,
                  timer: 3000
               })
            }
         })
         return false;
      })
      $(document).on('submit', '#edit-class-group', function(e) {
         e.preventDefault();
         $(this).find('.is-invalid').removeClass('is-invalid');
         $(this).find('.invalid-feedback').text(null);
         var form = $(this);
         var data = $(this).serialize();
         var class_group_code = $(this).find('[name=class_group_code]').val();
         $.ajax({
            url: "<?= base_url('api/classgroup') ?>/" + class_group_code,
            type: "put",
            dataType: "json",
            data: data,
            headers: {
               Authorization: "<?= session()->token ?>"
            },
            beforeSend: function() {
               $.blockUI(set_blockUI);
            },
            success: function(result) {
               $.unblockUI();
               if (result.error == false) {
                  $('#modal-edit-class-group').modal('hide');
                  Swal.fire({
                     title: "Success!",
                     text: result.message,
                     icon: "success",
                     showConfirmButton: false,
                     timer: 3000
                  }).then(function() {
                     tb_class_group_list.ajax.reload();
                  })
               } else if (result.error == true) {
                  Swal.fire({
                     title: "Failed!",
                     text: result.message,
                     icon: "error",
                     showConfirmButton: false,
                     timer: 3000
                  })
               } else {
                  Object.entries(result.errors).forEach(function(key, value) {
                     form.find('[name=' + key[0] + ']').addClass('is-invalid');
                     form.find('[name=' + key[0] + ']').closest('.form-group').find('.invalid-feedback').text(key[1]);
                  })
               }
            },
            error: function() {
               $.unblockUI();
               Swal.fire({
                  title: "Error!",
                  text: "An error occurred on the server.",
                  icon: "error",
                  showConfirmButton: false,
                  timer: 3000
               })
            }
         })
         return false;
      })
      $(document).on('click', '.delete-class-group', function() {
         var class_group_code = $(this).parents('.btn-actions').data('class_group_code');
         Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
            customClass: {
               confirmButton: "btn btn-primary",
               cancelButton: "btn btn-outline-danger ml-1"
            },
            buttonsStyling: false
         }).then((result) => {
            if (result.value) {
               $.ajax({
                  url: "<?= base_url('api/classgroup') ?>/" + class_group_code,
                  type: "delete",
                  dataType: "json",
                  headers: {
                     Authorization: "<?= session()->token ?>"
                  },
                  beforeSend: function() {
                     $.blockUI(set_blockUI);
                  },
                  success: function(result) {
                     $.unblockUI();
                     if (result.error == false) {
                        Swal.fire({
                           title: "Success!",
                           text: result.message,
                           icon: "success",
                           showConfirmButton: false,
                           timer: 3000
                        }).then(function() {
                           tb_class_group_list.ajax.reload();
                        })
                     } else {
                        Swal.fire({
                           title: "Failed!",
                           text: result.message,
                           icon: "error",
                           showConfirmButton: false,
                           timer: 3000
                        })
                     }
                  },
                  error: function() {
                     $.unblockUI();
                     Swal.fire({
                        title: "Error!",
                        text: "An error occurred on the server.",
                        icon: "error",
                        showConfirmButton: false,
                        timer: 3000
                     })
                  }
               })
            }
         })
      })
   })
</script>
<?= $this->endSection() ?>