<?php
	include "util/sql_queries.php";
	$q = new queries();
	date_default_timezone_set("US/Central");	
?>
<script type="text/javascript">
	function update(emp_id, h){

		var hourly = parseFloat(h);
		// alert( isNaN(document.getElementById('reg_' + emp_id).value));
		var reg = document.getElementById('reg_' + emp_id).value;
		var overtime = document.getElementById('overtime_'+emp_id).value;
		var overrate = document.getElementById('overrate_'+emp_id).value;
		var other_ded = document.getElementById('other_ded_'+emp_id).value;

		if( isNaN(reg)){
			alert("Please Enter a number for Regular Hours Worked");
		}else if( isNaN(overtime)){
			alert("Please Enter a number for Overtime Hours");
		}else if( isNaN(overrate)){
			alert("Please Enter a number for Overtime Rate");
		}else if( isNaN(other_ded)){
			alert("Please Enter a number for Other Deductions");
		}else{
			reg = parseFloat(reg);
			overtime = parseFloat(overtime);
			overrate = parseFloat(overrate);			
			other_ded = parseFloat(other_ded);
			var total_tax = parseFloat(document.getElementById('total_tax_'+emp_id).value);
			var total_ded = parseFloat(document.getElementById('total_ded_'+emp_id).value);

			var gross_pay = document.getElementById('gross_pay_'+emp_id);
			var taxes = document.getElementById('taxes_'+emp_id);
			var net_pay = document.getElementById('net_pay_'+emp_id);
			
			var checked = document.getElementById('checkbox_'+emp_id).checked;
			var total_pay = (reg * hourly);
			if( checked ){
				total_pay += (overtime*overrate);
			}else{
				total_pay += (overtime*overrate*hourly);
			}
			
			// var total_pay = (reg * hourly) + (overtime*overrate*hourly);
			var tax = total_pay * total_tax / 100;
		
			gross_pay.innerHTML = total_pay.toFixed(2);
			taxes.innerHTML = (tax + total_ded).toFixed(2);
			net_pay.innerHTML = (total_pay - (tax + total_ded + other_ded)).toFixed(2);
		}
	}
	function check_date(t){
		if( t == 'm'){
			var month = parseInt(document.hourly_form.month.value);
			if( month <= 0 || month > 12){
				alert( "Please Enter valid month");
			}
		}else if(t == 'd'){
			var day = parseInt(document.hourly_form.day.value);

			if( day <= 0 || day > 31){
				alert("Please Enter a valid day");
			}
		}else if(t == 'y'){
			var year = parseInt(document.hourly_form.year.value);
			if( year <= 2000 || year > 2099){
				alert("Please Enter a valid year");
			}
		}
	}
	function toggle_all(){
		var max = parseInt(document.getElementById('max_emp_id').value);
		var checkall = document.getElementById('checkall').checked;

		var i = 0;
		for( i = 1; i <= max; ++i){
			try{
				document.getElementById('checkbox_'+i).checked = checkall;
				toggle(i)
			}
			catch(erro){
				
			}
		}

	}
	function toggle(emp_id){
		var checked = document.getElementById('checkbox_'+emp_id).checked;
		var hourly = document.getElementById('hourly_'+emp_id).value;
		var overrate = document.getElementById('overrate_'+emp_id);
		hourly = parseFloat(hourly);
		var or = parseFloat(overrate.value);
		if( checked ){
			overrate.value = (or * hourly).toFixed(2);
		}else{
			overrate.value = (or / hourly);
		}
		update(emp_id, hourly);
	}
