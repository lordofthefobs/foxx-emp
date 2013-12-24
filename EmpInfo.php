<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Foxx Beauty Supply Employee Management System - Employee Information</title>

<script type="text/javascript">
	function edit(){
		var i = 0;
		var loc = "./EditEmp.php?emp_id="
		var found = false;
		for( i = 0; i < document.EmpInfo.emp.length; i++){
			if( document.EmpInfo.emp[i].checked){
				var emp_id = document.EmpInfo.emp[i].value;
				var loc = loc + emp_id;
				found = true;	
			}
		}
		if( found ){
			document.location=loc;
		}else{
			alert("Please select an Employee to edit");
		}

	}
</script>
		
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
	include "util/sql_queries.php";
	$q = new queries();
	if (isset($_POST['inactive'])){
		$emps = $q->get_inactive_employees();
	}else{
		$emps = $q->get_active_employees();
	}
	$color = False;
?>
<form name ="EmpInfo" action="EmpInfo.php" method="post">
	<table width="100%" border="1" frame="border" cellpadding='0' cellspacing='0'>
		<tr height="20"></tr>
		<tr height="50">
			<td width="5" bgcolor="#B1C3D9"> <center></td>
			<td width="10" bgcolor="#B1C3D9"><center>ID</center></td>
			<td width="70" bgcolor="#B1C3D9"><center>Name</center></td>
			<td width="10" bgcolor="#B1C3D9"><center>Type</center></td>
			<td width="10" bgcolor="#B1C3D9"><center>Store</center></td>
			<td width="10" bgcolor="#B1C3D9"><center>Wage</center></td>
			<td width="10" bgcolor="#B1C3D9"><center>Tax Status</center></td>
			<td width="10" bgcolor="#B1C3D9"><center>Federal<br>Allowance</center></td>
			<td width="10" bgcolor="#B1C3D9"><center>State Tax</center></td>
			<td width="10" bgcolor="#B1C3D9"><center>Social Security Tax</center></td>
			<td width="10" bgcolor="#B1C3D9"><center>Medical Tax</center></td>
			<td width="10" bgcolor="#B1C3D9"><center>Federal Income Tax</center></td>
			<td width="10" bgcolor="#B1C3D9"><center>Insurance Deductible</center></td>
			<td width="10" bgcolor="#B1C3D9"><center>Other Regular Deductible</center></td>
		</tr>
		<?php
			foreach( $emps as $e ){
				$emp_id 	= $e[0];
				$emp_name 	= $e[1];
				$type_id 	= $e[2];
				$store_id 	= $e[3];
				$wage 		= number_format($e[4], 2); 
				$tax_status = $e[5]; 
				$fed_allowance 	= $e[6]; 
				$state_tax 		= $e[7]; 
				$ss_tax 		= $e[8]; 
				$med_tax 		= $e[9]; 
				$fed_tax 		= $e[10];
				$ins_ded 		= $e[11];
				$other_ded 		= $e[12];
				$type = $q->get_type_name($type_id);
				$store = $q->get_store_name($store_id);
				
				?>
				<tr height="30">
					<td width = "5">	<input type="radio" name="emp" value=<?php echo $e[0];?>>
					</td>
					<td width ="10" <?php if($color){ ?> bgcolor="B1C3D9"<?php } ?>> <center> <?php echo $emp_id;		?></center></td>
					<td width ="70" <?php if($color){ ?> bgcolor="B1C3D9"<?php } ?>> <center> <?php echo $emp_name;		?></center></td>
					<td width ="10" <?php if($color){ ?> bgcolor="B1C3D9"<?php } ?>> <center> <?php echo $type; 		?></center></td>
					<td width ="10" <?php if($color){ ?> bgcolor="B1C3D9"<?php } ?>> <center> <?php echo $store;		?></center></td>
					<td width ="10" <?php if($color){ ?> bgcolor="B1C3D9"<?php } ?>> <center> <?php echo $wage;		 	?></center></td>
					<td width ="10" <?php if($color){ ?> bgcolor="B1C3D9"<?php } ?>> <center> <?php echo $tax_status; 	?></center></td>
					<td width ="10" <?php if($color){ ?> bgcolor="B1C3D9"<?php } ?>> <center> <?php echo $fed_allowance;?></center></td>
					<td width ="10" <?php if($color){ ?> bgcolor="B1C3D9"<?php } ?>> <center> <?php echo $state_tax ;	?></center></td>
					<td width ="10" <?php if($color){ ?> bgcolor="B1C3D9"<?php } ?>> <center> <?php echo $ss_tax 	; 	?></center></td>
					<td width ="10" <?php if($color){ ?> bgcolor="B1C3D9"<?php } ?>> <center> <?php echo $med_tax 	;   ?></center></td>
					<td width ="10" <?php if($color){ ?> bgcolor="B1C3D9"<?php } ?>> <center> <?php echo $fed_tax	;	?></center></td>
					<td width ="10" <?php if($color){ ?> bgcolor="B1C3D9"<?php } ?>> <center> <?php echo $ins_ded 	;   ?></center></td>
					<td width ="10" <?php if($color){ ?> bgcolor="B1C3D9"<?php } ?>> <center> <?php echo $other_ded ;	?></center></td>
		<?php $color = ($color +1)%2;}                                        
		?>
		
		
		<tr height="40">
	 		<td colspan=3><center>
				<input type="button" name="submit" value="New" onClick="document.location='./NewEmp.php';">
				<input type="button" name="submit" value="Edit" onClick="edit();" >
			</center></td>
			<td colspan=2><center>
				<?php
					if( isset($_POST['inactive']) ){
						echo '<input type="submit" name="active" value="View Active Employees" >';
					}else{
						echo '<input type="submit" name="inactive" value="View Inactive Employees" >';
					}
				?>
			</center></td>
			<td colspan=8 border=0></td>
			<td width="10">
			<center>
				<input type='button' name="to_main" value="Back to Main" onClick="document.location='./Emp.php';">
			</center>
			</td>
		</tr>
	</table>
</form>
</body>
</html>
