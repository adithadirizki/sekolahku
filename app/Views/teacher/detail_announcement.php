<?= $this->extend('teacher/template') ?>
<?= $this->section('vendorCSS') ?>
<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/editors/quill/katex.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/editors/quill/monokai-sublime.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/editors/quill/quill.snow.css') ?>">
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row match-height">
   <div class="col-lg-9">
      <div class="card">
         <div class="card-body">
            <h1 class="h2"><?= $data->announcement_title ?></h1>
            <hr>
            <div class="ql-snow">
               <div class="announcement-text text-wrap ql-editor p-0"><?= html_entity_decode($data->announcement_desc, ENT_QUOTES, 'UTF-8') ?></div>
            </div>
            <hr>
         </div>
      </div>
   </div>
   <div class="col-lg-3">
      <div class="card border-primary flex-grow-0">
         <div class="card-body">
            <h4 class="font-weight-bolder">
               Ditujukan untuk :
            </h4>
            <div class="mb-2">
               <?php
               if ($data->announcement_for == 'teacher') {
                  echo 'Hanya Guru';
               } elseif ($data->announcement_for == 'student') {
                  echo 'Hanya Siswa';
               } elseif ($data->announcement_for == 'all') {
                  echo 'Untuk Semua';
               }
               ?>
            </div>
            <h4 class="font-weight-bolder">
               Diumumkan pada :
            </h4>
            <div class="mb-2">
               <?= (new DateTime($data->announced_at))->format('d F Y H:i') ?> WIB
            </div>
            <h4 class="font-weight-bolder">
               Sampai :
            </h4>
            <div class="mb-2">
               <?= (new DateTime($data->announced_until))->format('d F Y H:i') ?> WIB
            </div>
            <h4 class="font-weight-bolder">
               Tahun Ajaran :
            </h4>
            <div>
               <?= $data->school_year_title ?>
            </div>

            <?php if ($data->announced_by == session()->username) { ?>
               <div class="d-flex justify-content-between flex-wrap-reverse mt-2">
                  <button id="delete-announcement" class="btn btn-danger mb-25">Hapus</button>
                  <a href="<?= base_url('/announcement/' . $data->announcement_id) ?>/edit" class="btn btn-primary mb-25">Edit Pengumuman</a>
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
      $(document).on('click', '#delete-announcement', function() {
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
                  url: "<?= base_url('api/announcement/' . $data->announcement_id) ?>",
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
                           window.location.href = "<?= base_url('announcement') ?>";
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