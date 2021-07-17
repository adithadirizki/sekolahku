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
                  <?= $data->value === null ? 'Belum dinilai' : $data->value; ?>
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