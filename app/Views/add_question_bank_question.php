<?= $this->extend('template') ?>
<?= $this->section('vendorCSS') ?>
<link rel="stylesheet" href="<?= base_url('app-assets/vendors/css/tables/datatable/datatables.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') ?>">
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="alert alert-primary" role="alert">
   <div class="alert-body"><strong>Penting!</strong> Soal yang bertanda <div class="badge badge-pill badge-light-danger"><i data-feather="x"></i></div> soal yang sudah digunakan dan tidak dapat dipilih kembali.</div>
</div>
<div class="card">
   <div class="card-header">
      <div class="card-title">Pilih Soal</div>
   </div>
   <div class="card-body pb-0">
      <ul class="nav nav-pills mb-2">
         <li class="nav-item">
            <a class="nav-link active" id="question-list-tab" data-toggle="pill" href="#question-list" aria-expanded="true">Daftar Soal</a>
         </li>
         <li class="nav-item">
            <a class="nav-link" id="bank-question-list-tab" data-toggle="pill" href="#bank-question-list" aria-expanded="false">Bank Soal</a>
         </li>
      </ul>
   </div>
   <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="question-list" aria-labelledby="question-list-tab" aria-expanded="true">
         <div class="form-group px-2">
            <label for="question_type">Tipe Soal</label>
            <select name="question_type" id="question_type" class="form-control w-auto">
               <option value=""> -- Pilih Tipe Soal -- </option>
               <option value="mc">Pilihan Ganda</option>
               <option value="essay">Essai</option>
            </select>
         </div>
         <div class="card-datatable table-responsive">
            <table class="table table-hover table-striped table-bordered" id="tb_question_list">
               <thead class="text-center">
                  <tr>
                     <th>No</th>
                     <th>Tipe Soal</th>
                     <th>Pertanyaan</th>
                     <th>Dibuat Oleh</th>
                     <th>Status</th>
                  </tr>
               </thead>
            </table>
         </div>
      </div>
      <div class="tab-pane" id="bank-question-list" role="tabpanel" aria-labelledby="bank-question-list-tab" aria-expanded="false">
         <div class="card-datatable table-responsive">
            <table class="table table-hover table-striped table-bordered" id="tb_bank_question_list">
               <thead class="text-center">
                  <tr>
                     <th>No</th>
                     <th>Nama Bank Soal</th>
                     <th>Jumlah Soal</th>
                     <th>Dibuat Oleh</th>
                     <th>Status</th>
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
<script src="<?= base_url('app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js') ?>"></script>
<?= $this->endSection() ?>
<?= $this->section('customJS') ?>
<script>
   $(document).ready(function() {
      var question_ids = <?= json_encode((array) $data->questions) ?>;
      var csrf_token = "<?= csrf_hash() ?>";
      var tb_question_list = $('#tb_question_list').DataTable({
         dom: '<"card-header py-0"<"dt-action-buttons"B>><"d-flex justify-content-between align-items-center mx-1 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-1 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
         order: [
            [0, 'desc']
         ],
         serverSide: true,
         processing: true,
         ajax: {
            url: "<?= base_url('question/get_questions') ?>",
            type: "post",
            dataType: "json",
            data: function(data) {
               data.question_type = $('[name=question_type]').val();
               data.<?= csrf_token() ?> = csrf_token;
            },
            dataSrc: function(result) {
               csrf_token = result.<?= csrf_token() ?>;
               return result.data;
            }
         },
         columns: [{
               "data": "question_id",
               "mRender": function(question_id, row, data, meta) {
                  if ($.inArray(parseInt(question_id), question_ids) == -1) {
                     return '<div class="custom-control custom-checkbox">' +
                        '<input type="checkbox" class="custom-control-input dt-checkboxes" id="checkbox' + question_id + '">' +
                        '<label class="custom-control-label" for="checkbox' + question_id + '"></label>' +
                        '</div>';
                  } else {
                     return '<div class="custom-control custom-checkbox">' +
                        '<input type="checkbox" class="custom-control-input dt-checkboxes" id="checkbox' + question_id + '" disabled>' +
                        '<label class="custom-control-label" for="checkbox' + question_id + '"></label>' +
                        '</div>';
                  }
               },
               "checkboxes": {
                  selectAllRender: '<div class="custom-control custom-checkbox"> <input class="custom-control-input" type="checkbox" value="" id="checkboxSelectAll" /><label class="custom-control-label" for="checkboxSelectAll"></label></div>'
               },
               "className": "text-center"
            },
            {
               "data": "question_type",
               "mRender": function(question_type) {
                  var text = {
                     "mc": "Pilihan Ganda",
                     "essay": "Essai"
                  };
                  return text[question_type];
               },
               "className": "text-center"
            },
            {
               "data": "question_text",
               "mRender": function(question_text) {
                  return $.parseHTML(question_text)[0].data;
               }
            },
            {
               "data": "created"
            },
            {
               "data": "question_id",
               "mRender": function(question_id, row, data) {
                  if ($.inArray(parseInt(question_id), question_ids) == -1) {
                     return '<div class="badge badge-pill badge-light-success">' + feather.icons['check'].toSvg({
                        class: 'font-medium-2'
                     }) + '</div>';
                  } else {
                     return '<div class="badge badge-pill badge-light-danger">' + feather.icons['x'].toSvg({
                        class: 'font-medium-2'
                     }) + '</div>';
                  }
               },
               "className": "text-center",
               "orderable": false
            }
         ]
      })
      var tb_bank_question_list = $('#tb_bank_question_list').DataTable({
         dom: '<"card-header py-0"<"dt-action-buttons"B>><"d-flex justify-content-between align-items-center mx-1 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-1 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
         order: [
            [0, 'desc']
         ],
         serverSide: true,
         processing: true,
         ajax: {
            url: "<?= base_url('bankquestion/get_bank_questions') ?>",
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
               "data": "bank_question_id",
               "mRender": function(data, row, type, meta) {
                  return meta.row + meta.settings._iDisplayStart + 1;
               },
               "className": "text-center"
            },
            {
               "data": "bank_question_title"
            },
            {
               "data": "total_question",
               "className": "text-center"
            },
            {
               "data": "created"
            },
            {
               "data": "bank_question_id",
               "mRender": function(bank_question_id, row, data) {
                  if ($.inArray(parseInt(bank_question_id), question_ids) == -1) {
                     return '<div class="badge badge-pill badge-light-success p-75">' + feather.icons['check-circle'].toSvg() + ' Pilih</div>';
                  } else {
                     return '<div class="badge badge-pill badge-light-danger">' + feather.icons['x'].toSvg({
                        class: 'font-medium-2'
                     }) + '</div>';
                  }
               },
               "className": "text-center",
               "orderable": false
            }
         ]
      })
      $(document).on('change', '[name=question_type]', function() {
         tb_question_list.ajax.reload();
      })
      $(document).on('click', '.delete-question', function() {
         var question_id = $(this).parents('.dropdown').data('question_id');
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
                  url: "<?= base_url('api/question') ?>/" + question_id,
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
                           tb_question_list.ajax.reload();
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