<?php
//! Load header
$title = 'login page';

ob_start();

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

<center class="p-4">
    <h2>Connexion</h2>
    <form action="" method="POST">
        <p><label>email :</label> <input type="text" name="mail_connect"></p>
        <p><label>password :</label> <input type="password" name="pass_connect"></p>
        <p><input type="submit" name="form_connexion" value="Log in"></p>
    </form>
</center>


<?php

$content = ob_get_clean();

require($_SERVER['DOCUMENT_ROOT'] . '/views/layouts/layout.php');
