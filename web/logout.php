<?php
session_start();
session_destroy();
setcookie("token",$token,time()-1,"/");

header("Location:index.php");
