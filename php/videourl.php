<?php
require "config2.php";
$filename=$_GET['filename'];
$sql="select * from filemap where videoname='$filename'";
if($res=mysqli_query($con,$sql)){
    while($row=mysqli_fetch_array($res)){
        echo $row['videourl'];
    }
}else{
    echo "error";
}

?>