<?= $this->extend('student/template') ?>
<?= $this->section('vendorCSS') ?>
<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/editors/quill/katex.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/editors/quill/monokai-sublime.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/editors/quill/quill.snow.css') ?>">
<?= $this->endSection() ?>
<?= $this->section('customCSS') ?>
<style>
   .question-list button.complete {
      border-color: #28c76f !important;
      background-color: #28c76f !important;
      color: #fff !important;
   }

   .question-list button.complete.active {
      border: 1px solid #28c76f !important;
      background-color: rgba(40, 199, 111, 0.04) !important;
      color: #28c76f !important;
   }
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row">
   <div class="col-md-8">
      <div class="card">
         <div class="card-body">
            <div class="divider divider-success divider-right m-0">
               <h3 class="border-success round text-center timer divider-text font-medium-4 px-1 py-50">00:00:00</h3>
            </div>
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
               <div class="form-answer" hidden>
                  <h4>Jawaban :</h4>
                  <textarea name="answer" id="answer" cols="30" rows="3" class="form-control" placeholder="Ketik Jawabanmu"></textarea>
               </div>
            </div>
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
               <button type="button" class="btn btn-success btn-complete" hidden>
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle mr-25">
                     <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                     <polyline points="22 4 12 14.01 9 11.01"></polyline>
                  </svg> Selesai
               </button>
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-4">
      <div class="card">
         <div class="card-body">
            <h4 class="card-title">Daftar Soal</h4>
            <div class="question-list row px-1">
               <?php
               $answers = array_values((array) json_decode($data->answer));
               $questions = array_keys((array) json_decode($data->answer));
               if (count($questions) === 0) {
                  echo '<center><em>Tidak ada soal</em></center>';
               }
               foreach ($questions as $key => $value) {
               ?>
                  <button class="btn btn-outline-danger mb-50 mx-25 <?= $answers[$key] != null ? 'complete' : null ?>"><?= $key + 1 ?></button>
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
      var question_ids = <?= json_encode($questions) ?>;
      var prev_number = false;
      var next_number = 0;
      var abcde = <?= json_encode(range('A', 'E')) ?>;
      var now = <?= strtotime('now') ?>;
      var time = <?= (int) $data->time ?>;
      var start = <?= strtotime($data->created_at) ?>;
      var due = <?= strtotime($data->due_at) ?>;
      if (start + (60 * time) > due) {
         var time_limit = due;
      } else {
         var time_limit = start + (60 * time);
      }
      var remaining = time_limit - now;
      var counter = setInterval(timer, 1000);

      function timer() {
         remaining -= 1;
         if (remaining < 0) {
            Swal.fire({
               title: "INFO!",
               text: "Waktu Quiz sudah habis.",
               icon: "info",
               showConfirmButton: false,
               timer: 3000
            }).then(function() {
               submit_quiz();
            })
            clearInterval(counter);
            return;
         }
         var seconds = remaining % 60;
         var minutes = Math.floor(remaining / 60);
         var hours = Math.floor(minutes / 60);
         seconds = seconds > 9 ? seconds : "0" + seconds;
         minutes = minutes % 60 > 9 ? minutes : "0" + minutes;
         hours = hours % 60 > 9 ? hours : "0" + hours;
         now = new Date(time_limit - remaining).toLocaleString();
         $('.timer').text(`${hours}:${minutes}:${seconds}`);
      }

      function all_completed(number_question) {
         var complete = $('.question-list button.complete').length;
         if (number_question == question_ids.length - 1 && complete == question_ids.length) {
            $('#question').closest('.card').find('.btn-next').prop('hidden', true);
            $('#question').closest('.card').find('.btn-complete').prop('hidden', false);
         } else {
            $('#question').closest('.card').find('.btn-next').prop('hidden', false);
            $('#question').closest('.card').find('.btn-complete').prop('hidden', true);
         }
      }

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

         all_completed(number_question);

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
                  if (data.question_type == 'essay') {
                     var answer = $.parseHTML(data.answer)[0];
                     $('.form-answer').prop('hidden', false);
                     $('#answer').val(answer ? answer.data : null).prop('hidden', false);
                  }
                  $('#question').attr('data-question_type', data.question_type);
                  $('#question').attr('data-number_question', number_question);
                  $('#question').find('.number-question').text(number_question + 1);
                  $('#question').find('.question-type').text(q_type[data.question_type]);
                  $('#question').find('.question-text').html($.parseHTML(data.question_text)[0].data);
                  $('#question').find('.edit-question').attr('href', '<?= base_url('question') ?>/' + question_id + '/edit');
                  data.choices.forEach(function(obj, i) {
                     var tmp_choice = $('#tmp-choice').clone();
                     tmp_choice.find('[name=choice]').val(i);
                     if (i == data.answer)
                        tmp_choice.find('[name=choice]').attr('checked', true);
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

      function submit_quiz() {
         Swal.fire({
            title: "Penting!",
            text: "Yakin sudah selesai menjawab semua soal Quiz ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, selesai!",
            cancelButtonText: "Batal",
            customClass: {
               confirmButton: "btn btn-primary",
               cancelButton: "btn btn-outline-danger ml-1"
            },
            buttonsStyling: false
         }).then((result) => {
            if (result.value) {
               $.ajax({
                  url: "<?= base_url('api/quiz/' . $data->quiz_code . '/complete') ?>",
                  type: "post",
                  dataType: "json",
                  headers: {
                     Authorization: "<?= session()->token ?>"
                  },
                  success: function(result) {
                     if (result.error == false) {
                        Swal.fire({
                           title: "Success!",
                           text: result.message,
                           icon: "success",
                           showConfirmButton: false,
                           timer: 3000
                        }).then(function() {
                           window.location.href = "<?= base_url('quiz/' . $data->quiz_code) ?>";
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
                  }
               })
            }
         });
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
      $(document).on('change', '[name=answer]', function() {
         var number_question = $('#question').attr('data-number_question');
         var question_id = question_ids[number_question];
         var answer = $(this).val();
         $.ajax({
            url: "<?= base_url('api/quiz/' . $data->quiz_code . '/answer') ?>",
            type: "post",
            dataType: "json",
            data: {
               question_id: question_id,
               answer: answer
            },
            headers: {
               Authorization: "<?= session()->token ?>"
            },
            success: function(result) {
               if (result.error == false) {
                  if (answer == null || answer == '') {
                     $('.question-list button').eq(number_question).removeClass('complete');
                  } else {
                     $('.question-list button').eq(number_question).addClass('complete');
                  }
                  all_completed(number_question);
               }
            }
         })
      })
      $(document).on('change', '[name=choice]', function() {
         var number_question = $('#question').attr('data-number_question');
         var question_id = question_ids[number_question];
         var answer = $(this).val();
         $.ajax({
            url: "<?= base_url('api/quiz/' . $data->quiz_code . '/answer') ?>",
            type: "post",
            dataType: "json",
            data: {
               question_id: question_id,
               answer: answer
            },
            headers: {
               Authorization: "<?= session()->token ?>"
            },
            success: function(result) {
               if (result.error == false) {
                  $('.question-list button').eq(number_question).addClass('complete');
                  all_completed(number_question);
               }
            }
         })
      })
      $(document).on('click', '.btn-complete', function() {
         var complete = $('.question-list button.complete').length;
         if (complete != question_ids.length) {
            Swal.fire({
               title: "Gagal!",
               text: "Masih ada soal yang belum dijawab.",
               icon: "error",
               showConfirmButton: false,
               timer: 3000
            })
            return false;
         }
         submit_quiz();
      })
   })
</script>
<?= $this->endSection() ?>