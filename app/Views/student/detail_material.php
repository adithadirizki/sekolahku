<?= $this->extend('student/template') ?>
<?= $this->section('vendorCSS') ?>
<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/editors/quill/katex.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/editors/quill/monokai-sublime.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/editors/quill/quill.snow.css') ?>">
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row match-height">
   <div class="col-lg-9">
      <div class="card">
         <div class="card-body">
            <h1 class="h2"><?= $data->material_title ?></h1>
            <hr>
            <div class="ql-snow">
               <div class="material-text text-wrap ql-editor p-0"><?= html_entity_decode($data->material_desc, ENT_QUOTES, 'UTF-8') ?></div>
            </div>
            <hr>
         </div>
      </div>
   </div>
   <div class="col-lg-3">
      <div class="card border-primary flex-grow-0">
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
               Diterbitkan pada :
            </h4>
            <div class="mb-2">
               <?= (new DateTime($data->publish_at))->format('d F Y H:i') ?> WIB
            </div>
            <h4 class="font-weight-bolder">
               Dibuat oleh :
            </h4>
            <div>
               <?= $data->created ?>
            </div>
         </div>
      </div>
   </div>
</div>
<?= $this->endSection() ?>