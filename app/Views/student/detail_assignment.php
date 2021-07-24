<?= $this->extend('student/template') ?>
<?= $this->section('vendorCSS') ?>
<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/editors/quill/katex.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/editors/quill/monokai-sublime.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/editors/quill/quill.snow.css') ?>">
<?= $this->endSection() ?>
<?= $this->section('customCSS') ?>
<style>
   .ql-container {
      resize: vertical;
      overflow-y: auto;
      min-height: 100px !important;
   }
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row match-height">
   <div class="col-md-8">
      <div class="card">
         <div class="card-body">
            <div class="card-title"><?= $data->assignment_title ?>
               <?= $data->assignment_result_id !== null ? '<div class="badge badge-pill badge-light-success ml-25">SELESAI</div>' : null ?>
               <?= strtotime('now') > strtotime($data->due_at) ? '<div class="badge badge-pill badge-light-danger ml-25">BERAKHIR</div>' : null ?>
            </div>
            <hr>
            <div class="ql-snow">
               <div class="assignment-text text-wrap ql-editor p-0"><?= html_entity_decode($data->assignment_desc, ENT_QUOTES, 'UTF-8') ?></div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-4">
      <div class="card border-primary flex-grow-0">
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
            <div>
               <?= $data->subject_name ?>
            </div>
         </div>
      </div>
      <div class="card flex-grow-0">
         <div class="card-body">
            <?php if ($data->assignment_result_id === null) { ?>
               <h4 class="font-weight-bolder">
                  Poin Tugas :
               </h4>
               <div class="mb-2">
                  <?= $data->point ?>
               </div>
            <?php } elseif ($data->value === null) { ?>
               <h4 class="font-weight-bolder">
                  Nilai Tugas :
               </h4>
               <div class="mb-2">
                  Belum dinilai/<?= $data->point ?>
               </div>
            <?php } else { ?>
               <h4 class="font-weight-bolder">
                  Nilai Tugas :
               </h4>
               <div class="mb-2">
                  <?= $data->value ?>/<?= $data->point ?>
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
               <?= $data->assigned ?>
            </div>
         </div>
      </div>
   </div>
   <?php if ($data->assignment_result_id !== null) { ?>
      <div class="col">
         <div class="card">
            <div class="card-body">
               <div class="divider">
                  <div class="divider-text">JAWABAN</div>
               </div>
               <div class="ql-snow">
                  <div class="ql-editor text-wrap p-0">
                     <?= html_entity_decode($data->answer, ENT_QUOTES, 'UTF-8') ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   <?php } elseif ($data->assignment_result_id === null && strtotime('now') < strtotime($data->due_at)) { ?>
      <div class="col">
         <div class="card">
            <div class="card-body">
               <div class="divider">
                  <div class="divider-text">JAWABAN</div>
               </div>
               <form id="add-assignment-result" enctype="multipart/form-data" onsubmit="return false;">
                  <div class="form-group">
                     <textarea name="answer" id="answer" hidden></textarea>
                     <div class="all-editor"></div>
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
      $(document).on('submit', '#add-assignment-result', function(e) {
         e.preventDefault();
         $(this).find('.is-invalid').removeClass('is-invalid');
         $(this).find('.invalid-feedback').text(null);
         var form = $(this);
         var data = $(this).serialize();
         $.ajax({
            url: "<?= base_url('api/assignment/' . $data->assignment_code . '/complete') ?>",
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