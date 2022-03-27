<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display data</title>
    <style>
        body{
            background-color:lightblue;
                    
        }
        table,th,td{
            border:1px solid black;
            width:1100px;
            background-color:lightgreen;
        }
        .btn{
            width:20%;
            height: 5%;
            font: 10px;
        }
        </style>
</head>
<body>
    <center>
    <h2>Report</h2>
    <div class="container">
        <form action="" method="POST">
            <table>
                <tr>
                    <th>sr no</th>
                    <th>name</th>
                    <th>age</th>
                    <th>gender</th>
                    <th>email</th>
                    <th>phone</th>
                    <th>other</th>
                    <th>data</th>
</tr>
                    <input type="sumbit" class="btn" name="search" value="SEARCH DATA"><br>
</table>
</form>
<?php
 
  $query_run="SELECT * FROM hosital_inquiry";
      while($row= mysqli_fetch_array($query_run))
      {
          ?>
          <tr>
              <td><?php echo $row['Sr no'] ?> </td>
              <td><?php echo $row['Name'] ?> </td>
              <td><?php echo $row['Age'] ?> </td>
              <td><?php echo $row['Gender'] ?> </td>
              <td><?php echo $row['Email'] ?> </td>
              <td><?php echo $row['Phone'] ?> </td>
              <td><?php echo $row['Other'] ?> </td>
              <td><?php echo $row['date'] ?> </td>
      </tr>
      <?php 
      }
  
?>
</div>
    </center>
</body>
</html>