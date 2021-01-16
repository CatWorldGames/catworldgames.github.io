<?php

$link = mysqli_connect("localhost", "root", "", "chat") or die (":( нет подключения к серверу");
$sql = "SELECT*FROM 'messages' ORDER BY 'date'";
$result = mysqli_query($link,$sql);
$out = mysqli_fetch_assoc($result);
mysql_select_db("db");
if (!isset($_GET['add_message'])){
  if(mysqli_num_rows($result)>= 1){
    $out = mysqli_fetch_assoc($result);
    while ($out = mysqli_fetch_assoc($result)) {
      echo "<ul class = 'display'></ul>"."<li>".$out['name']."|".$out['date']."<br>".$out['message']."</li>"."<hr>";
    }
  }
}

else{
  echo '
  <form action = "chat.php"method = "POST"><input type = "text" name = "name" placeholder = "Введите имя"class = "names">
    <br><br>
    <input type = "text" name="message" placeholder = "Message..."class = "messages1">
    <br></br>
    <button name="submit" class = "btn">Отправить</button>
  </form>

  <style>
  .names {
    width = 100%;
    height = 80px;
    border:1px solid black;
  }
  .messages1 {
    width = 100%;
    height = 80px;
    border:1px solid black;
  }
  div {
    display:none;
  }
  body {
    background-color:black;
  }
  .btn {
    border:1px;
    border-radius:10px;
    width:100px;
    height:100px;
  }
  .display {
    background-color:white;
    width:260px;
    height:300;
    overflow:visible;
  }
  </style>
';
}


if (isset($_POST['submit'])){
  if(!empty($_POST['name'])&& !empty(['message'])){
    $names = $_POST['name'];
    $send = $_POST['message'];
    $sql = "INSERT INTO 'messages'('id','name','message','date')VALUES(NULL,'".$names."', '".$send."', date('d.m.Y:i:s'));";
    mysql_query($link,$query);
  }
}
?>