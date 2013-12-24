<?php
	include "util/sql_queries.php";
	$q = new queries();	
	
	if( isset($_POST['edit'])){
		$data = array();
		$name = $_POST['name'];
		$name = "\"".$name."\"";
		$emp_id = $_POST['emp_id'];
		$data['emp_name'] = $name;
		$data['type_id'] = $_POST['type'];
		$data['store_id'] = $_POST['store'];
		$data['wage'] = $_POST['wage'];
		$data['tax_status'] = $_POST['tax_status'];
		$data['fed_allowance'] = $_POST['fed_allowance'];
		$data['state_tax'] = $_POST['state_tax'];
		$data['ss_tax'] = $_POST['ss_tax'];
		$data['med_tax'] = $_POST['med_tax'];
		$data['fed_tax'] = $_POST['fed_tax'];
		$data['ins_ded'] = $_POST['ins_ded'];
		$data['other_ded'] = $_POST['other_ded'];
		$q->edit_employee($emp_id, $data);
		header("Location:./EmpInfo.php");
	}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Foxx Beauty Supply Employee Management System - Edit Employee</title>

</head>

<body>
	<table width="100%" border="0" bgcolor="#3B5998" height="50">
	  <tr>
	    <td width="38">&nbsp;</td>
	    <td width="368"><font size="10" color="#FFFFFF">Foxx Beauty</font></td>
	    <td width="449"></td>
	  </tr>
	</table>

<?php
	$emp_id = $_GET['emp_id'];
	$emp_data = $q->get_employee($emp_id);
	// echo "emp_id = ".$emp_id."\n";
	// print_r($emp_data);
?>
<form name ="NewEmp" action="EditEmp.php" method="post">
	<table width="100%" border="1" frame="border" cellpadding='0' cellspacing='0'>
		<tr height="20"></tr>
		
		<tr height="50">
			<input name="emp_id" type='hidden' value="<?php echo $emp_id;?>" >
			<td width="10%" bgcolor="#B1C3D9"><center>Name</center></td>
			<td width="90%" bgcolor="#B1C3D9"><input type='text' name='name' value="<?php echo $emp_data[1]?>"></td>
		</tr>
		<tr height="50">
			<td width="10%" bgcolor="#B1C3D9"><center>Type</center></td>
			<td width="90%" bgcolor="#B1C3D9">
				<select name="type">
					<?php
						$type_id = $emp_data[2];
						$types = $q->get_types();
						foreach($types as $t){
							?> 
							<option 
								value="<?php echo $t[0];?>" 
								<?php if( $type_id == $t[0]){ echo " selected";}?>
								><?php echo $t[1];?>
							</option>
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
						$store_id = $emp_data[3];
						$stores = $q->get_stores();
						foreach($stores as $s){
							?>
							<option 
								value="<?php echo $s[0];?>"
								<?php if( $store_id == $s[0]){ echo " selected";}?>
								><?php echo $s[1];?>
							</option>
							<?php
						}
					?>
				</select>
			</td>
		</tr>
		<tr height="50">
			<td width="10%" bgcolor="#B1C3D9"><center>Wage</center></td>
			<td width="90%" bgcolor="#B1C3D9"><input type='text' name='wage' value="<?php echo $emp_data[4]?>"></td>
		</tr>
		<tr height="50">
			<td width="10%" bgcolor="#B1C3D9"><center>Tax Status</center></td>
			<td width="90%" bgcolor="#B1C3D9"><input type='text' name='tax_status' value="<?php echo $emp_data[5]?>"></td>
		</tr>
		<tr height="50">
			<td width="10%" bgcolor="#B1C3D9"><center>Federal<br>Allowance</center></td>
			<td width="90%" bgcolor="#B1C3D9"><input type='text' name='fed_allowance' value="<?php echo $emp_data[6]?>"></td>
		</tr>
		<tr height="50">
			<td width="10%" bgcolor="#B1C3D9"><center>State Tax</center></td>
			<td width="90%" bgcolor="#B1C3D9"><input type='text' name='state_tax' value="<?php echo $emp_data[7]?>"></td>
		</tr>
		<tr height="50">
			<td width="10%" bgcolor="#B1C3D9"><center>Social Security Tax</center></td>
			<td width="90%" bgcolor="#B1C3D9"><input type='text' name='ss_tax' value="<?php echo $emp_data[8]?>"></td>
		</tr>
		<tr height="50">
			<td width="10%" bgcolor="#B1C3D9"><center>Medical Tax</center></td>
			<td width="90%" bgcolor="#B1C3D9"><input type='text' name='med_tax' value="<?php echo $emp_data[9]?>"></td>
		</tr>
		<tr height="50">
			<td width="10%" bgcolor="#B1C3D9"><center>Federal Income Tax</center></td>
			<td width="90%" bgcolor="#B1C3D9"><input type='text' name='fed_tax' value="<?php echo $emp_data[10]?>"></td>
		</tr>
		<tr height="50">
			<td width="10%" bgcolor="#B1C3D9"><center>Insurance Deductible</center></td>
			<td width="90%" bgcolor="#B1C3D9"><input type='text' name='ins_ded' value="<?php echo $emp_data[11]?>"></td>
		</tr>
		<tr height="50">
			<td width="10%" bgcolor="#B1C3D9"><center>Other Regular Deductible</center></td>
			<td width="90%" bgcolor="#B1C3D9"><input type='text' name='other_ded' value="<?php echo $emp_data[12]?>"></td>
		</tr>

		<tr height="40">
	 		<td><center>
				<input name="edit" type="submit" value="Submit">
			</center></td>
			<td align="right">
				<input type='button' name='cancel' value="Cancel" onClick="document.location='./EmpInfo.php'">
				<input type='button' name='to_main' value="Back to Main" onClick="document.location='./Emp.php'">
			</td>
		</tr>
	</table>
</form>
</body>
</html>
