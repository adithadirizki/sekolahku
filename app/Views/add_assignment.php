<?php if (session()->role == 'superadmin') {
   echo $this->extend('template');
} elseif (session()->role == 'teacher') {
   echo $this->extend('teacher/template');
} ?>
<?= $this->section('vendorCSS') ?>
<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/editors/quill/katex.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/editors/quill/monokai-sublime.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/editors/quill/quill.snow.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/forms/select/select2.min.css') ?>">
<?= $this->endSection() ?>
<?= $this->section('customCSS') ?>
<style>
   .ql-container {
      resize: vertical;
      overflow-y: auto;
      min-height: 100px !important;
   }

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
<div class="card">
   <div class="card-body">
      <div class="card-title"><?= $title ?></div>
      <form id="add-assignment" enctype="multipart/form-data" onsubmit="return false;">
         <div class="form-group">
            <label for="assignment_title">Judul Tugas <span class="text-danger font-small-4">*</span></label>
            <input type="text" class="form-control" name="assignment_title" id="assignment_title" placeholder="Judul Tugas" required>
            <div class="invalid-feedback"></div>
         </div>
         <div class="form-group">
            <label for="assignment_desc">Deskripsi Tugas <span class="text-danger font-small-4">*</span></label>
            <textarea name="assignment_desc" id="assignment_desc" hidden></textarea>
            <div class="invalid-feedback mt-0 mb-50"></div>
            <div class="all-editor"></div>
         </div>
         <div class="row">
            <div class="col-md-6">
               <div class="form-group">
                  <label for="subject">Mata Pelajaran <span class="text-danger font-small-4">*</span></label>
                  <select name="subject" id="subject" class="form-control" required>
                     <option selected disabled></option>
                     <?php foreach ($subject as $v) { ?>
                        <option value="<?= $v->subject_id ?>"><?= $v->subject_name ?></option>
                     <?php } ?>
                  </select>
                  <div class="invalid-feedback"></div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <label for="class_group">Kelas <span class="text-danger font-small-4">*</span></label>
                  <select name="class_group[]" id="class_group" class="form-control" multiple required></select>
                  <div class="invalid-feedback"></div>
               </div>
            </div>
            <div class="col-md-4">
               <div class="form-group">
                  <label for="point">Poin Tugas <span class="text-danger font-small-4">*</span></label>
                  <input type="number" class="form-control" name="point" id="point" placeholder="Poin Tugas" required>
                  <div class="invalid-feedback"></div>
               </div>
            </div>
            <div class="col-md-4">
               <div class="form-group">
                  <label for="start_at">Ditugaskan pada <span class="text-danger font-small-4">*</span></label>
                  <input type="datetime-local" class="form-control" name="start_at" id="start_at" value="<?= (new DateTime())->format('Y-m-d\TH:i') ?>" required>
                  <div class="invalid-feedback"></div>
               </div>
            </div>
            <div class="col-md-4">
               <div class="form-group">
                  <label for="due_at">Berakhir pada <span class="text-danger font-small-4">*</span></label>
                  <input type="datetime-local" class="form-control" name="due_at" id="due_at" required>
                  <div class="invalid-feedback"></div>
               </div>
            </div>
         </div>
         <div class="text-right mt-2">
            <button type="submit" class="btn btn-primary">Tambahkan</button>
         </div>
      </form>
   </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('vendorJS') ?>
