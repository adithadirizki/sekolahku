<?php if (session()->role == 'superadmin') {
   echo $this->extend('template');
} elseif (session()->role == 'teacher') {
   echo $this->extend('teacher/template');
} ?>
<?= $this->section('content') ?>
<div class="row">
   <div class="col-lg-3">
      <div class="row">
         <div class="col-md-6 col-lg-12">
            <div class="card border-primary">
               <div class="card-body">
                  <h4 class="font-weight-bolder">
                     Kode Quiz :
                  </h4>
                  <div class="mb-2">
                     <?= $data->quiz ?>
                  </div>
                  <h4 class="font-weight-bolder">
                     Dikerjakan Oleh :
                  </h4>
                  <div>
                     <?= $data->submitted ?>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-6 col-lg-12">
            <div class="card">
               <div class="card-body">
                  <h4 class="font-weight-bolder">
                     Status :
                  </h4>
                  <div class="mb-2">
                     <?php
                     $text = ['SEDANG MENGERJAKAN', 'SELESAI', 'WAKTU HABIS'];
                     $color = ['warning', 'success', 'danger'];
                     echo '<div class="badge badge-light-' . $color[$data->status] . ' py-50 px-1">' . $text[$data->status] . '</div>';
                     ?>
                  </div>
                  <h4 class="font-weight-bolder">
                     Selesai pada :
                  </h4>
                  <div class="mb-2">
                     <?= (new DateTime($data->submitted_at))->format('d M Y H:i') ?> WIB
                  </div>
                  <form id="edit-value" enctype="multipart/form-data" onsubmit="return false;">
                     <div class="form-group">
                        <h4 class="font-weight-bolder">
                           Nilai :
                        </h4>
                        <input type="number" name="value" class="form-control" min="0" value="<?= $data->value ?>" placeholder="Nilai" required>
                        <div class="invalid-feedback"></div>
                     </div>
                     <div class="text-right">
                        <button class="btn btn-primary">Perbarui Nilai</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-lg-9 order-lg-first">
      <div class="card">
         <form id="edit-value" enctype="multipart/form-data" onsubmit="return false;">
            <div class="table-responsive">
               <table class="table table-bordered table-hover">
                  <thead>
                     <tr>
                        <th class="text-center align-middle">No</th>
                        <th class="align-middle">Pertanyaan</th>
                        <th class="text-center align-middle">Kunci Jawaban</th>
                        <th class="text-center align-middle">Jawaban Siswa</th>
                        <th class="text-center align-middle">B/S/SKOR</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php
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
                           <td><?= html_entity_decode($v->question_text, ENT_QUOTES, 'UTF-8') ?></td>
                           <td>
                              <?php
                              if ($v->question_type == 'mc') {
                                 echo '<center>' . $abcde[$v->answer_key] . '</center>';
                              } elseif ($v->question_type == 'essay') {
                                 echo $v->answer_key ? html_entity_decode($v->answer_key, ENT_QUOTES, 'UTF-8') : '<center>-</center>';
                              }
                              ?>
                           </td>
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
                                 echo '<div class="form-group"><input type="number" name="essay_score[' . $v->question_id . ']" class="form-control score" min="0" max="100" value="' . $essay_score[$v->question_id] . '" placeholder="Skor" required><div class="invalid-feedback"></div></div>';
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
                  <div class="offset-md-4"></div>
                  <div class="col-md-4">
                     <h4 class="font-weight-bold">
                        <span> PG :</span> <span class="float-right"><?= $total_mc ?> soal</span>
                     </h4>
                     <hr>
                     <h4 class="font-weight-bold">
                        <span> Essai :</span> <span class="float-right"><?= $total_essay ?> soal</span>
                     </h4>
                     <hr>
                  </div>
                  <div class="col-md-4">
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
         </form>
      </div>
   </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('customJS') ?>
<script>
   $(document).ready(function() {
      $(document).on('keyup', '.score', function() {
         var essay_score = 0;
         var total_score = 0;
         var total_essay = $('.score').length;
         var mc_score = parseInt($('.score-mc').text());
         $('.score').each(function(index, obj) {
            essay_score += parseInt($(obj).val() ? $(obj).val() : 0);
         })
         essay_score = Math.floor(essay_score / total_essay);
         total_score = Math.floor((mc_score + essay_score) / 2);
         $('.score-essay').text(essay_score);
         $('.total-score').text(total_score)
      })
      $(document).on('submit', '#edit-value', function(e) {
         e.preventDefault();
         $(this).find('.is-invalid').removeClass('is-invalid');
         $(this).find('.invalid-feedback').text(null);
         var form = $(this);
         var data = $(this).serialize();
         $.ajax({
            url: "<?= base_url('api/quizresult/' . $data->quiz_result_id) ?>",
            type: "put",
            dataType: "json",
            data: data,
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
                  })
               } else if (result.error == true) {
                  Swal.fire({
                     title: "Failed!",
                     text: result.message,
                     icon: "error",
                     showConfirmButton: false,
                     timer: 3000
                  })
               } else {
                  Object.entries(result.errors).forEach(function(key, value) {
                     if (key[0].search('.')) {
                        key[0] = key[0].split('.');
                        key[0] = `${key[0][0]}[${key[0][1]}]`;
                        key[0] = key[0].replace('*', '');
                     }
                     form.find('[name="' + key[0] + '"]').addClass('is-invalid');
                     form.find('[name="' + key[0] + '"]').closest('.d-flex').addClass('is-invalid');
                     form.find('[name="' + key[0] + '"]').closest('.form-group').find('.invalid-feedback').addClass('d-block').text(key[1]);
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
      })
   })
</script>
<?= $this->endSection() ?>