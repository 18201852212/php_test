
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
   <style>
     *{
       padding: 0;
       margin: 0;
     }
     #unlog{
      margin-top:20px;
       margin-left: 20px;
     }
     #log{
      margin-top:20px;
       margin-left: 20px;
     }
     #searchbox{
       margin-top:20px;
       margin-left: 20px;
     }
     #searchbox input[type='submit']{
       margin-left: 10px;
     }
     .videoname{
       list-style: none;
       width: 20%;
     }
     .videoname:hover{
       background-color:blanchedalmond;
     }
     #videoplay{
       margin-top:20px;
       margin-left: 20px;
       width: 320px;
       height: 180px;
     }
   </style>
</head>
<script src="/js/jquery-3.3.1.min.js"></script>
<script src="/js/jquery.cookie.js"></script>
<body>
  <div id='unlog'>
    <a id='login' href="#">登录</a>
    <a id='register' href="#">注册</a>
  </div>
  <div id="log">
  <h1 id='ex'>退出登录</h1>
  </div>
  <div id='searchbox'>
    <input type="text" name="filename"><input type="submit" value="搜索">
    <br>
    <ul id="findresult"></ul>
  </div>
  <div id="videobox"><video id="videoplay" controls="controls" preload="auto"></video></div>
  <?php
if(isset($_COOKIE['uid'])&&isset($_COOKIE['psd'])&&$_COOKIE['uid']!='null'&&$_COOKIE['psd']!='null'){
 echo "<script>$('#unlog').css('display','none');$('#log').prepend($.cookie('uid'))</script>";
}else{
  echo "<script>$('#log').css('display','none')</script>";
}
?>
  <script>
  

    // document.onvisibilitychange=function(){
    //   window.location.reload() 
    // }
    //对于视频类网站慎用reload方法
    $('#ex').click(function(){
      $.cookie('uid',null,{ expires: 7 })
      $.cookie('psd',null,{ expires: 7 })
      window.location.reload()
    })
    $('#login').click(function(e){
      e.preventDefault
      window.open('/login.php')
    })
    $('#register').click(function(e){
      e.preventDefault
      window.open('/register.php')
    })

    $("#searchbox input[name='filename']").on('input',function(e){
      value=$(e.target).val()
      $.ajax({
        url:"/php/findfile.php",
        type:"GET",
        data:{filename:value},
        cache:false,
        error:function(){console.log('加载出错')},
        success:function(data){
          var text=''
          if(/error/g.test(data)){
            $("#findresult").html(text)
          }else{
            var data=data.replace(/[\r\n]/g,"")
            var filelist=data.split(';')
            for(let i=0;i<filelist.length;i++){
              text=text+"<li class='videoname'>"+filelist[i]+"</li>"
              $("#findresult").html(text)
            }
          }
        }
      })
    })
  //给动态创建的元素添加绑定事件，其实就是利于了冒泡的原理，利用DOM树中，
  //存在的被创建元素的父亲元素或整个DOM树来，通过适配的方式，来查找创建元素的绑定事件.
  //$(selector).on(event,childSelector,data,function)
//   event：必需。规定要从被选元素移除的一个或多个事件或命名空间。
// childSelector：可选。规定只能添加到指定的子元素上的事件处理程序（且不是选择器本身，比如已废弃的 delegate() 方法）。
// data：可选。规定传递到函数的额外数据。
// function：可选。规定当事件发生时运行的函数。
// 注意：使用 on() 方法添加的事件处理程序适用于当前及未来的元素（比如由脚本创建的新元素）。
   $('#findresult').on('click','.videoname',function(e){
     $("#searchbox input[name='filename']").val($(e.target).text())
   })

   $('#searchbox input[type="submit"]').click(function(e){
      e.preventDefault()
      videoname=$("#searchbox input[name='filename']").val()
      $("#searchbox input[name='filename']").val("")
      $('#findresult').html("")
      $.ajax({
        url:'/php/videourl.php',
        type:"GET",
        cache:false,
        data:{filename:videoname},
        error:function(){
          console.log('加载错误')
        },
        success:function(data){
          if(/error/g.test(data)){
            console.log('查找出错')
          }else{
            var data=data.replace(/[\r\n]|E:\\www/g,'')
            $("#videoplay").attr("src",data)
          }
        }
      })
   })
  </script>
</body>
</html>

   