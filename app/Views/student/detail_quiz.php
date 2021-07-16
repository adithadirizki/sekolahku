<?= $this->extend('student/template') ?>
<?= $this->section('vendorCSS') ?>
<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/editors/quill/katex.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/editors/quill/monokai-sublime.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/editors/quill/quill.snow.css') ?>">
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="card">
   <div class="card-body">
      <div class="card-title m-0"><?= $data->quiz_title ?>
         <?= $data->quiz_result_id !== null ? '<div class="badge badge-pill badge-light-success ml-25">SELESAI</div>' : null ?>
         <?= strtotime('now') > strtotime($data->due_at) ? '<div class="badge badge-pill badge-light-danger ml-25">BERAKHIR</div>' : null ?>
      </div>
   </div>
</div>
<div class="row">
   <div class="col-md-4">
      <div class="card border-primary flex-grow-0">
         <div class="card-body">
            <h4 class="font-weight-bolder">
               Kode Quiz :
            </h4>
            <div class="mb-2">
               <?= $data->quiz_code ?>
            </div>
            <h4 class="font-weight-bolder">
               Mata Pelajaran :
            </h4>
            <div>
               <?= $data->subject_name ?>
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-8">
      <div class="card flex-grow-0">
         <div class="card-body">
            <?php if ($data->value === null) { ?>
               <h4 class="font-weight-bolder">
                  Nilai Quiz :
               </h4>
               <div class="mb-2">
                  Belum dinilai
               </div>
            <?php } else { ?>
               <h4 class="font-weight-bolder">
                  Nilai Quiz :
               </h4>
               <div class="mb-2">
                  <?= $data->value ?>
               </div>
            <?php } ?>
            <h4 class="font-weight-bolder">
               Ditugaskan pada :
            </h4>
            <div class="mb-2">
               <?= (new DateTime($data->start_at))->format('d M Y H:i') ?> WIB
            </div>
            <h4 class="font-weight-bolder">
               Sampai :
            </h4>
            <div class="mb-2">
               <?= (new DateTime($data->due_at))->format('d M Y H:i') ?> WIB
            </div>
            <h4 class="font-weight-bolder">
               Ditugaskan oleh :
            </h4>
            <div>
               <?= $data->created ?>
            </div>
            <?php if ($data->status == 0 || $data->status == 2) { ?>
               <div class="text-right mt-2">
                  <button class="btn btn-primary do-quiz">Kerjakan Quiz</button>
               </div>
            <?php } ?>
         </div>
      </div>
   </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('customJS') ?>
<script>
   $(document).ready(function() {
      var tmp_question = $('#question').html();
      var question_ids = <?= $data->questions ?>;
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
                     tmp_choice.find('strong').text(abcde[i]);
                     if (data.answer_key == i) {
                        tmp_choice.find('strong').addClass('text-danger');
                        $('#question').find('.answer-key').addClass('font-weight-bolder');
                     }
                     tmp_choice.find('.choice-text').html($.parseHTML(obj)[0].data);
                     $('#choices').append(tmp_choice.html());
                  })
                  if (data.question_type == 'mc') {
                     $('#question').find('.answer-key').text(abcde[data.answer_key]);
                  } else if (data.question_type == 'essay') {
                     if (data.answer_key) {
                        $('#question').find('.answer-key').html('<br/>' + data.answer_key);
                     }
                  }
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