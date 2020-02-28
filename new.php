<?php 

$name = $_POST['postname'];
$color = $_POST['postcolor'];
$pattern = $_POST['postpattern'];

include 'db_connection.php' ;
$query = "SELECT price,location FROM items WHERE name='$name' AND color='$color' AND pattern ='$pattern'";
$conn = OpenCon();
$data = mysqli_query($conn,$query) or die('Error');
CloseCon($conn);
$dbData = array();
//echo mysqli_num_rows($data);
if(mysqli_num_rows($data)>0){
    while($row = mysqli_fetch_assoc($data)){
        $price = $row['price'];
        array_push($dbData,$price);
        $location = $row['location'];
        array_push($dbData,$location);
    }
}
    
foreach($dbData as $value){
    echo $value . " ";
}


?>