<?php
//! Load header
$title = 'CRUD page';

//! --------------------------------- Page Content --------------------------------------------------------------------------------

ob_start();

// error message timeout display
if (!empty($errorMessage)) { ?>
    <div id="message_error" class="text-center <?= $errorMessageColor ?>">
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

<h2 class="text-center p-4">Bloody CRUD</h2>

<!-- 
    id email, password, 
    name, surname, gender,
    street_number, street_name, cp, city,
    skill_level, cover_letter_filepath, cv_filepath 
-->
<div class="table-responsive">
    <table class="table">
        <thead class="table-dark">
            <tr>
                <th class="text-center align-middle">user_id</th>
                <th class="text-center align-middle">email</th>
                <th class="text-center align-middle">name</th>
                <th class="text-center align-middle">surname</th>
                <th class="text-center align-middle">Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php
            foreach ($users as $user) { ?>
                <tr>
                    <th class="text-center align-middle"><?= $user['id'] ?></th>
                    <td class="text-center align-middle"><?= $user['email'] ?></td>
                    <td class="text-center align-middle"><?= $user['name'] ?></td>
                    <td class="text-center align-middle"><?= $user['surname'] ?></td>
                    <td class="text-center align-middle">
                        <button type="button" class="btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditUser_<?= $user['id'] ?>">Edit
                        </button> <br><br>
                        <button type="button" class="btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalDeleteUser_<?= $user['id'] ?>">Delete
                        </button>
                    </td>
                </tr>

                <!-- Modals -->
                <!-- BEGIN modal edit user -->
                <div class="modal fade" id="modalEditUser_<?= $user['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">

                            <div class="modal-header">
                                <center class="modal-title" id="">
                                    Edit user infos
                                </center>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">X</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form method="post" action="" enctype="multipart/form-data">
                                    <input type="hidden" name="action" value="editUser">
                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">

                                    <div class="row d-flex justify-content-center">
                                        <h3 class="text-center">Personnal infos</h3>
                                        <div class="col-6 p-2">
                                            <p class="d-flex justify-content-between"><label for="<?= $user['id'] ?>_email">Email address :</label> <input id="<?= $user['id'] ?>_email" type="text" name="email" value="<?= $user['email'] ?>" required></p>
                                            <p class="d-flex justify-content-between"><label for="<?= $user['id'] ?>_name">Name : </label> <input id="<?= $user['id'] ?>_name" type="text" name="name" value="<?= $user['name'] ?>" required></p>
                                            <p class="d-flex justify-content-between"><label for="<?= $user['id'] ?>_surname">Surname : </label> <input id="<?= $user['id'] ?>_surname" type="text" name="surname" value="<?= $user['surname'] ?>" required></p>
                                        </div>
                                    </div>

                                    <center>
                                        <button type="button" class="btn btn-outline-warning" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-outline-danger">Edit user's infos</button>
                                    </center>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END modal edit user -->

                <!-- BEGIN Modal Delete user -->
                <div class="modal fade" id="modalDeleteUser_<?= $user['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">

                            <div class="modal-header">
                                <center class="modal-title text-danger" id="">
                                    Delete user
                                </center>
                                <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">X</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form method="post" action="">
                                    <input type="hidden" name="action" value="deleteUser">
                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">

                                    <p class="text-center align-middle">You are about to delete the following user : <br>
                                        <span class="fw-bold">Name : </span><?= $user['name'] ?> <br>
                                        <span class="fw-bold">Surname : </span><?= $user['surname'] ?> <br>
                                        <span class="fw-bold">Mail : </span><?= $user['email'] ?> <br>
                                        You're also about to delete all of their files and associated courses.<br><br>
                                        <span class="fw-bold text-danger">Do you really wish to continue ?</span>
                                    </p>

                                    <center>
                                        <button type="button" class="btn btn-outline-warning" data-bs-dismiss="modal">No no no no no ! Cancel !</button>
                                        <button type="submit" class="btn btn-outline-danger">Yes, delete user. I know this action cannot be undone</button>
                                    </center>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END modal Delete user -->
                <!-- END modals -->

            <?php
            } ?>
        </tbody>

        <tfoot>
            <tr>
                <th class="text-center align-middle">user_id</th>
                <th class="text-center align-middle">email</th>
                <th class="text-center align-middle">name</th>
                <th class="text-center align-middle">surname</th>
                <th class="text-center align-middle">Actions</th>
            </tr>
        </tfoot>
    </table>
</div>

<?php

$content = ob_get_clean();

require($_SERVER['DOCUMENT_ROOT'] . '/app/views/layouts/layout.php');
