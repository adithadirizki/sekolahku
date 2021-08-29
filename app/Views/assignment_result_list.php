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
      <div class="card-title">Daftar Tugas</div>
   </div>
   <div class="card-body d-flex flex-wrap pb-0">
      <div class="form-group mb-0 mr-1">
         <label for="value">Nilai</label>
         <select name="value" id="value" class="form-control w-auto">
            <option value=""> -- Pilih Nilai -- </option>
            <option value="0">Belum Dinilai</option>
            <option value="1">Sudah Dinilai</option>
         </select>
      </div>
   </div>
   <div class="card-datatable table-responsive">
      <table class="table table-hover table-striped table-bordered" id="tb_assignment_result_list">
         <thead class="text-center">
            <tr>
               <th>No</th>
               <th>Kode Tugas</th>
               <th>Judul Tugas</th>
               <th>Nilai</th>
               <th>Dikerjakan Oleh</th>
               <th>Selesai Pada</th>
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

      var tb_assignment_result_list = $('#tb_assignment_result_list').DataTable({
         dom: '<"card-header py-0"<"dt-action-buttons"B>><"d-flex justify-content-between align-items-center mx-1 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-1 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
         order: [
            [0, 'desc']
         ],
         serverSide: true,
         processing: true,
         ajax: {
            url: "<?= base_url('assignmentresult/get_assignment_results') ?>",
            type: "post",
            dataType: "json",
            data: function(data) {
               data.value = $('[name=value]').val();
               data.status = $('[name=status]').val();
               data.<?= csrf_token() ?> = csrf_token;
            },
            dataSrc: function(result) {
               csrf_token = result.<?= csrf_token() ?>;
               return result.data;
            }
         },
         columns: [{
               "data": "assignment_result_id",
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
               "data": "value",
               "mRender": function(value) {
                  if (value === null) {
                     return '<div class="badge badge-light-info">Belum dinilai</div>';
                  }
                  return value;
               },
               "className": "text-center"
            },
            {
               "data": "created"
            },
            {
               "data": "submitted_at",
               "mRender": function(submitted_at) {
                  return toDateTime(submitted_at);
               },
               "className": "text-center"
            },
            {
               "data": "assignment_result_id",
               "mRender": function(assignment_result_id, row, data) {
                  return '<div class="dropdown" data-assignment_result_id="' + assignment_result_id + '"><button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">' + feather.icons['more-vertical'].toSvg({
                     class: 'font-medium-2'
                  }) + '</button><div class="dropdown-menu"><a class="dropdown-item show-assignment-result text-primary" href="<?= base_url('assignmentresult') ?>/' + assignment_result_id + '">' + feather.icons['search'].toSvg({
                     class: 'font-medium-2'
                  }) + ' <span>Koreksi</span></a></a><a class="dropdown-item delete-assignment-result text-danger" href="javascript:void(0);">' + feather.icons['trash'].toSvg({
                     class: 'font-medium-2'
                  }) + ' <span>Hapus</span></a></div></div>';
               },
               "className": "text-center",
               "orderable": false
            }
         ],
         search: {
            "search": "<?= isset($_GET['assignment']) ? $_GET['assignment'] : null ?>"
         }
      })
      $(document).on('change', '[name=value]', function() {
         tb_assignment_result_list.ajax.reload();
      })
      $(document).on('click', '.delete-assignment-result', function() {
         var assignment_result_id = $(this).parents('.dropdown').data('assignment_result_id');
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
                  url: "<?= base_url('api/assignmentresult') ?>/" + assignment_result_id,
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
                           tb_assignment_result_list.ajax.reload();
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