<?= $this->extend('student/template'); ?>
<?= $this->section('styleCSS') ?>
<style>
   #loading-sm {
      display: none;
   }
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div id="tmp-announcement" class="d-none">
   <div class="col-md-6">
      <div class="card mb-1">
         <div class="card-body">
            <h4 class="card-title mb-50">
               <a href="javascript:void(0)" class="blog-title-truncate text-body-heading announcement-title">-</a>
            </h4>
            <div class="media">
               <div class="media-body">
                  <small class="text-muted announced-at">-</small>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="list-group">
   <div class="row" id="announcements">
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
            url: "<?= base_url('api/announcement/getAll') ?>",
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
                     $('#announcements').html('<h5 class="text-center w-100">Tidak ada pengumuman</h5>');
                  }
                  result.data.forEach(v => {
                     var announcement_id = v.announcement_id,
                        announcement_title = v.announcement_title,
                        announced_at = new Date(v.announced_at);
                     var d = announced_at.getDate() > 9 ? announced_at.getDate() : "0" + announced_at.getDate();
                     var m = announced_at.toLocaleString('default', {
                        'month': 'short'
                     });
                     var Y = announced_at.getFullYear();
                     var tmp = $('#tmp-announcement').clone();
                     tmp.find('.announcement-title').attr('href', '<?= base_url('announcement') ?>/' + announcement_id);
                     tmp.find('.announcement-title').text($.parseHTML(announcement_title)[0].data);
                     tmp.find('.announced-at').text(`${d} ${m} ${Y} ${announced_at.toTimeString().substr(0, 5)} WIB`);
                     $('#announcements h5').remove();
                     $('#announcements').append(tmp.html());
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