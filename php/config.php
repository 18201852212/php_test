<?php
$datalocal="localhost:3306";
$database="test";
$dataname="root";
$datapswd="liulu789";
$con=mysqli_connect($datalocal,$dataname,$datapswd,$database);
if(!$con){echo "未能成功连接";}
?>