</script>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Foxx Beauty Employee Management System - Hourly Payroll Calculator</title>

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
$emp_data = $q->get_hourly_employees();
?>
<p>
<form name ="hourly_form" action="Paystubs.php" method="post">
	<center>
		<table border="1" frame="border" cellpadding='0' cellspacing='0'>
			<tr>
				<td colspan=2>Period Ending in:</td>
				<td colspan=9><input type="text" name="month" size=2 value='<?php echo date("m")?>' onChange="check_date('m');">
					/ <input type="text" name="day" size=2 value='<?php echo date("d")?>' onChange="check_date('d')">
					/ <input type="text" name="year" size=4 value='<?php echo date("Y")?>' onChange="check_date('y')"></td>
			</tr>
			<tr></tr>
			<tr>
				<td width="30">ID</td>
				<td width="200">Name</td>
				<td width="30">Regular Hours</td>
				<td width="100">Overtime</td>
				<td width="10"><input type="checkbox" name="checkall" id="checkall" onChange="toggle_all()"></td>
				<td width="100">Overrate</td>
				<td width="70">Gross Pay</td>
				<td width="70">Taxes and<br>Deductions</td>
				<td width="70">Other<br>Deductions</td>
				<td width="70">Net Pay</td>
				<td width="100">Note</td>
			</tr>
			<?php
			$max_emp_id = 0;
				foreach($emp_data as $e){
					$total_tax = $e[7] + $e[8] + $e[9];
					$total_ded = $e[10] + $e[11] + $e[12];
					$emp_id = $e[0];
					?>
						<tr>
							<input type='hidden' name='total_tax_<?php echo $emp_id;?>' id='total_tax_<?php echo $emp_id;?>' value='<?php echo $total_tax;?>'>
							<input type='hidden' name='total_ded_<?php echo $emp_id;?>' id='total_ded_<?php echo $emp_id;?>' value='<?php echo $total_ded;?>'>
							<input type='hidden' id='hourly_<?php echo $emp_id;?>' value='<?php echo $e[4]?>'>
							<td width="10"><?php echo $emp_id?></td>
							<td width="10"><?php echo $e[1]?></td>
							<td width="10"><input type='text' name='reg_<?php echo $emp_id;?>' id='reg_<?php echo $emp_id;?>' onChange="update(<?php echo $emp_id.", ".$e[4];?>);" value=0.00></td>
							<td width="10"><input type='text' name='overtime_<?php echo $emp_id;?>' id='overtime_<?php echo $emp_id;?>' onChange="update(<?php echo $emp_id.", ".$e[4];?>);" value=0.00></td>
							<td width="10"><input type='checkbox' name='checkbox_<?php echo $emp_id;?>' id='checkbox_<?php echo $emp_id;?>' onChange="toggle(<?php echo $emp_id;?>)"></td>
							<td width="10"><input type='text' name='overrate_<?php echo $emp_id;?>' id='overrate_<?php echo $emp_id;?>' onChange="update(<?php echo $emp_id.", ".$e[4];?>);" value=1.5></td>
							<td width="10"><label name='gross_pay_<?php echo $emp_id;?>' id='gross_pay_<?php echo $emp_id;?>'>0.0</label></td>
							<td width="10"><label name='taxes_<?=$emp_id;?>' id='taxes_<?php echo $emp_id;?>'>0.00</label></td>
							<td width="10"><input type='text' name='other_ded_<?php echo $emp_id;?>' id='other_ded_<?php echo $emp_id;?>' onChange="update(<?php echo $emp_id.", ".$e[4];?>);" value=0.00></td>
							<td width="10"><label name='net_pay_<?php echo $emp_id;?>' id='net_pay_<?php echo $emp_id;?>'>0.00</label></td>
							<td width="10"><input type='text' name='note_<?php echo $emp_id;?>' value=" "></td>
						</tr>
					<?php
					$max_emp_id = max($emp_id, $max_emp_id);
				}
				echo "<input type='hidden' id='max_emp_id' value='$max_emp_id'>";
			?>
			<tr>
				<td colspan=2><input type="submit" name="hourly" value="Submit"></td>
				
				<td colspan=7 border=0></td>
				<td width="10">
				<center>
					<input type='button' name="to_main" value="Back to Main" onClick="document.location='./Emp.php';">
				</center>
				</td>
			</tr>
		</table>
	</center>
</form>
</body>
</html>
