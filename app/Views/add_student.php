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
            <div class="col-md-6 mb-2">
               <div class="row">
                  <div class="col-12">
                     <h4 class="mb-1">
                        <i class="font-medium-3 mr-50" data-feather="user"></i>
                        <span class="align-middle">Account</span>
                     </h4>
                  </div>
                  <div class="col-12 text-center">
                     <label for="photo">
                        <img src="<?= base_url('assets/upload/avatar-default.jpg') ?>" class="img-fluid user-avatar rounded" alt="Photo" width="120" height="120">
                        <input type="file" name="photo" id="photo" hidden accept="image/jpeg,image/png">
                     </label>
                  </div>
                  <div class="col-12">
                     <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" class="form-control" name="username" placeholder="Username" required>
                        <div class="invalid-feedback"></div>
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="form-group">
                        <label for="fullname">Nama Lengkap</label>
                        <input type="text" id="fullname" class="form-control" name="fullname" placeholder="Nama Lengkap" required>
                        <div class="invalid-feedback"></div>
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" id="email" class="form-control" name="email" placeholder="E-mail" required>
                        <div class="invalid-feedback"></div>
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="form-group">
                        <label for="password">Password</label>
                        <input type="text" id="password" class="form-control" name="password" minlength="6" placeholder="Password" required>
                        <input type="hidden" id="role" class="form-control" name="role" value="teacher" required>
                        <div class="invalid-feedback"></div>
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="form-group">
                        <label for="is_active">Status</label>
                        <select name="is_active" id="is_active" class="form-control" required>
                           <option value="" selected disabled> -- Pilih Status -- </option>
                           <option value="0">Menunggu Konfirmasi</option>
                           <option value="1">Aktif</option>
                           <option value="2">Nonaktif</option>
                        </select>
                        <div class="invalid-feedback"></div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="row">
                  <div class="col-12">
                     <h4 class="mb-1">
                        <i class="font-medium-3 mr-50" data-feather="info"></i>
                        <span class="align-middle">Data Personal</span>
                     </h4>
                  </div>
                  <div class="col-12">
                     <div class="form-group">
                        <label for="nip">NIP</label>
                        <input type="text" id="nip" class="form-control" name="nip" placeholder="NIP" required>
                        <div class="invalid-feedback"></div>
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="form-group">
                        <label for="birth_in">Tempat Lahir</label>
                        <input type="text" id="birth_in" class="form-control" name="birth_in" placeholder="Tempat Lahir">
                        <div class="invalid-feedback"></div>
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="form-group">
                        <label for="birth_at">Tanggal Lahir</label>
                        <input type="date" id="birth_at" class="form-control" name="birth_at">
                        <div class="invalid-feedback"></div>
                     </div>
                  </div>
                  <div class="col-12">
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
                  </div>
                  <div class="col-12">
                     <div class="form-group">
                        <label class="d-block">Jenis kelamin</label>
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
                  </div>
                  <div class="col-12">
                     <div class="form-group">
                        <label for="class_group">Kelas</label>
                        <select id="class_group" class="form-control" name="class_group"></select>
                        <div class="invalid-feedback"></div>
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="form-group">
                        <label for="phone">No telp</label>
                        <input id="phone" type="number" name="phone" class="form-control" placeholder="No Telp">
                        <div class="invalid-feedback"></div>
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="form-group">
                        <label for="address-1">Alamat</label>
                        <textarea class="form-control" name="address" id="address" cols="10" rows="4" placeholder="Alamat"></textarea>
                        <div class="invalid-feedback"></div>
                     </div>
                  </div>
               </div>
               <button type="submit" class="btn btn-primary waves-effect waves-float waves-light float-right">Tambahkan</button>
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
      $(document).on('submit', '#add-user', function(e) {
         e.preventDefault();
         $(this).find('.is-invalid').removeClass('is-invalid');
         $(this).find('.invalid-feedback').removeClass('d-block').text(null);
         var form = $(this);
         var data = new FormData($(this)[0]);
         $.ajax({
            url: "<?= base_url('api/user/account/create') ?>",
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
                     window.location.href = "<?= base_url('administrator/teacher') ?>";
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
                     form.find('[name=' + key[0] + ']').closest('.form-group').find('.invalid-feedback').addClass('d-block').text(key[1]);
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
      var class_group = $('#class_group');
      class_group.wrap('<div class="position-relative"></div>');
      class_group.select2({
         placeholder: ' -- Pilih Kelas -- ',
         dropdownAutoWidth: true,
         width: '100%',
         dropdownParent: class_group.parent(),
         ajax: {
            url: "<?= base_url('class_group/get_class_groups') ?>",
            type: "post",
            dataType: "json",
            delay: 250,
            data: function(params) {
               // Select2 styling DataTables
               var page = params.page || 0;
               return {
                  search: {
                     value: params.term || ''
                  },
                  page: page + 1,
                  length: 10,
                  start: page * 10,
                  columns: [{
                     data: 'class_group_name'
                  }],
                  order: [{
                     column: 0,
                     dir: 'ASC'
                  }],
                  <?= csrf_token() ?>: csrf_token
               }
            },
            processResults: function(result, params) {
               var page = params.page || 0;
               csrf_token = result.<?= csrf_token() ?>;
               return {
                  results: $.map(result.data, function(item) {
                     return {
                        id: item.class_group_code,
                        text: item.class_group_name
                     }
                  }),
                  pagination: {
                     more: (page * 10) < result.recordsFiltered
                  }
               }
            }
         }
      });
   })
</script>
<?= $this->endSection() ?>