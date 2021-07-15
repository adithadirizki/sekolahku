<?= $this->extend('student/template'); ?>
<?= $this->section('styleCSS') ?>
<style>
   #loading-sm {
      display: none;
   }
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div id="tmp-assignment" class="d-none">
   <div class="col-md-6">
      <div class="card mb-1">
         <div class="card-body">
            <h4 class="card-title mb-50">
               <a href="javascript:void(0)" class="blog-title-truncate text-body-heading assignment-title">The Best Features Coming to iOS and Web design</a>
            </h4>
            <div class="media">
               <div class="media-body">
                  <small class="subject-name">Matematika</small>
                  <span class="text-muted ml-50 mr-25">|</span>
                  <small class="text-muted assigned-at">14 Jan 2021, 14:45 WIB</small>
               </div>
            </div>
            <div class="mt-1 pt-25">
               <a href="javascript:void(0);">
                  <div class="badge badge-pill badge-light-danger mr-50">BERAKHIR</div>
               </a>
               <a href="javascript:void(0);">
                  <div class="badge badge-pill badge-light-success">SELESAI</div>
               </a>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="list-group">
   <div class="row" id="assignments">
   </div>
   <div class="col-md-6 d-none" id="atmp-assignment">
      <a href="javascript:void(0)" class="list-group-item list-group-item-action mb-1">
         <div class="d-flex justify-content-between">
            <div class="d-flex justify-content-left align-items-center">
               <div class="avatar mr-1">
                  <img src="" alt="avatar" width="30" height="30">
               </div>
               <div class="d-flex flex-column">
                  <span class="text-truncate font-weight-bold assigned"></span>
                  <small class="text-truncate text-muted subject-name"></small>
               </div>
            </div>
            <small class="start-at"></small>
         </div>
         <p class="card-text assignment-title mt-1"></p>
      </a>
   </div>
   <div class="m-auto" id="loading-sm">
      <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
      <span class="ml-25 align-middle">Loading...</span>
   </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('customJS') ?>
<script>
   $(document).ready(function() {
      var curr_page = 1;
      var total_pages = 1;
      var limit_page = false;
      var on_load_data = false;
      var csrf_hash = "<?= csrf_hash() ?>";
      var load_data = (page = 1) => {
         $.ajax({
            url: "<?= base_url('api/assignment/getAll') ?>",
            type: "post",
            dataType: "json",
            data: {
               page: page
            },
            headers: {
               Authorization: "<?= session()->token ?>"
            },
            beforeSend: function() {
               on_load_data = true;
               $('#loading-sm').show();
            },
            success: function(result) {
               on_load_data = false;
               $('#loading-sm').hide();
               if (result.error == false) {
                  curr_page = page;
                  total_pages = Math.floor(result.total_nums / 10) + 1;
                  if (result.data.length === 0 && curr_page === 1) {
                     $('#assignments').html('<h5 class="text-center w-100">Tidak ada tugas</h5>');
                  }
                  result.data.forEach(v => {
                     var assignment_code = v.assignment_code,
                        assignment_title = v.assignment_title,
                        subject_name = v.subject_name,
                        start_at = new Date(v.start_at),
                        due_at = v.due_at === null ? new Date(Date.now()) : new Date(v.due_at);
                     var tmp = $('#tmp-assignment').clone();
                     tmp.find('.assignment-title').attr('href', '<?= base_url('assignment') ?>/' + assignment_code);
                     tmp.find('.assignment-title').text(assignment_title);
                     tmp.find('.subject-name').text(subject_name);
                     tmp.find('.assigned-at').text(start_at.toDateString() + ' ' + start_at.toTimeString().substr(0, 5) + ' WIB');
                     $('#assignments h5').remove();
                     $('#assignments').append(tmp.html());
                  });
               }
            },
            error: function() {
               on_load_data = false;
               $('#loading-sm').hide();
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
      load_data()
      $(window).scroll(function() {
         // load data if total pages > curr_page
         if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
            if (total_pages > curr_page && on_load_data === false) {
               load_data(curr_page + 1)
            }
         }
      })
   })
</script>
<?= $this->endSection() ?>