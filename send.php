<?php
include_once __DIR__ . '/header.php';
require __DIR__ . '/bootstrap.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] != 1) {
    header('Location: http://localhost:8898/Dbank/login.php');
    die;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? 0;
    $id = (int) $id;

    $balance = $_POST['balance'] ?? 0;
    $balance = (int) $balance;

    sendMoney($id, $balance);
    header('Location:' . URL . 'main.php');
    die;
}

?>


<body>
    <div class="container">
        <h4>Hello, <?= $_SESSION['user']['name'] ?></h4>
        <a href="<?= URL ?>login.php?logout">LogOut</a>
        <h5>Fill the balance field to send money</h5>
        <div class="card">
            <div class="card-body">
                <?php foreach (read() as $client) : ?>

                <form action="<?= URL ?>send.php" method="post">
                    <input type="hidden" name="id" value="<?= $client['id'] ?>">
                    <div class="row">

                        <div class="col">
                            Nr.: <?= $client['id'] ?>

                        </div>
                        <div class="col">
                            <?= $client['name'] ?>

                        </div>
                        <div class="col">
                            <?= $client['surname'] ?>

                        </div>
                        <div class="col">
                            Balance: <?= $client['balance'] ?>
                        </div>
                        <div class="col">
                            <input type="number" class="form-control" placeholder="Balance" aria-label="Balance"
                                name="balance">
                        </div>

                        <div class="col">
                            <button type="submit" class="btn btn-outline-primary" name="btn-add">Send</button>
                        </div>
                    </div>

                </form>
                <?php endforeach; ?>

            </div>

</body>

</html>