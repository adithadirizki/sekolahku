<?= $this->extend('template') ?>
<?= $this->section('content') ?>
<div class="row">
   <div class="col-md-6 col-lg-5 col-xl-4">
      <div class="card">
         <div class="card-body">
            <div class="card-title">Account</div>
            <div class="row">
               <div class="col-12 d-flex flex-column justify-content-between mb-1">
                  <div class="user-avatar-section">
                     <div class="d-flex justify-content-start">
                        <img class="img-fluid rounded" src="<?= base_url('assets/upload/' . $data->photo) ?>" height="104" width="104" alt="User avatar">
                        <div class="d-flex flex-column ml-1">
                           <div class="user-info mb-1">
                              <h4 class="mb-0"><?= $data->fullname ?></h4>
                              <span class="card-text font-italic">@<?= $data->student_username ?></span>
                           </div>
                           <div class="d-flex flex-wrap">
                              <a href="<?= base_url('student/' . $data->student_username . '/edit') ?>" class="btn btn-primary">Edit</a>
                              <button id="delete-student" class="btn btn-outline-danger ml-1">Delete</button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-12 mb-50">
                  <label>Username</label>
                  <h5><?= $data->student_username ?></h5>
               </div>
               <div class="col-12 mb-50">
                  <label>Nama Lengkap</label>
                  <h5><?= $data->fullname ?></h5>
               </div>
               <div class="col-12 mb-50">
                  <label>E-mail</label>
                  <h5><?= $data->email ?></h5>
               </div>
               <div class="col-12 mb-50">
                  <label>Status</label>
                  <?php $status = ['Menunggu Konfirmasi', 'Aktif', 'Nonaktif']; ?>
                  <h5><?= $status[$data->is_active] ?></h5>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-6 col-lg-7 col-xl-4">
      <div class="card">
         <div class="card-body">
            <div class="card-title">Data Personal</div>
            <div class="row">
               <div class="col-12 mb-50">
                  <label>NIS</label>
                  <h5><?= $data->nis ?></h5>
               </div>
               <div class="col-12 mb-50">
                  <label>Tempat Lahir</label>
                  <h5><?= $data->pob ? $data->pob : '-' ?></h5>
               </div>
               <div class="col-12 mb-50">
                  <label>Tanggal Lahir</label>
                  <h5><?= $data->dob ? (new DateTime($data->dob))->format('d F Y') : null ?></h5>
               </div>
               <div class="col-12 mb-50">
                  <label>Agama</label>
                  <h5><?= $data->religion ? ucfirst($data->religion) : '-' ?></h5>
               </div>
               <div class="col-12 mb-50">
                  <label>Jenis Kelamin</label>
                  <?php $gender = ['male' => 'Laki - laki', 'female' => 'Perempuan']; ?>
                  <h5><?= $gender[$data->gender] ?></h5>
               </div>
               <div class="col-12 mb-50">
                  <label>No Telp</label>
                  <h5><?= $data->phone ? $data->phone : '-' ?></h5>
               </div>
               <div class="col-12 mb-50">
                  <label1">Alamat</label>
                     <h5><?= $data->address ? $data->address : '-' ?></h5>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-6 col-lg-5 col-xl-4">
      <div class="card">
         <div class="card-body">
            <div class="card-title">Riwayat Kelas</div>
            <div class="table-responsive">
               <table class="table text-center">
                  <thead>
                     <tr>
                        <th>KELAS</th>
                        <th>TAHUN AJARAN</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <td><?= $data->class_group_name ?></td>
                        <td>Sekarang</td>
                     </tr>
                     <?php
                     foreach (json_decode($data->class_history) as $v) :
                        $class = array_search($v->class, array_column($history_classgroup, 'class_group_code'));
                        $year = array_search($v->year, array_column($history_schoolyear, 'school_year_id'));
                     ?>
                        <tr>
                           <td><?= $history_classgroup[$class]->class_group_name ?></td>
                           <td><?= $history_schoolyear[$year]->school_year_title ?></td>
                        </tr>
                     <?php
                     endforeach;
                     ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>
</div>
<?= $this->endSection() ?>
<?= $this->section('customJS') ?>
<script>
   $(document).ready(function() {
      $(document).on('click', '#delete-student', function() {
         Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
            customClass: {
               confirmButton: "btn btn-primary",
               cancelButton: "btn btn-outline-danger ml-1"
            },
            buttonsStyling: false
         }).then((result) => {
            if (result.value) {
               $.ajax({
                  url: "<?= base_url('api/user/' . $data->student_username) ?>",
                  type: "delete",
                  dataType: "json",
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
                           window.location.href = "<?= base_url('student') ?>";
                        })
                     } else {
                        Swal.fire({
                           title: "Failed!",
                           text: result.message,
                           icon: "error",
                           showConfirmButton: false,
                           timer: 3000
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
            }
         })
      })
   })
</script>
<?= $this->endSection() ?>