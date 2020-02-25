<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" href="/Truecaller/th.jpg">
 <meta charset="utf-8">
</head>
 <body>
<?php
$operator=array("Airtel","Vodafone","Idea","Jio","BSNL");
$state=array("Rajasthan","Tamil Nadu","Delhi","West Bengal","Gujarat");
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

/*$Fname=$_POST("Fname");
$Lname=$_POST('Lname');
$Email=$_POST('Email');
$ContactNo=$_POST('ContactNo');
$City=$_POST('City');
$State=$_POST('State');
$Occupation=$_POST('Occupation');
$Password=$_POST('Password');
*/
$a=$_POST['Contact_No'].' ';

if($_POST['Fname']==''||$_POST['Email']==''||$_POST['Contact_No']==''||$_POST['Password']=='')
{
//alert("Field cannot be empty!");
echo "<script type=\"text/javascript\">window.alert('Fill all the necessary fields-First Name,Email ID,Contact Number,Password.');
window.location.href = '/Truecaller/registration.html';</script>"; 
//header("refresh:2;url=/Truecaller/registration.html");
}
else if($a[0]!='8' && $a[0]!='9' && $a[0]!='7')
	{
			echo "<script type=\"text/javascript\">window.alert('Invalid Number Entry.');
window.location.href = '/Truecaller/registration.html';</script>";
		
	}
else if(strlen($_POST['Password'])<8 )
{	
echo "<script type=\"text/javascript\">window.alert('Password must be at least 8 characters long.');
window.location.href = '/Truecaller/registration.html';</script>"; 
}

else if(!(preg_match('/[A-Za-z]/', $_POST['Password']) && preg_match('/[0-9]/', $_POST['Password']) && preg_match('/[\'^£$%&*()}{@#~?><>,|=_+!-]/', $_POST['Password'])))
{
		echo "<script type=\"text/javascript\">window.alert('Password should contain alphanumeric and special characters.');
window.location.href = '/Truecaller/registration.html';</script>"; 
	}
else if(strlen($_POST['Contact_No'])!=10)
{
	echo "<script type=\"text/javascript\">window.alert('Contact Number must be 10 digits long.');
window.location.href = '/Truecaller/registration.html';</script>";
}

else if( !ctype_digit($a[0]) || !ctype_digit($a[1]) || !ctype_digit($a[2]) ||!ctype_digit($a[3]) ||!ctype_digit($a[4]) ||!ctype_digit($a[5]) ||!ctype_digit($a[6]) || !ctype_digit($a[7]) || !ctype_digit($a[8]) ||!ctype_digit($a[9]))
{
	echo "<script type=\"text/javascript\">window.alert('Contact Number must have only digits.');
window.location.href = '/Truecaller/registration.html';</script>";
}
	
else if(strcmp($_POST['Password'],$_POST['Password2'])!=0){
echo "<script type=\"text/javascript\">window.alert('Passwords do not match.');
window.location.href = '/Truecaller/registration.html';</script>"; 
}

else if(!filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL)) {
     echo "<script type=\"text/javascript\">window.alert('Invalid Email.');
window.location.href = '/Truecaller/registration.html';</script>";
}
//$sqlnumber=mysqli_query($con,"select Email from registered_user where Email='$_POST[Email]'");
//$sqlcontact=mysqli_query($con,"select Contact_No from registered_user where Contact_No=$_POST[Contact_No]");

