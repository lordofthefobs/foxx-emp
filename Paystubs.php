<?php
	include 'util/sql_queries.php';
	$q = new queries();

	$period = $_POST['month']."/".$_POST['day']."/".$_POST['year'];

	$submit_type = isset($_POST["salary"]) ? 1 : (isset($_POST["submit_salary"]) ? 2 : (isset($_POST["hourly"]) ? 3 : (isset($_POST["submit_hourly"]) ? 4 : 0)));
	// submit_type
	// 	salary = 1
	// 	submit_salary = 2
	// 	hourly = 3
	// 	submit_hourly = 4
	if( $submit_type == 4){
		$emps_data = $q->get_hourly_employees();
		foreach($emps_data as $e){
			$emp_id = $e[0];
			$reg = isset($_POST["reg_$emp_id"])? (float)$_POST["reg_$emp_id"] : 0;
			$overtime = isset($_POST["overtime_$emp_id"])?(float)$_POST["overtime_$emp_id"] : 0;
			if( $reg + $overtime > 0){
				$overrate  = (float)$_POST["overrate_$emp_id"];

				$wage = $e[4];
				$note = "";
				if( isset($_POST["note_$emp_id"])){
					$note = $_POST["note_$emp_id"];
				}
				$note = "'".$note."'";
				
				$overtype = (isset($_POST["checkbox_$emp_id"]) && $_POST["checkbox_$emp_id"] == "on") ? 1 : 0;

			
				$gross_pay = ($reg * $wage);

				$total_tax = ($e[7] + $e[8] + $e[9]) * $gross_pay / 100;
				$total_ded = $e[10] + $e[11] + $e[12];
				$other_ded = (float)$_POST["other_ded_$emp_id"];
				
				if($overtype == 0){
					$gross_pay += ($overtime * $overrate);
				}else{
					$gross_pay += ($overtime * $overrate * $wage);
				}
				$total_tax_ded = $total_tax + $total_ded + $other_ded;
				$net_pay = $gross_pay - $total_tax_ded;
				$period_id = $q->get_period_id($period);

				$q->submit_hourly( $emp_id, $reg, $overtime, $overrate, $overtype, $gross_pay, $total_tax, $total_ded, $other_ded, $net_pay, $period_id, $note);
			}	
		}
	}else if( $submit_type == 2){

		$emps_data = $q->get_salary_employees();
		foreach($emps_data as $e){
			$emp_id = $e[0];
			$salary = isset($_POST["salary_$emp_id"]) ? (float)$_POST["salary_$emp_id"] : 0;
			$bonus = isset($_POST["bonus_$emp_id"]) ? (float)$_POST["bonus_$emp_id"] : 0;
			if( $salary + $bonus > 0){
				$note = "";
				if( isset($_POST["note_$emp_id"])){
					$note = $_POST["note_$emp_id"];
				}
				$note = "'".$note."'";
			
				$gross_pay = $salary;

				$total_tax = ($e[7] + $e[8] + $e[9]) * $gross_pay / 100;
				$total_ded = $e[10] + $e[11] + $e[12];
				$other_ded = (float)$_POST["other_ded_$emp_id"];

				$total_tax_ded = $total_tax + $total_ded + $other_ded;
				$net_pay = $gross_pay - $total_tax_ded;
				$period_id = $q->get_period_id($period);

				$q->submit_salary( $emp_id, $salary, $bonus, $gross_pay, $total_tax, $total_ded, $other_ded, $net_pay, $period_id, $note);
			}
		}
	}

	
	
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Foxx Beauty Supply Employee Management System - Paystubs</title>

</head>

