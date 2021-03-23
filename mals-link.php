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

    // Everything below this point in the file is secured by the login system

    // We can display the user's username to them by reading it from the session array.  Remember that because
    // a username is user submitted content we must use htmlentities on it before displaying it to the user.
?>
<html>
<head>
  <title>Mals Link Generator</title>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="list-admin-styles.css">
</head>
<header>
  <div class="listlogo">
    <img src="http://www.list57.com/wp-content/uploads/2016/07/logot-1.jpg">
  </div>
  <nav class= "usernav">
      <ul>
          <li class="dropdown">
              <a href="javascript:void(0)" class="dropbtn">Hello <?php echo htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8'); ?></a>
              <div class="dropdown-content">
                <a href="edit_account.php">Edit My Account</a>
                <a href="logout.php">Logout</a>
              </div>
          </li>
        </ul>
    </nav>
    <nav class="listnav">
      <ul>
          <li><a href="register.php">ADD USER</a></li>
          <li><a href="memberlist.php">VIEW MEMBERLIST</a></li>
                <li class="dropdown">
                    <a href="private.php">LIST ADMIN</a>

                </li>
              
      </ul>
    </nav>
</header>
<body>
<div class="container">
  <div class="center">
  <div  class="logo-header">
<img src="http://www.list57.com/wp-content/uploads/2016/07/logot-1.jpg">
</div>
<h3>Mals Link Generator</h3>
</div>
<p>Enter a product and price here and the link generated will deliver the customer to our Mals shopping cart
  with the information filled in and ready to check out. Copy and paste the link into an email and send it
  to the customer for one click shopping!</p>
<form id="link-form" action="" >
  <ul>
       <li><label>Product:</label> <input id="product" type="text" name="product" size="45" maxlength="45" /></li>
       <li><label>Price:</label> <input id="price" type="text" name="price" size="30" maxlength="30" /></li>
       <li><input  type="submit" value="show mals link" id="link-submit"></li>
   </ul>
</form>
<p class="hide">This is your link:</p>
<p id="new-link"></p>
<p class="hide">Paste it into your browser URL window or use the button to test</p>
<div class="hide" id="test-link-button" ></div>


<script>

$('input#link-submit').click( function() {
    event.preventDefault();

  var product = document.getElementById("product").value,
     price = document.getElementById("price").value,
     malslink = "",
     showlink = document.getElementById("new-link"),
     testlink = document.getElementById("test-link-button"),
     linktag = document.createElement('a'),
     hide = document.getElementsByClassName('hide');

     if (product.length == 0 || price.length == 0)
     {
       alert("fill in the fields please");
       return;
     }

     malslink = "http://ww4.aitsafe.com/cf/add.cfm?userid=64288154&product=" + product + "&price=" + price + "&return=http%3A//list57.com&units=1&qty=1";

     malslink = malslink.replace(/ /g,"%20");//replaces all spaces in the malslink with 20% so the link will work in mozilla (google appends the link automatically)

   showlink.style.color = '#0574F2';
   showlink.innerHTML = malslink;
   hide[0].style.display = 'block';
   hide[1].style.display = 'block';
   hide[2].style.display = 'block';
   linktag.style.textDecoration = 'none';
   linktag.style.color = '#fff';
   linktag.style.cursor = 'pointer';
   linktag.setAttribute("href", malslink);
   linktag.setAttribute("target", '_blank');
   linktag.innerText = "Test Link";
   testlink.appendChild(linktag);

         });




</script>

</body>
</html>
