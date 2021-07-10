<?= $this->extend('template') ?>
<?= $this->section('vendorCSS') ?>
<link rel="stylesheet" href="<?= base_url('app-assets/vendors/css/tables/datatable/datatables.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css') ?>">
<?= $this->endSection() ?>
<?= $this->section('customCSS') ?>
<style>
   .dtr-details tr {
      text-align: left !important;
   }
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-header">
            <div class="card-title">Daftar Guru</div>
         </div>
         <div class="card-body d-flex flex-wrap pb-0">
            <div class="form-group m-0 mb-md-1 mr-1">
               <label for="gender">Jenis Kelamin</label>
               <select name="gender" id="gender" class="form-control w-auto">
                  <option value=""> -- Pilih Jenis Kelamin -- </option>
                  <option value="male">Laki - laki</option>
                  <option value="female">Perempuan</option>
               </select>
            </div>
         </div>
         <div class="card-datatable table-responsive">
            <table class="table table-hover table-bordered" id="tb_teacher_list">
               <thead>
                  <tr>
                     <th>No</th>
                     <th>Nama</th>
                     <th>NIP</th>
                     <th>L/P</th>
                     <th>Agama</th>
                     <th>No Telp</th>
                     <th>Aksi</th>
                  </tr>
               </thead>
            </table>
         </div>
      </div>
   </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('vendorJS') ?>
<script src="<?= base_url('app-assets/vendors/js/tables/datatable/datatables.min.js') ?>"></script>
<script src="<?= base_url('app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') ?>"></script>
<script src="<?= base_url('app-assets/vendors/js/tables/datatable/responsive.bootstrap.min.js') ?>"></script>
<script src="<?= base_url('app-assets/vendors/js/tables/datatable/datatables.buttons.min.js') ?>"></script>
<script src="<?= base_url('app-assets/vendors/js/tables/datatable/jszip.min.js') ?>"></script>
<script src="<?= base_url('app-assets/vendors/js/tables/datatable/pdfmake.min.js') ?>"></script>
<script src="<?= base_url('app-assets/vendors/js/tables/datatable/vfs_fonts.js') ?>"></script>
<script src="<?= base_url('app-assets/vendors/js/tables/datatable/buttons.html5.min.js') ?>"></script>
<script src="<?= base_url('app-assets/vendors/js/tables/datatable/buttons.print.min.js') ?>"></script>
<?= $this->endSection() ?>
<?= $this->section('customJS') ?>
<script>
   $(document).ready(function() {
      var csrf_token = "<?= csrf_hash() ?>";
      var tb_teacher_list = $('#tb_teacher_list').DataTable({
         dom: '<"card-header py-0"<"dt-action-buttons"B>><"d-flex justify-content-between align-items-center mx-1 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-1 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
         order: [
            [0, 'desc']
         ],
         serverSide: true,
         processing: true,
         ajax: {
            url: "<?= base_url('teacher/get_teachers') ?>",
            type: "post",
            dataType: "json",
            data: function(data) {
               data.gender = $('[name=gender]').val();
               data.is_active = $('[name=is_active]').val();
               data.<?= csrf_token() ?> = csrf_token;
            },
            dataSrc: function(result) {
               csrf_token = result.<?= csrf_token() ?>;
               return result.data;
            }
         },
         columns: [{
               "data": "teacher_id",
               "mRender": function(data, row, type, meta) {
                  return meta.row + meta.settings._iDisplayStart + 1;
               },
               "className": "text-center"
            },
            {
               "data": "username",
               "mRender": function(username, row, data) {
                  return '<div class="d-flex justify-content-left align-items-center"><div class="avatar-wrapper"></div><div class="d-flex flex-column"><a href="<?= base_url('teacher') ?>/' + username + '" class="teacher_name text-truncate"><span class="font-weight-bold">' + data.fullname + '</span>&nbsp;</a><small class="emp_post text-muted">@' + username + '</small></div></div>';
               }
            },
            {
               "data": "nip",
               "className": "text-center"
            },
            {
               "data": "gender",
               "mRender": function(gender) {
                  let text = {
                     "male": "L",
                     "female": "P"
                  };
                  return text[gender];
               },
               "className": "text-center"
            },
            {
               "data": "religion",
               "mRender": function(religion) {
                  return '<span class="text-capitalize">' + religion + '</span>';
               },
               "className": "text-center"
            },
            {
               "data": "phone",
               "className": "text-center"
            },
            {
               "data": "username",
               "mRender": function(username, row, data) {
                  return '<div class="dropdown" data-username="' + username + '"><button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">' + feather.icons['more-vertical'].toSvg({
                     class: 'font-medium-2'
                  }) + '</button><div class="dropdown-menu"><a class="dropdown-item show-teacher text-primary" href="<?= base_url('teacher') ?>/' + username + '">' + feather.icons['search'].toSvg({
                     class: 'font-medium-2'
                  }) + ' <span>Lihat</span></a><a class="dropdown-item edit-teacher text-info" href="<?= base_url('teacher') ?>/' + username + '/edit">' + feather.icons['edit'].toSvg({
                     class: 'font-medium-2'
                  }) + ' <span>Edit</span></a><a class="dropdown-item delete-teacher text-danger" href="javascript:void(0);">' + feather.icons['trash'].toSvg({
                     class: 'font-medium-2'
                  }) + ' <span>Hapus</span></a></div></div>';
               },
               "className": "text-center",
               "orderable": false
            }
         ],
         buttons: [{
               extend: 'collection',
               className: 'btn btn-outline-secondary dropdown-toggle mr-50',
               text: feather.icons['share'].toSvg({
                  class: 'font-small-4 mr-50'
               }) + 'Export',
               buttons: [{
                     extend: 'print',
                     text: feather.icons['printer'].toSvg({
                        class: 'font-small-4 mr-50'
                     }) + 'Print',
                     className: 'dropdown-item',
                     exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                     }
                  },
                  {
                     extend: 'csv',
                     text: feather.icons['file-text'].toSvg({
                        class: 'font-small-4 mr-50'
                     }) + 'Csv',
                     className: 'dropdown-item',
                     exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                     }
                  },
                  {
                     extend: 'excel',
                     text: feather.icons['file'].toSvg({
                        class: 'font-small-4 mr-50'
                     }) + 'Excel',
                     className: 'dropdown-item',
                     exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                     }
                  },
                  {
                     extend: 'pdf',
                     text: feather.icons['clipboard'].toSvg({
                        class: 'font-small-4 mr-50'
                     }) + 'Pdf',
                     className: 'dropdown-item',
                     exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                     }
                  },
                  {
                     extend: 'copy',
                     text: feather.icons['copy'].toSvg({
                        class: 'font-small-4 mr-50'
                     }) + 'Copy',
                     className: 'dropdown-item',
                     exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                     }
                  }
               ]
            },
            {
               className: 'btn btn-primary',
               text: 'Tambah Guru',
               attr: {
                  onclick: 'window.location.href = "<?= base_url('teacher/new') ?>"'
               }
            }
         ],
         responsive: {
            details: {
               display: $.fn.dataTable.Responsive.display.modal({
                  header: function() {
                     return 'Detail Guru';
                  }
               }),
               renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                  tableClass: 'table'
               })
            }
         }
      })
      $(document).on('change', '[name=gender]', function() {
         tb_teacher_list.ajax.reload();
      })
   })
</script>
<?= $this->endSection() ?>