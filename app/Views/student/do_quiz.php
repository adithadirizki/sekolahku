<?= $this->extend('student/template') ?>
<?= $this->section('vendorCSS') ?>
<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/editors/quill/katex.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/editors/quill/monokai-sublime.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/editors/quill/quill.snow.css') ?>">
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row">
   <div class="col-md-8">
      <div class="card">
         <div class="card-body">
            <div id="question" data-question_type="" data-number_question="">
               <div class="btn btn-sm btn-outline-primary question-type">Tipe Soal</div>
               <div class="btn btn-sm btn-primary font-weight-bold">No. <span class="number-question"></span></div>
               <div class="mb-2"></div>
               <div class="ql-snow">
                  <div class="question-text ql-editor p-0">
                     <center><em>Tidak ada soal</em></center>
                  </div>
               </div>
               <div id="choices" class="my-2"></div>
               <div class="d-flex justify-content-between mt-3">
                  <button type="button" class="btn btn-primary btn-prev">
                     <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left">
                        <polyline points="15 18 9 12 15 6"></polyline>
                     </svg> Sebelumnya
                  </button>
                  <button type="button" class="btn btn-primary btn-next">
                     Selanjutnya <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                        <polyline points="9 18 15 12 9 6"></polyline>
                     </svg>
                  </button>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-4">
      <div class="card">
         <div class="card-body">
            <h4 class="mb-50">Daftar Soal</h4>
            <div class="question-list row px-1">
               <?php
               $questions = $data->questions;
               if (count($questions) === 0) {
                  echo '<center><em>Tidak ada soal</em></center>';
               }
               foreach ($questions as $key => $value) {
               ?>
                  <button class="btn btn-outline-success mb-50 mx-25"><?= $key + 1 ?></button>
               <?php
               }
               ?>
            </div>
            <div class="d-flex justify-content-between mt-1">
               <button type="button" class="btn btn-primary btn-prev">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-left">
                     <polyline points="11 17 6 12 11 7"></polyline>
                     <polyline points="18 17 13 12 18 7"></polyline>
                  </svg>
               </button>
               <button type="button" class="btn btn-primary btn-next">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-right">
                     <polyline points="13 17 18 12 13 7"></polyline>
                     <polyline points="6 17 11 12 6 7"></polyline>
                  </svg>
               </button>
            </div>
         </div>
      </div>
   </div>
</div>
<div id="tmp-choice" class="d-none">
   <div class="d-flex mb-1">
      <div class="custom-control custom-radio">
         <input type="radio" id="choice" name="choice" class="custom-control-input">
         <label class="custom-control-label" for="choice">
            <div class="ql-snow">
               <div class="choice-text ql-editor p-0"></div>
            </div>
         </label>
      </div>
   </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('customJS') ?>
<script>
   $(document).ready(function() {
      var tmp_question = $('#question').html();
      var question_ids = <?= json_encode($data->questions) ?>;
      var prev_number = false;
      var next_number = 0;
      var abcde = <?= json_encode(range('A', 'E')) ?>;

      function get_question(number_question = 0) {
         var question_id = question_ids[number_question];
         if (question_id === undefined) {
            return false;
         }
         if (number_question > -1 && number_question < question_ids.length) {
            prev_number = number_question - 1;
            next_number = number_question + 1;
         }
         $('.question-list button').removeClass('active');
         $('.question-list button').eq(number_question).addClass('active');
         $.ajax({
            url: "<?= base_url('api/quiz/' . $data->quiz_code) ?>/question/" + number_question,
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
               $('#question').html(tmp_question); // Reset question
               if (result.error == false) {
                  var data = result.data;
                  var q_type = {
                     "mc": "Pilihan Ganda",
                     "essay": "Essai"
                  };
                  $('#question').data('question_type', data.question_type);
                  $('#question').data('number_question', number_question);
                  $('#question').find('.number-question').text(number_question + 1);
                  $('#question').find('.question-type').text(q_type[data.question_type]);
                  $('#question').find('.question-text').html($.parseHTML(data.question_text)[0].data);
                  $('#question').find('.edit-question').attr('href', '<?= base_url('question') ?>/' + question_id + '/edit');
                  data.choices.forEach(function(obj, i) {
                     var tmp_choice = $('#tmp-choice').clone();
                     tmp_choice.find('[name=choice]').val(i);
                     tmp_choice.find('[name=choice]').attr('id', 'choice' + i);
                     tmp_choice.find('label').attr('for', 'choice' + i);
                     tmp_choice.find('.choice-text').html($.parseHTML(obj)[0].data);
                     $('#choices').append(tmp_choice.html());
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

      if (question_ids.length > 0) {
         get_question(next_number);
      }

      $(document).on('click', '.btn-prev', function() {
         get_question(prev_number);
      })
      $(document).on('click', '.btn-next', function() {
         get_question(next_number);
      })
      $(document).on('click', '.question-list button', function() {
         var number_question = $(this).text();
         get_question(number_question - 1);
      })
      $(document).on('click', '.delete-question', function() {
         var number_question = $('#question').data('number_question');
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
                  url: "<?= base_url('api/quiz/' . $data->quiz_code . '/question') ?>/" + number_question,
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
                           question_ids.splice(number_question, 1);
                           $('.question-list button').last().remove();
                           get_question();
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
      $(document).on('click', '#delete-quiz', function() {
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
                  url: "<?= base_url('api/quiz/' . $data->quiz_code) ?>",
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
                           window.location.href = "<?= base_url('quiz') ?>";
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
         selector: ".edit-question, .delete-question",
         placement: "top",
         trigger: "hover"
      })
   })
</script>
<?= $this->endSection() ?>