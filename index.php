<html>
<head>
<title>
тест чат на php
</title>
</head>
<body>
<style>
div
{
	display:none;
}
</style>
<div class='chat'>
	<div class='chat-messages'>
		<div class='chat-messages__content' id='messages'>
			Загрузка...
		</div>
	</div>
	<div class='chat-input'>
		<form method='post' id='chat-form'>
			<input type='text' id='message-text' class='chat-form__input' placeholder='Введите сообщение'> <input type='submit' class='chat-form__submit' value='=>'>
		</form>
	</div>
</div>
.chat {
	border:1px solid #333;
	margin:15px;
	width:40%;
	height:70%;
	background:#555;
	color:#fff;
}

.chat-messages {
	min-height:93%;
	max-height:93%;
	overflow:auto;
}

.chat-messages__content {
	padding:1px;
}

.chat__message {
	border-left:3px solid #333;
	margin-top:2px;
	padding:2px;
}

.chat__message_black {
	border-color:#000;
}

.chat__message_blue {
	border-color:blue;
}

.chat__message_green {
	border-color:green;
}

.chat__message_red {
	border-color:red;
}

.chat-input {
	min-height:6%;
}
input {
	font-family:arial;
	font-size:16px;
	vertical-align:middle;
	background:#333;
	color:#fff;
	border:0;
	display:inline-block;
	margin:1px;
	height:30px;
}

.chat-form__input {
	width:79%;
}

.chat-form__submit {
	width:18%;
}
</style>
<script>
var messages__container = document.getElementById('messages'); 
//Контейнер сообщений — скрипт будет добавлять в него сообщения

var interval = null; //Переменная с интервалом подгрузки сообщений

var sendForm = document.getElementById('chat-form'); //Форма отправки
var messageInput = document.getElementById('message-text');
</script>
<script>
function send_request(act, login = null, password = null) {//Основная функция
	//Переменные, которые будут отправляться
	var var1 = null;
	var var2 = null;
	
	if(act == 'auth') {
		//Если нужно авторизоваться, получаем логин и пароль, которые были переданы в функцию
		var1 = login;
		var2 = password;
	} else if(act == 'send') {
//Если нужно отправить сообщение, то получаем текст из поля ввода
		var1 = messageInput.value;
	}
	
	$.post('includes/chat.php',{ //Отправляем переменные
		act: act,
		var1: var1,
		var2: var2
	}).done(function (data) { 
		//Заносим в контейнер ответ от сервера
		messages__container.innerHTML = data;
		if(act == 'send') {
			//Если нужно было отправить сообщение, очищаем поле ввода
			messageInput.value = '';
		}
	});
}
</script>
<script>
function update() {
	send_request('load');
}
interval = setInterval(update,500);
</script>
<script>
sendForm.onsubmit = function () {
	send_request('send');
	return false; //Возвращаем ложь, чтобы остановить классическую отправку формы
};
</script>
<?php
session_start();
$db = mysqli_connect("localhost","login","password"); 
mysqli_select_db($db,"chat");

$_SESSION['login'] = 'admin';
$_SESSION['password'] = 'admin';
$_SESSION['id'] = 1;
?>
</script>
<script>
<?php
function load($db) {
	$echo = "";
	if(auth($db,$_SESSION['login'],$_SESSION['password'])) {//Проверяем успешность авторизации
		$result = mysqli_query($db,"SELECT * FROM messages"); //Запрашиваем сообщения из базы
		if($result) {
			if(mysqli_num_rows($result) >= 1) {
				while($array = mysqli_fetch_array($result)) {//Выводим их с помощью цикла
					$user_result = mysqli_query($db,"SELECT * FROM userlist WHERE id='$array[user_id]'");//Получаем данные об авторе сообщения
					if(mysqli_num_rows($user_result) == 1) {
						$user = mysqli_fetch_array($user_result);
						$echo .= "<div class='chat__message chat__message_$user[nick_color]'><b>$user[login]:</b> $array[message]</div>"; //Добавляем сообщения в переменную $echo
					}
				}
			
			} else {
				$echo = "Нет сообщений!";//В базе ноль записей
			}
		}
	} else {
		$echo = "Проблема авторизации";//Авторизация не удалась
	}
	
	return $echo;//Возвращаем результат работы функции
}
?>
</script>
<script>
<?php
//Получаем переменные из супермассива $_POST
//Тут же их можно проверить на наличие инъекций
if(isset($_POST['act'])) {$act = $_POST['act'];}
if(isset($_POST['var1'])) {$var1 = $_POST['var1'];}
if(isset($_POST['var2'])) {$var2 = $_POST['var2'];}

