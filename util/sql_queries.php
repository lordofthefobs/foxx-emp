<?php
	class queries {
		public $conn;
		public $c;
		function __construct(){
			$c = mysql_connect('127.0.0.1', 'foxx', 'cw3651');
			mysql_select_db('foxx_emp');
			date_default_timezone_set("US/Central");
		}		
		
// getters
		
		function get_employees(){
			$query = "SELECT * FROM employees";
			return $this->get_results($query);
		}
		
		function get_active_employees(){
			$query = "SELECT * FROM employees WHERE type_id > 2";
			return $this->get_results($query);
		}
		
		function get_inactive_employees(){
			$query = "SELECT * FROM employees WHERE type_id <= 2";
			return $this->get_results($query);
		}
		
		function get_salary_employees(){
			$query = "SELECT * FROM employees WHERE type_id=3";
			return $this->get_results($query);
		}
		
		function get_hourly_employees(){
			$query = "SELECT * FROM employees WHERE type_id=4";
			return $this->get_results($query);
		}
		
		function get_employee($emp_id){
			$query ="SELECT * FROM employees WHERE emp_id=".$emp_id;
			$q = mysql_query($query);
			if( $q == false){
				return $q;
			}else{
				$r =  mysql_fetch_row($q);
				return $r;
			}
		}
		
		function get_employees_id_name(){
			$query = "SELECT emp_id, emp_name FROM employees";
			return $this->get_results($query);
		}
		
		function get_types(){
			$query = "SELECT * FROM types";
			return $this->get_results($query);
		}
		
		function get_type_name($type_id){
			$query = "SELECT type_name FROM types WHERE type_id = $type_id";
			$q = mysql_query($query);
			$r =  mysql_fetch_row($q);
			return $r[0];
		}
		
		function get_stores(){
			$query = "SELECT * FROM stores";
			return $this->get_results($query);
		}
		
		function get_store_name($store_id){
			$query = "SELECT store_name FROM stores WHERE store_id = $store_id";
			$q = mysql_query($query);
			$r =  mysql_fetch_row($q);
			return $r[0];
		}

		function get_period_id($period){
			$p = split("/", $period);
			$month = $p[0];
			$day = $p[1];
			$year = $p[2];
			$date = "$year/$month/$day";
			$q = mysql_query("SELECT period_id FROM periods WHERE period_date = '$date'");
			if( mysql_num_rows($q) == 0){
				mysql_query("INSERT INTO periods VALUES( null, '$date')");
				$q = mysql_query("SELECT period_id FROM periods WHERE period_date = '$date'");
			}
			$r = mysql_fetch_row($q);
			return $r[0];
		}
		
		function get_period($period_id){
			$q = mysql_query("SELECT * FROM periods WHERE period_id = $period_id");
			if( mysql_num_rows($q) == 0 ){
				return 0;
			}
			$r = mysql_fetch_row($q);
			return $r[1];
		}
		
		function get_periods(){
			$query = "SELECT * FROM periods ORDER BY period_date";

			return $this->get_results($query);
		}

		
// management functions

		function new_employee( $data ){
			$query = "INSERT INTO employees VALUES(NULL";
			foreach ($data as $d){
				$query .= ", ".$d;
			}
			$query .= ")";
 			$this->submit_query($query);
		}
		
		function edit_employee($emp_id, $data){
			$query = "UPDATE employees SET ";
			$keys = array_keys($data);
			foreach($keys as $k){
				$d = $data[$k];
				$query .= $k."=".$d.", ";
			}
			$query = substr($query, 0, -2);
			$query .= " WHERE emp_id=".$emp_id;
			$this->submit_query($query);
		}

// paystub functions	
		function submit_hourly($emp_id, $reg, $overtime, $overrate, $overtype, $gross_pay, $total_tax, $total_ded, $other_ded, $net_pay, $period_id, $note){
			$query = "SELECT hourly_id FROM hourly WHERE emp_id = $emp_id AND period_id = $period_id;";
			$q = $this->get_results($query);
			if( $q != 0 ){
				$hourly_id = $q[0][0];
				$query = "DELETE FROM hourly WHERE hourly_id = $hourly_id;";
				$this->submit_query($query);
				
			}
			$query = "INSERT INTO hourly VALUES( null, $emp_id, $reg, $overtime, $overrate, $overtype, $gross_pay, $total_tax, $total_ded, $other_ded, $net_pay, $period_id, $note )";
			$this->submit_query($query);
		}
		
		function submit_salary($emp_id, $salary, $bonus, $gross_pay, $total_tax, $total_ded, $other_ded, $net_pay, $period_id, $note){
			$query = "SELECT salary_id FROM salary WHERE emp_id = $emp_id AND period_id = $period_id;";
			$q = $this->get_results($query);
			if( $q != 0 ){
				$salary_id = $q[0][0];
				$query = "DELETE FROM salary WHERE salary_id = $salary_id;";
				$this->submit_query($query);
				
			}	
			$query = "INSERT INTO salary VALUES( null, $emp_id, $salary, $bonus, $gross_pay, $total_tax, $total_ded, $other_ded, $net_pay, $period_id, $note)";
			$this->submit_query($query);
		}

// for search

		function search($min_period, $max_period, $emp_id, $type_id, $store_id, $note){
			$emp_id = (int)$emp_id;
			$type_id = (int)$type_id;
			$store_id = (int)$store_id;
			$matches= $this->check_match($emp_id, $type_id, $store_id);
			if( $matches== 0 ){
				return 0;
			}
			$periods = $this->get_periods_between($min_period, $max_period);
			if( $matches== 1 && $periods == 0 && $note == ""){
				return 0;
			}
			if( $type_id < 3){
				$result = array();
				$sal_result = $this->query_salary($matches, $periods, $note);
				$hour_result = $this->query_hourly($matches, $periods, $note);
				if( $sal_result != 0 ){
					$result = array_merge($result, $sal_result);
				}
				if( $hour_result != 0 ){
					$result = array_merge($result, $hour_result);
				}
			}else if($type_id == 3){
				$result = $this->query_salary($matches, $periods, $note);
			}else if($type_id == 4){
				$result = $this->query_hourly($matches, $periods, $note);
			}
			return $result;
	
		}

		function get_min_period(){
			$query = "SELECT MIN(period_date) FROM periods;";
			$q = mysql_query($query);
			if( mysql_num_rows($q) == 0 ){
				return False;
			}
			$r = mysql_fetch_row($q);
			$min_date = $r[0];
			return $min_date;
			
		}
		
		function get_max_period(){
			$query = "SELECT MAX(period_date) FROM periods;";
			$q = mysql_query($query);
			if( mysql_num_rows($q) == 0 ){
				return False;
			}
			$r = mysql_fetch_row($q);
			$max_date = $r[0];
			return $max_date;
			
		}
		
		
		
		
// Private Functions {}

		private function query_salary($matches, $periods, $note){

			$query = "SELECT * FROM salary WHERE ";
			$emp_query = "";
			$period_query = "";
			$sub_queries = array();
			if( $periods != 0){
				$p = $periods[0][0];
				$period_query = "(period_id = ".$p;
				$num_periods = count($periods);
				for( $i = 1; $i < $num_periods; ++$i){
					$p = $periods[$i][0];
					$period_query .= " OR period_id=$p";
				}
				$period_query .=")";
				$sub_queries[] = $period_query;
			}
			if($matches != 1){
				$e = $matches[0][0];
				$emp_query = "(emp_id = $e";
				$num_matches = count($matches);
				for( $i = 1; $i < $num_matches; ++$i){
					$e = $matches[$i][0];
					$emp_query .= " OR emp_id=$e";
				}
				$emp_query .= ")";
				
				$sub_queries[] = $emp_query;
			}
			if($note != ""){
				$note_query = "note LIKE '%$note%'";
				$sub_queries[] = $note_query;
			}
			
			$query .= $sub_queries[0];
			for($i = 1; $i < count($sub_queries); ++$i){
				$s = $sub_queries[$i];
				$query .= " AND $s";
			}
			
			return $this->get_results($query);
		}
		
		private function query_hourly($matches, $periods, $note){
			
			$query = "SELECT * FROM hourly WHERE ";
			$emp_query = "";
			$period_query = "";
			$sub_queries = array();
			if( $periods != 0){
				$p = $periods[0][0];
				$period_query = "(period_id = ".$p;
				$num_periods = count($periods);
				for( $i = 1; $i < $num_periods; ++$i){
					$p = $periods[$i][0];
					$period_query .= " OR period_id=$p";
				}
				$period_query .=")";
				$sub_queries[] = $period_query;
			}
			if($matches!= 1){
				$e = $matches[0][0];
				$emp_query = "(emp_id = $e";
				$num_matches = count($matches);
				for( $i = 1; $i < $num_matches; ++$i){
					$e = $matches[$i][0];
					$emp_query .= " OR emp_id=$e";
				}
				$emp_query .= ")";
				
				$sub_queries[] = $emp_query;
			}
			if($note != ""){
				$note_query = "note LIKE '%$note%'";
				$sub_queries[] = $note_query;
			}
			
			$query .= $sub_queries[0];
			for($i = 1; $i < count($sub_queries); ++$i){
				$s = $sub_queries[$i];
				$query .= " AND $s";
			}
			
			return $this->get_results($query);
			
			
			
		}
		
		private function check_match($emp_id, $type_id, $store_id){
			if( $emp_id + $type_id + $store_id == 0 ){
				return 1;
			}
			$query = "SELECT emp_id From employees WHERE ";
			$length = strlen($query);
			$len = strlen($query);
			if( $emp_id != 0 ){
				$query .= " emp_id = '$emp_id' ";
				$len = strlen($query);
			}
			if( $type_id != 0 ){
				if( $len != $length){
					$query .="AND";
					// $length = strlen($query);
				}
				$query .= " type_id = '$type_id' ";
				$len = strlen($query);
			}
			if( $store_id != 0 ){
				if( $len != $length){
					// $length = strlen($query);
					$query .="AND";
				}
				$query .= " store_id = '$store_id' ";
				$len = strlen($query);
			}
			// $q = mysql_query($query);
			return $this->get_results($query);
		}
		
		
		private function get_periods_between($min_id, $max_id){
			$query = "SELECT period_id FROM periods WHERE";
			$length = strlen($query);
			if( $min_id != "default"){
				$min = $this->get_period($min_id);
				$query .= " period_date >= '$min'";
				if( $max != "default"){
					$max = $this->get_period($max_id);
					$query .= " AND period_date <= '$max'";
				}
			}else if($max_id != "default"){

				$max = $this->get_period($max_id);
				$query .= " period_date <= '$max'";
			}
			if( $length == strlen($query)){
				return 0;
			}
			return $this->get_results($query);
		}
		
		private function get_user_id($username){
			$query = "SELECT user_id FROM users WHERE username='$username';";
			$q = mysql_query($query);
			$r = mysql_fetch_row($q);
			return $r[0];
		}
		
		private function submit_query($query){
			// print $query;
			// echo "<script type='text/javascript'>alert($query);</script>";
			// print $query;
			mysql_query($query);
		}
		private function get_results($query){

			$q = mysql_query($query);;
			if( mysql_num_rows($q) == 0){
				return 0;
			}
			$results = array();
			while( $r = mysql_fetch_row($q) ){
				$results[] = $r;
			}
			return $results;
		}

		
/** Login functions
	Not used
		function backup(){
			try{
				$backupFile = "./backup/foxx_emp" . date("Y-m-d-H-i-s") . '.gz';
				$command = "mysqldump --opt -h localhost -u foxx -p cw3651 foxx_emp | gzip > $backupFile";
				echo $command;
				system($command);
				echo "SUCCESS";
			}catch(Exception $e){
				echo "error:", $e->getMessage(), "\n<br>";
			}
			
		}
	
		function check_login($username, $password){
			$username = stripslashes($username);
			$username = mysql_real_escape_string($username);
			
			$password = stripslashes($password);
			$password = mysql_real_escape_string($password);
			$password = sha1($password);
			$random = rand();
			$password = "$password$random";
			$password = sha1($password);

			$query = "SELECT password FROM users WHERE username = '$username';";
			$q = mysql_query($query);
			if( mysql_num_rows($q) <= 0 ){
				return False;
			}
			$r = mysql_fetch_row($q);
			$server_password = $r[0];
			$server_password = "$server_password$random";
			$server_password = sha1($server_password);
			if( $password == $server_password ){
				$this->log_login($username);
				return True;
			}else{
				return false;
			}
			// return $password == $server_password;
		}
		function log_login($username){
			$user_id  = $this->get_user_id($username);
			$date = date("Y-m-d");
			$time = time("h:m:s");
			$datetime=$date.$time;
			$query = "INSERT INTO logs VALUES( NULL, $user_id, 0, $datetime)";
			mysql_query($query);
		}
		function log_logout($username){
			$user_id = $this->get_user_id($username);
			$date = date("Y-m-d");
			$time = time("h:m:s");
			$datetime=$date.$time;
			$query = "INSERT INTO logs VALUES( NULL, $user_id, 1, $datetime)";
			$this->submit_query($query);
		}
*/
		
	}
	

	
?>
