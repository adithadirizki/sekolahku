<?= $this->extend('template') ?>
<?= $this->section('vendorCSS') ?>
<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/forms/select/select2.min.css') ?>">
<?= $this->endSection() ?>
<?= $this->section('customCSS') ?>
<style>
   .is-invalid~.select2 .select2-selection {
      border-color: #ea5455;
   }

   .form-control.is-invalid~.select2 .select2-selection {
      border-color: #ea5455;
      padding-right: calc(1.45em + 0.876rem);
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23ea5455' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23ea5455' stroke='none'/%3e%3c/svg%3e");
      background-repeat: no-repeat;
      background-position: right calc(0.3625em + 0.219rem) center;
      background-size: calc(0.725em + 0.438rem) calc(0.725em + 0.438rem);
   }
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row">
   <div class="col-lg-12 m-auto">
      <div class="card">
         <div class="card-body">
            <div class="card-title"><?= $title ?></div>
            <form id="edit-quiz" enctype="multipart/form-data" onsubmit="return false;">
               <div class="form-group">
                  <label for="quiz_title">Judul Quiz <span class="text-danger font-small-4">*</span></label>
                  <input type="text" class="form-control" name="quiz_title" id="quiz_title" value="<?= $data->quiz_title ?>" placeholder="Judul Quiz" required>
                  <div class="invalid-feedback"></div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="subject">Mata Pelajaran <span class="text-danger font-small-4">*</span></label>
                        <select name="subject" id="subject" class="form-control" required>
                           <?php foreach ($subject as $v) { ?>
                              <option value="<?= $v->subject_id ?>" <?= $data->subject_id == $v->subject_id ? 'selected' : null ?>><?= $v->subject_name ?></option>
                           <?php } ?>
                        </select>
                        <div class="invalid-feedback"></div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="class_group">Kelas <span class="text-danger font-small-4">*</span></label>
                        <select name="class_group[]" id="class_group" class="form-control" multiple required>
                           <?php foreach ($class_group as $v) { ?>
                              <option value="<?= $v->class_group_code ?>" selected><?= $v->class_group_name ?></option>
                           <?php } ?>
                        </select>
                        <div class="invalid-feedback"></div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="d-block">Model Pertanyaan <span class="text-danger font-small-4">*</span></label>
                        <div class="custom-control custom-radio custom-control-inline">
                           <input type="radio" id="normal" name="question_model" class="custom-control-input" value="0" <?= $data->question_model == 0 ? 'checked' : null ?> required>
                           <label class="custom-control-label" for="normal">Berurutan</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                           <input type="radio" id="random" name="question_model" class="custom-control-input" value="1" <?= $data->question_model == 1 ? 'checked' : null ?>>
                           <label class="custom-control-label" for="random">Acak</label>
                        </div>
                        <div class="invalid-feedback"></div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="d-block ">Perlihatkan Kunci Jawaban <span class="text-danger font-small-4">*</span> (jika siswa sudah selesai mengerjakan quiz)</label>
                        <div class="custom-control custom-radio custom-control-inline">
                           <input type="radio" id="yes" name="show_ans_key" class="custom-control-input" value="1" <?= $data->question_model == 1 ? 'checked' : null ?> required>
                           <label class="custom-control-label" for="yes">YA</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                           <input type="radio" id="no" name="show_ans_key" class="custom-control-input" value="0" <?= $data->question_model == 0 ? 'checked' : null ?>>
                           <label class="custom-control-label" for="no">TIDAK</label>
                        </div>
                        <div class="invalid-feedback"></div>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="time">Waktu Quiz <span class="text-danger font-small-4">*</span></label>
                        <input type="number" class="form-control" name="time" id="time" value="<?= $data->time ?>" placeholder="Waktu Quiz" required>
                        <div class="invalid-feedback"></div>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="start_at">Ditugaskan pada <span class="text-danger font-small-4">*</span></label>
                        <input type="datetime-local" class="form-control" name="start_at" id="start_at" value="<?= (new DateTime($data->start_at))->format('Y-m-d\TH:i') ?>" required>
                        <div class="invalid-feedback"></div>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="due_at">Berakhir pada <span class="text-danger font-small-4">*</span></label>
                        <input type="datetime-local" class="form-control" name="due_at" id="due_at" value="<?= (new DateTime($data->due_at))->format('Y-m-d\TH:i') ?>" required>
                        <div class="invalid-feedback"></div>
                     </div>
                  </div>
               </div>
               <div class="text-right mt-2">
                  <button type="submit" class="btn btn-primary">Simpan perubahan</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('vendorJS') ?>
<script src="<?= base_url('app-assets/vendors/js/forms/select/select2.full.min.js') ?>"></script>
<?= $this->endSection() ?>
<?= $this->section('customJS') ?>
<script>
   $(document).ready(function() {
      var csrf_token = "<?= csrf_hash() ?>";
      var class_group = $('#class_group');
      class_group.wrap('<div class="position-relative"></div>');
      $(class_group).select2({
         placeholder: ' -- Pilih Kelas -- ',
         width: '100%',
         closeOnSelect: false,
         dropdownAutoWidth: true,
         dropdownParent: class_group.parent(),
         ajax: {
            url: "<?= base_url('classes/get_class_groups') ?>",
            type: "post",
            dataType: "json",
            delay: 500,
            data: function(params) {
               var search = {
                  value: params.term || ''
               };
               var page = params.page || 1;
               var length = 10;
               var start = (page - 1) * length;
               return {
                  length: length,
                  start: start,
                  search: search,
                  columns: [{
                        data: "class_name"
                     },
                     {
                        data: "major_code"
                     },
                     {
                        data: "unit_major"
                     }
                  ],
                  order: [{
                        column: 0,
                        dir: "asc"
                     },
                     {
                        column: 1,
                        dir: "asc"
                     },
                     {
                        column: 2,
                        dir: "asc"
                     }
                  ],
                  <?= csrf_token() ?>: csrf_token
               }
            },
            processResults: function(result, params) {
               var page = params.page || 1;
               var length = 10;
               csrf_token = result.<?= csrf_token() ?>;
               return {
                  results: $.map(result.data, function(value, index) {
                     return {
                        id: value.class_group_code,
                        text: value.class_group_name
                     }
                  }),
                  pagination: {
                     more: (page * 10) < result.recordsFiltered
                  }
               };
            }
         }
      });
      var subject = $('#subject');
      subject.wrap('<div class="position-relative"></div>');
      $(subject).select2({
         placeholder: ' -- Pilih Mata Pelajaran -- ',
         width: '100%',
         dropdownAutoWidth: true,
         dropdownParent: subject.parent(),
      })
      $(document).on('submit', '#edit-quiz', function(e) {
         e.preventDefault();
         $(this).find('.is-invalid').removeClass('is-invalid');
         $(this).find('.invalid-feedback').text(null);
         var form = $(this);
         var data = $(this).serialize();
         $.ajax({
            url: "<?= base_url('api/quiz/' . $data->quiz_code) ?>",
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
                  }).then(function() {
                     window.location.href = "<?= base_url('quiz/' . $data->quiz_code) ?>";
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
         return false;
      })
   })
</script>
<?= $this->endSection() ?>