<?php
//! Load header
$title = 'RegisterPage';

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

<h2 class="text-center">Register</h2>

<form class="row d-flex justify-content-center" action="" method="POST">
    <div class="row d-flex justify-content-center">
        <div class="col-4 p-2">
            <p class="d-flex justify-content-between"><label for="email">Email address :</label> <input id="email" type="text" name="email" value="<?= $email ?? '' ?>" required></p>
            <p class="d-flex justify-content-between"><label for="pass">Password :</label> <input id="pass" type="password" name="pass" value="<?= $pass ?? '' ?>" required></p>
            <p class="d-flex justify-content-between"><label for="confirm_pass">Password confirmation :</label> <input id="confirm_pass" value="<?= $confirm_pass ?? '' ?>" type="password" name="confirm_pass" required></p>
            <p class="d-flex justify-content-between"><label for="name">Name : </label> <input id="name" type="text" name="name" value="<?= $name ?? '' ?>" required></p>
            <p class="d-flex justify-content-between"><label for="surname">Surname : </label> <input id="surname" type="text" name="surname" value="<?= $surname ?? '' ?>" required></p>
        </div>
    </div>

    <div class="d-flex justify-content-center">
        <button class='btn btn-success' type="submit" name="form_registration">Register</button>
    </div>
</form>

<?php

$content = ob_get_clean();

require($_SERVER['DOCUMENT_ROOT'] . '/app/views/layouts/layout.php');
