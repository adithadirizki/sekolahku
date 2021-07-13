<?= $this->extend('template') ?>
<?= $this->section('vendorCSS') ?>
<link rel="stylesheet" href="<?= base_url('app-assets/vendors/css/tables/datatable/datatables.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css') ?>">
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="modal fade" id="modal-add-assignment" role="dialog" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h2 class="modal-title">
               Tambah Tugas
            </h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form id="add-assignment" enctype="multipart/form-data" onsubmit="return false;">
            <div class="modal-body">
               <div class="form-group">
                  <label>Nama Tugas <span class="text-danger font-small-4">*</span></label>
                  <input type="text" class="form-control" name="assignment_name" placeholder="Nama Tugas" required>
                  <div class="invalid-feedback"></div>
               </div>
               <div class="form-group">
                  <label>Kode Tugas <span class="text-danger font-small-4">*</span></label>
                  <input type="text" class="form-control" name="assignment_code" placeholder="Kode Tugas" required>
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
<div class="modal fade" id="modal-edit-assignment" role="dialog" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h2 class="modal-title">
               Edit Tugas
            </h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form id="edit-assignment" enctype="multipart/form-data" onsubmit="return false;">
            <div class="modal-body">
               <div class="form-group">
                  <label>Nama Tugas <span class="text-danger font-small-4">*</span></label>
                  <input type="hidden" class="form-control" name="assignment_id" disabled>
                  <input type="text" class="form-control" name="assignment_name" placeholder="Nama Tugas" required>
                  <div class="invalid-feedback"></div>
               </div>
               <div class="form-group">
                  <label>Kode Tugas <span class="text-danger font-small-4">*</span></label>
                  <input type="text" class="form-control" name="assignment_code" placeholder="Kode Tugas" required>
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
      <div class="card-title">Daftar Tugas</div>
   </div>
   <div class="card-datatable table-responsive">
      <table class="table table-hover table-striped table-bordered" id="tb_assignment_list">
         <thead class="text-center">
            <tr>
               <th>No</th>
               <th>Kode Tugas</th>
               <th>Judul Tugas</th>
               <th>Mata Pelajaran</th>
               <th>Dibuat Oleh</th>
               <th>Dibuat Pada</th>
               <th>Aksi</th>
            </tr>
         </thead>
      </table>
   </div>
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
      var tb_assignment_list = $('#tb_assignment_list').DataTable({
         dom: '<"card-header py-0"<"dt-action-buttons"B>><"d-flex justify-content-between align-items-center mx-1 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-1 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
         order: [
            [1, 'asc']
         ],
         serverSide: true,
         processing: true,
         ajax: {
            url: "<?= base_url('assignment/get_assignments') ?>",
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
               "data": "assignment_id",
               "mRender": function(data, row, type, meta) {
                  return meta.row + meta.settings._iDisplayStart + 1;
               },
               "className": "text-center"
            },
            {
               "data": "assignment_code",
               "className": "text-center"
            },
            {
               "data": "assignment_title"
            },
            {
               "data": "subject_name",
               "className": "text-center"
            },
            {
               "data": "assigned"
            },
            {
               "data": "start_at",
               "mRender": function(start_at) {
                  return start_at + ' WIB';
               },
               "className": "text-center"
            },
            {
               "data": "assignment_code",
               "mRender": function(assignment_code, row, data) {
                  return '<div class="dropdown" data-assignment_code="' + assignment_code + '"><button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">' + feather.icons['more-vertical'].toSvg({
                     class: 'font-medium-2'
                  }) + '</button><div class="dropdown-menu"><a class="dropdown-item show-assignment text-primary" href="<?= base_url('assignment') ?>/' + assignment_code + '">' + feather.icons['search'].toSvg({
                     class: 'font-medium-2'
                  }) + ' <span>Lihat</span></a><a class="dropdown-item edit-assignment text-info" href="<?= base_url('assignment') ?>/' + assignment_code + '/edit">' + feather.icons['edit'].toSvg({
                     class: 'font-medium-2'
                  }) + ' <span>Edit</span></a><a class="dropdown-item delete-assignment text-danger" href="javascript:void(0);">' + feather.icons['trash'].toSvg({
                     class: 'font-medium-2'
                  }) + ' <span>Hapus</span></a></div></div>';
               },
               "className": "text-center",
               "orderable": false
            }
         ],
         buttons: [{
            className: 'btn btn-primary',
            text: 'Tambah Tugas',
            attr: {
               "data-toggle": "modal",
               "data-target": "#modal-add-assignment"
            }
         }]
      })
      $(document).on('click', '.edit-assignment', function() {
         var data = tb_assignment_list.row($(this).parents('tbody tr')).data();
         $('#edit-assignment [name=assignment_id]').val(data.assignment_id);
         $('#edit-assignment [name=assignment_name]').val(data.assignment_name);
         $('#edit-assignment [name=assignment_code]').val(data.assignment_code);
      })
      $(document).on('submit', '#add-assignment', function(e) {
         e.preventDefault();
         $(this).find('.is-invalid').removeClass('is-invalid');
         $(this).find('.invalid-feedback').text(null);
         var form = $(this);
         var data = $(this).serialize();
         $.ajax({
            url: "<?= base_url('api/assignment') ?>",
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
                  $('#modal-add-assignment').modal('hide');
                  Swal.fire({
                     title: "Success!",
                     text: result.message,
                     icon: "success",
                     showConfirmButton: false,
                     timer: 3000
                  }).then(function() {
                     tb_assignment_list.ajax.reload();
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
      $(document).on('submit', '#edit-assignment', function(e) {
         e.preventDefault();
         $(this).find('.is-invalid').removeClass('is-invalid');
         $(this).find('.invalid-feedback').text(null);
         var form = $(this);
         var data = $(this).serialize();
         var assignment_id = $(this).find('[name=assignment_id]').val();
         $.ajax({
            url: "<?= base_url('api/assignment') ?>/" + assignment_id,
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
                  $('#modal-edit-assignment').modal('hide');
                  Swal.fire({
                     title: "Success!",
                     text: result.message,
                     icon: "success",
                     showConfirmButton: false,
                     timer: 3000
                  }).then(function() {
                     tb_assignment_list.ajax.reload();
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
      $(document).on('click', '.delete-assignment', function() {
         var assignment_id = $(this).parents('.btn-actions').data('assignment_id');
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
                  url: "<?= base_url('api/assignment') ?>/" + assignment_id,
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
                           tb_assignment_list.ajax.reload();
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