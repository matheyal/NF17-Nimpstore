<html>
<?php include("base.php"); ?>
<?php

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