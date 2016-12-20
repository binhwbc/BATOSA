<div style="padding:20px;" id="content" class="AutoDetect">
 <div class="page-header">
    <div class="container-fluid">
      <h1>PLEASE WAIT UNTIL IS FINISHED! DO NOT EXIT!</h1>
      </div></div>
  <h2 id="mainMsg">Installing IP database (<span id="msgPercent">0%</span>). You will be redirected back to the extensions page after the process is complete.</h2>
	<div class="progress">
	  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%" id="progressBar">
	    <span class="sr-only">0%</span>
	  </div>
	</div>
</div>
<script type="text/javascript">
var start_point = 0;
var filename = '<?php echo $filename; ?>';

function import_db() {
  $.ajax({
    url: 'index.php',
    method: 'GET',
    dataType: 'json',
    data: {
      route: '<?php echo $modulePath ?>/import',
      token: getURLVar('token'),
      filename: filename,
      start_pos: start_point
    },
    success: function(resp) {
      if (resp.error) {
        $('#mainMsg').text(resp.error);
        return;
      }

      start_point = resp.pointer_pos;

      if (!resp.done) {
        var percent = (parseInt(resp.pointer_pos) / parseInt(resp.filesize)) * 100;
        percent = parseInt(percent);
        $('#progressBar').width(percent + '%').attr('aria-valuenow', percent).find('span').text(percent + '%');
        $('#msgPercent').text(percent + '%');
        import_db();
      } else {
        window.history.back();
      }
    },
    fail: function() {
      window.history.back();
    }
  });
}
import_db();
</script>
<?php echo $footer; ?>
