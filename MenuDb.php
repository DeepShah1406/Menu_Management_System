<?php
$con = mysqli_connect('localhost', 'root', '', 'food&bevdb') or die("Not Connected");

$qry = "SELECT * FROM menu_items";
    $result = mysqli_query($con, $qry);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Train Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        h1, h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            text-align: center;
            margin-top: 20px;
        }

        input[type="text"], input[type="submit"] ,name{
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ddd;
            margin-right: 10px;
            font-size:17px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            padding: 10px 20px;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
        h1,b{
            color:#45a049;
        }
    </style>
</head>
<body>

<h1>Food Menu</h1>

<table border='0' align='center'>
    <tr>
        <th>Item ID</th>
        <th>Item Name</th>
        <th>Description</th>
        <th>Price</th>
        
    </tr>

    <?php
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['Item_ID'] . "</td>";
            echo "<td>" . $row['Item_Name'] . "</td>";
            echo "<td>" . $row['Description'] . "</td>";
            echo "<td>" . $row['Price'] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No records found</td></tr>";
    }

    if (isset($_POST['btnBack'])){
        header("Location:menu.php");
        exit();
    }
    ?>
</table>

<form action="MenuDb.php" method="POST">
    <input type="submit" name="btnBack" value="Back">
</form>

</body>
</html>

<?php
mysqli_close($con);
?>
