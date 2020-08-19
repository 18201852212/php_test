<?php
require 'config.php';
require 'getid.php';
$name=$_POST['username'];
$psd=$_POST['passwd'];
$email=$_POST['email'];
$phone=$_POST['phone'];
$country=$_POST['country'];
$sql="insert into emp (username,passwd,email,telephone) values ('$name','$psd','$email','$phone')";
if (!preg_match("/^[a-zA-Z0-9_]{3,10}$/",$name)){
   header('location:/feedback/fail1.html'); 
  }
else{if (!preg_match("/^[a-zA-Z0-9_]{5,15}$/",$psd)){
  header('location:/feedback/fail2.html'); 
 }
else{if (!preg_match("/^([\w\-]+\@[\w\-]+\.[\w\-]+)$/",$email)){
  header('location:/feedback/fail3.html'); 
}
else{if(!preg_match("/^[1][3-9][0-9]{9}$/",$phone)){
  header('location:/feedback/fail4.html');
}
 else{if(mysqli_query($con,$sql)){
  echo "<script>window.location.href='/feedback/success.html'</script>";
  }
  else{header('location:/feedback/fail5.html');
        }
      }
    }
  }
}
mysqli_close($con);
?>