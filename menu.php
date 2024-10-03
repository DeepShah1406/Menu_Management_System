<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Menu Management</title>
        <style>
        body 
        {
            font-family: Arial, sans-serif;
        }
        table 
        {
            border-collapse: collapse;
            width: 100%;
        }
        th, td 
        {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        tr:nth-child(even) 
        {
            background-color: #f2f2f2;
        }
        form 
        {
            margin-bottom: 20px;
        }
        .container 
        {
            width: 80%;
            margin: 0 auto;
        }
        .btn 
        {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn:hover 
        {
            background-color: #45a049;
        }
        </style>
    </head>
    <body>
        <div class="container">
        <h2>Menu Management System</h2>
        
        <form method="post" action="menu.php" enctype="multipart/form-data">
            <label for="txtSearchID">Search Item ID:</label>
            <input type="text" id="txtSearchID" name="txtSearchID">
            <input type="submit" name="btnSearch" value="Search" class="btn">
        </form>

        <form method="post" action="menu.php" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>Item ID:</td>
                    <td><input type="text" name="txtItemID" id="txtItemID"></td>
                </tr>

                <tr>
                    <td>Item Name:</td>
                    <td><input type="text" name="txtItemName" id="txtItemName"></td>
                </tr>
                
                <tr>
                    <td>Description:</td>
                    <td><textarea name="txtDescription" id="txtDescription" rows="4"></textarea></td>
                </tr>
                
                <tr>
                    <td>Price:</td>
                    <td><input type="text" name="txtPrice" id="txtPrice"></td>
                </tr>
                
                <tr>
                    <td colspan="2" align="center">
                        <input type="submit" name="btnInsert" value="Insert" class="btn">
                        <input type="submit" name="btnUpdate" value="Update" class="btn">
                        <input type="submit" name="btnDelete" value="Delete" class="btn">
                        <input type="submit" name="btnSelect" value="Show Menu" class="btn">
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>


<?php
    $con = mysqli_connect('localhost', 'root', '', 'food&bevdb') or die("Not Connected");

    if (isset($_POST['btnInsert'])) 
    {
        $txtItemID = $_POST['txtItemID'];
        $txtItemName = $_POST['txtItemName'];
        $txtDescription = $_POST['txtDescription'];
        $txtPrice = $_POST['txtPrice'];


        $qry = $con->prepare("INSERT INTO menu_items (Item_ID,Item_Name,Description,Price) VALUES (?, ?, ?, ?)");
        $qry->bind_param("issd", $txtItemID,$txtItemName,$txtDescription,$txtPrice);
        $result = $qry->execute();

        if ($result) 
        {
            echo "Record Inserted";
        } 
        else 
        {
            echo "Error in Insertion";
        }

        $qry->close();
    }
        
    if (isset($_POST['btnUpdate'])) 
    {
        $txtItemID = $_POST['txtItemID'];
        $txtItemName = $_POST['txtItemName'];
        $txtDescription = $_POST['txtDescription'];
        $txtPrice = $_POST['txtPrice'];

        $qry = $con->prepare("UPDATE menu_items SET Item_Name=?, Description=?, Price=? WHERE Item_ID=?");
        $qry->bind_param("ssdi",$txtItemName,$txtDescription,$txtPrice, $txtItemID);
        $result = $qry->execute();

        if ($result) 
        {
            echo "Record Updated";
        }
        else 
        {
            echo "Error in Update: " ;
        }

        $qry->close();
    }
        
    if (isset($_POST['btnDelete'])) 
    {
        $txtItemID = $_POST['txtItemID'];

        $qry = $con->prepare("DELETE FROM menu_items WHERE Item_ID=?");
        $qry->bind_param("i", $txtItemID);
        $result = $qry->execute();

        if ($result) 
        {
            echo "Record Deleted";
        } 
        else 
        {
            echo "Error in Deletion";
        }

        $qry->close();
    }

    if(isset($_POST['btnSearch'])) 
    {
        $txtSearchID = $_POST['txtSearchID'];
        
        $qry = "SELECT * FROM menu_items WHERE Item_ID=?";
        
        $stmt = $con->prepare($qry);
        
        $stmt->bind_param("i", $txtSearchID);
        
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        if(mysqli_num_rows($result)>0)
        {
            // Output the table header
            echo "<table border ='1' align='center'>";
            echo "<h1 align='center'>Search Food Items</h1>";
            echo "<tr><th>Items ID</th> <th>Item Name</th> <th>Description</th> <th>Price</th></tr>" ;
            
            // Output each row of the result set
            while($row=mysqli_fetch_assoc($result))
            {
                echo "<tr>";
                echo "<td>".$row['Item_ID']."</td>";
                echo "<td>".$row['Item_Name']."</td>";
                echo "<td>".$row['Description']."</td>";
                echo "<td>".$row['Price']."</td>";
                echo "</tr>";
            } 
            echo "</table>";
        }
    }


    mysqli_close($con);   

    if (isset($_POST['btnSelect'])) 
    {
        header("Location:MenuDb.php");
        exit();
    }
?>