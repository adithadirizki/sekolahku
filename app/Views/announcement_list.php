<?php if (session()->role == 'superadmin') {
   echo $this->extend('template');
} elseif (session()->role == 'teacher') {
   echo $this->extend('teacher/template');
} ?>
<?= $this->section('vendorCSS') ?>
<link rel="stylesheet" href="<?= base_url('app-assets/vendors/css/tables/datatable/datatables.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css') ?>">
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="card">
   <div class="card-header">
      <div class="card-title">Daftar Pengumuman</div>
   </div>
   <div class="card-datatable table-responsive">
      <table class="table table-hover table-striped table-bordered" id="tb_announcement_list">
         <thead class="text-center">
            <tr>
               <th>No</th>
               <th>Judul Pengumuman</th>
               <th>Diumumkan Oleh</th>
               <th>Diumumkan Pada</th>
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

      function toDateTime(datetime) {
         var datetime = new Date(datetime),
            y = datetime.getFullYear(),
            m = datetime.toLocaleDateString('default', {
               'month': 'short'
            }),
            d = (d = datetime.getDate()) > 9 ? d : "0" + d,
            h = (h = datetime.getHours()) > 9 ? h : "0" + h,
            i = (i = datetime.getMinutes()) > 9 ? i : "0" + i;
         return `${d} ${m} ${y} ${h}:${i} WIB`;
      }

      var tb_announcement_list = $('#tb_announcement_list').DataTable({
         dom: '<"card-header py-0"<"dt-action-buttons"B>><"d-flex justify-content-between align-items-center mx-1 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-1 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
         order: [
            [0, 'desc']
         ],
         serverSide: true,
         processing: true,
         ajax: {
            url: "<?= base_url('announcement/get_announcements') ?>",
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
               "data": "announcement_id",
               "mRender": function(data, row, type, meta) {
                  return meta.row + meta.settings._iDisplayStart + 1;
               },
               "className": "text-center"
            },
            {
               "data": "announcement_title"
            },
            {
               "data": "announced"
            },
            {
               "data": "announced_at",
               "mRender": function(announced_at) {
                  return toDateTime(announced_at);
               },
               "className": "text-center"
            },
            {
               "data": "announcement_id",
               "mRender": function(announcement_id, row, data) {
                  if (data.announced_by == "<?= session()->username ?>") {
                     return '<div class="dropdown" data-announcement_id="' + announcement_id + '"><button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">' + feather.icons['more-vertical'].toSvg({
                        class: 'font-medium-2'
                     }) + '</button><div class="dropdown-menu"><a class="dropdown-item show-announcement text-primary" href="<?= base_url('announcement') ?>/' + announcement_id + '">' + feather.icons['search'].toSvg({
                        class: 'font-medium-2'
                     }) + ' <span>Lihat</span></a><a class="dropdown-item edit-announcement text-info" href="<?= base_url('announcement') ?>/' + announcement_id + '/edit">' + feather.icons['edit'].toSvg({
                        class: 'font-medium-2'
                     }) + ' <span>Edit</span></a><a class="dropdown-item delete-announcement text-danger" href="javascript:void(0);">' + feather.icons['trash'].toSvg({
                        class: 'font-medium-2'
                     }) + ' <span>Hapus</span></a></div></div>';
                  } else {
                     return '<a class="btn btn-sm btn-outline-primary round show-announcement text-nowrap font-weight-bolder" href="<?= base_url('announcement') ?>/' + announcement_id + '">' + feather.icons['search'].toSvg() + ' <span>Lihat</span></a>';
                  }
               },
               "className": "text-center",
               "orderable": false
            }
         ],
         buttons: [{
            className: 'btn btn-primary',
            text: 'Tambah Pengumuman',
            attr: {
               "onclick": "window.location.href = '<?= base_url('announcement/new') ?>'"
            }
         }]
      })
      $(document).on('click', '.delete-announcement', function() {
         var announcement_id = $(this).parents('.dropdown').data('announcement_id');
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
                  url: "<?= base_url('api/announcement') ?>/" + announcement_id,
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
                           tb_announcement_list.ajax.reload();
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