<body>
<form name ="paystub" action="Paystubs.php" method="post">
<center>
	<input type="hidden" name="month" value="<?php echo $_POST["month"]?>">
	<input type="hidden" name="day" value="<?php echo $_POST["day"]?>">
	<input type="hidden" name="year" value="<?php echo $_POST["year"]?>">		
	<?php
		if( $submit_type==3 || $submit_type==4){ 
			$emps_data = $q->get_hourly_employees();
		}else if( $submit_type==1 || $submit_type == 2){
			$emps_data = $q->get_salary_employees();
		}

		// $emps_data = $q->get_employees();
		$stub_num = 0;
		foreach($emps_data as $e){
			$emp_id = $e[0];

			if( $submit_type > 2){
				$overtype = (isset($_POST["checkbox_$emp_id"]) && $_POST["checkbox_$emp_id"] == "on") ? 1 : 0;
				$checkbox = ($overtype==1) ? "on" : "";
			}else{
				$checkbox = "";
				$overtype = 0;
			}
			
			$go = False;
			if( $submit_type==3 || $submit_type==4){
				$reg = isset($_POST["reg_$emp_id"])? (float)$_POST["reg_$emp_id"] : 0;
				$overtime = isset($_POST["overtime_$emp_id"])?(float)$_POST["overtime_$emp_id"] : 0;
				if( $reg + $overtime > 0){
					$go = True;
				}
			}else if( $submit_type==1 || $submit_type == 2){
				$salary = isset($_POST["salary_$emp_id"]) ? (float)$_POST["salary_$emp_id"] : 0;
				$bonus = isset($_POST["bonus_$emp_id"]) ? (float)$_POST["bonus_$emp_id"] : 0;
				if ( $salary + $bonus > 0){
					$go  = True;
				}
			}
			if( $go ){ 	
				if( $submit_type == 3 || $submit_type == 4){
					$overrate = (float)$_POST["overrate_$emp_id"];
					$gross_pay = ($reg* $e[4]) ;
					$salary = 0;
					$bonus = 0;
					if( $overtype == 0){
						$gross_pay += ($overtime * $overrate);}
				}else if( $submit_type == 1 || $submit_type==2){
					$overtime = 0;
					$overrate = 0;
					$reg = 0;
					$salary = (float)$_POST["salary_$emp_id"];
					$bonus = (float)$_POST["bonus_$emp_id"];
					$gross_pay = $salary;// + $bonus;
				}
				$emp_name = $e[1];
				$type = $e[2];
				$store = $e[3];
				$wage = $e[4];
				$tax_status = $e[5];
				$fed_allowance = $e[6];
				$state_tax = $e[7] * $gross_pay / 100;
				$ss_tax = $e[8] * $gross_pay / 100;
				$med_tax = $e[9] * $gross_pay / 100;
				$fed_tax = $e[10];
				$ins_ded = $e[11];
				$other_ded = $e[12];
				
				$total_tax = $state_tax + $ss_tax + $med_tax;
				$total_ded = $fed_tax + $ins_ded + $other_ded;
				$other_ded = (float)$_POST["other_ded_$emp_id"];					
				$total_tax_ded = $total_tax + $total_ded + $other_ded;
				$net_pay = $gross_pay - $total_tax_ded;
					
	?>
	
	<input type='hidden' name='<?php echo "reg_$emp_id";?>' value='<?php echo $reg;?>'>
	<input type='hidden' name='<?php echo "overtime_$emp_id";?>' value='<?php echo $overtime;?>'>
	<input type='hidden' name='<?php echo "overrate_$emp_id";?>' value='<?php echo $overrate;?>'>
	<input type='hidden' name='<?php echo "salary_$emp_id";?>' value='<?php echo $salary;?>'>
	<input type='hidden' name='<?php echo "bonus_$emp_id";?>' value='<?php echo $bonus;?>'>
	<input type='hidden' name='<?php echo "other_ded_$emp_id";?>' value='<?php echo $other_ded;?>'>
	<input type='hidden' name='<?php echo "name_$emp_id";?>' value='<?php echo $emp_id;?>'>
	<input type='hidden' name='<?php echo "checkbox_$emp_id";?>' value='<?php echo $checkbox;?>'>
			<?php include "generate_paystubs.php";?>

	<?php
			$stub_num++;
			if( $stub_num % 3 == 0)
			echo '<p style="page-break-before: always">';
		}}
		if( $stub_num > 0 ){
			$type = ($submit_type==1 || $submit_type==2) ? "salary" : "hourly";
			if( $submit_type == 1 || $submit_type == 3 ){
				echo "<input type='submit' name='submit_$type' value='Submit'>\n";
			}else{
				echo "<input type='button' name='print' value='Print' onClick=\"window.print();\">\n";
			}
			echo "<input type='button' name='back' value='Back' onClick=\"history.go(-2)\">\n";
			echo "<input type='button' name='to_main' value='Back to Main' onClick=\"document.location='./Emp.php'\">\n";
			
		}
		if( $submit_type == 2 || $submit_type == 4){
			echo "<script> window.print();</script>\n";
		}
	?>
</center>
</form>
</body>
</html>
