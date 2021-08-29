<?php if (session()->role == 'superadmin') {
   echo $this->extend('template');
} elseif (session()->role == 'teacher') {
   echo $this->extend('teacher/template');
} ?>
<?= $this->section('vendorCSS') ?>
<link rel="stylesheet" href="<?= base_url('app-assets/vendors/css/tables/datatable/datatables.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') ?>">
<?= $this->endSection() ?>
<?= $this->section('content') ?>
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
         <div class="d-flex align-items-center justify-content-between px-1">
            <div class="form-group">
               <label for="question_type">Tipe Soal</label>
               <select name="question_type" id="question_type" class="form-control w-auto">
                  <option value=""> -- Pilih Tipe Soal -- </option>
                  <option value="mc">Pilihan Ganda</option>
                  <option value="essay">Essai</option>
               </select>
            </div>
            <button class="btn btn-success btn-add-question ml-1"><i data-feather="check-circle"></i>&nbsp; Simpan Soal</button>
         </div>
         <div class="card-datatable table-responsive">
            <table class="table table-hover table-striped table-bordered" id="tb_question_list">
               <thead class="text-center">
                  <tr>
                     <th>No</th>
                     <th>Tipe Soal</th>
                     <th>Pertanyaan</th>
                     <th>Dibuat Oleh</th>
                  </tr>
               </thead>
            </table>
         </div>
      </div>
      <div class="tab-pane" id="bank-question-list" role="tabpanel" aria-labelledby="bank-question-list-tab" aria-expanded="false">
         <div class="text-right px-1">
            <button class="btn btn-success btn-add-question ml-1"><i data-feather="check-circle"></i>&nbsp; Simpan Soal</button>
         </div>
         <div class="card-datatable table-responsive">
            <table class="table table-hover table-striped table-bordered" id="tb_bank_question_list">
               <thead class="text-center">
                  <tr>
                     <th>No</th>
                     <th>Nama Bank Soal</th>
                     <th>Jumlah Soal</th>
                     <th>Dibuat Oleh</th>
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
      var question_ids = [];
      var quiz_codes = [];
      var checkbox_disabled = <?= json_encode((array) $data->questions) ?>;
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
                  return '<div class="custom-control custom-checkbox">' +
                     '<input type="checkbox" class="custom-control-input dt-checkboxes" id="checkbox' + question_id + '" value="' + question_id + '">' +
                     '<label class="custom-control-label" for="checkbox' + question_id + '"></label>' +
                     '</div>';
               },
               "checkboxes": {
                  selectAllRender: '<div class="custom-control custom-checkbox"> <input class="custom-control-input" type="checkbox" value="" id="checkboxSelectAll1" /><label class="custom-control-label" for="checkboxSelectAll1"></label></div>'
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
            }
         ],
         initComplete: function(settings) {
            var api = this.api();
            api.cells(
               api.rows(function(idx, data, node) {
                  return $.inArray(parseInt(data.question_id), checkbox_disabled) > -1 ? true : false;
               }).indexes(), 0
            ).checkboxes.disable();
         }
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
                  return '<div class="custom-control custom-checkbox">' +
                     '<input type="checkbox" class="custom-control-input dt-checkboxes" id="checkbox' + data + '">' +
                     '<label class="custom-control-label" for="checkbox' + data + '"></label>' +
                     '</div>';
               },
               "checkboxes": {
                  selectAllRender: '<div class="custom-control custom-checkbox"> <input class="custom-control-input" type="checkbox" value="" id="checkboxSelectAll2" /><label class="custom-control-label" for="checkboxSelectAll2"></label></div>'
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
            }
         ]
      })

      function submit_changes(data) {
         data = Array.from(new Set(data));
         $.ajax({
            url: "<?= base_url('api/quiz/' . $data->quiz_code . '/question') ?>",
            type: "put",
            dataType: "json",
            data: {
               question_id: data
            },
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
                     window.history.back();
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

      $(document).on('change', '[name=question_type]', function() {
         tb_question_list.ajax.reload();
      })

      // Question List
      $(document).on('change', '#checkboxSelectAll1', function() {
         var checkboxAll = $(this);
         var nodes = tb_question_list.column(0).nodes();
         var data = $(nodes).find('input[type=checkbox]:enabled');
         // console.log($(data).find('input[type=checkbox]').val());
         // return false;
         $.each(data, function(index, value) {
            if (checkboxAll.is(':checked')) {
               question_ids.push(parseInt($(this).val()));
            } else {
               question_ids.splice(question_ids.indexOf($(this).val()), 1);
            }
         })
      })
      $(document).on('change', '#tb_question_list .dt-checkboxes', function() {
         var value = parseInt($(this).val());
         if ($(this).is(':checked')) {
            question_ids.push(value);
         } else {
            question_ids.splice(question_ids.indexOf(value), 1);
         }
      })
      $(document).on('click', '#question-list .btn-add-question', function() {
         submit_changes(question_ids);
      })
      // End Question List

      // Bank Question List
      $(document).on('change', '#checkboxSelectAll2', function() {
         var checkboxAll = $(this);
         var data = tb_bank_question_list.rows().data();
         $.each(data, function(index, value) {
            if (checkboxAll.is(':checked')) {
               $.merge(quiz_codes, JSON.parse(value.questions));
            } else {
               quiz_codes = quiz_codes.filter(function(x) {
                  return JSON.parse(value.questions).indexOf(x) < 0;
               });
            }
         })
      })
      $(document).on('change', '#tb_bank_question_list .dt-checkboxes', function() {
         var data = tb_bank_question_list.row($(this).closest('tr')).data();
         if ($(this).is(':checked')) {
            $.merge(quiz_codes, JSON.parse(data.questions));
         } else {
            quiz_codes = quiz_codes.filter(function(x) {
               return JSON.parse(data.questions).indexOf(x) < 0;
            });
         }
      })
      $(document).on('click', '#bank-question-list .btn-add-question', function() {
         submit_changes(quiz_codes);
      })
      // End Bank Question List
   })
</script>
<?= $this->endSection() ?>