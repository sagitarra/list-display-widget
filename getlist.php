<?php
// First we execute our common code to connection to the database and start the session
require("common.php");

// At the top of the page we check to see whether the user is logged in or not
if(empty($_SESSION['user']))
{
    // If they are not, we redirect them to the login page.
    header("Location: login.php");

    // Remember that this die statement is absolutely critical.  Without it,
    // people can view your members-only content without logging in.
    die("Redirecting to login.php");
}
//all good!

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname;$port=3306;charset=utf8",$username,$password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
}
catch(PDOException $e){
  $error = $e->getMessage();//somethingin the database is acting wonky so i put this as json_encode so it didn't break the autocomplete - but it needs to get looked at
}

$return_arr = array();

if ($conn)
{
  $action = $_GET['state'];//this gets the state of the form - if it is adding a list then we want to know for the warning hint below
  $term = $_GET['term'];
  $query = "SELECT * FROM lists WHERE title REGEXP :term ";
  $result = $conn->prepare($query);
  $result->bindValue(':term',$term);
  $result->execute();

  $i = 0;

  while($row = $result->fetch(PDO::FETCH_ASSOC)){
  if ($i == 0 && $action == "add"){//adds one instance of the helper hint to the autocomplete array if we are adding a list
       $return_arr['id'] = 0;
       $return_arr['value'] = "To avoid adding duplicates keep typing until they disappear";
       $i++;
     }

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
