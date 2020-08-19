<?php
require 'config.php';
$name=$_GET['name'];
$psd=$_GET['psd'];
$sql="select * from emp where username='$name' and passwd='$psd'";
if(!preg_match("/^[a-zA-Z0-9_]{3,10}$/",$name)){
    echo 1;
}
else{if (!preg_match("/^[a-zA-Z0-9_]{5,15}$/",$psd)){
    echo 2;
}
else{if($result=mysqli_query($con,$sql)){
    while($row = mysqli_fetch_array($result)){
        echo "uid=".$row['username'].";psd=".$row['passwd'];
    }
    
}else{
    echo 3;
}
}
}
mysqli_close($con);
?>