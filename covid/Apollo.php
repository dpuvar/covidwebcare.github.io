
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Availability of following</title>
</head>

<style>
    body {
        padding: 0px;
        margin: 0;
        font-family: Verdana, Geneva, Tahoma, sans-serif;
    }

    table {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        border-collapse: collapse;
        width: 800px;
        height: 200px;
        border: 1px solid #bdc3c7;
        box-shadow: 2px 2px 12px rgba(0, 0, 0, 0.2), -1px -1px 8px rgba(0, 0, 0, 0.2);
    }
 table1 {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        border-collapse: collapse;
        width: 800px;
        height: 200px;
        border: 1px solid #bdc3c7;
        box-shadow: 2px 2px 12px rgba(0, 0, 0, 0.2), -1px -1px 8px rgba(0, 0, 0, 0.2);
    }

    tr {
        transition: all .2s ease-in;
        cursor: pointer;
    }

    th,
    td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    #header {
        background-color: #16a085;
        color: #fff;
    }
    #header1 {
        background-color: #16a085;
        color: #fff;
    }

    h1 {
        font-weight: 600;
        text-align: center;
        background-color: #1650a0;
        color: #fff;
        padding: 10px 0px;
    }

    tr:hover {
        background-color: #f5f5f5;
        transform: scale(1.02);
        box-shadow: 2px 2px 12px rgba(0, 0, 0, 0.2), -1px -1px 8px rgba(0, 0, 0, 0.2);
    }

    @media only screen and (max-width: 768px) {
        table {
            width: 90%;
        }
    }
    
</style>

<body>
<h1>Iris Hospital</h1>
<img src="hos7.png"  height="35%" width="20%"/>
<img src="hos5.png" style="float: right;"  height="35%" width="20%" alt=""/>  

<hr>

<table>
    <thread>
    <tr id="header">
        <th>Floor NO.</th>
        <th>Beds</th>
        <th>Oxygen Cylinder</th>
    </tr>
</thread>
<?php   
include 'connection.php';

$selectquery = " SELECT * FROM Iris ";
$query = mysqli_query($conn,$selectquery);

while( $res= mysqli_fetch_array($query))
{ ?>
   
    <tr> 
     <td><?php echo $res['Floor no'] ?></td>
     <td><?php echo $res['Beds'] ?></td>
     <td><?php echo $res['OxygenCylinder'] ?></td>
    
</tr>
<?php
}
?>
    <tr id="header1">
        <th colspan="3">Following facilities are available here</th>
    </tr>
    <tr>
        <td>Blood Bank </td>
        <td>Available</td>
    </tr>
    <tr>
        <td>CT Scan</td>
        <td>Available</td>
    </tr>
</table>
<img  src="hos8.png" height="35%" width="20%" alt=""/>

<img src="hos6.png" style="float: right;"  height="35%" width="20%" alt=""/>  

</body>
</html>