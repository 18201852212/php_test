

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="pragma" content="no-cache">   
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">   
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        *{
            padding: 0;
            margin: 0;
        }
        span{
            padding-left: 15px;
        }
        #mask{
            position: absolute;
            z-index: 100;
        }
        #canbox{
            height: 400px;
            width: 400px;
            position: relative;
            margin-left: 20px;
            margin-top: 10px;
        }
        #register img{
            margin-left: 10px;
        }
        #register span{
            font-size:10px;
            color: rgb(161, 161, 158);
        }
        #dragbox{
            height: 50px;
            width: 400px;
            margin-top:10px;
            margin-left: 20px;
            background-color:rgb(178, 180, 182);  
            border-radius: 10px;   
            position: relative;       
        }
        #slug{
            height: 50px;
            width: 70px;
            position: absolute;
            border-radius: 10px;
            background-color: brown;
        }
        #content{
            display: none;
        }

    </style>
    <script src="./js/jquery-3.3.1.min.js"></script>
</head>
<body>
    <h1>注册界面</h1>
    <form id='register' action="./php/insert.php" method="POST">
        账户：<input type="text" name="username" autocomplete="off"><img src="" alt=""><span>请输入3-10位由大小写字母数字以及下划线组成的用户名</span>
        <br>
        密码：<input type="text" name="passwd" autocomplete="off"><img src="" alt=""><span>请输入由5-15位大小写字母数字以及下划线组成的密码</span>
        <br>  
        邮箱：<input type="text" name="email" autocomplete="off"><img src="" alt=""><span>请输入邮箱地址</span>
        <br>
        电话：<input type="text" name="phone"autocomplete="off" ><img src="" alt=""><span>请输入手机号码</span>
        <br>
        <select name="country">
            <option value="China">China</option>
            <option value="America">America</option>
            <option value="England">England</option>
        </select>
        <br>
        <input type="submit" value="提交">
        </form>
        <div id='content'>
        <div id='canbox'>
            <canvas id='mask' height="400px" width="400px"></canvas>
            <canvas id='layer' height="400px" width="400px"></canvas>
        </div> 
        <div id="dragbox"><div id="slug"></div></div>
        </div>
    
     <script>  
     (function(){
    var mask=document.getElementById('mask')
    var layer=document.getElementById('layer')
    var mkctx=mask.getContext('2d')
    var lyctx=layer.getContext('2d')
    var maskoffset=0
    
    var usernametest=false
    var passwdtest=false
    var emailtest=false
    var phonetest=false

    window.onload=function(){
       for(let i=0;i<$("#register input[type='text']").length;i++){
           $("#register input[type='text']").eq(i).val('')
       }
    }



    //注意执行顺序
    function imgidentify(){
        var x=200+Math.floor(Math.random()*130)
        var y=20+Math.floor(Math.random()*330)
        mask.height=mask.height
        mask.width=mask.width
        layer.height=layer.height
        layer.width=layer.width
        var img = document.createElement('img')
        img.src="./image/wall.jpg"
        img.onload=function(){
        draw(x,y,50,10,mkctx);
        mkctx.drawImage(img,0,0);
        lyctx.drawImage(img,0,0);
        fillin(x,y,50,10,lyctx);
        $('#mask').css("left",-x);
        maskoffset=x
        }
        $("#slug").css('left',0)
    }

    function draw(x,y,w,r,ctx){
    ctx.beginPath()
    var gradient=ctx.createLinearGradient(0,0,400,0);
    gradient.addColorStop("0","white");
    gradient.addColorStop("1","black");
    ctx.strokeStyle=gradient
    ctx.lineWidth=5
    ctx.moveTo(x,y)
    ctx.lineTo(x+w/2,y)
    ctx.arc(x+w/2,y-r+2, r,0,2*Math.PI) //
    ctx.lineTo(x+w/2,y)
    ctx.lineTo(x+w,y)
    ctx.lineTo(x+w,y+w/2)
    ctx.arc(x+w+r-2,y+w/2,r,0,2*Math.PI) //
    ctx.lineTo(x+w,y+w/2)
    ctx.lineTo(x+w,y+w)
    ctx.lineTo(x,y+w)
    ctx.lineTo(x,y+w-r)
    ctx.arc(x,y+w/2,r,0.5*Math.PI,1.5*Math.PI,true)
    ctx.lineTo(x,y)
    ctx.closePath()
    //closePath封闭线条路径
    ctx.stroke()
    ctx.clip()
    }

    function fillin(x,y,w,r,ctx){
    ctx.fillStyle='white'
    ctx.moveTo(x,y)
    ctx.lineTo(x+w/2,y)
    ctx.arc(x+w/2,y-r+2, r,0,2*Math.PI) //
    ctx.lineTo(x+w/2,y)
    ctx.lineTo(x+w,y)
    ctx.lineTo(x+w,y+w/2)
    ctx.arc(x+w+r-2,y+w/2,r,0,2*Math.PI) //
    ctx.lineTo(x+w,y+w/2)
    ctx.lineTo(x+w,y+w)
    ctx.lineTo(x,y+w)
    ctx.lineTo(x,y+w-r)
    ctx.arc(x,y+w/2,r,0.5*Math.PI,1.5*Math.PI,true)
    ctx.lineTo(x,y)
    ctx.fill()
    }
    
    imgidentify()
    
    dragcan=false
    $('#slug').mousedown(function(){dragcan=true});
    $(document).mouseup(function(){
        if(dragcan){
            dragcan=false
            if(parseInt($('#mask').css("left"))>=-5&&parseInt($('#mask').css("left"))<=5){
                alert('通过验证')
                $('#register').submit()
            }
            else{
                alert('未通过验证')
                imgidentify()
            }
        }
        });
    $(document).mousemove(function(e){
        var dragbox=document.getElementById('dragbox')
        offsetx=e.clientX-dragbox.offsetLeft;
        if(dragcan&&offsetx<=365&&offsetx>=35){
        $('#slug').css("left",offsetx-35);
        $('#mask').css("left",offsetx-35-maskoffset)
        }
    })

    
    $("#register input[type='text']").change(function(e){
        var input=$(e.target)
        switch(input.attr('name')){
            //test只是检测字符串是否包含,search() 方法使用表达式来搜索匹配，然后返回匹配的位置。replace() 方法返回模式被替换处修改后的字符串。
            //exec() 方法是一个正则表达式方法。它通过指定的模式（pattern）搜索字符串，并返回已找到的文本。

            case 'username':
                if(/^[a-zA-Z0-9_]{3,10}$/.test(input.val())){
                    input.next().attr("src","./image/yes.png")
                    usernametest=true
                }
                else{
                    input.next().attr("src","./image/no.png")
                    usernametest=false
                }
                break;
            case 'passwd':
                if(/^[a-zA-Z0-9_]{5,15}$/.test(input.val())){
                    input.next().attr("src","./image/yes.png")
                    passwdtest=true
                }
                else{
                    input.next().attr("src","./image/no.png")
                    passwdtest=false
                }
                break;
            case 'email':
                if(/^([\w\-]+\@[\w\-]+\.[\w\-]+)$/.test(input.val())){
                    input.next().attr("src","./image/yes.png")
                    emailtest=true
                }
                else{
                    input.next().attr("src","./image/no.png")
                    emailtest=false
                }
                break;
            case 'phone':
                if(/^[1][3-9][0-9]{9}$/.test(input.val())){
                    input.next().attr("src","./image/yes.png")
                    phonetest=true
                }
                else{
                    input.next().attr("src","./image/no.png")
                    phonetest=false
                }
                break;
            default:
                break;
        }
    })

    $('#register input[type="submit"]').click(
        function(e){
            e.preventDefault()
            if(usernametest&&passwdtest&&emailtest&&phonetest){
                if($('#content').css('display')=='none'){
                $('#content').css('display','block')
                }else{
                    alert("请完成人机检测")
                }
            }else{
                alert('请正确填写表单')
            }
            
        }
    )


     })()
     </script>
</body>
</html>