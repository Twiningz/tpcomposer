<!DOCTYPE html>
<html>

<head>
  <?php require($_SERVER['DOCUMENT_ROOT'] . '/app/views/general/head.php'); ?>
</head>

<body>
  <header>
    <?php require($_SERVER['DOCUMENT_ROOT'] . '/app/views/general/nav.php'); ?>
  </header>

  <?= $content; ?>

  <footer>
    <?php require($_SERVER['DOCUMENT_ROOT'] . '/app/views/general/footer.php'); ?>
  </footer>
</body>

</html>