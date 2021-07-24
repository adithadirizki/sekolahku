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
         <?php
         if ($data->quiz_result_id !== null) {
            if ($data->status == 0) {
               echo '<div class="badge badge-pill badge-light-warning ml-25">SEDANG MENGERJAKAN</div>';
            } elseif ($data->status == 1) {
               echo '<div class="badge badge-pill badge-light-success ml-25">SELESAI</div>';
            } elseif ($data->status == 2) {
               echo '<div class="badge badge-pill badge-light-danger ml-25">WAKTU HABIS</div>';
            }
         }
         if (strtotime('now') > strtotime($data->due_at))
            echo '<div class="badge badge-pill badge-light-danger ml-25">BERAKHIR</div>';
         ?>
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
            <?php if ($data->quiz_result_id !== null) { ?>
               <h4 class="font-weight-bolder">
                  Nilai Quiz :
               </h4>
               <div class="mb-2">
                  <?= $data->value === null ? 'Belum dinilai' : $data->value ?>
               </div>
               <h4 class="font-weight-bolder">
                  Selesai pada :
               </h4>
               <div class="mb-2">
                  <?= (new DateTime($data->submitted_at))->format('d M Y H:i') ?> WIB
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
               <?= $data->assigned ?>
            </div>
            <?php if (strtotime('now') < strtotime($data->due_at)) { ?>
               <?php if ($data->quiz_result_id === null) { ?>
                  <div class="text-right mt-2">
                     <button class="btn btn-primary do-quiz">Kerjakan Quiz</button>
                  </div>
               <?php } elseif ($data->status == 0) { ?>
                  <div class="text-right mt-2">
                     <a href="<?= base_url('quiz/' . $data->quiz_code . '/do_quiz') ?>" class="btn btn-primary">Lanjut Mengerjakan</a>
                  </div>
               <?php } ?>
            <?php } ?>
         </div>
      </div>
   </div>
</div>
<?php if (count($questions) > 0) { ?>
   <div class="card">
      <div class="table-responsive">
         <table class="table table-bordered table-hover">
            <thead>
               <tr>
                  <th class="text-center align-middle">No</th>
                  <th class="align-middle">Pertanyaan</th>
                  <?php if ($data->show_ans_key == 1) { ?>
                     <th class="text-center align-middle">Kunci Jawaban</th>
                  <?php } ?>
                  <th class="text-center align-middle">Jawaban</th>
                  <th class="text-center align-middle">B/S</th>
               </tr>
            </thead>
            <tbody>
               <?php
               // dd($questions);
               $abcde = range('A', 'E');
               $mc_score = 0;
               $answers = json_decode($data->answer, true);
               $essay_score = json_decode($data->essay_score, true);

               $question_type = array_count_values(array_column($questions, 'question_type'));
               $total_mc = isset($question_type['mc']) ? $question_type['mc'] : 0;
               $total_essay = isset($question_type['essay']) ? $question_type['essay'] : 0;

               foreach ($questions as $k => $v) { ?>
                  <tr>
                     <td class="text-center"><?= ($k + 1) ?></td>
                     <td>
                        <div id="headingCollapse<?= $k + 1 ?>" data-toggle="collapse" role="button" data-target="#collapse<?= $k + 1 ?>" aria-expanded="false" aria-controls="collapse<?= $k + 1 ?>">
                           <?= html_entity_decode($v->question_text, ENT_QUOTES, 'UTF-8') ?>
                           <div class="text-right">
                              <i data-feather="chevron-down"></i>
                           </div>
                        </div>
                        <div id="collapse<?= $k + 1 ?>" role="tabpanel" aria-labelledby="headingCollapse<?= $k + 1 ?>" class="collapse">
                           <?php
                           $abcde = range('A', 'E');
                           $choices = json_decode($v->choice);
                           foreach ($choices as $key => $value) { ?>
                              <div class="d-flex mb-50">
                                 <h5 class="mr-75"><strong><?= $abcde[$key] ?></strong>.</h5>
                                 <div class="ql-snow">
                                    <div class="choice-text ql-editor p-0"><?= html_entity_decode($value, ENT_QUOTES, 'UTF-8') ?></div>
                                 </div>
                              </div>
                           <?php }
                           ?>
                        </div>
                     </td>
                     <td>
                        <?php
                        if ($v->question_type == 'mc') {
                           echo '<center>' . $abcde[$v->answer_key] . '</center>';
                        } elseif ($v->question_type == 'essay') {
                           echo $v->answer_key ? html_entity_decode($v->answer_key, ENT_QUOTES, 'UTF-8') : '<center>-</center>';
                        }
                        ?>
                     </td>
                     <?php if ($data->show_ans_key == 1) { ?>
                        <td>
                           <?php
                           if ($v->question_type == 'mc') {
                              if ($answers[$v->question_id] === null || $answers[$v->question_id] == '') {
                                 echo '<center>-</center>';
                              } else {
                                 echo '<center>' . $abcde[$answers[$v->question_id]] . '</center>';
                              }
                           } elseif ($v->question_type == 'essay') {
                              if ($answers[$v->question_id] === null || $answers[$v->question_id] == '') {
                                 echo '<center>-</center>';
                              } else {
                                 echo html_entity_decode($answers[$v->question_id], ENT_QUOTES, 'UTF-8');
                              }
                           }
                           ?>
                        </td>
                     <?php } ?>
                     <td class="text-center">
                        <?php
                        if ($v->question_type == 'mc') {
                           if ($answers[$v->question_id] == $v->answer_key) {
                              $mc_score += 100;
                              echo '<div class="badge badge-pill badge-light-success">BENAR</div>';
                           } else {
                              echo '<div class="badge badge-pill badge-light-danger">SALAH</div>';
                           }
                        } elseif ($v->question_type == 'essay') {
                           echo $essay_score[$v->question_id] ? $essay_score[$v->question_id] : '-';
                        }
                        ?>
                     </td>
                  </tr>
               <?php } ?>
            </tbody>
         </table>
      </div>
      <div class="card-body">
         <div class="row">
            <div class="offset-sm-4"></div>
            <div class="col-sm-4">
               <h4 class="font-weight-bold">
                  <span> PG :</span> <span class="float-right"><?= $total_mc ?> soal</span>
               </h4>
               <hr>
               <h4 class="font-weight-bold">
                  <span> Essai :</span> <span class="float-right"><?= $total_essay ?> soal</span>
               </h4>
               <hr>
            </div>
            <div class="col-sm-4">
               <?php
               $mc_score = $total_mc ? floor($mc_score / $total_mc) : 0;
               $essay_score = $total_essay ? array_sum($essay_score)  / $total_essay : 0;
               $total_score = floor(($mc_score + $essay_score) / ($total_mc && $total_essay ? 2 : 1));
               ?>
               <h4 class="font-weight-bold">
                  <span> Skor PG :</span> <span class="float-right score-mc"><?= $mc_score ?></span>
               </h4>
               <hr>
               <h4 class="font-weight-bold">
                  <span> Skor Essai :</span> <span class="float-right score-essay"><?= $essay_score ?></span>
               </h4>
               <hr>
               <h4 class="font-weight-bolder">
                  <span> Nilai Akhir :</span> <span class="float-right total-score"><?= $total_score ?></span>
               </h4>
            </div>
         </div>
      </div>
   </div>
<?php } ?>
<?= $this->endSection() ?>
<?= $this->section('customJS') ?>
<script>
   $(document).ready(function() {
      $(document).on('click', '.do-quiz', function() {
         var number_question = $('#question').data('number_question');
         Swal.fire({
            title: "Penting!",
            text: "Setelah menekan tombol lanjut, jangan tinggalkan halaman hingga selesai mengerjakan Quiz.",
            icon: "info",
            showCancelButton: true,
            confirmButtonText: "Lanjut!",
            cancelButtonText: "Batal",
            customClass: {
               confirmButton: "btn btn-primary",
               cancelButton: "btn btn-outline-danger ml-1"
            },
            buttonsStyling: false
         }).then((result) => {
            if (result.value) {
               $.ajax({
                  url: "<?= base_url('api/quiz/' . $data->quiz_code . '/start') ?>",
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
                        window.location.href = "<?= base_url('quiz/' . $data->quiz_code . '/do_quiz') ?>";
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