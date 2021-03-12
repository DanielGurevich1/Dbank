<?php

function read(): array
{
    if (!file_exists(DIR . 'data/client.json')) { // pirmas kartas
        $data = json_encode([]);
        file_put_contents(DIR . 'data/client.json', $data);
    }

    $data = file_get_contents(DIR . 'data/client.json');
    return json_decode($data, 1);
}


function write(array $data): void
{
    $data = json_encode($data);
    file_put_contents(DIR . 'data/client.json', $data);
}

function getNextId(): int
{
    if (!file_exists(DIR . 'data/indexes.json')) {
        $index = json_encode(['id' => 1]);
        file_put_contents(DIR . 'data/indexes.json', $index);
    }

    $index = file_get_contents(DIR . 'data/indexes.json');
    $index = json_decode($index, 1);

    $id = (int) $index['id'];
    $index['id'] = $id + 1;

    $index = json_encode($index);
    file_put_contents(DIR . 'data/indexes.json', $index);
    return $id;
}

function getClient(int $id)
{

    foreach (read() as $client) {
        if ($client['id'] == $id) {
            return $client;
        }
    }
    return null;
}

function createClient($client): void
{
    $clients = read();
    //$id = getNextId();
    $client['id'] = getNextId();
    $clients[] = $client;
    $_SESSION['messages']['success'][] = "ACCOUNT was created!";
    write($clients);
}

function addMoney(int $id, int $count)

{
    // $clients =  read();
    $client = getClient($id);
    if (!$client) {

        return;
    }
    $client['balance'] += $count;
    if ($client['balance'] > 0) {
        $_SESSION['messages']['success'][] = "Amount was added!";
        header('Location:' . URL . 'send.php');

        deleteUser($id);
        $clients = read();
        $clients[] = $client;
        write($clients);
    } else {
        $_SESSION['messages']['error'][] = "Account cannot be overdrafted";
        header('Location:' . URL . 'add.php');
    }
}
function sendMoney(int $id, int $count)

{
    // $clients =  read();
    $client = getClient($id);
    if (!$client) {
        return;
    }
    $client['balance'] -= $count;
    //     die;
    // }
    if ($client['balance'] < 0) {
        $_SESSION['messages']['error'][] = "Account cannot be overdrafted";
        header('Location:' . URL . 'send.php');
    } else {
        deleteUser($id);
        $clients = read();
        $clients[] = $client;
        $_SESSION['messages']['success'][] = "Well done - money sent!";
        header('Location:' . URL . 'send.php');
        write($clients);
    }
}


function deleteUser(int $id): void
{
    $clients = read();
    foreach ($clients as $key => $client) {
        if ($client['id'] == $id) {
            unset($clients[$key]);

            write($clients);
            return;
        }
    }
}

function createID()
{
    $idn = rand(6688, 7688);
    $firstNum = rand(3, 6);
    $d = (date("ymd"));
    // $d = $_POST['date'];
    return $firstNum . $d . $idn;
}

function bankIban()
{
    $lastfigures = rand(116688, 999688);
    $first = 'LT';
    $x = 7044060000;
    // $d = $_POST['date'];
    $accountNum =  "$first" . $x . $lastfigures;
    return $accountNum;
}

function alert($alertMessage)
{
    echo "<script>alert('$alertMessage');</script>";
}