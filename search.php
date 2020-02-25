<?php
$output="NULL";
if(isset($_POST['Search']))
{
	
$con=mysqli_connect('localhost','root','');
if(!$con){
echo 'Not Connected';
}
else{ 
echo "SEARCHING....";

}
if(!mysqli_select_db($con,'truecaller'))
{
	echo 'Database Not Found';
}
/*else{ 
echo "connected2db";
}*/
$NUMBER=$_POST['NUMBER'];
$query="SELECT * FROM output where NUMBER='$NUMBER'";
if(!mysqli_query($con,$query)){
	echo "not found";
}
else{
	
$resultset=mysqli_query($con,$query);
$rows=mysqli_fetch_array($resultset,MYSQLI_ASSOC);
//echo "$rows[0]";
	if($rows['NUMBER']!=NULL){
		$FNAME=$rows['FNAME'];
		$LNAME=$rows['LNAME'];
		$NUMBER=$rows['NUMBER'];
		
		if($rows['OCCUPATION']=='')
			$OCCUPATION="NULL";
		else
			$OCCUPATION=$rows['OCCUPATION'];
		
		if($rows['OPERATOR']=='')
			$OPERATOR="NULL";
		else
			$OPERATOR=$rows['OPERATOR'];
		
		if($rows['LOCATION']=='')
			$LOCATION="NULL";
		else
			$LOCATION=$rows['LOCATION'];
		
		if($rows['EMAIL']=='')
			$EMAIL="NULL";
		else
			$EMAIL=$rows['EMAIL'];
		
		
		$output='<span class="glyphicon glyphicon-user"></span> <span style="padding-right:68px;"></span>'."$FNAME".'   '."$LNAME<br /><br />".'<span class="glyphicon glyphicon-earphone"></span> <span style="padding-right:68px;"></span>'."$NUMBER<br /><br />".'<span class="glyphicon glyphicon-briefcase"></span> <span style="padding-right:68px;"></span>'."$OCCUPATION<br /><br />".'<span class="glyphicon glyphicon-phone"></span> <span style="padding-right:68px;"></span>'."$OPERATOR<br /><br />".'<span class="glyphicon glyphicon-map-marker"></span> <span style="padding-right:68px"></span>'."$LOCATION<br /><br />".'<span class="glyphicon glyphicon-envelope"></span> <span style="padding-right:68px;"></span>'."$EMAIL";
		#<div class="well">$output="$FNAME".'   '."$LNAME<br /><br />$NUMBER<br />$OCCUPATION<br />$OPERATOR<br />$LOCATION<br />$EMAIL";</div>
}
else{
	$a=$NUMBER.' ';
	$s=$a[0];
	//echo "$s";
    if(strlen($a)!=11 || ctype_alpha($a[0]) || ctype_alpha($a[1]) || ctype_alpha($a[2]) ||ctype_alpha($a[3]) ||ctype_alpha($a[4]) ||ctype_alpha($a[5]) ||ctype_alpha($a[6]) ||ctype_alpha($a[7]) ||ctype_alpha($a[8]) ||ctype_alpha($a[9]) )
    $output="$NUMBER is INVALID";
    else if($s=='0' ||$s=='1' || $s=='2' || $s=='3' || $s=='4' || $s=='5' || $s=='6')
	$output="<font color='red'>$NUMBER is SPAM!</font>";
	else	
	$output = "No Results";
}
}
}
?>

<!--<form method="POST">
<input type="TEXT" name="NUMBER" />
<input type="SUBMIT" name="search" value="Search"/>
</form>-->
<html lang="en">
<head>
<link rel="icon" href="/Truecaller/th.jpg">
  <title>Truecaller</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
body {
background-color: #1e90ff;
}
</style>
</head>
<body>

   <nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><font color='white' face='Broadway' size=6>Truecaller</font></a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="/Truecaller/Page.html">Home</a></li>
      <li><a href="/Truecaller/about.html">About Us</a></li>
	        <li><a href="/Truecaller/contact.html">Contact Us</a></li>
    </ul>
	<ul class="nav navbar-nav navbar-right">
        <li><span class="glyphicon glyphicon-user"></span>Logged in</li>
        <li><a href="/Truecaller/login.html"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
      </ul>
  </div>
</nav> 
  
 <div class="container">
   <br><br><br><br><br>
   <h1><center><font color="white" face="Verdana"><b>Search Over Hundreds of Contact Numbers in India.</b></font></center></h1>
  <br><br><br><br><br>
  
<form method="POST">
<input type="TEXT" name="NUMBER" class="form-control input-lg" class="col-xs-3" placeholder="Search"/>
<input type="SUBMIT" name="Search" value="Search"/>
</form> 

<div class="panel panel-primary" style="background-color:red">
  <div class="panel-body" style="background-color:LightGray">
 
<h4><center><font color="black" face="Verdana"><b><?php echo "$output" ; ?></b></font></center></h4>
</div>
</div>
<br><br><br>
</div>

<img src="/Truecaller/home-phone-android.8831f2a.png">
</body>
</html>


