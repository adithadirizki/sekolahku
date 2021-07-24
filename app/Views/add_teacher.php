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
<div class="card">
   <div class="card-body">
      <form id="add-user" enctype="multipart/form-data" onsubmit="return false;">
         <div class="row">
            <div class="col-md-6 col-lg-4 mb-2">
               <h4 class="mb-1">
                  <i class="font-medium-3 mr-50" data-feather="user"></i>
                  <span class="align-middle">Account</span>
               </h4>
               <div class="col-12 text-center">
                  <label for="photo">
                     <img src="<?= base_url('assets/upload/avatar-default.jpg') ?>" class="img-fluid user-avatar rounded" alt="Photo" width="120" height="120">
                     <input type="file" name="photo" id="photo" hidden accept="image/jpeg,image/png">
                  </label>
               </div>
               <div class="form-group">
                  <label for="username">Username <span class="text-danger font-small-4">*</span></label>
                  <input type="text" id="username" class="form-control" name="username" placeholder="Username" required>
                  <div class="invalid-feedback"></div>
               </div>
               <div class="form-group">
                  <label for="fullname">Nama Lengkap <span class="text-danger font-small-4">*</span></label>
                  <input type="text" id="fullname" class="form-control" name="fullname" placeholder="Nama Lengkap" required>
                  <div class="invalid-feedback"></div>
               </div>
               <div class="form-group">
                  <label for="email">E-mail <span class="text-danger font-small-4">*</span></label>
                  <input type="email" id="email" class="form-control" name="email" placeholder="E-mail" required>
                  <div class="invalid-feedback"></div>
               </div>
               <div class="form-group">
                  <label for="password">Password <span class="text-danger font-small-4">*</span></label>
                  <input type="text" id="password" class="form-control" name="password" minlength="6" placeholder="Password" required>
                  <input type="hidden" id="role" class="form-control" name="role" value="teacher" required>
                  <div class="invalid-feedback"></div>
               </div>
               <div class="form-group">
                  <label for="is_active">Status <span class="text-danger font-small-4">*</span></label>
                  <select name="is_active" id="is_active" class="form-control" required>
                     <option value="" selected disabled> -- Pilih Status -- </option>
                     <option value="0">Menunggu Konfirmasi</option>
                     <option value="1">Aktif</option>
                     <option value="2">Nonaktif</option>
                  </select>
                  <div class="invalid-feedback"></div>
               </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-2">
               <h4 class="mb-1">
                  <i class="font-medium-3 mr-50" data-feather="info"></i>
                  <span class="align-middle">Data Personal</span>
               </h4>
               <div class="form-group">
                  <label for="nip">NIP <span class="text-danger font-small-4">*</span></label>
                  <input type="text" id="nip" class="form-control" name="nip" placeholder="NIP" required>
                  <div class="invalid-feedback"></div>
               </div>
               <div class="form-group">
                  <label for="pob">Tempat Lahir</label>
                  <input type="text" id="pob" class="form-control" name="pob" placeholder="Tempat Lahir">
                  <div class="invalid-feedback"></div>
               </div>
               <div class="form-group">
                  <label for="dob">Tanggal Lahir</label>
                  <input type="date" id="dob" class="form-control" name="dob" placeholder="Tanggal Lahir">
                  <div class="invalid-feedback"></div>
               </div>
               <div class="form-group">
                  <label for="religion">Agama</label>
                  <select id="religion" class="form-control text-capitalize" name="religion">
                     <option value="" selected> -- Pilih Agama -- </option>
                     <option value="islam">islam</option>
                     <option value="protestan">protestan</option>
                     <option value="khatolik">khatolik</option>
                     <option value="hindu">hindu</option>
                     <option value="budha">budha</option>
                     <option value="khonghucu">khonghucu</option>
                  </select>
                  <div class="invalid-feedback"></div>
               </div>
               <div class="form-group">
                  <label class="d-block">Jenis Kelamin <span class="text-danger font-small-4">*</span></label>
                  <div class="custom-control custom-radio custom-control-inline">
                     <input type="radio" id="male" name="gender" class="custom-control-input" value="male" checked required>
                     <label class="custom-control-label" for="male">Laki - laki</label>
                  </div>
                  <div class="custom-control custom-radio custom-control-inline">
                     <input type="radio" id="female" name="gender" class="custom-control-input" value="female">
                     <label class="custom-control-label" for="female">Perempuan</label>
                  </div>
                  <div class="invalid-feedback"></div>
               </div>
               <div class="form-group">
                  <label for="phone">No Telp</label>
                  <input id="phone" type="number" name="phone" class="form-control" placeholder="No Telp">
                  <div class="invalid-feedback"></div>
               </div>
               <div class="form-group">
                  <label for="address-1">Alamat</label>
                  <textarea class="form-control" name="address" id="address" cols="10" rows="4" placeholder="Alamat"></textarea>
                  <div class="invalid-feedback"></div>
               </div>
            </div>
            <div class="col-lg-4 mb-2">
               <h4 class="mb-1">
                  <i class="font-medium-3 mr-50" data-feather="unlock"></i>
                  <span class="align-middle">Akses Guru</span>
               </h4>
               <div class="form-group">
                  <label for="teaching_class">Mengajar di Kelas</label>
                  <select name="teaching_class[]" id="teaching_class" class="form-control" multiple></select>
                  <div class="invalid-feedback"></div>
               </div>
               <div class="form-group">
                  <label for="teaching_subject">Mengajar Mata Pelajaran</label>
                  <select name="teaching_subject[]" id="teaching_subject" class="form-control" multiple></select>
                  <div class="invalid-feedback"></div>
               </div>
            </div>
            <div class="col-12 text-right">
               <button type="submit" class="btn btn-primary">Tambahkan</button>
            </div>
         </div>
      </form>
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
      const photo = "<?= base_url('assets/upload/avatar-default.jpg') ?>";
      $(document).on('change', '#photo', function(e) {
         if (this.files && this.files[0]) {
            if (this.files[0].size / 1024 / 1024 > 2) {
               Swal.fire({
                  title: "Failed!",
                  text: "The uploaded file is too large! Maximum file size of 2MB.",
                  icon: "error",
                  showConfirmButton: false,
                  timer: 3000
               })
               $(this).val(null)
               return false
            }
            var reader = new FileReader();
            reader.onload = function(e) {
               $('.user-avatar').attr('src', e.target.result);
            };
            reader.readAsDataURL(this.files[0]);
         } else {
            $('.user-avatar').attr('src', photo);
         }
      });
      var class_group = $('#teaching_class');
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
      var subject = $('#teaching_subject');
      subject.wrap('<div class="position-relative"></div>');
      $(subject).select2({
         placeholder: ' -- Pilih Mata Pelajaran -- ',
         width: '100%',
         closeOnSelect: false,
         dropdownAutoWidth: true,
         dropdownParent: subject.parent(),
         ajax: {
            url: "<?= base_url('subject/get_subjects') ?>",
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
                     data: "subject_name"
                  }],
                  order: [{
                     column: 0,
                     dir: "asc"
                  }],
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
                        id: value.subject_id,
                        text: value.subject_name
                     }
                  }),
                  pagination: {
                     more: (page * 10) < result.recordsFiltered
                  }
               };
            }
         }
      });
      $(document).on('submit', '#add-user', function(e) {
         e.preventDefault();
         $(this).find('.is-invalid').removeClass('is-invalid');
         $(this).find('.invalid-feedback').removeClass('d-block').text(null);
         var form = $(this);
         var data = new FormData($(this)[0]);
         $.ajax({
            url: "<?= base_url('api/teacher') ?>",
            type: "post",
            cache: false,
            dataType: "json",
            processData: false,
            contentType: false,
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
                     window.location.href = "<?= base_url('teacher') ?>";
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