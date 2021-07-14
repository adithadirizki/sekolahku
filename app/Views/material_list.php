<?= $this->extend('template') ?>
<?= $this->section('vendorCSS') ?>
<link rel="stylesheet" href="<?= base_url('app-assets/vendors/css/tables/datatable/datatables.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css') ?>">
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="card">
   <div class="card-header">
      <div class="card-title">Daftar Materi</div>
   </div>
   <div class="card-datatable table-responsive">
      <table class="table table-hover table-striped table-bordered" id="tb_material_list">
         <thead class="text-center">
            <tr>
               <th>No</th>
               <th>Kode Materi</th>
               <th>Judul Materi</th>
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
      var tb_material_list = $('#tb_material_list').DataTable({
         dom: '<"card-header py-0"<"dt-action-buttons"B>><"d-flex justify-content-between align-items-center mx-1 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-1 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
         order: [
            [0, 'desc']
         ],
         serverSide: true,
         processing: true,
         ajax: {
            url: "<?= base_url('material/get_materials') ?>",
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
               "data": "material_id",
               "mRender": function(data, row, type, meta) {
                  return meta.row + meta.settings._iDisplayStart + 1;
               },
               "className": "text-center"
            },
            {
               "data": "material_code",
               "className": "text-center"
            },
            {
               "data": "material_title"
            },
            {
               "data": "subject_name",
               "className": "text-center"
            },
            {
               "data": "created"
            },
            {
               "data": "publish_at",
               "mRender": function(publish_at) {
                  return publish_at + ' WIB';
               },
               "className": "text-center"
            },
            {
               "data": "material_code",
               "mRender": function(material_code, row, data) {
                  return '<div class="dropdown" data-material_code="' + material_code + '"><button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">' + feather.icons['more-vertical'].toSvg({
                     class: 'font-medium-2'
                  }) + '</button><div class="dropdown-menu"><a class="dropdown-item show-material text-primary" href="<?= base_url('material') ?>/' + material_code + '">' + feather.icons['search'].toSvg({
                     class: 'font-medium-2'
                  }) + ' <span>Lihat</span></a><a class="dropdown-item copy-material text-secondary">' + feather.icons['copy'].toSvg({
                     class: 'font-medium-2'
                  }) + ' <span>Salin</span></a><a class="dropdown-item edit-material text-info" href="<?= base_url('material') ?>/' + material_code + '/edit">' + feather.icons['edit'].toSvg({
                     class: 'font-medium-2'
                  }) + ' <span>Edit</span></a><a class="dropdown-item delete-material text-danger" href="javascript:void(0);">' + feather.icons['trash'].toSvg({
                     class: 'font-medium-2'
                  }) + ' <span>Hapus</span></a></div></div>';
               },
               "className": "text-center",
               "orderable": false
            }
         ],
         buttons: [{
            className: 'btn btn-primary',
            text: 'Tambah Materi',
            attr: {
               "onclick": "window.location.href = '<?= base_url('material/new') ?>'"
            }
         }]
      })
      $(document).on('click', '.copy-material', function() {
         var material_code = $(this).parents('.dropdown').data('material_code');
         Swal.fire({
            title: "Are you sure?",
            text: "You will copy this material!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, copy it!",
            cancelButtonText: "Cancel",
            customClass: {
               confirmButton: "btn btn-primary",
               cancelButton: "btn btn-outline-danger ml-1"
            },
            buttonsStyling: false
         }).then((result) => {
            if (result.value) {
               $.ajax({
                  url: "<?= base_url('api/material') ?>/" + material_code + '/copy',
                  type: "post",
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
                           tb_material_list.ajax.reload();
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
      $(document).on('click', '.delete-material', function() {
         var material_code = $(this).parents('.dropdown').data('material_code');
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
                  url: "<?= base_url('api/material') ?>/" + material_code,
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
                           tb_material_list.ajax.reload();
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