		<table width="700" height="250" border="1" cellpadding="0" cellspacing="0" frame="border">
        	<tr>
            	<td colspan=6>FOXX BEAUTY SUPPLY CORP.</td>
            </tr>
			<tr>
				<td width="130">Period:</td><td width="65"><?php echo $period;?></td>
				<td width="200">Employee Name</td><td><?php echo $emp_name;?></td>
				<td width="105">Employee ID</td><td width="50"><?php echo $emp_id;?></td>
			</tr>
			<tr height=10>
				<td colspan=6></td>
			</tr>
			
			<tr>
				<td width="130">Tax Status</td><td width="65"><?php echo $tax_status?></td>
				<td width="200">Federal Allowance (from W-4)</td><td><?php echo $fed_allowance;?></td>
				<td width="105">Hours Worked</td><td width='50'><?php echo $reg;?></td>

			</tr>
			
			<tr>
				<?php
				
					if( $submit_type == 3 || $submit_type == 4){
						echo "	<td width='130'>Hourly Rate</td><td width='65'> $wage</td>";
						if($overtype == 1){
							$overrate = 1.5;
						}
						echo "<td width='200'>Overtime Rate</td><td> $overrate</td>";
					}else if( $submit_type == 1 || $submit_type==2){
						$s = number_format($salary, 2);
						echo "	<td  width='130'>Salary Amount</td><td width='65'>$s</td>";
						echo "<td width='200'>Bonus</td><td>0.0</td>";
					}
				?>
				<td width='105'>Sick Hours</td><td width='50'>0</td>
			</tr>
			<tr>
				<td width='130'>Social Security Tax</td><td width='65'><?php echo number_format($ss_tax, 2);?></td>
				<td width='200'>Federal Income Tax</td><td><?php echo number_format($fed_tax, 2 );?></td>
				<td width='105'>Vacation Hours</td><td width='50'>0</td>
			</tr>
			
			<tr>
				<td width='130'>Medicare Tax</td><td width='65'><?php echo number_format($med_tax, 2);?></td>
				<td width='200'>State Tax</td><td><?php echo number_format($state_tax, 2);?></td>
				<td width='105'>Overtime Hours</td>
					<td width='50'>
						<?php
							if( $overtype == 1){
								echo 0;
							}else{
								echo $overtime;
							}
						?>
					</td>
			</tr>
			
			<tr>
				<td width='130'>Insurance Deduction</td><td width='65'><?php echo number_format($ins_ded, 2);?></td>
				<td width='200'>Other Regular Deduction</td><td><?php echo number_format($other_ded, 2);?></td>
				<td width='105'>Gross Pay</td><td width='50'><?php echo number_format($gross_pay, 2);?></td>
			</tr>
			<tr>
				<td width='130'>Total Taxes and<br>Regular Deductions</td><td width='65'><?php echo number_format($total_tax + $total_ded, 2);?></td>
				<td width='200'>Other Deduction</td><td><?php echo number_format($other_ded, 2);?></td>
				<td width='105'>Total taxes and<br>Deductions</td><td width='50'><?php echo number_format($total_tax_ded, 2);?></td>
			</tr>
			
			<tr>
				<td colspan=4></td>
				<td width='105'>Net Pay</td><td width='50'><?php echo number_format($net_pay, 2);?></td>
			</tr>
        </table>

		<table border='0'>
			<tr><td><p> </td></tr>
		</table>