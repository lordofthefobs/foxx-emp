<?php
	if( isset($_POST['submit'])){
		$action = $_POST["action"];
		if($action == "EmpInfo"){
			$URL = "./EmpInfo.php";
		}else if($action == "Salary"){
			$URL = "./Salary.php"; 
		}else if($action == "Hourly"){
			$URL = "./Hourly.php";
		}else if($action == "Search"){
			$URL = "./Search.php";
		}else if($action == "Report"){
			$URL = "./reports/";
		}
		// else if($action == "Backup"){
		// 			$URL = "./Backup.php";
		// 		}
		header("Location:$URL");
	}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Foxx Beauty Employee Management System</title>

</head>

<body>
	<table width="100%" border="0" bgcolor="#3B5998" height="50">
	  <tr>
	    <td width="38">&nbsp;</td>
	    <td width="368"><font size="10" color="#FFFFFF">Foxx Beauty</font></td>
	    <td width="449"></td>
	  </tr>
	</table>

<form name ="adminAction" action="Emp.php" method="post">
	<table width="100%" border="0" frame="border">
		<tr height="20"></tr>

		<tr height="100">
			<td width="38">&nbsp;</td>
			<td width="368" bgcolor="#B1C3D9"><center>Choose Action:</center></td>
			<td width="449" bgcolor="#B1C3D9">
				<table width="250">
					<tr>
						<td><label>
							<input type="radio" name="action" value="EmpInfo" checked>
							Employee Information
						</label></td>
					</tr>
					<tr>
						<td><label>
							<input type="radio" name="action" value="Salary">
							Salary Payroll
						</label></td>
					</tr>
					<tr>
						<td><label>
							<input type="radio" name="action" value="Hourly">
							Hourly Payroll</label></td>
					</tr>
					<tr>
						<td><label>
							<input type="radio" name="action" value="Search">
							Search Paystubs</label></td>
					</tr>
					<tr>
						<td>
						<label>
							<input type="radio" name="action" value="Report">
							Reports
						</label>
						</td>
					</tr>
					<!-- <tr>
											<td><label>
												<input type="radio" name="action" value="Backup">
												Backup Database</label></td>
										</tr> -->
				</table>
			</td>
		</tr>
		<tr height="40">
	 		<td colspan=3><center>
				<input name="submit" type="submit" value="Submit">
			</center></td>
		</tr>
	</table>
</form>
</body>
</html>
