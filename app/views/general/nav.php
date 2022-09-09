<center class="d-flex justify-content-around">
    <a href="/index.php">Back to index</a>

    <?php
    if (isset($_SESSION['user_id'])) {
        echo '<a href="/index.php?page=logout">Logout</a>';
    } else {
        echo '<a href="/index.php?page=register">Register</a>';
        echo '<a href="/index.php?page=login">Login</a>';
    }
    echo '<a href="/index.php?page=pdf">PDFs</a>';

    ?>
</center>

<?php
//show session flash_message if exists
if (isset($_SESSION['flash_message']) && !empty($_SESSION['flash_message'])) {
    $flash_message = $_SESSION['flash_message'];
    $_SESSION['flash_message'] = '';
?>

    <div id="flash_message" class="text-center p-4">
        <?php echo $flash_message ?>
    </div>
    <script type="text/javascript">
        setTimeout(function() {
            document.getElementById("flash_message").className = "d-none";
        }, 10000);
    </script>
<?php
}
?>