<?php
// Започнување на сесија за чување на податоци за сесијата
session_start();

// Вчитување на поврзувањето со базата на податоци
include '../../database/db_connection.php';

// Проверка дали формата е испратена преку POST метода
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Преземање на податоци од формата за корисничко име и лозинка
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Проверка за минимална должина на корисничко име и лозинка
    if (strlen($username) < 3 || strlen($password) < 6) {
        die('Корисничкото име мора да има најмалку 3 карактери, а лозинката најмалку 6.');
    }

    // Хеширање на лозинката за безбедност
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Вметнување на нов корисник во базата на податоци

    $db = connectDatabase();

    $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':password', $hashedPassword);


    // Успешна регистрација, прикажување на порака и линк за најава
    if ($stmt->execute()) {
        // Redirect back to the view page
        echo "Регистрацијата е успешна! <a href='../../pages/auth/login.php'>Најавете се тука</a>";
    } else {
        echo "Error register: " . $db->lastErrorMsg();
    }
}
?>