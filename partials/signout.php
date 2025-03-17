<?php

session_start();
session_destroy();

header("Location: /IPT2-MIDTERM-PROJECT-G6/login.php");
exit();
?>