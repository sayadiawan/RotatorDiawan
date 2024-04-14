 <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">-->
	<!--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>-->
    <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>-->
	<!--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>-->
<!--<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>-->
<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>-->
<?php
if(empty($secure) or $secure!='OK'){
	header("location:http://$domain/error/");
}
else {
?>

	<header>
    	<!--<div class="container"> -->
     <!--       <div id="topleft"> <?php include("../components/topleft.php"); ?> </div>-->
     <!--       <div id="topright"> <?php include("../components/topright.php"); ?> </div>-->
     <!--   </div>-->
    </header>
    <div id="top"> <div class=""> <?php include("../components/top.php"); ?> </div> </div>
    <div class="col-md-12">
    <div id="main"> 
        <div class="container"> 
            <?php include("../components/main.php"); ?> 
        </div> 
    </div>
    </div>
    <div id="bottom"> <div class="container"> <?php include("../components/bottom.php"); ?> </div> </div>
    <footer> <div class="container"> <?php include("../components/foot.php"); ?> </div> </footer>

<?php
}
?>