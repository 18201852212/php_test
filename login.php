<?php
if(isset($_COOKIE['uid'])&&isset($_COOKIE['psd'])&&$_COOKIE['uid']!='null'&&$_COOKIE['psd']!='null'){
    echo "<script>window.location.replace('/index.php')</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<script src='/js/jquery-3.3.1.min.js'></script>
<script src="/js/jquery.cookie.js"></script>
<body>
    <h1>登录页面</h1>
    <form id='login'>
    用户名: <input type="text" name='username' autocomplete="off" ><img src="" alt="">
    <br>
    密码: <input type="text" name='passwd' autocomplete="off"><img src="" alt="">
    <br>
    <input type="submit" value='登录'>
    </form>
    <script>
        document.onvisibilitychange=function(){
            window.location.reload()
        }
        var usernametest=false
        var passwdtest=false
        $("#login input[type='text']").change(function(e){
        var input=$(e.target)
        switch(input.attr('name')){
            case 'username':
                if(/^[a-zA-Z0-9_]{3,10}$/.test(input.val())){
                    input.next().attr("src","/image/yes.png")
                    usernametest=true
                }
                else{
                    input.next().attr("src","/image/no.png")
                    usernametest=false
                }
                break;
            case 'passwd':
                if(/^[a-zA-Z0-9_]{5,15}$/.test(input.val())){
                    input.next().attr("src","/image/yes.png")
                    passwdtest=true
                }
                else{
                    input.next().attr("src","/image/no.png")
                    passwdtest=false
                }
                break;
            default:
                break;
        }
    })

    $('#login input[type="submit"]').click(
        function(e){
            e.preventDefault()
            if(usernametest&&passwdtest){
                $.ajax({
                    url:"/php/search.php",
                    type:"GET",
                    data:{name:$("#login input[name='username']").val(),psd:$("#login input[name='passwd']").val()},
                    cache:false,
                    error:function(){console.log('加载出错')},
                    success:function(data){
                       switch(data){
                           case 1:
                               console.log('非法用户名');
                               break;
                            case 2:
                                console.log('非法密码');
                                break;
                            case 3:
                                console.log('用户名或密码错误');
                                break;
                            default:
                                if(data){
                                    var data=data.replace(/[\r\n]/g,"")
                                     var list=data.split(';')
                                     for(let i=0;i<list.length;i++){
                                         let tulp=list[i].split("=")
                                         if(tulp[0]=='uid'){
                                             $.cookie('uid',tulp[1],{ expires: 7 })
                                         }else{
                                             if(tulp[0]=='psd'){
                                                 $.cookie('psd',tulp[1],{ expires: 7 })
                                                 for(let i=0;i<$("#login input[type='text']").length;i++){
                                                 $("#login input[type='text']").eq(i).val('')
                                                  }
                                                 window.open('/index.php')
                                             }
                                         }
                                     }
                                }
                       }
                    }
                })
                
            }else{
                alert('请正确填写表单')
            }  
        }
    )
    </script>
</body>

</html>