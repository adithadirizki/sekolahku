<?= $this->extend('teacher/template') ?>
<?= $this->section('vendorCSS') ?>
<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/editors/quill/katex.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/editors/quill/monokai-sublime.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/editors/quill/quill.snow.css') ?>">
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row match-height">
   <div class="col-md-8">
      <div class="card">
         <div class="card-body">
            <h1 class="h2"><?= $data->assignment_title ?></h1>
            <hr>
            <div class="ql-snow">
               <div class="assignment-text text-wrap ql-editor p-0"><?= html_entity_decode($data->assignment_desc, ENT_QUOTES, 'UTF-8') ?></div>
            </div>
            <hr>
         </div>
      </div>
   </div>
   <div class="col-md-4">
      <div class="card border-primary flex-grow-0">
         <div class="card-body">
            <?= strtotime('now') > strtotime($data->due_at) ? '<div class="badge badge-light-danger font-medium-2 d-block p-75 mb-1">BERAKHIR</div>' : '' ?>
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
            <div class="mb-2">
               <?= $data->class_group_name ?>
            </div>
            <h4 class="font-weight-bolder">
               Tahun Ajaran :
            </h4>
            <div>
               <?= $data->school_year_title ?>
            </div>
         </div>
      </div>
      <div class="card flex-grow-0">
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
            <a href="<?= base_url('assignmentresult?assignment=' . $data->assignment_code) ?>" class="btn btn-info btn-block">Lihat hasil Tugas</a>
            <a href="<?= base_url('assignment/' . $data->assignment_code) ?>/edit" class="btn btn-primary btn-block">Edit tugas</a>
            <button id="delete-assignment" class="btn btn-danger btn-block">Hapus</button>
         </div>
      </div>
   </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('customJS') ?>
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