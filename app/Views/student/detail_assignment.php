<?= $this->extend('student/template') ?>
<?= $this->section('vendorCSS') ?>
<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/editors/quill/katex.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/editors/quill/monokai-sublime.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/editors/quill/quill.snow.css') ?>">
<?= $this->endSection() ?>
<?= $this->section('styleCSS') ?>
<style>
   .ql-container {
      resize: vertical;
      overflow-y: auto;
      min-height: 100px !important;
   }
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row">
   <div class="col-md-8">
      <div class="card">
         <div class="card-body">
            <div class="card-title text-center">
               <?= $data->assignment_title ?>
            </div>
            <?php
            if (new DateTime() < new DateTime($data->start_at) || new DateTime() > new DateTime($data->due_at)) {
               echo '<h4 class="mb-2"><div class="badge badge-light-danger d-block py-1">TELAH BERAKHIR</div></h4>';
            }
            ?>
            <h4 class="font-weight-bolder">
               Mata pelajaran :
            </h4>
            <div class="mb-2">
               <?= $data->subject_name ?>
            </div>
            <h4 class="font-weight-bolder">
               Poin :
            </h4>
            <div class="mb-2">
               <?= $data->point ?>
            </div>
            <h4 class="font-weight-bolder">
               Deskripsi tugas :
            </h4>
            <div class="ql-editor text-wrap p-0" id="assignment_desc">
               <?= html_entity_decode($data->assignment_desc, ENT_QUOTES, 'UTF-8') ?>
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-4 order-md-first">
      <div class="card">
         <div class="card-body">
            <h4 class="font-weight-bolder">
               Kode tugas :
            </h4>
            <div class="mb-2">
               <?= $data->assignment_code ?>
            </div>
            <h4 class="font-weight-bolder">
               Dibuat pada :
            </h4>
            <div class="mb-2">
               <?php
               echo (new Datetime($data->start_at))->format('d m Y');
               ?>
            </div>
            <h4 class="font-weight-bolder">
               Berakhir :
            </h4>
            <div class="mb-2">
               <?= $data->due_at ? (new Datetime($data->due_at))->format('d m Y') : '-' ?>
            </div>
            <h4 class="font-weight-bolder">
               Tahun ajaran :
            </h4>
            <div class="mb-2">
               <?= $data->school_year_title ?>
            </div>
            <h4 class="font-weight-bolder">
               Ditugaskan oleh :
            </h4>
            <div class="mb-2">
               <?= $data->assigned ?>
            </div>
            <?php if ($data->assignment_result_id !== null) { ?>
               <h4 class="font-weight-bolder">
                  Nilai :
               </h4>
               <div class="mb-2">
                  <?= $data->value !== null ? $data->value . '/' . $data->point : 'Belum dinilai' ?>
               </div>
               <h4 class="font-weight-bolder">
                  Dikirim pada :
               </h4>
               <div class="mb-2">
                  <?= (new DateTime($data->submitted_at))->format('d m Y') ?>
               </div>
               <?php if (new DateTime($data->submitted_at) > new DateTime($data->due_at)) { ?>
                  <h4>
                     <div class="badge badge-light-danger d-block py-1">TERLAMBAT</div>
                  </h4>
               <?php } ?>
            <?php } else { ?>
               <h4 class="m-0">
                  <div class="badge badge-danger d-block py-1">BELUM DIKERJAKAN</div>
               </h4>
            <?php } ?>
         </div>
      </div>
   </div>
   <?php if ($data->assignment_result_id !== null) { ?>
      <div class="col">
         <div class="card">
            <div class="card-body">
               <div class="divider">
                  <div class="font-weight-bolder divider-text">
                     JAWABAN
                  </div>
               </div>
               <div class="ql-editor text-wrap p-0">
                  <?= html_entity_decode($data->answer, ENT_QUOTES, 'UTF-8') ?>
               </div>
            </div>
         </div>
      </div>
   <?php } else { ?>
      <div class="col">
         <div class="card">
            <div class="card-body">
               <div class="divider">
                  <div class="divider-text">JAWABAN</div>
               </div>
               <form id="add-assignment-result" enctype="multipart/form-data" onsubmit="return false;">
                  <div class="form-group">
                     <input type="hidden" name="assignment_code" value="<?= $data->assignment_code ?>">
                     <textarea name="answer" id="answer" class="d-none"></textarea>
                     <div class="quill-editor"></div>
                  </div>
                  <div class="d-flex justify-content-end">
                     <button type="submit" class="btn btn-primary">Serahkan tugas</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   <?php } ?>
</div>
<?= $this->endSection() ?>
<?= $this->section('vendorJS') ?>
<script src="<?= base_url('app-assets/vendors/js/editors/quill/katex.min.js') ?>"></script>
<script src="<?= base_url('app-assets/vendors/js/editors/quill/highlight.min.js') ?>"></script>
<script src="<?= base_url('app-assets/vendors/js/editors/quill/quill.min.js') ?>"></script>
<script src="<?= base_url('app-assets/vendors/js/editors/quill/image-resize.min.js') ?>"></script>
<script src="<?= base_url('app-assets/vendors/js/forms/select/select2.full.min.js') ?>"></script>
<?= $this->endSection() ?>
<?= $this->section('scriptJS') ?>
<script src="<?= base_url('assets/js/quill-editor.js') ?>" type="text/javascript"></script>
<script>
   $(document).ready(function() {
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
                     const range = editor.getSelection();
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
                                    editor.insertEmbed(range.index, 'image', result.url);
                                 } else if (listMimeAudio.indexOf(file.type) > -1) {
                                    //Audio
                                    editor.insertEmbed(range.index, 'audio', result.url);
                                 } else if (listMimeVideo.indexOf(file.type) > -1) {
                                    //Video
                                    editor.insertEmbed(range.index, 'video', result.url);
                                 } else if (listOtherMime.indexOf(file.type) > -1) {
                                    //Other file type
                                    editor.insertText(range.index, file.name, 'link', result.url);
                                 }
                              }
                           }
                        })
                     };
                  },
                  undo: function() {
                     editor.history.undo();
                  },
                  redo: function() {
                     editor.history.redo();
                  }
               }
            }
         }
      };
      var editor = new Quill('.quill-editor', set_editor);
      editor.setContents(editor.clipboard.convert($('#answer').val())); // Set default value
      editor.on('text-change', function() {
         // Set value on change
         $('#answer').val(editor.root.innerHTML);
      })
      $(document).on('submit', '#add-assignment-result', function(e) {
         e.preventDefault();
         $(this).find('.is-invalid').removeClass('is-invalid');
         $(this).find('.invalid-feedback').text(null);
         var form = $(this);
         var data = $(this).serialize();
         $.ajax({
            url: "<?= base_url('api/assignment_result') ?>",
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
                     window.location.reload();
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
                     form.find('[name=' + key[0] + ']').addClass('is-invalid');
                     form.find('[name=' + key[0] + ']').closest('.form-group').find('.invalid-feedback').text(key[1]);
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