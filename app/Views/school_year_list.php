<?= $this->extend('template') ?>
<?= $this->section('vendorCSS') ?>
<link rel="stylesheet" href="<?= base_url('app-assets/vendors/css/tables/datatable/datatables.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css') ?>">
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="modal fade" id="modal-add-school-year" role="dialog" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h2 class="modal-title">
               Tambah Tahun Pelajaran
            </h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form id="add-school-year" enctype="multipart/form-data" onsubmit="return false;">
            <div class="modal-body">
               <div class="form-group">
                  <label>Tahun Pelajaran <span class="text-danger font-small-4">*</span></label>
                  <input type="text" class="form-control" name="school_year_title" placeholder="Tahun Pelajaran" required>
                  <div class="invalid-feedback"></div>
               </div>
               <div class="form-group">
                  <label>Status <span class="text-danger font-small-4">*</span></label>
                  <div class="d-flex">
                     <div class="custom-control custom-control-success custom-radio mr-1">
                        <input type="radio" name="school_year_status" id="status11" class="custom-control-input" value="1" required>
                        <label class="custom-control-label" for="status11">Aktif</label>
                     </div>
                     <div class="custom-control custom-control-danger custom-radio">
                        <input type="radio" name="school_year_status" id="status12" class="custom-control-input" value="0" checked>
                        <label class="custom-control-label" for="status12">Tidak Aktif</label>
                     </div>
                  </div>
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
<div class="modal fade" id="modal-edit-school-year" role="dialog" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h2 class="modal-title">
               Edit Tahun Pelajaran
            </h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form id="edit-school-year" enctype="multipart/form-data" onsubmit="return false;">
            <div class="modal-body">
               <div class="form-group">
                  <label>Tahun Pelajaran <span class="text-danger font-small-4">*</span></label>
                  <input type="hidden" class="form-control" name="school_year_id" disabled>
                  <input type="text" class="form-control" name="school_year_title" placeholder="Tahun Pelajaran" required>
                  <div class="invalid-feedback"></div>
               </div>
               <div class="form-group">
                  <label>Status <span class="text-danger font-small-4">*</span></label>
                  <div class="d-flex">
                     <div class="custom-control custom-control-success custom-radio mr-1">
                        <input type="radio" name="school_year_status" id="status21" class="custom-control-input" value="1" required>
                        <label class="custom-control-label" for="status21">Aktif</label>
                     </div>
                     <div class="custom-control custom-control-danger custom-radio">
                        <input type="radio" name="school_year_status" id="status22" class="custom-control-input" value="0">
                        <label class="custom-control-label" for="status22">Tidak Aktif</label>
                     </div>
                  </div>
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
<div class="alert alert-primary" role="alert">
   <div class="alert-body"><strong>Penting!</strong> Tahun Pelajaran <code class="text-success">Aktif</code> tidak bisa dihapus atau diubah menjadi  <code>Tidak Aktif</code>.</div>
