<?php
include_once __DIR__ . '/header.php';
require __DIR__ . '/bootstrap.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] != 1) {
    header('Location: http://localhost:8898/Dbank/login.php');
    die;
}

// $d =  $client['date'];
$individualAccountNum = rand(1234, 9876);
$idnum = createID();
$iban = bankIban();
// echo $iban;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $client['name'] = $_POST['name'];
    $client['surname'] = $_POST['surname'];
    $client['date'] = $_POST['date'];
    $client['idn'] = $_POST['idn'];
    $client['balance'] = 0;

    $client['AC'] = $_POST['AC'];

    $nameLength = strlen($_POST['name']);
    $surnameLength = strlen($_POST['surname']);

    if (isset($_POST['name']) || isset($_POST['surname'])) {
        if ($nameLength < 3 || $surnameLength < 3) {

            // alert("Name or Surname are too short");

            exit(alert("Name or Surname are too short"));
        }
    } else {

        createClient($client); // sukuria

        header('Location: ' . URL . 'main.php');
        die;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Account</title>
</head>
<div class="container">


    <body>
        <h4>Hello, <?= $_SESSION['user']['name'] ?></h4>
        <a href="<?= URL ?>login.php?logout">LogOut</a>
        <h5>Fill the fields to add a new account</h5>
        <form class="row row-cols-lg-auto align-items-center" method="post">
            <div class="row">
                <div class="col">
                    <input type="text" class="form-control" placeholder="First name" aria-label="First name" value=""
                        name="name">
                </div>
                <div class="col">
                    <input type="text" class="form-control" placeholder="Last name" aria-label="Last name" value=""
                        name="surname">
                </div>
                <div class="col">
                    <input type="date" class="form-control" placeholder="Date" aria-label="Last name" value=""
                        name="date">
                </div>
                <div class="col">
                    <input type="number" class="form-control" placeholder="ID number" aria-label="ID Number"
                        value="<?= $idnum ?>" name="idn">
                </div>

                <div class="col">
                    <input type="text" class="form-control" placeholder="Account number" aria-label="Account_number"
                        value="<?php echo $iban ?>" name="AC">
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-outline-primary">Create </button>
                </div>
            </div>

        </form>
    </body>
</div>

</html>