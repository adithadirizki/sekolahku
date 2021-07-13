<?= $this->extend('template') ?>
<?= $this->section('content') ?>
<div class="card">
   <div class="card-body">
      <form id="edit-user" enctype="multipart/form-data" onsubmit="return false;">
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
                        <img src="<?= base_url('assets/upload/' . $data->photo) ?>" class="img-fluid user-avatar rounded" alt="Photo" width="120" height="120">
                        <input type="file" name="photo" id="photo" hidden accept="image/jpeg,image/png">
                     </label>
                  </div>
                  <div class="col-12">
                     <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" class="form-control" value="<?= $data->teacher_username ?>" placeholder="Username" disabled>
                        <div class="invalid-feedback"></div>
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="form-group">
                        <label for="fullname">Nama Lengkap <span class="text-danger font-small-4">*</span></label>
                        <input type="text" id="fullname" class="form-control" name="fullname" value="<?= $data->fullname ?>" placeholder="Nama Lengkap" required>
                        <div class="invalid-feedback"></div>
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="form-group">
                        <label for="email">E-mail <span class="text-danger font-small-4">*</span></label>
                        <input type="email" id="email" class="form-control" name="email" value="<?= $data->email ?>" placeholder="E-mail" required>
                        <div class="invalid-feedback"></div>
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="form-group">
                        <label for="password">Password</label>
                        <input type="text" id="password" class="form-control" name="password" minlength="6" placeholder="Password">
                        <div class="invalid-feedback"></div>
                     </div>
                  </div>
                  <div class="col-12">
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
                        <label for="nip">NIP <span class="text-danger font-small-4">*</span></label>
                        <input type="text" id="nip" class="form-control" name="nip" placeholder="NIP" value="<?= $data->nip ?>" required>
                        <div class="invalid-feedback"></div>
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="form-group">
                        <label for="pob">Tempat Lahir</label>
                        <input type="text" id="pob" class="form-control" name="pob" value="<?= $data->pob ?>" placeholder="Tempat Lahir">
                        <div class="invalid-feedback"></div>
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="form-group">
                        <label for="dob">Tanggal Lahir</label>
                        <input type="date" id="dob" class="form-control" name="dob" value="<?= $data->dob ?>">
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
                        <label class="d-block">Jenis kelamin <span class="text-danger font-small-4">*</span></label>
                        <div class="custom-control custom-radio custom-control-inline">
                           <input type="radio" id="male" name="gender" class="custom-control-input" value="male" <?= $data->gender == 'male' ? 'checked' : null ?> required>
                           <label class="custom-control-label" for="male">Laki - laki</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                           <input type="radio" id="female" name="gender" class="custom-control-input" value="female" <?= $data->gender == 'female' ? 'checked' : null ?>>
                           <label class="custom-control-label" for="female">Perempuan</label>
                        </div>
                        <div class="invalid-feedback"></div>
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="form-group">
                        <label for="phone">No telp</label>
                        <input id="phone" type="number" name="phone" class="form-control" value="<?= $data->phone ?>" placeholder="No Telp">
                        <div class="invalid-feedback"></div>
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="form-group">
                        <label for="address-1">Alamat</label>
                        <textarea class="form-control" name="address" id="address" cols="10" rows="4" value="<?= $data->address ?>" placeholder="Alamat"></textarea>
                        <div class="invalid-feedback"></div>
                     </div>
                  </div>
               </div>
               <button type="submit" class="btn btn-primary float-right">Simpan Perubahan</button>
            </div>
         </div>
      </form>
   </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('customJS') ?>
<script>
   $(document).ready(function() {
      const photo = "<?= base_url('assets/upload/avatar-default.jpg') ?>";
      $('#is_active').val("<?= $data->is_active ?>").trigger('change');
      $('#religion').val("<?= $data->religion ?>").trigger('change');
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
      $(document).on('submit', '#edit-user', function(e) {
         e.preventDefault();
         $(this).find('.is-invalid').removeClass('is-invalid');
         $(this).find('.invalid-feedback').removeClass('d-block').text(null);
         var form = $(this);
         var data = new FormData($(this)[0]);
         $.ajax({
            url: "<?= base_url('api/teacher/' . $data->teacher_username) ?>",
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
   })
</script>
<?= $this->endSection() ?>