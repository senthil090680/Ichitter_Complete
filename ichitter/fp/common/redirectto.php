<?php
if ($session_obj->checkSession()) {
    echo "<script>window.location='index.php';</script>";
}
?>
