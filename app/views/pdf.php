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

<h2 class="text-center">Edit pdf</h2>

<form action="" method='post'>
  <select name="action">
    <option value="bill">bill</option>
    <option value="quote">quote</option>
  </select>

  <button type="submit" value="" formtarget="_blank">get a doc</button>
</form>

<?php

$content = ob_get_clean();

require($_SERVER['DOCUMENT_ROOT'] . '/app/views/layouts/layout.php');
