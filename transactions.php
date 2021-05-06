<?php
    $host='localhost'; 
    $username = 'admin';
    $pass='admin@123';
    $database='bank';
    $port='3306';
    $conn= new mysqli($host,$username,$pass,$database,$port);
    if($conn->connect_error)
    {
        die('Database not connected or offline');
    }
    $qResultTransactions=$conn->query('select * from bank.grip_bank_transaction');
    $transactions=$qResultTransactions->fetch_all(MYSQLI_ASSOC);
?>
<html>
    <head>
        <title>Basic banking system</title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    
        <!-- Personal CSS -->
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="container">
        <a href="index.php">Click to go home</a>
        
        <table class="table mt-5">
            <thead>
                <tr>
                    <th scope="col">Transfered To</th>
                    <th scope="col" class="tramt">Transfered Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach($transactions as $key)
                    {

                        echo '
                        <tr>
                            <th scope="row">'.$key['sentTo'].'</th>
                            <td class="tramt">$ '.$key['amt'].'</td>
                        </tr>';
                    } ?>
            </tbody>
        </table>
        </div>
    </body>
</html>