<script src="<?= base_url('app-assets/vendors/js/editors/quill/katex.min.js') ?>"></script>
<script src="<?= base_url('app-assets/vendors/js/editors/quill/highlight.min.js') ?>"></script>
<script src="<?= base_url('app-assets/vendors/js/editors/quill/quill.min.js') ?>"></script>
<script src="<?= base_url('app-assets/vendors/js/editors/quill/image-resize.min.js') ?>"></script>
<script src="<?= base_url('app-assets/vendors/js/forms/select/select2.full.min.js') ?>"></script>
<?= $this->endSection() ?>
<?= $this->section('customJS') ?>
<script src="<?= base_url('assets/js/quill-editor.js') ?>" type="text/javascript"></script>
<script>
   $(document).ready(function() {
      var csrf_token = "<?= csrf_hash() ?>";
      var icons = Quill.import('ui/icons');
      var all_editor = [];
      icons['undo'] = feather.icons['corner-up-left'].toSvg();
      icons['redo'] = feather.icons['corner-up-right'].toSvg();
      var set_editor = {
         theme: 'snow',
         modules: {
            formula: true,
            syntax: true,
            imageResize: {
               displaySize: true
            },
            toolbar: {
               container: [
                  [{
                     font: []
                  }],
                  [{
                     header: [1, 2, 3, 4, 5, 6, false]
                  }],
                  ['bold', 'italic', 'underline', 'strike'],
                  [{
                        color: []
                     },
                     {
                        background: []
                     }
                  ],
                  [{
                        script: 'super'
                     },
                     {
                        script: 'sub'
                     }
                  ],
                  [
                     'blockquote',
                     'code-block'
                  ],
                  [{
                        list: 'ordered'
                     },
                     {
                        list: 'bullet'
                     },
                     {
                        indent: '-1'
                     },
                     {
                        indent: '+1'
                     }
                  ],
                  [
                     'direction',
                     {
                        align: []
                     }
                  ],
                  ['link', 'image', 'file', 'video', 'formula'],
                  ['undo', 'redo', 'clean']
               ],
               handlers: {
                  file: function() {
                     const quill_editor = this.quill;
                     const range = this.quill.getSelection();
                     const input = document.createElement('input');
                     input.setAttribute('type', 'file');
                     input.setAttribute('accept', listMimeImg.concat(listMimeAudio, listMimeVideo, listOtherMime));
                     input.click();
                     input.onchange = () => {
                        var formData = new FormData();
                        var file = input.files[0];
                        formData.append('file', file);
                        $.ajax({
                           url: "<?= base_url('api/upload/file') ?>",
                           type: "post",
                           dataType: "json",
                           data: formData,
                           headers: {
                              Authorization: "<?= session()->token ?>"
                           },
                           cache: false,
                           contentType: false,
                           processData: false,
                           success: function(result) {
                              if (result.error == false) {
                                 if (listMimeImg.indexOf(file.type) > -1) {
                                    //Picture
                                    quill_editor.insertEmbed(range.index, 'image', result.url);
                                 } else if (listMimeAudio.indexOf(file.type) > -1) {
                                    //Audio
                                    quill_editor.insertEmbed(range.index, 'audio', result.url);
                                 } else if (listMimeVideo.indexOf(file.type) > -1) {
                                    //Video
                                    quill_editor.insertEmbed(range.index, 'video', result.url);
                                 } else if (listOtherMime.indexOf(file.type) > -1) {
                                    //Other file type
                                    quill_editor.insertText(range.index, file.name, 'link', result.url);
                                 }
                              }
                           }
                        })
                     };
                  },
                  undo: function() {
                     this.quill.history.undo();
                  },
                  redo: function() {
                     this.quill.history.redo();
                  }
               }
            }
         }
      };
      $('.all-editor').each(function(index, obj) {
         var this_editor = $(this);
         all_editor.push(new Quill(obj, set_editor));
         all_editor[index].setContents(all_editor[index].clipboard.convert(this_editor.siblings('textarea').val())); // Set default value
         all_editor[index].on('text-change', function(delta) {
            // Update value choices every text change
            this_editor.siblings('textarea').val(all_editor[index].root.innerHTML);
         })
      })
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
      $(document).on('submit', '#add-assignment', function(e) {
         e.preventDefault();
         $(this).find('.is-invalid').removeClass('is-invalid');
         $(this).find('.invalid-feedback').text(null);
         var form = $(this);
         var data = $(this).serialize();
         $.ajax({
            url: "<?= base_url('api/assignment') ?>",
            type: "post",
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
                     window.location.href = "<?= base_url('assignment') ?>";
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