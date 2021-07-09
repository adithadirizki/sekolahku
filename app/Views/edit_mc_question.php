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
<div id="question">
   <form id="edit-question" enctype="multipart/form-data" onsubmit="return false;">
      <div class="card">
         <div class="card-body">
            <div class="card-title">Edit Soal</div>
            <div class="form-group">
               <label class="m-0">Pertanyaan <span class="text-danger font-small-4">*</span></label>
               <input type="hidden" name="question_type" value="<?= $data->question_type ?>">
               <textarea name="question_text" class="form-control" hidden><?= html_entity_decode($data->question_text, ENT_QUOTES, 'UTF-8') ?></textarea>
               <div class="invalid-feedback my-25"></div>
               <div class="all-editor quill-editor"></div>
            </div>

            <?php if ($data->question_type == 'mc') { ?>
               <?php
               $abcde = range('A', 'E');
               $choices = json_decode($data->choice);
               ?>
               <div id="choices" data-columns="<?= count($choices) ?>">
                  <?php foreach ((object) $choices as $key => $value) { ?>
                     <div class="form-group" data-index="<?= $key ?>">
                        <div class="custom-control custom-radio mb-50">
                           <input type="radio" id="choice-<?= $key ?>" name="answer_key" class="custom-control-input" value="<?= $key ?>" <?= $data->answer_key == $key ? 'checked' : null ?>>
                           <label class="custom-control-label" for="choice-<?= $key ?>"><strong><?= $abcde[$key] ?></strong>. Jadikan Kunci Jawaban</label>
                           <div class="invalid-feedback my-25"></div>
                        </div>
                        <textarea name="choice[<?= $key ?>]" class="form-control" hidden><?= html_entity_decode($value, ENT_QUOTES, 'UTF-8') ?></textarea>
                        <div class="invalid-feedback my-25"></div>
                        <div class="all-editor quill-editor"></div>
                     </div>
                  <?php } ?>
               </div>
               <div class="text-right">
                  <button type="button" class="btn btn-sm btn-primary btn-minus" title="Minimal 2"><i data-feather="minus"></i></button>
                  <div class="d-inline-block font-weight-bold total-choice h4 px-3 py-1 m-0"><?= count($choices) ?></div>
                  <button type="button" class="btn btn-sm btn-primary btn-plus" title="Maksimal 5"><i data-feather="plus"></i></button>
               </div>
            <?php } elseif ($data->question_type == 'essay') { ?>
               <div class="form-group">
                  <label class="m-0">Kunci Jawaban <small>(boleh kosong)</small></label>
                  <textarea name="answer_key" class="form-control" rows="2"><?= $data->answer_key ?></textarea>
                  <div class="invalid-feedback my-25"></div>
               </div>
            <?php } ?>
            
            <button type="submit" class="btn btn-primary float-right mt-2">Simpan perubahan</button>
         </div>
      </div>
   </form>

   <?php if ($data->question_type == 'mc') { ?>
      <div id="tmp-choice" class="d-none">
         <div class="form-group" data-index="">
            <div class="custom-control custom-radio mb-50">
               <input type="radio" id="" name="answer_key" class="custom-control-input" value="">
               <label class="custom-control-label" for=""><strong></strong>. Jadikan Kunci Jawaban</label>
               <div class="invalid-feedback my-25"></div>
            </div>
            <textarea name="choice" class="form-control" hidden disabled></textarea>
            <div class="invalid-feedback my-25"></div>
            <div class="all-editor quill-editor"></div>
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
<?= $this->endSection() ?>
<?= $this->section('customJS') ?>
<script src="<?= base_url('assets/js/quill-editor.js') ?>" type="text/javascript"></script>
<script>
   $(document).ready(function() {
      var abcde = <?= json_encode(range('A', 'E')) ?>;
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
      $('#edit-question .all-editor').each(function(index, obj) {
         var this_editor = $(this);
         all_editor.push(new Quill(obj, set_editor));
         all_editor[index].setContents(all_editor[index].clipboard.convert(this_editor.siblings('textarea').val())); // Set default value
         all_editor[index].on('text-change', function(delta) {
            // Update value choices every text change
            this_editor.siblings('textarea').val(all_editor[index].root.innerHTML);
         })
      })
      $(document).on('submit', '#edit-question', function(e) {
         e.preventDefault();
         $(this).find('.is-invalid').removeClass('is-invalid');
         $(this).find('.invalid-feedback').text(null);
         var form = $(this);
         var data = $(this).serialize();
         $.ajax({
            url: "<?= base_url('api/question/' . $data->question_id) ?>",
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
                     window.history.back();
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
                     form.find('[name="' + key[0] + '"]').addClass('is-invalid');
                     form.find('[name="' + key[0] + '"]').siblings('.invalid-feedback').text(key[1]);
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

      <?php if ($data->question_type == 'mc') { ?>
         $(document).on('click', '.btn-plus', function() {
            var tmp_choice = $('#tmp-choice').clone();
            var columns = $('#choices').data('columns');
            if (columns >= 5) {
               // Maximun choices
               return false;
            }
            tmp_choice.find('.form-group').data('index', columns);
            tmp_choice.find('textarea').attr('name', 'choice[' + columns + ']');
            tmp_choice.find('textarea').prop('disabled', false);
            tmp_choice.find('strong').text(abcde[columns]);
            tmp_choice.find('input').val(columns);
            tmp_choice.find('input').attr('id', 'choice-' + columns);
            tmp_choice.find('label').attr('for', 'choice-' + columns);
            $('#choices').append(tmp_choice.html());
            $('#choices').data('columns', columns + 1);
            $('.total-choice').text(columns + 1);
            console.log($('#choices').find('.all-editor')[columns])
            all_editor[columns] = new Quill($('#choices').find('.all-editor')[columns], set_editor);
         })
         $(document).on('click', '.btn-minus', function() {
            var columns = $('#choices').data('columns');
            if (columns <= 2) {
               // Minimum choices
               return false;
            }
            $('#choices').find('.form-group').last().remove();
            $('#choices').data('columns', columns - 1);
            $('.total-choice').text(columns - 1);
         })
         $('body').tooltip({
            selector: ".btn-minus, .btn-plus",
            placement: "top",
            trigger: "hover"
         })
      <?php } ?>
   })
</script>
<?= $this->endSection() ?>