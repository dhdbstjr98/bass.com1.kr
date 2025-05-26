<?php
include("./common.php");

$sheets = sql_fetch_all("SELECT * FROM `sheet` WHERE 1");
?>
<!DOCTYPE html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus®">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <title>bass</title>
 </head>
 <body>
  <ul>
  <?php foreach($sheets as $sheet) { ?>
    <li><a href="./<?php echo $sheet['no']; ?>"><?php echo $sheet['title']; ?> - <?php echo $sheet['artist']; ?> (<?php echo $sheet['source']; ?>)</a></li>
  <?php } ?>
  </ul>
 </body>
</html>