//if(mysqli_num_rows($sqlnumber)==0||mysqli_num_rows($sqlcontact)==0){
//	echo "<script type=\"text/javascript\">window.alert('User already registered.');
//window.location.href = '/Truecaller/login.html';</script>";
//}
else{
$sql0="Insert into temp(email,password) values('$_POST[Email]','$_POST[Password]')";
if(!mysqli_query($con,$sql0))
{
		echo '';
}
$sql="Insert Into registered_user(Contact_No,Fname,Lname,City,State,Email,Occupation,Password)
 Values ($_POST[Contact_No],'$_POST[Fname]','$_POST[Lname]','$_POST[City]','$_POST[State]','$_POST[Email]','$_POST[Occupation]',AES_ENCRYPT('$_POST[Password]', 'encryption_key'))";
if(!mysqli_query($con,$sql))
{
		echo 'Error Occured!! User is either already registered or Invalid Entry in a field .';
		header("refresh:2;url=/Truecaller/login.html");
}

else
{
	/*$form = false;

                      //mail function

                        //mail end
                        $to = '$_POST[Email]';
    $subject = "Welcome to";
    $message = " Hi '$_POST[Fname]',<br /><br />
    Thank you for signing up with us.<br />

    Thanks <br />";
    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
    // More headers
    $headers .= 'From: <sarrafparul1073@gmail.com>' . "\r\n";
    $mail=mail($to,$subject,$message,$headers);*/
	for( $i = 0; $i<20;$i++)
	{
		$j=25*$i;
		$l=$i+1;
		$query="select * from contact_list order by id limit $j,25";
		$res=mysqli_query($con,$query);
		$row=mysqli_fetch_array($res,MYSQLI_NUM);
		if($row[0]==NULL)
		{
			$sql1 = "update contact_list set USER_NO=$_POST[Contact_No] where id = $l and  USER_NO is NULL";
			if(!mysqli_query($con,$sql1))
			{
				echo 'Could not update data';
			}
			$sql2="INSERT INTO name_count(PHONE_NO,FNAME,LNAME,NCOUNT)
					SELECT PHONE_NO,FNAME,LNAME,1 NCOUNT FROM contact_list WHERE id=$l
					ON DUPLICATE KEY
					UPDATE NCOUNT=NCOUNT+1";
			if(!mysqli_query($con,$sql2))
			{
				echo "Not Inserted";
			}
			$sql3="INSERT INTO occupation_count(PHONE_NO,OCCUPATION,OCOUNT)
					SELECT PHONE_NO,OCCUPATION,1 OCOUNT FROM contact_list WHERE id=$l AND LENGTH(OCCUPATION) > 0
					ON DUPLICATE KEY
					UPDATE OCOUNT=OCOUNT+1";
			if(!mysqli_query($con,$sql3))
			{
				echo "Not Inserted";
			}
			
			$sql4="INSERT INTO output(FNAME,LNAME,NUMBER)
					SELECT N.FNAME,N.LNAME,N.PHONE_NO FROM name_count AS N
					WHERE N.NCOUNT=(SELECT MAX(N1.NCOUNT) FROM name_count as N1 
					WHERE N1.PHONE_NO=N.PHONE_NO) 
					ON DUPLICATE KEY
					UPDATE FNAME=N.FNAME,LNAME=N.LNAME,NUMBER=N.PHONE_NO";
			if(!mysqli_query($con,$sql4))
			{
				echo "Not Inserted";
			}
			$sql5="INSERT INTO output(OCCUPATION,NUMBER)
					SELECT N.OCCUPATION,N.PHONE_NO FROM occupation_count AS N
					WHERE N.OCOUNT=(SELECT MAX(N1.OCOUNT) FROM occupation_count as N1 
					WHERE N1.PHONE_NO=N.PHONE_NO) 
					ON DUPLICATE KEY
					UPDATE OCCUPATION=N.OCCUPATION,NUMBER=N.PHONE_NO";
			if(!mysqli_query($con,$sql5))
			{
				echo "Not Inserted";
			}
			$temp="select * from registered_user";
			$rtemp=mysqli_query($con,$temp);
			while($rowtemp=mysqli_fetch_array($rtemp,MYSQLI_ASSOC))
			{
				$sql6="INSERT INTO output(FNAME,LNAME,NUMBER,EMAIL,OCCUPATION,LOCATION) VALUES
					('$rowtemp[Fname]','$rowtemp[Lname]','$rowtemp[Contact_No]','$rowtemp[Email]','$rowtemp[Occupation]','$rowtemp[State]')
					ON DUPLICATE KEY
					UPDATE FNAME='$rowtemp[Fname]',LNAME='$rowtemp[Lname]',EMAIL='$rowtemp[Email]',OCCUPATION='$rowtemp[Occupation]',
					LOCATION='$rowtemp[State]'";
					
			if(!mysqli_query($con,$sql6))
			{
				echo "Not Inserted";
			}
			}
			$n=0;
			$sql7="select * from output order by FNAME";
			$res1=mysqli_query($con,$sql7);
			$k=0;
			while($row1=mysqli_fetch_array($res1,MYSQLI_ASSOC))
			{
				if($k<5)
				{
					if($row1['OPERATOR']==NULL)
						{
						$sql8="UPDATE output SET OPERATOR='$operator[$n]' where NUMBER='$row1[NUMBER]'";
						if(!mysqli_query($con,$sql8))
						{
							echo "Not Inserted";
						}
						if($row1['LOCATION']==NULL)
						{
						$sql9="UPDATE output SET LOCATION='$state[$k]' where NUMBER='$row1[NUMBER]'";
						if(!mysqli_query($con,$sql9))
						{
							echo "Not Inserted";
						}
						//$row1['OPERATOR']=$operator[$n];
						//$row1['LOCATION']=$state[$k];
						$k=$k+1;
						}
						}
				}
				else{
					$k=0;
					$n=($n+1)%5;
					if($row1['OPERATOR']==NULL)
						{
						$sql8="UPDATE output SET OPERATOR='$operator[$n]' where NUMBER='$row1[NUMBER]'";
						if(!mysqli_query($con,$sql8))
						{
							echo "Not Inserted";
						}
						if($row1['LOCATION']==NULL)
						{
						$sql9="UPDATE output SET LOCATION='$state[$k]' where NUMBER='$row1[NUMBER]'";
						if(!mysqli_query($con,$sql9))
						{
							echo "Not Inserted";
						}
						//$row1['OPERATOR']=$operator[$n];
						//$row1['LOCATION']=$state[$k];
						$k=$k+1;
						}
						}
					
				}
				
			}
			if(!mysqli_query($con,$sql7)){
				echo "not found";
			}

			break;
		}
	}	
	header("refresh:1;url=/Truecaller/search.php");
}
}
?>
</body></html>