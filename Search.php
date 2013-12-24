<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Foxx Beauty Supply Employee Management System - Search</title>

</head>
<?php
include "util/sql_queries.php";
$q = new queries();
if(isset($_POST["search"])){
	
	$min_period = isset($_POST["min_period"]) ? $_POST["min_period"] : "";
	$max_period = isset($_POST["max_period"]) ? $_POST["max_period"] : "";
	$emp_id = isset($_POST["employee"]) ? $_POST["employee"] : "0";
	$type_id = isset($_POST["type"]) ? $_POST["type"] : "0";
	$store_id = isset($_POST["store"]) ? $_POST["store"] : "0";
	$note = isset($_POST["note"]) ? $_POST["note"] : "";

	$result = $q->search($min_period, $max_period, $emp_id, $type_id, $store_id, $note);
	if( $result == 0 || count($result) == 0){
		?>
		<table width="100%" border="0" bgcolor="#3B5998" height="50">
		  <tr>
		    <td width="38">&nbsp;</td>
		    <td width="368"><font size="10" color="#FFFFFF">Foxx Beauty</font></td>
		    <td width="449"></td>
		  </tr>
		</table>
		<center>
		<?php
		echo "<p><h1>NO RESULT FOUND</h1>";
		?>
		</center>
		</body>
		</html>
		<?php
	}else{
		?>
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Foxx Beauty Supply Employee Management System - Paystubs</title>

		</head>

		<body>
		<center>
		<?php 
			$stub_num = 0;
		foreach($result as $r){
			$emp_id = $r[1];
			
			$e = $q->get_employee($emp_id);
			$emp_name = $e[1];
			$type = $e[2];
			$store = $e[3];
			$wage = $e[4];
			$tax_status = $e[5];
			$fed_allowance = $e[6];
			$state_tax = $e[7];
			$ss_tax = $e[8];
			$med_tax = $e[9];
			$fed_tax = $e[10];
			$ins_ded = $e[11];
			$other_ded = $e[12];
			if( count($r) == 11 ){
				$submit_type = 1;
//				null, $emp_id, $salary, $bonus, $gross_pay, $total_tax, $total_ded, $other_ded, $net_pay, $period_id, $note
				$salary = $r[2];
				$bonux = $r[3];
				$gross_pay = $r[4];
				$total_tax = $r[5];
				$total_ded = $r[6];
				$other_ded = $r[7];
				$net_pay = $r[8];
				$period_id = $r[9];
				$period = $q->get_period($period_id);
				$note = $r[10];
			}else if(count($r) == 13){
				$submit_type = 3;
// 				null, $emp_id, $reg, $overtime, $overrate, $overtype, $gross_pay, $total_tax, $total_ded, $other_ded, $net_pay, $period_id, $note
				$reg = $r[2];
				$overtime = $r[3];
				$overrate = $r[4];
				$overtype = $r[5];
				$gross_pay = $r[6];
				$total_tax = $r[7];
				$total_ded = $r[8];
				$other_ded = $r[9];
				$net_pay = $r[10];
				$period_id = $r[11];
				$period = $q->get_period($period_id);
				$note = $r[12];
			}
			include "generate_paystubs.php";
			$stub_num++;
			if( $stub_num % 3 == 0){
				echo '<p style="page-break-before: always">';
			}
		}
		
		?> 

		<input type='button' name='print' value='Print' onClick="window.print();">
		<input type='button' name='back' value='Back to Search' onClick="history.go(-1);">
		<input type='button' name='to_main' value='Back to Main' onClick="document.location = './Emp.php';">		
		</center>
		</body>
		</html>
		<?php 

	}

}else{
?>
	<body>
		<table width="100%" border="0" bgcolor="#3B5998" height="50">
		  <tr>
		    <td width="38">&nbsp;</td>
		    <td width="368"><font size="10" color="#FFFFFF">Foxx Beauty</font></td>
		    <td width="449"></td>
		  </tr>
		</table>
<p>
	<form name ="EmpInfo" action="Search.php" method="post">
		<center>
		<table border="1" frame="border" cellpadding='0' cellspacing='0'>
			<tr>

				<td>Starting:</td>
				<td>Ending:</td>
				<td>Employee</td>
				<td>Employee Type</td>
				<td>Store</td>
				<td>Note</td>
			</tr>
			<tr>
				<td>
					<select name='min_period'>
						<?php
							$periods = $q->get_periods();
							foreach($periods as $p){
								?>
								<option value="<?php echo $p[0];?>"><?php echo $p[1];?></option>
								<?php
							}
						?>
					</select>
				</td>
				<td>
					<select name='max_period'>
						<?php
							$periods = $q->get_periods();
							foreach($periods as $p){
								?>
								<option value="<?php echo $p[0];?>"><?php echo $p[1];?></option>
								<?php
							}
						?>
					</select>	
				</td>
				<td>
					<select name="employee">
						<option value=0></option>
						<?php
							$emps = $q->get_employees_id_name();
							foreach($emps as $e){
								?>
								<option value="<?php echo $e[0];?>"><?php echo $e[1];?></option>
								<?php
							}
						?>
					</select>
				</td>
				<td>
					<select name="type">
						<option value=0></option>
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
				<td>
					<select name="store">
						<option value=0></option>
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
				<td><input type='text' name='note' size=10></td>
			</tr>
			<tr>
				<td colspan=4></td>
				<td><center><input type="submit" name="search" value="Search"></center></td>
				<td><input type='button' name='to_main' value="Back to Main" onClick="document.location='./Emp.php'"></td>
		</table>
		</center>
	</form>
	</body>
<?php 
}
?>
<script language='javascript'>
	document.EmpInfo.min_period.selectedIndex = 0;
	document.EmpInfo.max_period.selectedIndex = (document.EmpInfo.max_period.length - 1);
</script>
</html>
