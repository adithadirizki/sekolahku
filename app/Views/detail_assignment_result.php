<?php if (session()->role == 'superadmin') {
   echo $this->extend('template');
} elseif (session()->role == 'teacher') {
   echo $this->extend('teacher/template');
} ?>
<?= $this->section('vendorCSS') ?>
<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/editors/quill/katex.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/editors/quill/monokai-sublime.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/editors/quill/quill.snow.css') ?>">
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row match-height">
   <div class="col-xl-3">
      <div class="row match-height">
         <div class="col-sm-6 col-xl-12">
            <div class="card border-primary">
               <div class="card-body">
                  <h4 class="font-weight-bolder">
                     Kode Tugas :
                  </h4>
                  <div class="mb-2">
                     <?= $data->assignment ?>
                  </div>
                  <h4 class="font-weight-bolder">
                     Dikerjakan Oleh :
                  </h4>
                  <div class="mb-2">
                     <?= $data->submitted ?>
                  </div>
                  <h4 class="font-weight-bolder">
                     Diserahkan pada :
                  </h4>
                  <div>
                     <?= (new DateTime($data->submitted_at))->format('d M Y H:i') ?> WIB
                  </div>
               </div>
            </div>
         </div>
         <div class="col-sm-6 col-xl-12">
            <div class="card">
               <div class="card-body">
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
   <div class="col-xl-9">
      <div class="card">
         <div class="card-body ql-snow">
            <h1 class="h3 m-0">Jawaban</h1>
            <hr>
            <div class="card-text ql-editor p-0"><?= html_entity_decode($data->answer, ENT_QUOTES, 'UTF-8') ?></div>
         </div>
      </div>
   </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('customJS') ?>
<script>
   $(document).ready(function() {
      $(document).on('submit', '#edit-value', function(e) {
         e.preventDefault();
         $(this).find('.is-invalid').removeClass('is-invalid');
         $(this).find('.invalid-feedback').text(null);
         var form = $(this);
         var data = $(this).serialize();
         $.ajax({
            url: "<?= base_url('api/assignmentresult/' . $data->assignment_result_id) ?>",
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
                     key[0] = key[0].replace('*', '[]');
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