switch($_POST['act']) {//В зависимости от значения act вызываем разные функции
	case 'load': 
		$echo = load($db); //Загружаем сообщения
	break;
	
	case 'send': 
		if(isset($var1)) {
			$echo = send($db,$var1); //Отправляем сообщение
		}
	break;
	
	case 'auth': 
		if(isset($var1) && isset($var2)) {//Авторизуемся
			if(auth($db,$var1,$var2)) {
				$echo = load($db);
			}
		}
	break;
}

echo $echo;//Выводим результат работы кода
?>
</script>
<script>
<?php
$.post('includes/index.php',{
	act: act,
	var1: var1,
	var2: var2
}).done(function (data) {
	messages__container.innerHTML = data;
	if(data == 'Проблема авторизации') {
		clearInterval(interval); //Если проблема авторизации, отключаем автообновление
		if(login == null && password == null) {
			login = prompt('Введите логин: ');//Запрашиваем логин
			if(login != null) {
				password = prompt('Введите пароль: ');//Запрашиваем пароль
				send_request('auth',login,password); //Отправляем еще один запрос
			}
		}
	} 
	if(act == 'auth') {
		interval = setInterval(update,500); //Заново запускаем автообновление
	}
	if(act == 'send') {
		messageInput.value = '';
	}
});
?>
</script>
<form method='post' id='chat-form'>
<div class='emojis-container emojis-container_hidden' id='emojis'></div>
	<img src='/images/emojis/happy.png' class='emoji-img' id='emoji-button'>
<input type='text' id='message-text' class='chat-form__input' placeholder='Введите сообщение'> 
<input type='submit' class='chat-form__submit' value='=>'>
</form>
<style>
.emojis-container {
	position:absolute;
	z-index:100;
	background:#555;
	border:1px solid #333;
	padding:2px;
	max-width:38%;
	top:20px;
}

.emojis-container_hidden {
	left:-9999999999999999px;
}

.emoji-img {
	vertical-align:middle;
	width:20px;
	margin:1px;
	cursor:pointer;
}
</style>
<script>
var emojis__container = document.getElementById('emojis');
var emojis__button = document.getElementById('emoji-button');
var showed = false;

function getEmojis() {//Получаем смайлики из PHP-файла
	$.post('/includes/chat.php',{act: 'load-emojis'}).done(function (data) {
		emojis__container.innerHTML = data;
	});
}

function showEmojis() {//Добавляем отображение и скрытие окна
	if(showed) {
		emojis__container.setAttribute('class','emojis-container emojis-container_hidden');
		showed = false;
	} else {
		emojis__container.setAttribute('class','emojis-container');
		showed = true;
	}
}
</script>
<script>
function addEmoji(title) {
	messageInput.value += " " + title + " ";
//Тут же можно добавить закрытие контейнера
messageInput.focus();
}
</script>
<script>
<?php
$(document).ready(function (){
	$(".emoji-add").on("click", function () {addEmoji($(this).attr('title'));});
});
emojis__button.addEventListener('click',showEmojis); 

getEmojis();
?>
</script>
<script>
<?php
function getEmojis() {
	$dir = '../images/emojis';
	$echo = "";
	$files = scandir($dir);
	
	for($i = 0; $i != count($files); $i++) {
		$ext = explode('.',$files[$i]);
		if($ext[1] == 'png') {
			$echo .= "<img src='/images/emojis/".$files[$i]."' title=':".$ext[0].":' class='emoji-img emoji-add'> ";
		} 
	}
	return $echo;
}
?>
</script>
<script>
<?php
function transformEmoji($message) {
	$pattern = '/(\:\S*\:)/i'; //Паттерн смайлика
	if(preg_match($pattern,$message,$matches)) {//Ищем все совпадения для смайлика одного типа — только :happy: или только :sad:
		$path = explode(":",$matches[0]);
		if(file_exists("../images/emojis/".$path[1].".png")) {//Проверяем, существует ли такое изображение
			$message = preg_replace("/".$matches[0]."/","<img src='/images/emojis/$path[1].png' class='emoji-img'>",$message);//Заменяем код на изображение
		}
		$message = transformEmoji($message); //Повторяем, пока в $message есть коды смайликов
	}
	return $message;
}
?>
</script>
<script>
<?php
$array['message'] = transformEmoji($array['message']);
?>

</script>
<script>
<?php
$echo .= "<div class='chat__message chat__message_$user[nick_color]'><b><span class='answer-span'>$user[login]</span>:</b> $array[message]</div>";
?>
</script>
<script>
function addAnswer(login) {
	messageInput.value = login + ", " + messageInput.value;
	messageInput.focus();
}
</script>
<script>
<?php
$(document).ready(function (){
	$(".add-answer").on("click", function () {addEmoji($(this).text());});
});
?>
</script>