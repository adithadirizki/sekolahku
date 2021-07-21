<?= $this->extend('student/template'); ?>
<?= $this->section('styleCSS') ?>
<style>
   #loading-sm {
      display: none;
   }
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div id="tmp-material" class="d-none">
   <div class="col-md-6">
      <div class="card mb-1">
         <div class="card-body">
            <h4 class="card-title mb-50">
               <a href="javascript:void(0)" class="blog-title-truncate text-body-heading material-title">-</a>
            </h4>
            <div class="media">
               <div class="media-body">
                  <small class="subject-name">-</small>
                  <span class="text-muted ml-50 mr-25">|</span>
                  <small class="text-muted published-at">-</small>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="list-group">
   <div class="row" id="materials">
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
            url: "<?= base_url('api/material/getAll') ?>",
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
                     $('#materials').html('<h5 class="text-center w-100">Tidak ada materi</h5>');
                  }
                  result.data.forEach(v => {
                     var material_code = v.material_code,
                        material_title = v.material_title,
                        subject_name = v.subject_name,
                        publish_at = new Date(v.publish_at);
                     var d = publish_at.getDate() > 9 ? publish_at.getDate() : "0" + publish_at.getDate();
                     var m = publish_at.toLocaleString('default', {
                        'month': 'short'
                     });
                     var Y = publish_at.getFullYear();
                     var tmp = $('#tmp-material').clone();
                     if (subject_name.length > 20) {
                        subject_name = v.subject_code;
                     }
                     tmp.find('.material-title').attr('href', '<?= base_url('material') ?>/' + material_code);
                     tmp.find('.material-title').text($.parseHTML(material_title)[0].data);
                     tmp.find('.subject-name').text(subject_name);
                     tmp.find('.published-at').text(`${d} ${m} ${Y} ${publish_at.toTimeString().substr(0, 5)} WIB`);
                     $('#materials h5').remove();
                     $('#materials').append(tmp.html());
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