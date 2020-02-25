
<?php
$con=mysqli_connect('localhost','root','');
//echo "hello";
//echo "hi";
if(!$con){
echo 'Not Connected';
}
else{
	//echo '1';
}

if(!mysqli_select_db($con,'truecaller'))
{
	echo 'Database Not Found';
}
else{
	//echo '2';
}

$email=$_POST['Email'];
$password=$_POST['password'];
$sql0="select AES_DECRYPT(Password,'encryption_key') from registered_user where email='". $email. "'";
//decrypt the code using AES_DESCRYPT
//.
//.
//.
//No hashing used
//md5, sha1 are unidirectional encryption methods
//Actuslly, they are hashing methods not 
//"encryption" method
//$sql=""select AES_DECRYPT();
//header();
//<head>
//</html>

$query = "select *  from temp where email='". $email. "'";
$result = $con->query($query);
$row = $result->fetch_array(MYSQLI_NUM);
if($row[0]==''){
	echo "<script type=\"text/javascript\">window.alert('Email does not exist. Kindly register.');
window.location.href = '/Truecaller/registration.html';</script>";
	header("refresh:1;url=/Truecaller/registration.html");
}

else if($password!=$row[1])
{
	echo "<script type=\"text/javascript\">window.alert('Password Incorrect.');
window.location.href = '/Truecaller/login.html';</script>";
	    //echo 'Incorrect Password.';
		// Kindly <a href="/Truecaller/registration.html">register. </a>';
		
		header("refresh:1;url=/Truecaller/login.html");
}
else
{
	if($password==$row[1])
	{
		echo 'If not redirected. <a href="/Truecaller/Page2.html"> Click here. </a>';
		header("refresh:1;url=/Truecaller/search.php");
	}
}

?>