<?php
require __DIR__ . '/bootstrap.php';

//logged out scenarijus

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ' . URL . 'login.php');
    die;
}
if (isset($_SESSION['login']) && $_SESSION['login'] == 1) {
    header('Location: http://localhost:8898/Dbank/main.php');
    die;
}

// post metodas login

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $users = file_get_contents(__DIR__ . '/users.json');
    $users = json_decode($users, 1);

    $postName = $_POST['name'] ?? '';
    $postPass = $_POST['pass'] ?? '';

    foreach ($users as $user) {
        if ($postName == $user['name']) { // <--- turim useri
            if (password_verify($postPass, $user['pass'])) {
                // <--- viskas OK
                // sugalvojam kad 1 reiks prisijungusi vartotoja
                //  o 0 reiks neprisijungusi
                $_SESSION['login'] = 1;
                $_SESSION['user'] = $user;
                header('Location: http://localhost:8898/Dbank/main.php');
                die;
            }
        }
    }
    echo 'Password or Name is invalid.';
    header('Location: http://localhost:8898/Dbank/login.php');
    die;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <h1>Bank Login </h1>
    <?php if (isset($_SESSION[''])) : ?>
    <h3 style="color:red"><?= $_SESSION['error_msg'] ?></h3>
    <!-- atvaizdavome. nebereikalingas istrinam, kad nerodytu sekati karta -->
    <?php unset($_SESSION['error_msg']) ?>
    <?php endif ?>
    <form action="<?= URL ?>login.php" method="post">
        NAME:<input type="text" name="name">
        PASSWORD:<input type="password" name="pass">
        <button type="submit">login</button>
    </form>
</body>

</html>