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
    $qResultAccounts=$conn->query('select * from bank.grip_bank_cust');
    $accounts=$qResultAccounts->fetch_all(MYSQLI_ASSOC);

    $qResultTransactions=$conn->query('select * from bank.grip_bank_transaction');
    $transactions=$qResultTransactions->fetch_all(MYSQLI_ASSOC);

    $msg='';

   
    if(isset($_POST['submit']))
    {
        if(empty($_POST['amount']))
        {
            $msg="Amount field is empty";
        }
        else
        {
            $amt=$_POST['amount'];
            if(!preg_match('/^\d+(\.\d{1,2})?$/', $amt))
            {
                $msg="Enter a numerical amount";
            }
            else
            {
                $cID=$_POST['cID'];
                $sql_accounts="UPDATE bank.grip_bank_cust SET balance=balance+".$amt." WHERE cusID=".$cID.";";
                $sql_transactions="INSERT INTO bank.grip_bank_transaction VALUES ('".$cID."', '".$amt."');";
                if(mysqli_query($conn,$sql_accounts))
                {
                    if(mysqli_query($conn,$sql_transactions))
                    {
                        $msg="Money Transfered";
                        header("Refresh:0");
                    }
                    else
                    {
                        echo('Query error : '.mysqli_error($conn));
                    }
                }
                else
                {
                    echo('Query error : '.mysqli_error($conn));
                }
            }
        }

        echo"<script>alert('".$msg."');</script>";
    }
    
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

        <script src="script.js"></script>
    </head>
    <body>
        <div class="container">
        <a href="transactions.php">Click to check transactions</a>
        <table class="table mt-5">
            <thead>
                <tr>
                    <th scope="col">Customer ID</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Balance</th>
                    <th scope="col">Details</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach($accounts as $key)
                    {

                        echo '
                        <tr>
                            <th scope="row">'.$key['cusID'].'</th>
                            <td>'.$key['fname'].'</td>
                            <td>'.$key['lname'].'</td>
                            <td>'.$key['email'].'</td>
                            <td>$ '.$key['balance'].'</td>
                            <td><button id="button" onclick="displayModal('.$key['cusID'].',\''.$key['fname'].'\',\''.$key['lname'].'\',\''.$key['email'].'\',\''.$key['balance'].'\')">View</button></td>
                        </tr>';
                    } ?>
            </tbody>
        </table>
        <div class="bg-modal">
            <div class="modal-content">
                <button type="button" class="btn-close" onclick="closeModal(this)"></button>

                <table class="mt-5 ml-2 popup-table">
                    <tbody>
                    <form action="index.php" method="POST">
                        <tr>
                            <th class="record-title">Customer ID</th>
                            <td>:</td>
                            <td><input type="text" id="cID" name="cID" readonly></td>
                        </tr>
                        <tr>
                            <th class="record-title">First Name</th>
                            <td>:</td>
                            <td><input type="text" id="fname" name="fname" readonly></td>
                        </tr>
                        <tr>
                            <th class="record-title">Last Name</th>
                            <td>:</td>
                            <td><input type="text" id="lname" name="lname" readonly></td>
                        </tr>
                        <tr>
                            <th class="record-title">Email</th>
                            <td>:</td>
                            <td><input type="text" id="email" name="email" readonly></td>
                        </tr>
                        <tr>
                            <th class="record-title">Balance</th>
                            <td>:</td>
                            <td><input type="text" id="balance" name="balance" readonly></td>
                        </tr>

                        <tr class="payment">
                            
                                <td colspan="2"><input type="text" name="amount" style="width :90%; margin :0 auto; border-radius :30px; "></td>
                                <td><input type="submit" name="submit" value="Transfer" style="background-color: #03fcb1; border-radius: 30px;"></td>
                            </tr>
                    </form>
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </body>
</html>