</div>
<div class="card">
   <div class="card-header">
      <div class="card-title">Daftar Tahun Pelajaran</div>
   </div>
   <table class="table table-hover table-striped table-bordered" id="tb_school_year_list">
      <thead class="text-center">
         <tr>
            <th>No</th>
            <th>Tahun Pelajaran</th>
            <th>Status</th>
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
      var tb_school_year_list = $('#tb_school_year_list').DataTable({
         dom: '<"card-header py-0"<"dt-action-buttons"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
         order: [
            [1, 'desc']
         ],
         serverSide: true,
         processing: true,
         ajax: {
            url: "<?= base_url('schoolyear/get_school_years') ?>",
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
               "data": "school_year_id",
               "mRender": function(data, row, type, meta) {
                  return meta.row + meta.settings._iDisplayStart + 1;
               },
               "className": "text-center"
            },
            {
               "data": "school_year_title",
               "className": "text-center"
            },
            {
               "data": "school_year_status",
               "mRender": function(school_year_status) {
                  var text = {
                     "0": "Tidak Aktif",
                     "1": "Aktif"
                  }
                  var color = {
                     "0": "danger",
                     "1": "success"
                  }
                  return '<span class="badge badge-pill badge-light-' + color[school_year_status] + '">' + text[school_year_status] + '</span>';
               },
               "className": "text-center"
            },
            {
               "data": "school_year_id",
               "mRender": function(school_year_id, row, data) {
                  if (data.school_year_status == 0) {
                     return '<div class="btn-actions" data-school-year_id="' + school_year_id + '"><button class="btn btn-flat-info btn-icon rounded-circle edit-school-year" title="Edit" data-toggle="modal" data-target="#modal-edit-school-year">' + feather.icons['edit'].toSvg({
                        class: 'font-medium-2'
                     }) + '</button><button class="btn btn-flat-danger btn-icon rounded-circle delete-school-year" title="Hapus">' + feather.icons['trash'].toSvg({
                        class: 'font-medium-2'
                     }) + '</button></div>';
                  } else if (data.school_year_status == 1) {
                     return '<div class="btn-actions" data-school-year_id="' + school_year_id + '"><button class="btn btn-flat-info btn-icon rounded-circle edit-school-year" title="Edit" data-toggle="modal" data-target="#modal-edit-school-year">' + feather.icons['edit'].toSvg({
                        class: 'font-medium-2'
                     }) + '</button></div>';
                  }
               },
               "className": "text-center",
               "orderable": false
            }
         ],
         buttons: [{
            className: 'btn btn-primary',
            text: 'Tambah Tahun Pelajaran',
            attr: {
               "data-toggle": "modal",
               "data-target": "#modal-add-school-year"
            }
         }]
      })
      // Class
      $(document).on('click', '.edit-school-year', function() {
         var data = tb_school_year_list.row($(this).parents('tbody tr')).data();
         $('#edit-school-year [name=school_year_id]').val(data.school_year_id);
         $('#edit-school-year [name=school_year_title]').val(data.school_year_title);
         $('#edit-school-year [name=school_year_status][value=' + data.school_year_status + ']').prop('checked', true);
         if (data.school_year_status == 1) {
            $('#edit-school-year [name=school_year_status][value=0]').prop('disabled', true);
         } else if (data.school_year_status == 0) {
            $('#edit-school-year [name=school_year_status]').prop('disabled', false);
         }
      })
      $(document).on('submit', '#add-school-year', function(e) {
         e.preventDefault();
         $(this).find('.is-invalid').removeClass('is-invalid');
         $(this).find('.invalid-feedback').removeClass('d-block').text(null);
         var form = $(this);
         var data = $(this).serialize();
         $.ajax({
            url: "<?= base_url('api/schoolyear') ?>",
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
                  $('#modal-add-school-year').modal('hide');
                  Swal.fire({
                     title: "Success!",
                     text: result.message,
                     icon: "success",
                     showConfirmButton: false,
                     timer: 3000
                  }).then(function() {
                     tb_school_year_list.ajax.reload();
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
                     form.find('[name=' + key[0] + ']').closest('.form-group').find('.invalid-feedback').addClass('d-block').text(key[1]);
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
      $(document).on('submit', '#edit-school-year', function(e) {
         e.preventDefault();
         $(this).find('.is-invalid').removeClass('is-invalid');
         $(this).find('.invalid-feedback').removeClass('d-block').text(null);
         var form = $(this);
         var data = $(this).serialize();
         var school_year_id = $(this).find('[name=school_year_id]').val();
         $.ajax({
            url: "<?= base_url('api/schoolyear') ?>/" + school_year_id,
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
                  $('#modal-edit-school-year').modal('hide');
                  Swal.fire({
                     title: "Success!",
                     text: result.message,
                     icon: "success",
                     showConfirmButton: false,
                     timer: 3000
                  }).then(function() {
                     tb_school_year_list.ajax.reload();
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
                     form.find('[name=' + key[0] + ']').closest('.form-group').find('.invalid-feedback').addClass('d-block').text(key[1]);
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
      $(document).on('click', '.delete-school-year', function() {
         var school_year_id = $(this).parents('.btn-actions').data('school_year_id');
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
                  url: "<?= base_url('api/schoolyear') ?>/" + school_year_id,
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
                           tb_school_year_list.ajax.reload();
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
      $('body').tooltip({
         selector: ".edit-school-year, .delete-school-year",
         placement: "top",
         trigger: "hover"
      })
   })
</script>
<?= $this->endSection() ?>