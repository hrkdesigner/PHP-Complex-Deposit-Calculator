<?php
$amount = $_POST['amount'];
$rate = $_POST['rate'];
$monthOfPayment = $_POST['deposit'];
$name = trim($_POST['name']);
$postal = $_POST['code'];
$phone = $_POST['number'];
$email = $_POST['mail'];

$time = isset($_POST['time']);

$errors = array();
$dayTime = array();

if (isset($_POST['submit'])) {

    if (empty($amount)) {
        $errorAmount = "Please insert your desired amount";
        array_push($errors, $errorAmount);
    }
    if ($amount <= 0 || !is_numeric($amount)) {
        $errortypo = "Amount must be numric and grater than zero";
        array_push($errors, $errortypo);
    }
    if (empty($rate)) {
        $errorRate = "Please insert your desired rate";
        array_push($errors, $errorRate);
    }
    if ($rate < 0 || !is_numeric($rate)) {
        $error = "Interest rate must be numeric and not negative";
        array_push($errors, $error);
    }
    if (empty($monthOfPayment)) {
        $errorMonth = "Please choose your desired month for pament";
        array_push($errors, $errorMonth);
    }
    if (empty($name)) {
        $errorName = "Please insert your name";
        array_push($errors, $errorName);
    }
    if (empty($postal)) {
        $errorPostal = "Please insert your postal code";
        array_push($errors, $errorPostal);
    }
    if (empty($_POST['contact'])) {
        $errorContact = "Choose your method of contact";
        array_push($errors, $errorContact);
    }

    if (isset($_POST['contact']) && $_POST['contact'] == "phone") {
        if (!$time) {
            $errorPhone = "If you use phone, you have to use at least one preferred range of day time";
            array_push($errors, $errorPhone);
        } else {
            foreach ($_POST['time'] as $x => $y) {
                array_push($dayTime, $y);
            }
        }
    }
}


// include("DepositCalculator.html");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Deposit Calculator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        body {
            padding: 20px auto;
            margin: 0;
            box-sizing: border-box;
            background-color: #fff;
            cursor: default;
        }

        h3 {
            text-align: center;
            padding-bottom: 20px;

        }

        tr {
            height: 40px;
            font-size: 18px;
        }

        a {
            text-decoration: none;
            font-size: 18px;
            text-align: center;
            margin-top: 40px;
            display: block;
        }
    </style>
</head>

<body class="container">
    <h1>Thank you <?php (!$name ? print("Dear user") : print($name)) ?>, for using our deposit calculator!</h1>
    <p><?php count($errors) ? print("However we can not process your request because of the following inputes") : print("") ?></p>
    <ul>
        <?php foreach ($errors as $x) {
            print("<li>" . $x . "</li>");
        } ?>
    </ul>
    <?php
    if (!count(($errors))) {
        if ($_POST['contact'] == "phone") {
            if (array_key_exists(0, $dayTime) && array_key_exists(1, $dayTime)) {
                print(" <p>Our Customer service will call you tomorrow " . $dayTime[0] . " or " . $dayTime[1] . " at " . $phone . "</p>");
            } else {
                if (array_key_exists(1, $dayTime) && array_key_exists(2, $dayTime)) {
                    print("<p>Our Customer service will call you tomorrow " . $dayTime[0] . " , " . $dayTime[1] . " or " . $dayTime[2] . " at " . $phone . "</p>");
                } else {
                    print("<p>Our Customer service will call you tomorrow " . $dayTime[0] . "  at " . $phone . "</p>");
                }
            }
        }
        if ($_POST['contact'] == "email") {
            print("<p>Our Customer service will email you soon " . $email . "</p>");
        }
        print("<p>The following is the result of your calculation</p>");


        echo "<table class='table table-striped table-condensed table-bordered' border =\"1\" style='border-collapse: collapse'>";
        echo "<tr><th>Year</th><th>Princial at Year Start</th><th>Interest for the Year</th>
        </tr> \n";
        for ($x = 1; $x <= $monthOfPayment; $x++) {
            $calculation =  $rate / 10;
            $term = 1 / $monthOfPayment;
            $total = $amount * $term * $calculation;
            echo "<tr> \n";
            for ($col = 1; $col <= 3; $col++) {
                if ($col == 1) echo "<td>$x</td> \n";
                elseif ($col == 2) echo "<td>" . round(($amount), 2) . "</td> \n";
                else echo "<td>" . round($total, 2) . "</td> \n";
            }
            $amount += $total;
            echo "</tr>";
        }
        echo "</table>";
    }  
    ?>
</body>

</html>