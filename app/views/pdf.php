<?php
//! Load header
$title = 'Edit pdf page';

//! --------------------------------- Page Content --------------------------------------------------------------------------------

ob_start();

// error message timeout display
if (!empty($errorMessage)) { ?>
  <div id="message_error" class="text-center text-danger">
    <?php echo $errorMessage ?>
  </div>
  <script type="text/javascript">
    setTimeout(function() {
      document.getElementById("message_error").className = "d-none";
    }, 10000);
  </script>
<?php
}
?>
<div class="row">
  <div class="col">

    <h2 class="text-center">Edit pdf</h2>

    <form class="text-center" action="" method='post'>
      <select name="type">
        <option value="bill">bill</option>
        <option value="quote">quote</option>
      </select>

      <button type="submit" name="action" value="edit_pdf" formtarget="_blank">get a doc</button>
    </form>

  </div>

  <div class="col">
    <h2 class="text-center">Send mail</h2>

    <form class="text-center" action="" method='post'>
      <select name="type">
        <option value="bill">bill</option>
        <option value="quote">quote</option>
      </select>

      <button type="submit" name="action" value="send_mail" formtarget="_blank">send mail</button>
    </form>

  </div>
</div>
<?php

$content = ob_get_clean();

require($_SERVER['DOCUMENT_ROOT'] . '/app/views/layouts/layout.php');
