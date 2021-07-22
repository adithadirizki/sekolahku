<?= $this->extend('template') ?>
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
<div class="row">
   <div class="col-lg-12 m-auto">
      <div class="card">
         <div class="card-body">
            <div class="card-title"><?= $title ?></div>
            <form id="add-announcement" enctype="multipart/form-data" onsubmit="return false;">
               <div class="form-group">
                  <label for="announcement_title">Judul Pengumuman <span class="text-danger font-small-4">*</span></label>
                  <input type="text" class="form-control" name="announcement_title" id="announcement_title" placeholder="Judul Pengumuman" required>
                  <div class="invalid-feedback"></div>
               </div>
               <div class="form-group">
                  <label for="announcement_desc">Deskripsi Pengumuman <span class="text-danger font-small-4">*</span></label>
                  <textarea name="announcement_desc" id="announcement_desc" hidden></textarea>
                  <div class="invalid-feedback mt-0 mb-50"></div>
                  <div class="all-editor"></div>
               </div>
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="announcement_for">Ditujukan untuk <span class="text-danger font-small-4">*</span></label>
                        <select name="announcement_for" id="announcement_for" class="form-control" required>
                           <option value="all" selected>Semua</option>
                           <option value="teacher">Hanya Guru</option>
                           <option value="student">Hanya Siswa</option>
                        </select>
                        <div class="invalid-feedback"></div>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="announced_at">Diumumkan pada <span class="text-danger font-small-4">*</span></label>
                        <input type="datetime-local" class="form-control" name="announced_at" id="announced_at" value="<?= (new DateTime())->format('Y-m-d\TH:i') ?>" required>
                        <div class="invalid-feedback"></div>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="announced_until">Berakhir pada <span class="text-danger font-small-4">*</span></label>
                        <input type="datetime-local" class="form-control" name="announced_until" id="announced_until" required>
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
      $(document).on('submit', '#add-announcement', function(e) {
         e.preventDefault();
         $(this).find('.is-invalid').removeClass('is-invalid');
         $(this).find('.invalid-feedback').text(null);
         var form = $(this);
         var data = $(this).serialize();
         $.ajax({
            url: "<?= base_url('api/announcement') ?>",
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
                     window.location.href = "<?= base_url('announcement') ?>";
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