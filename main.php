<?php
include_once __DIR__ . '/header.php';
require __DIR__ . '/bootstrap.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] != 1) {
    header('Location: http://localhost:8898/Dbank/login.php');
    die;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['btn-add'])) {
        header('Location: ' . URL . 'add.php');
        die;
    }
    if (isset($_POST['btn-send'])) {
        header('Location: ' . URL . 'send.php');
        die;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? 0;
    // $id = (int) $id;
    $client = getClient($id);

    if ($client['balance'] == 0) {
        deleteUser($id);
        header('Location: ' . URL . 'main.php');
        $_SESSION['messages']['warning'][] = "sorry to let you go";
    } else {
        header('Location: ' . URL . 'main.php');
        $_SESSION['messages']['error'][] = "Account with positive balance cannot be deleted";
        die;
    }
}
?>

<div class="container">

    <body>
        <h4>Hello, <?= $_SESSION['user']['name'] ?></h4>
        <a href="<?= URL ?>login.php?logout">LogOut</a>
        <table class="table table-bordered border-secondary">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Surname</th>
                    <th scope="col">ID</th>
                    <th scope="col">ACC NUM</th>
                    <th scope="col">Balance</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>

                <?php
                // sort
                $clients = read();

                usort($clients, function ($a, $b) {
                    return $a['surname'] <=> $b['surname'];
                });

                //print
                foreach ($clients as $client) : ?>

                    <tr>
                        <th scope="row"><?= $client['id'] ?></th>
                        <td><?= $client['name'] ?></td>
                        <td><?= $client['surname'] ?></td>
                        <td><?= $client['idn'] ?></td>

                        <td><?= $client['AC'] ?></td>
                        <td><?= $client['balance'] ?> EUR</td>


                        <td>
                            <form action="" method="POST">
                                <input type="hidden" name="id" value="<?= $client['id'] ?>">

                                <button type="submit" name="btn-add" class="btn btn-sm btn-outline-primary">Add</button>
                                <button type="submit" name="btn-send" class="btn btn-sm btn-outline-secondary">Send</button>
                                <button type="submit" name="btn-delete" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                    </tr>
                    </td>
            </tbody>
        <?php endforeach ?>
        </table>
    </body>
</div>

</html>