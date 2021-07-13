<?= $this->extend('template') ?>
<?= $this->section('vendorCSS') ?>
<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/editors/quill/katex.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/editors/quill/monokai-sublime.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/editors/quill/quill.snow.css') ?>">
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row">
   <div class="col-md-6 col-xl-3 order-xl-first">
      <div class="card border-primary">
         <div class="card-body">
            <h4 class="font-weight-bolder">
               Kode Tugas :
            </h4>
            <div class="mb-2">
               <?= $data->assignment_code ?>
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
            <div>
               <?= $data->class_group_name ?> (<?= $data->school_year_title ?>)
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-12 order-md-first col-xl-6 ">
      <div class="card">
         <div class="card-body">
            <div class="card-title"><?= $data->assignment_title ?></div>
            <div class="font-medium-1 mb-50">Deskripsi Tugas :</div>
            <div class="ql-snow">
               <div class="assignment-text text-wrap ql-editor p-0"><?= html_entity_decode($data->assignment_desc, ENT_QUOTES, 'UTF-8') ?></div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-6 col-xl-3">
      <div class="card">
         <div class="card-body">
            <h4 class="font-weight-bolder">
               Poin Tugas :
            </h4>
            <div class="mb-2">
               <?= $data->point ?>
            </div>
            <h4 class="font-weight-bolder">
               Ditugaskan pada :
            </h4>
            <div class="mb-2">
               <?= (new DateTime($data->start_at))->format('d F Y H:i') ?> WIB
            </div>
            <h4 class="font-weight-bolder">
               Sampai :
            </h4>
            <div class="mb-2">
               <?= (new DateTime($data->due_at))->format('d F Y H:i') ?> WIB
            </div>
            <h4 class="font-weight-bolder">
               Dibuat oleh :
            </h4>
            <div class="mb-2">
               <?= $data->assigned ?>
            </div>
            <a href="<?= base_url('/assignment/' . $data->assignment_code) ?>/edit" class="btn btn-primary btn-block">Edit tugas</a>
            <button id="delete-assignment" class="btn btn-danger btn-block">Hapus</button>
         </div>
      </div>
   </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('customJSXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX') ?>
<script>
   $(document).ready(function() {
      $(document).on('click', '#delete-assignment', function() {
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
                  url: "<?= base_url('api/assignment/' . $data->assignment_code) ?>",
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
                           window.location.href = "<?= base_url('assignment') ?>";
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