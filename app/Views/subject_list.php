<?= $this->extend('template') ?>
<?= $this->section('vendorCSS') ?>
<link rel="stylesheet" href="<?= base_url('app-assets/vendors/css/tables/datatable/datatables.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css') ?>">
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="modal fade" id="modal-add-subject" role="dialog" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h2 class="modal-title">
               Tambah Mata Pelajaran
            </h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form id="add-subject" enctype="multipart/form-data" onsubmit="return false;">
            <div class="modal-body">
               <div class="form-group">
                  <label>Nama Mata Pelajaran <span class="text-danger font-small-4">*</span></label>
                  <input type="text" class="form-control" name="subject_name" placeholder="Nama Mata Pelajaran" required>
                  <div class="invalid-feedback"></div>
               </div>
               <div class="form-group">
                  <label>Kode Mata Pelajaran <span class="text-danger font-small-4">*</span></label>
                  <input type="text" class="form-control" name="subject_code" placeholder="Kode Mata Pelajaran" required>
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
<div class="modal fade" id="modal-edit-subject" role="dialog" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h2 class="modal-title">
               Edit Mata Pelajaran
            </h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form id="edit-subject" enctype="multipart/form-data" onsubmit="return false;">
            <div class="modal-body">
               <div class="form-group">
                  <label>Nama Mata Pelajaran <span class="text-danger font-small-4">*</span></label>
                  <input type="hidden" class="form-control" name="subject_id" disabled>
                  <input type="text" class="form-control" name="subject_name" placeholder="Nama Mata Pelajaran" required>
                  <div class="invalid-feedback"></div>
               </div>
               <div class="form-group">
                  <label>Kode Mata Pelajaran <span class="text-danger font-small-4">*</span></label>
                  <input type="text" class="form-control" name="subject_code" placeholder="Kode Mata Pelajaran" required>
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
      <div class="card-title">Daftar Mata Pelajaran</div>
   </div>
   <table class="table table-hover table-striped table-bordered" id="tb_subject_list">
      <thead class="text-center">
         <tr>
            <th>No</th>
            <th>Nama Mata Pelajaran</th>
            <th>Kode Mata Pelajaran</th>
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
      var tb_subject_list = $('#tb_subject_list').DataTable({
         dom: '<"card-header py-0"<"dt-action-buttons"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
         order: [
            [1, 'asc']
         ],
         serverSide: true,
         processing: true,
         ajax: {
            url: "<?= base_url('subject/get_subjects') ?>",
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
               "data": "subject_id",
               "mRender": function(data, row, type, meta) {
                  return meta.row + meta.settings._iDisplayStart + 1;
               },
               "className": "text-center"
            },
            {
               "data": "subject_name"
            },
            {
               "data": "subject_code",
               "className": "text-center"
            },
            {
               "data": "subject_id",
               "mRender": function(subject_id, row, data) {
                  return '<div class="btn-actions" data-subject_id="' + subject_id + '"><button class="btn btn-flat-info btn-icon rounded-circle edit-subject" title="Edit" data-toggle="modal" data-target="#modal-edit-subject">' + feather.icons['edit'].toSvg({
                     class: 'font-medium-2'
                  }) + '</button><button class="btn btn-flat-danger btn-icon rounded-circle delete-subject" title="Hapus">' + feather.icons['trash'].toSvg({
                     class: 'font-medium-2'
                  }) + '</button></div>';
               },
               "className": "text-center",
               "orderable": false
            }
         ],
         buttons: [{
            className: 'btn btn-primary',
            text: 'Tambah Mata Pelajaran',
            attr: {
               "data-toggle": "modal",
               "data-target": "#modal-add-subject"
            }
         }]
      })
      // Class
      $(document).on('click', '.edit-subject', function() {
         var data = tb_subject_list.row($(this).parents('tbody tr')).data();
         $('#edit-subject [name=subject_id]').val(data.subject_id);
         $('#edit-subject [name=subject_name]').val(data.subject_name);
         $('#edit-subject [name=subject_code]').val(data.subject_code);
      })
      $(document).on('submit', '#add-subject', function(e) {
         e.preventDefault();
         $(this).find('.is-invalid').removeClass('is-invalid');
         $(this).find('.invalid-feedback').text(null);
         var form = $(this);
         var data = $(this).serialize();
         $.ajax({
            url: "<?= base_url('api/subject') ?>",
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
                  $('#modal-add-subject').modal('hide');
                  Swal.fire({
                     title: "Success!",
                     text: result.message,
                     icon: "success",
                     showConfirmButton: false,
                     timer: 3000
                  }).then(function() {
                     tb_subject_list.ajax.reload();
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
      $(document).on('submit', '#edit-subject', function(e) {
         e.preventDefault();
         $(this).find('.is-invalid').removeClass('is-invalid');
         $(this).find('.invalid-feedback').text(null);
         var form = $(this);
         var data = $(this).serialize();
         var subject_id = $(this).find('[name=subject_id]').val();
         $.ajax({
            url: "<?= base_url('api/subject') ?>/" + subject_id,
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
                  $('#modal-edit-subject').modal('hide');
                  Swal.fire({
                     title: "Success!",
                     text: result.message,
                     icon: "success",
                     showConfirmButton: false,
                     timer: 3000
                  }).then(function() {
                     tb_subject_list.ajax.reload();
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
      $(document).on('click', '.delete-subject', function() {
         var subject_id = $(this).parents('.btn-actions').data('subject_id');
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
                  url: "<?= base_url('api/subject') ?>/" + subject_id,
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
                           tb_subject_list.ajax.reload();
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