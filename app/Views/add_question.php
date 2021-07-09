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
<?php if (isset($bank_question_id)) $url = base_url('api/bank_question/' . $bank_question_id . '/question');
elseif (isset($quiz_code)) $url = base_url('api/quiz/' . $quiz_code . '/question');
else $url = base_url('api/question'); ?>
<div class="card">
   <div class="card-header">
      <h4 class="card-title">Tambah Soal</h4>
   </div>
   <div class="card-body">
      <ul class="nav nav-pills mb-2">
         <li class="nav-item">
            <a class="nav-link active" id="mc-tab" data-toggle="pill" href="#mc" aria-expanded="true">Pilihan Ganda</a>
         </li>
         <li class="nav-item">
            <a class="nav-link" id="essay-tab" data-toggle="pill" href="#essay" aria-expanded="false">Essai</a>
         </li>
      </ul>
      <div class="tab-content">
         <div role="tabpanel" class="tab-pane active" id="mc" aria-labelledby="mc-tab" aria-expanded="true">
            <form class="add-question" enctype="multipart/form-data" onsubmit="return false;">
               <div class="form-group">
                  <label class="m-0">Pertanyaan</label>
                  <input type="hidden" name="question_type" value="mc">
                  <textarea name="question_text" class="form-control" hidden></textarea>
                  <div class="invalid-feedback my-25"></div>
                  <div class="quill-editor-question"></div>
               </div>
               <div class="choices">
                  <?php for ($i = 0; $i < 5; $i++) { ?>
                     <div class="form-group">
                        <div class="custom-control custom-radio">
                           <span>
                              <input type="radio" name="answer_key" id="choice-<?= $i ?>" value="<?= $i ?>" class="custom-control-input" required>
                              <label class="custom-control-label w-100" for="choice-<?= $i ?>">
                                 Jadikan kunci jawaban
                              </label>
                              <div class="invalid-feedback my-25"></div>
                           </span>
                           <textarea name="choice[<?= $i ?>]" class="form-control" hidden></textarea>
                           <div class="invalid-feedback my-25"></div>
                           <div class="quill-editor-<?= $i ?>"></div>
                        </div>
                     </div>
                  <?php } ?>
               </div>
               <div class="mt-50 float-right">
                  <button type="button" class="btn btn-sm btn-primary btn-minus" title="Minimal 2"><i data-feather="minus"></i></button>
                  <div class="d-inline-block font-weight-bold total-choices h4 px-3 py-1 m-0">5</div>
                  <button type="button" class="btn btn-sm btn-primary btn-plus" title="Maksimal 5"><i data-feather="plus"></i></button>
               </div>
               <div class="clearfix"></div>
               <button type="submit" class="btn btn-primary float-right mt-2">Tambahkan</button>
            </form>
         </div>
         <div class="tab-pane" id="essay" role="tabpanel" aria-labelledby="essay-tab" aria-expanded="false">
            <form class="add-question" enctype="multipart/form-data" onsubmit="return false;">
               <div class="form-group">
                  <label class="m-0">Pertanyaan</label>
                  <input type="hidden" name="question_type" value="essay">
                  <textarea name="question_text" class="form-control" hidden></textarea>
                  <div class="invalid-feedback my-25"></div>
                  <div class="quill-editor-question"></div>
               </div>
               <button type="submit" class="btn btn-primary float-right mt-2">Tambahkan</button>
            </form>
         </div>
      </div>
   </div>
</div>
<div class="d-none">
   <div id="tmp-choice" class="form-group">
      <div class="custom-control custom-radio">
         <span>
            <input type="radio" name="key" id="" value="" class="custom-control-input" required>
            <label class="custom-control-label w-100 mb-50" for="">
               Jadikan kunci jawaban
            </label>
            <div class="invalid-feedback my-25"></div>
         </span>
         <textarea name="choices[]" class="form-control" hidden></textarea>
         <div class="invalid-feedback my-25"></div>
         <div class="quill-editor"></div>
      </div>
   </div>
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
   var icons = Quill.import('ui/icons');
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
   var editor_choices = [];
   var editor_mc_question = new Quill('#mc .quill-editor-question', set_editor);
   var editor_essay_question = new Quill('#essay .quill-editor-question', set_editor);
   editor_mc_question.focus();
   editor_mc_question.setContents(editor_mc_question.clipboard.convert($('#mc [name=question]').val())); // Set default value
   editor_essay_question.setContents(editor_essay_question.clipboard.convert($('#essay [name=question]').val())); // Set default value
   for (let index = 0; index < 5; index++) {
      if ($('.quill-editor-' + index).attr('class') === undefined) {
         continue;
      }
      editor_choices.push(new Quill('.quill-editor-' + index, set_editor));
      editor_choices[index].setContents(editor_choices[index].clipboard.convert($('.choices textarea').eq(index).val())); // Set default value
   }
   editor_mc_question.on('text-change', function() {
      // Update value question every text change
      $('#mc [name=question]').val(editor_mc_question.root.innerHTML);
   })
   editor_essay_question.on('text-change', function() {
      // Update value question every text change
      $('#essay [name=question]').val(editor_essay_question.root.innerHTML);
   })
   editor_choices.forEach(function(val, index) {
      editor_choices[index].on('text-change', function() {
         // Update value choices every text change
         $('.choices textarea').eq(index).val(editor_choices[index].root.innerHTML);
      })
   })
   $(document).on('click', '.btn-plus', function() {
      var total_index = $('.choices').find('.form-group').length;
      if (total_index == 5) {
         return false;
      }
      var tmp_choice = $('#tmp-choice').clone();
      tmp_choice.removeAttr('id');
      tmp_choice.find('textarea').attr('name', 'choices[' + total_index + ']');
      tmp_choice.find('.quill-editor').attr('class', 'quill-editor-' + total_index);
      tmp_choice.find('[name=key]').val(total_index).attr('id', 'choice-' + total_index);
      tmp_choice.find('.custom-control-label').attr('for', 'choice-' + total_index);
      $('.choices').append(tmp_choice);
      $('.total-choices').text(total_index + 1);
      new Quill('.quill-editor-' + total_index, set_editor);
   })
   $(document).on('click', '.btn-minus', function() {
      var total_index = $('.choices').find('.form-group').length;
      if (total_index == 2) {
         return false;
      }
      $('.total-choices').text(total_index - 1);
      $('.choices > .form-group').eq(total_index - 1).remove();
   })
   $(document).on('submit', '.add-question', function(e) {
      e.preventDefault();
      $(this).find('.is-invalid').removeClass('is-invalid');
      $(this).find('.invalid-feedback').text(null);
      var form = $(this);
      var data = $(this).serialize();
      $.ajax({
         url: "<?= $url ?>",
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
   $('body').tooltip({
      selector: ".btn-minus, .btn-plus",
      placement: "top",
      trigger: "hover"
   })
</script>
<?= $this->endSection() ?>