<?php session_start();
if (isset($_SESSION['login']))
    $login=$_SESSION['login'];
else{
    session_destroy();
    $login=NULL;
}
?>
<html>
<head>
    <title>NimpStore - Mes Applications</title>
   <meta charset='utf-8'>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/css.css">
</head>
<body>
<?php include("navbar.php");
      include("idConnex.php");
    require("class/class.php");

$appName = $_POST['appName'];
$note = $_POST['note'];
$com = $_POST['com'];


if($note <= 5 && $note >= 0) {
$queryString="INSERT INTO avis VALUES ('$login','$appName',$note,'$com')";
pg_query($idConnex,$queryString);

header("Location: mesApplications.php");
}

else header("Location: mesApplications.php?err=1");

?>



<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script src="js/jquery.localscroll.js"></script>
<script src="js/jquery.scrollTo.js"></script>
<script src="js/bootstrap.min.js"></script> 
<script src="js/ourFunction.js"></script> 
</body>
</html>