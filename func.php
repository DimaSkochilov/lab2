<?php
include 'config.php';
date_default_timezone_set('Europe/Moscow');

$name = $_POST['name'];
$comment = $_POST['comment'];
$pos = $_POST['pos'];
$date = date("Y-m-d G:i:s", time() + 0);

// Create
if (isset($_POST['submit'])) {
	$sql = ("INSERT INTO `users`(`name`, `comment`, `date`, `likes`) VALUES(?,?,?,0)");
	$query = $pdo->prepare($sql);
	$query->execute([$name, $comment, $date]);
	$success = '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Данные успешно отправлены!</strong> Вы можете закрыть это сообщение.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
    header('Location: '. $_SERVER['HTTP_REFERER']);
}

// Read
$sql = $pdo->prepare("SELECT * FROM `users` ORDER BY `date` DESC LIMIT 100");
$sql->execute();
$result = $sql->fetchAll();

$edit_name = $_POST['edit_name'];
$edit_comment = $_POST['edit_comment'];
$edit_pos = $_POST['edit_pos'];
$edit_date = $_POST['edit_date'];
$get_id = $_GET['id'];

// EDIT
if (isset($_POST['edit-submit'])) {
	$sqll = "UPDATE `users` SET (`name`=?, `comment`=?, `date`=?) WHERE `id`=?";
	$querys = $pdo->prepare($sqll);
	$querys->execute([$edit_name, $edit_comment, $edit_date, $get_id]);
	header('Location: '. $_SERVER['HTTP_REFERER']);
}

// DELETE
if (isset($_POST['delete_submit'])) {
	$sql = "DELETE FROM users WHERE id=?";
	$query = $pdo->prepare($sql);
	$query->execute([$get_id]);
	header('Location: '. $_SERVER['HTTP_REFERER']);
}

// REACT
if (isset($_POST['like-submit'])) {
    $con = mysqli_connect("127.0.0.1","root", "root", "crud");
    $sql1 = "SELECT * FROM `users` WHERE `id`='$get_id'";
    $result1 = mysqli_query($con, $sql1);
    $row = mysqli_fetch_assoc($result1);
    $likes = $row['likes'] + 1;

    $sql2 = "UPDATE `users` SET `likes`=? WHERE `id`=?";
    $query2 = $pdo->prepare($sql2);
    $query2->execute([$likes, $get_id]);
    header('Location: '. $_SERVER['HTTP_REFERER']);
}
