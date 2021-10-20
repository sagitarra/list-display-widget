<?php
// First we execute our common code to connection to the database and start the session
require("permission.php");


try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname;$port=3306;charset=utf8",$username,$password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
}
catch(PDOException $e){
//  $error = $e->getMessage();//somethingin the database is acting wonky so i put this as json_encode so it didn't break the autocomplete - but it needs to get looked at
echo json_encode("error finding list");
}

$return_arr = array();

if ($conn)
{
  $term = $_GET['term'];
  $query = "SELECT * FROM lists WHERE title REGEXP :term ";
  $result = $conn->prepare($query);
  $result->bindValue(':term',$term);
  $result->execute();



  while($row = $result->fetch(PDO::FETCH_ASSOC)){

    $row_array['id'] = $row['id'];
    $row_array['value'] = $row['title'];
    $row_array['retailprice'] = $row['retailprice'];
    $row_array['description'] = $row['description'];
    $row_array['pagelink'] = $row['pagelink'];
    $row_array['rowcounts'] = $row['rowcounts'];
    array_push($return_arr,$row_array);

  }
}

/*free connection resources*/
$conn = null;
echo json_encode($return_arr);

exit();
