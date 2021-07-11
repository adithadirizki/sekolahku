<?= $this->extend('template') ?>
<?= $this->section('vendorCSS') ?>
<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/editors/quill/katex.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/editors/quill/monokai-sublime.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/editors/quill/quill.snow.css') ?>">
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="card">
   <div class="card-body">
      <div class="ql-snow mb-1">
         <div class="question-text ql-editor p-0"><?= html_entity_decode($data->question_text, ENT_QUOTES, 'UTF-8') ?></div>
      </div>

      <hr>

      <?php if ($data->question_type == 'mc') { ?>
         <?php
         $abcde = range('A', 'E');
         $choices = json_decode($data->choice);
         ?>
         <div id="choices" class="mb-0">
            <?php foreach ((object) $choices as $key => $value) { ?>
               <div class="d-flex">
                  <h5 class="mr-75"><strong><?= $abcde[$key] ?></strong>.</h5>
                  <div class="ql-snow mb-1">
                     <div class="choice-text ql-editor p-0"><?= html_entity_decode($value, ENT_QUOTES, 'UTF-8') ?></div>
                  </div>
               </div>
            <?php } ?>
         </div>

         <hr>

         <h5>Kunci Jawaban :
            <span class="answer-key font-weight-bolder"><?= $abcde[$data->answer_key] ?></span>
         </h5>

      <?php } elseif ($data->question_type == 'essay') { ?>
         <h5>Kunci Jawaban :</h5>
         <div class="answer-key"><?= $data->answer_key ? html_entity_decode($data->answer_key, ENT_QUOTES, 'UTF-8') : '<small><em>Tidak ada</em></small>' ?></div>
      <?php } ?>

   </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('customJSXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX') ?>
<script>
   $(document).ready(function() {
      $(document).on('click', '#delete-question', function() {
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
                  url: "<?= base_url('api/question/' . $data->question_id) ?>",
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
                           window.location.href = "<?= base_url('question') ?>";
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