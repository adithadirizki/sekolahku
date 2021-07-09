<?= $this->extend('template') ?>
<?= $this->section('vendorCSS') ?>
<link rel="stylesheet" href="<?= base_url('app-assets/vendors/css/tables/datatable/datatables.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css') ?>">
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="modal fade" id="modal-add-major" role="dialog" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h2 class="modal-title">
               Tambah Jurusan
            </h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form id="add-major" enctype="multipart/form-data" onsubmit="return false;">
            <div class="modal-body">
               <div class="form-group">
                  <label>Nama Jurusan <span class="text-danger font-small-4">*</span></label>
                  <input type="text" class="form-control" name="major_name" placeholder="Nama Jurusan" required>
                  <div class="invalid-feedback"></div>
               </div>
               <div class="form-group">
                  <label>Kode Jurusan <span class="text-danger font-small-4">*</span></label>
                  <input type="text" class="form-control" name="major_code" placeholder="Kode Jurusan" required>
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
<div class="modal fade" id="modal-edit-major" role="dialog" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h2 class="modal-title">
               Edit Jurusan
            </h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form id="edit-major" enctype="multipart/form-data" onsubmit="return false;">
            <div class="modal-body">
               <div class="form-group">
                  <label>Nama Jurusan <span class="text-danger font-small-4">*</span></label>
                  <input type="hidden" class="form-control" name="major_id" disabled>
                  <input type="text" class="form-control" name="major_name" placeholder="Nama Jurusan" required>
                  <div class="invalid-feedback"></div>
               </div>
               <div class="form-group">
                  <label>Kode Jurusan <span class="text-danger font-small-4">*</span></label>
                  <input type="text" class="form-control" name="major_code" placeholder="Kode Jurusan" required>
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
<div class="card">
   <div class="card-header">
      <div class="card-title">Daftar Jurusan</div>
   </div>
   <table class="table table-hover table-striped table-bordered" id="tb_major_list">
      <thead class="text-center">
         <tr>
            <th>No</th>
            <th>Nama Jurusan</th>
            <th>Kode Jurusan</th>
            <th>Aksi</th>
         </tr>
      </thead>
   </table>
</div>
<?= $this->endSection() ?>
<?= $this->section('vendorJS') ?>
<script src="<?= base_url('app-assets/vendors/js/tables/datatable/datatables.min.js') ?>"></script>
<script src="<?= base_url('app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('app-assets/vendors/js/tables/datatable/datatables.buttons.min.js') ?>"></script>
<?= $this->endSection() ?>
<?= $this->section('customJS') ?>
<script>
   $(document).ready(function() {
      var csrf_token = "<?= csrf_hash() ?>";
      var tb_major_list = $('#tb_major_list').DataTable({
         dom: '<"card-header py-0"<"dt-action-buttons"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
         order: [
            [1, 'asc']
         ],
         serverSide: true,
         processing: true,
         ajax: {
            url: "<?= base_url('major/get_majors') ?>",
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
               "data": "major_id",
               "mRender": function(data, row, type, meta) {
                  return meta.row + meta.settings._iDisplayStart + 1;
               },
               "className": "text-center"
            },
            {
               "data": "major_name"
            },
            {
               "data": "major_code",
               "className": "text-center"
            },
            {
               "data": "major_id",
               "mRender": function(major_id, row, data) {
                  return '<div class="btn-actions" data-major_id="' + major_id + '"><button class="btn btn-flat-info btn-icon rounded-circle edit-major" title="Edit" data-toggle="modal" data-target="#modal-edit-major">' + feather.icons['edit'].toSvg({
                     class: 'font-medium-2'
                  }) + '</button><button class="btn btn-flat-danger btn-icon rounded-circle delete-major" title="Hapus">' + feather.icons['trash'].toSvg({
                     class: 'font-medium-2'
                  }) + '</button></div>';
               },
               "className": "text-center",
               "orderable": false
            }
         ],
         buttons: [{
            className: 'btn btn-primary',
            text: 'Tambah Jurusan',
            attr: {
               "data-toggle": "modal",
               "data-target": "#modal-add-major"
            }
         }]
      })
      // Class
      $(document).on('click', '.edit-major', function() {
         var data = tb_major_list.row($(this).parents('tbody tr')).data();
         $('#edit-major [name=major_id]').val(data.major_id);
         $('#edit-major [name=major_name]').val(data.major_name);
         $('#edit-major [name=major_code]').val(data.major_code);
      })
      $(document).on('submit', '#add-major', function(e) {
         e.preventDefault();
         $(this).find('.is-invalid').removeClass('is-invalid');
         $(this).find('.invalid-feedback').text(null);
         var form = $(this);
         var data = $(this).serialize();
         $.ajax({
            url: "<?= base_url('api/major') ?>",
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
                  $('#modal-add-major').modal('hide');
                  Swal.fire({
                     title: "Success!",
                     text: result.message,
                     icon: "success",
                     showConfirmButton: false,
                     timer: 3000
                  }).then(function() {
                     tb_major_list.ajax.reload();
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
      $(document).on('submit', '#edit-major', function(e) {
         e.preventDefault();
         $(this).find('.is-invalid').removeClass('is-invalid');
         $(this).find('.invalid-feedback').text(null);
         var form = $(this);
         var data = $(this).serialize();
         var major_id = $(this).find('[name=major_id]').val();
         $.ajax({
            url: "<?= base_url('api/major') ?>/" + major_id,
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
                  $('#modal-edit-major').modal('hide');
                  Swal.fire({
                     title: "Success!",
                     text: result.message,
                     icon: "success",
                     showConfirmButton: false,
                     timer: 3000
                  }).then(function() {
                     tb_major_list.ajax.reload();
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
      $(document).on('click', '.delete-major', function() {
         var major_id = $(this).parents('.btn-actions').data('major_id');
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
                  url: "<?= base_url('api/major') ?>/" + major_id,
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
                           tb_major_list.ajax.reload();
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