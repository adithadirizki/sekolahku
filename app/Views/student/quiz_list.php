<?= $this->extend('student/template'); ?>
<?= $this->section('styleCSS') ?>
<style>
   #loading-sm {
      display: none;
   }
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div id="tmp-quiz" class="d-none">
   <div class="col-md-6">
      <div class="card mb-1">
         <div class="card-body">
            <h4 class="card-title mb-50">
               <a href="javascript:void(0)" class="blog-title-truncate text-body-heading quiz-title">-</a>
            </h4>
            <div class="media">
               <div class="media-body">
                  <small class="subject-name">-</small>
                  <span class="text-muted ml-50 mr-25">|</span>
                  <small class="text-muted assigned-at">-</small>
               </div>
            </div>
            <div class="mt-1 pt-25 tag-badges"></div>
         </div>
      </div>
   </div>
</div>
<div class="list-group">
   <div class="row" id="quizzes">
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
            url: "<?= base_url('api/quiz/getAll') ?>",
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
                     $('#quizzes').html('<h5 class="text-center w-100">Tidak ada quiz</h5>');
                  }
                  result.data.forEach(v => {
                     var quiz_code = v.quiz_code,
                        quiz_title = v.quiz_title,
                        subject_name = v.subject_name,
                        start_at = new Date(v.start_at),
                        due_at = new Date(v.due_at),
                        status = v.status;
                     var d = start_at.getDate() > 9 ? start_at.getDate() : "0" + start_at.getDate();
                     var m = start_at.toLocaleString('default', {
                        'month': 'short'
                     });
                     var Y = start_at.getFullYear();
                     var tmp = $('#tmp-quiz').clone();
                     if (subject_name.length > 20) {
                        subject_name = v.subject_code;
                     }
                     if (status == 0) {
                        tmp.find('.tag-badges').append('<div class="badge badge-pill badge-light-warning mr-50">SEDANG MENGERJAKAN</div>');
                     } else if (status == 1) {
                        tmp.find('.tag-badges').append('<div class="badge badge-pill badge-light-success mr-50">SELESAI</div>');
                     } else if (status == 2) {
                        tmp.find('.tag-badges').append('<div class="badge badge-pill badge-light-danger mr-50">WAKTU HABIS</div>');
                     }
                     if (Date.now() > new Date(due_at).getTime()) {
                        tmp.find('.tag-badges').append('<div class="badge badge-pill badge-light-danger mr-50">BERAKHIR</div>');
                     }
                     tmp.find('.quiz-title').attr('href', '<?= base_url('quiz') ?>/' + quiz_code);
                     tmp.find('.quiz-title').text(quiz_title);
                     tmp.find('.subject-name').text(subject_name);
                     tmp.find('.assigned-at').text(`${d} ${m} ${Y} ${start_at.toTimeString().substr(0, 5)} WIB`);
                     $('#quizzes h5').remove();
                     $('#quizzes').append(tmp.html());
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