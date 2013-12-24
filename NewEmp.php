<?php
	include "util/sql_queries.php";
	$q = new queries();	
	
	if( isset($_POST['submit'])){
		$data = array();
		$name = $_POST['name'];
		$name = "\"".$name."\"";
		$data[] = $name;
		$data[] = $_POST['type'];
		$data[] = $_POST['store'];
		$data[] = $_POST['wage'];
		$data[] = $_POST['tax_status'];
		$data[] = $_POST['fed_allowance'];
		$data[] = $_POST['state_tax'];
		$data[] = $_POST['ss_tax'];
		$data[] = $_POST['med_tax'];
		$data[] = $_POST['fed_tax'];
		$data[] = $_POST['ins_ded'];
		$data[] = $_POST['other_ded'];
		$q->new_employee($data);
		header("Location: ./EmpInfo.php");
	}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Foxx Beauty Supply Employee Management System - New Employee</title>

</head>

<body>
	<table width="100%" border="0" bgcolor="#3B5998" height="50">
	  <tr>
	    <td width="38">&nbsp;</td>
	    <td width="368"><font size="10" color="#FFFFFF">Foxx Beauty</font></td>
	    <td width="449"></td>
	  </tr>
	</table>

<form name ="NewEmp" action="NewEmp.php" method="post">
	<table width="100%" border="1" frame="border" cellpadding='0' cellspacing='0'>
		<tr height="20"></tr>

		<tr height="50">
			<td width="10%" bgcolor="#B1C3D9"><center>Name</center></td>
			<td width="90%" bgcolor="#B1C3D9"><input type='text' name='name'></td>
		</tr>
		<tr height="50">
			<td width="10%" bgcolor="#B1C3D9"><center>Type</center></td>
			<td width="90%" bgcolor="#B1C3D9">
				<select name="type">
					<?php
						$types = $q->get_types();
						foreach($types as $t){
							?> 
							<option value="<?php echo $t[0];?>"><?php echo $t[1];?></option>
							<?php
						}
					?>
				</select>
			</td>
		</tr>
		<tr height="50">
			<td width="10%" bgcolor="#B1C3D9"><center>Store</center></td>
				
			<td width="90%" bgcolor="#B1C3D9">
				<select name="store">
					<?php
						$stores = $q->get_stores();
						foreach($stores as $s){
							?>
							<option value="<?php echo $s[0];?>"><?php echo $s[1];?></option>
							<?php
						}
					?>
				</select>
			</td>
		</tr>
		<tr height="50">
			<td width="10%" bgcolor="#B1C3D9"><center>Wage</center></td>
			<td width="90%" bgcolor="#B1C3D9"><input type='text' name='wage' value=0.0></td>
		</tr>
		<tr height="50">
			<td width="10%" bgcolor="#B1C3D9"><center>Tax Status</center></td>
			<td width="90%" bgcolor="#B1C3D9"><input type='text' name='tax_status' value=0.0></td>
		</tr>
		<tr height="50">
			<td width="10%" bgcolor="#B1C3D9"><center>Federal<br>Allowance</center></td>
			<td width="90%" bgcolor="#B1C3D9"><input type='text' name='fed_allowance' value=0.0></td>
		</tr>
		<tr height="50">
			<td width="10%" bgcolor="#B1C3D9"><center>State Tax</center></td>
			<td width="90%" bgcolor="#B1C3D9"><input type='text' name='state_tax' value=0.0></td>
		</tr>
		<tr height="50">
			<td width="10%" bgcolor="#B1C3D9"><center>Social Security Tax</center></td>
			<td width="90%" bgcolor="#B1C3D9"><input type='text' name='ss_tax' value=0.0></td>
		</tr>
		<tr height="50">
			<td width="10%" bgcolor="#B1C3D9"><center>Medical Tax</center></td>
			<td width="90%" bgcolor="#B1C3D9"><input type='text' name='med_tax' value=0.0></td>
		</tr>
		<tr height="50">
			<td width="10%" bgcolor="#B1C3D9"><center>Federal Income Tax</center></td>
			<td width="90%" bgcolor="#B1C3D9"><input type='text' name='fed_tax' value=0.0></td>
		</tr>
		<tr height="50">
			<td width="10%" bgcolor="#B1C3D9"><center>Insurance Deductible</center></td>
			<td width="90%" bgcolor="#B1C3D9"><input type='text' name='ins_ded' value=0.0></td>
		</tr>
		<tr height="50">
			<td width="10%" bgcolor="#B1C3D9"><center>Other Regular Deductible</center></td>
			<td width="90%" bgcolor="#B1C3D9"><input type='text' name='other_ded' value=0.0></td>
		</tr>

		<tr height="40">
	 		<td><center>
				<input name="submit" type="submit" value="Submit">
			</center></td>
			<td align="right">
				<input type='button' name='cancel' value="Cancel" onClick="document.location='./EmpInfo.php';">
				<input type='button' name='to_main' value="Back to Main" onClick="document.location='./Emp.php'">
			</td>
		</tr>
	</table>
</form>
</body>
</html>
