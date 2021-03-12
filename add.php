<?php
include_once __DIR__ . '/header.php';
require __DIR__ . '/bootstrap.php';

//post signal
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? 0;
    $id = (int) $id;

    $balance = $_POST['balance'] ?? 0;
    $balance = (int) $balance;
    addMoney($id, $balance);
    header('Location:' . URL . 'main.php');
    die;
}
?>

<body>
    <div class="container">
        <h5>Fill the balance field to add money</h5>

        <div class="card">
            <div class="card-body">
                <?php foreach (read() as $client) : ?>

                <!-- <h4>
                        Update user <b><?php echo $client['id'] ?></b>
                    </h4> -->
                <form action="<?= URL ?>add.php" method="post">
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
                            <button type="submit" class="btn btn-outline-primary" name="btn-add">Add</button>
                        </div>
                    </div>

                </form>
                <?php endforeach; ?>

            </div>

</body>

</html>