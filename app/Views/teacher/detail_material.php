<?= $this->extend('teacher/template') ?>
<?= $this->section('vendorCSS') ?>
<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/editors/quill/katex.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/editors/quill/monokai-sublime.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/editors/quill/quill.snow.css') ?>">
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row">
   <div class="col-lg-9">
      <div class="card">
         <div class="card-body">
            <div class="card-title"><?= $data->material_title ?></div>
            <hr>
            <div class="font-medium-1 mb-50">Deskripsi Materi :</div>
            <div class="ql-snow">
               <div class="material-text text-wrap ql-editor p-0"><?= html_entity_decode($data->material_desc, ENT_QUOTES, 'UTF-8') ?></div>
            </div>
            <hr>
         </div>
      </div>
   </div>
   <div class="col-lg-3">
      <div class="card border-primary">
         <div class="card-body">
            <h4 class="font-weight-bolder">
               Kode Materi :
            </h4>
            <div class="mb-2">
               <?= $data->material_code ?>
            </div>
            <h4 class="font-weight-bolder">
               Mata Pelajaran :
            </h4>
            <div class="mb-2">
               <?= $data->subject_name ?>
            </div>
            <h4 class="font-weight-bolder">
               Kelas :
            </h4>
            <div class="mb-2">
               <?= $data->class_group_name ?>
            </div>
            <h4 class="font-weight-bolder">
               Tahun Ajaran :
            </h4>
            <div class="mb-2">
               <?= $data->school_year_title ?>
            </div>
            <h4 class="font-weight-bolder">
               Dibuat pada :
            </h4>
            <div class="mb-2">
               <?= (new DateTime($data->publish_at))->format('d F Y H:i') ?> WIB
            </div>
            <a href="<?= base_url('/material/' . $data->material_code) ?>/edit" class="btn btn-primary btn-block">Edit Materi</a>
            <button id="delete-material" class="btn btn-danger btn-block">Hapus</button>
         </div>
      </div>
   </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('customJS') ?>
<script>
   $(document).ready(function() {
      $(document).on('click', '#delete-material', function() {
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
                  url: "<?= base_url('api/material/' . $data->material_code) ?>",
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
                           window.location.href = "<?= base_url('material') ?>";
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