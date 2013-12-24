<?php
session_start();
ob_start();
?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php include "phprptinc/ewrcfg3.php"; ?>
<?php include "phprptinc/ewmysql.php"; ?>
<?php include "phprptinc/ewrfn3.php"; ?>
<?php

// Get page start time
$starttime = ewrpt_microtime();

// Open connection to the database
$conn = ewrpt_Connect();

// Table level constants
define("EW_REPORT_TABLE_VAR", "Hourly_Total_by_Periods", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "Hourly_Total_by_Periods_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "Hourly_Total_by_Periods_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "Hourly_Total_by_Periods_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "Hourly_Total_by_Periods_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "Hourly_Total_by_Periods_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "hourlysumbyperiods";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT hourlysumbyperiods.period_date As Date, hourlysumbyperiods.gross As `Gross Total`, hourlysumbyperiods.net As `Net Total` FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = "";
$EW_REPORT_TABLE_SQL_GROUPBY = "";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";
$EW_REPORT_TABLE_SQL_CHART_BASE = "";
$af_Gross_Total = NULL; // Popup filter for Gross Total
$af_Net_Total = NULL; // Popup filter for Net Total
$af_Date = NULL; // Popup filter for Date
?>
<?php

// Initialize common variables
// Paging variables

$nRecCount = 0; // Record count
$nStartGrp = 0; // Start group
$nStopGrp = 0; // Stop group
$nTotalGrps = 0; // Total groups
$nGrpCount = 0; // Group count
$nDisplayGrps = 5; // Groups per page
$nGrpRange = 10;

// Clear field for ext filter
$sClearExtFilter = "";

// Non-Text Extended Filters
// Text Extended Filters
// Custom filters

$ewrpt_CustomFilters = array();
?>
<?php
?>
<?php

// Field variables
$x_Gross_Total = NULL;
$x_Net_Total = NULL;
$x_Date = NULL;

// Detail variables
$o_Gross_Total = NULL; $t_Gross_Total = NULL; $ft_Gross_Total = 5; $rf_Gross_Total = NULL; $rt_Gross_Total = NULL;
$o_Net_Total = NULL; $t_Net_Total = NULL; $ft_Net_Total = 5; $rf_Net_Total = NULL; $rt_Net_Total = NULL;
$o_Date = NULL; $t_Date = NULL; $ft_Date = 133; $rf_Date = NULL; $rt_Date = NULL;
?>
<?php

// Chart level SQL
$EW_REPORT_CHART_GROSS_TOTAL_PER_PERIODS_SQL_SELECT = "SELECT `Date`, '', SUM(`Gross Total`) FROM " . $EW_REPORT_TABLE_SQL_CHART_BASE;
$EW_REPORT_CHART_GROSS_TOTAL_PER_PERIODS_SQL_GROUPBY = "`Date`";
$EW_REPORT_CHART_GROSS_TOTAL_PER_PERIODS_SQL_ORDERBY = "`Date` ASC";
$EW_REPORT_CHART_GROSS_TOTAL_PER_PERIODS_DATE_TYPE = "";

// Chart configuration parameters
$Gross_Total_per_Periods_cht_parms = array(); // Store all chart parameters

// Chart data
$Gross_Total_per_Periods_cht_index = NULL;
$Gross_Total_per_Periods_cht_id = NULL;
$Gross_Total_per_Periods_cht_smry = NULL;
$Gross_Total_per_Periods_cht_series = NULL; // Series field
$Gross_Total_per_Periods_cht_XFld = NULL;
$Gross_Total_per_Periods_cht_YFld = NULL;
$Gross_Total_per_Periods_cht_YFldBase = NULL;
$Gross_Total_per_Periods_cht_XFld = 'Date';
$Gross_Total_per_Periods_cht_YFld = 'Gross Total';
$Gross_Total_per_Periods_cht_XDateFld = '';
$Gross_Total_per_Periods_cht_SFld = '';
$Gross_Total_per_Periods_cht_SFldAr = NULL;
?>
<?php
$Gross_Total_per_Periods_cht_trends = array(); // Store all chart trendlines
?>
<?php

// Chart level SQL
$EW_REPORT_CHART_NET_TOTAL_PER_PERIODS_SQL_SELECT = "SELECT `Date`, '', SUM(`Net Total`) FROM " . $EW_REPORT_TABLE_SQL_CHART_BASE;
$EW_REPORT_CHART_NET_TOTAL_PER_PERIODS_SQL_GROUPBY = "`Date`";
$EW_REPORT_CHART_NET_TOTAL_PER_PERIODS_SQL_ORDERBY = "`Date` ASC";
$EW_REPORT_CHART_NET_TOTAL_PER_PERIODS_DATE_TYPE = "";

// Chart configuration parameters
$Net_Total_per_Periods_cht_parms = array(); // Store all chart parameters

// Chart data
$Net_Total_per_Periods_cht_index = NULL;
$Net_Total_per_Periods_cht_id = NULL;
$Net_Total_per_Periods_cht_smry = NULL;
$Net_Total_per_Periods_cht_series = NULL; // Series field
$Net_Total_per_Periods_cht_XFld = NULL;
$Net_Total_per_Periods_cht_YFld = NULL;
$Net_Total_per_Periods_cht_YFldBase = NULL;
$Net_Total_per_Periods_cht_XFld = 'Date';
$Net_Total_per_Periods_cht_YFld = 'Net Total';
$Net_Total_per_Periods_cht_XDateFld = '';
$Net_Total_per_Periods_cht_SFld = '';
$Net_Total_per_Periods_cht_SFldAr = NULL;
?>
<?php
$Net_Total_per_Periods_cht_trends = array(); // Store all chart trendlines
?>
<?php

// Filter
$sFilter = "";

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 4;
$nGrps = 1;
$val = ewrpt_InitArray($nDtls, 0);
$cnt = ewrpt_Init2DArray($nGrps, $nDtls, 0);
$smry = ewrpt_Init2DArray($nGrps, $nDtls, 0);
$mn = ewrpt_Init2DArray($nGrps, $nDtls, NULL);
$mx = ewrpt_Init2DArray($nGrps, $nDtls, NULL);
$grandsmry = ewrpt_InitArray($nDtls, 0);
$grandmn = ewrpt_InitArray($nDtls, NULL);
$grandmx = ewrpt_InitArray($nDtls, NULL);

// Set up if accumulation required
$col = array(FALSE, FALSE, FALSE, FALSE);

// Set up groups per page dynamically
SetUpDisplayGrps();

// Set up popup filter
SetupPopup();

// Extended filter
$sExtendedFilter = "";

// Build popup filter
$sPopupFilter = GetPopupFilter();

//echo "popup filter: " . $sPopupFilter . "<br>";
if ($sPopupFilter <> "") {
	if ($sFilter <> "")
		$sFilter = "($sFilter) AND ($sPopupFilter)";
	else
		$sFilter = $sPopupFilter;
}

// No filter
$bFilterApplied = FALSE;

// Get sort
$sSort = getSort();

// Get total count
$sSql = ewrpt_BuildReportSql($EW_REPORT_TABLE_SQL_SELECT, $EW_REPORT_TABLE_SQL_WHERE, $EW_REPORT_TABLE_SQL_GROUPBY, $EW_REPORT_TABLE_SQL_HAVING, $EW_REPORT_TABLE_SQL_ORDERBY, $sFilter, @$sSort);
$nTotalGrps = GetCnt($sSql);
if ($nDisplayGrps <= 0) // Display all groups
	$nDisplayGrps = $nTotalGrps;
$nStartGrp = 1;

// Show header
$bShowFirstHeader = ($nTotalGrps > 0);

//$bShowFirstHeader = TRUE; // Uncomment to always show header
// Set up start position if not export all

if (EW_REPORT_EXPORT_ALL && @$sExport <> "")
    $nDisplayGrps = $nTotalGrps;
else
    SetUpStartGroup(); 

// Get current page records
$rs = GetRs($sSql, $nStartGrp, $nDisplayGrps);
?>
<?php include "phprptinc/header.php"; ?>
<script type="text/javascript">
var EW_REPORT_DATE_SEPARATOR = "/";
if (EW_REPORT_DATE_SEPARATOR == "") EW_REPORT_DATE_SEPARATOR = "/"; // Default date separator
</script>
<script type="text/javascript" src="phprptjs/ewrpt.js"></script>
<script src="phprptjs/popup.js" type="text/javascript"></script>
<script src="phprptjs/ewrptpop.js" type="text/javascript"></script>
<script src="FusionChartsFree/JSClass/FusionCharts.js" type="text/javascript"></script>
<script type="text/javascript">
var EW_REPORT_POPUP_ALL = "(All)";
var EW_REPORT_POPUP_OK = "  OK  ";
var EW_REPORT_POPUP_CANCEL = "Cancel";
var EW_REPORT_POPUP_FROM = "From";
var EW_REPORT_POPUP_TO = "To";
var EW_REPORT_POPUP_PLEASE_SELECT = "Please Select";
var EW_REPORT_POPUP_NO_VALUE = "No value selected!";

// popup fields
</script>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
Hourly Total By Periods
<br /><br />
</div></td></tr>
<!-- Top Container (End) -->
<tr>
	<!-- Left Container (Begin) -->
	<td valign="top"><div id="ewLeft" class="phpreportmaker">
	<!-- Left slot -->
	</div></td>
	<!-- Left Container (End) -->
	<!-- Center Container - Report (Begin) -->
	<td valign="top" class="ewPadding"><div id="ewCenter" class="phpreportmaker">
	<!-- center slot -->
<!-- summary report starts -->
<div id="report_summary">
<table class="ewGrid" cellspacing="0"><tr>
	<td class="ewGridContent">
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table class="ewTable ewTableSeparate" cellspacing="0">
<?php

// Set the last group to display if not export all
if (EW_REPORT_EXPORT_ALL && @$sExport <> "") {
	$nStopGrp = $nTotalGrps;
} else {
	$nStopGrp = $nStartGrp + $nDisplayGrps - 1;
}

// Stop group <= total number of groups
if (intval($nStopGrp) > intval($nTotalGrps))
	$nStopGrp = $nTotalGrps;
$nRecCount = 0;

// Get first row
if ($nTotalGrps > 0) {
	GetRow(1);
	$nGrpCount = 1;
}
while (($rs && !$rs->EOF) || $bShowFirstHeader) {

	// Show header
	if ($bShowFirstHeader) {
?>
	<thead>
	<tr>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Gross
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Gross</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Net
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Net</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Period Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Period Date</td>
			</tr></table>
		</td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
		$bShowFirstHeader = FALSE;
	}
	$nRecCount++;

		// Set row color
		$sItemRowClass = " class=\"ewTableRow\"";

		// Display alternate color for rows
		if ($nRecCount % 2 <> 1)
			$sItemRowClass = " class=\"ewTableAltRow\"";
?>
	<tr>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_Gross_Total) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_Net_Total) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue(ewrpt_FormatDateTime($x_Date,5)) ?>
</td>
	</tr>
<?php

		// Accumulate page summary
		AccumulateSummary();

		// Get next record
		GetRow(2);
	$nGrpCount++;
} // End while
?>
	</tbody>
	<tfoot>
	</tfoot>
</table>
</div>
<div class="ewGridLowerPanel">
<form action="Hourly_Total_by_Periodsrpt.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="Hourly_Total_by_Periodsrpt.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="Hourly_Total_by_Periodsrpt.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="Hourly_Total_by_Periodsrpt.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="Hourly_Total_by_Periodsrpt.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/lastdisab.gif" alt="Last" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpreportmaker">&nbsp;of <?php echo $Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpreportmaker"> <?php echo $Pager->FromIndex ?> to <?php echo $Pager->ToIndex ?> of <?php echo $Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($sFilter == "0=101") { ?>
	<span class="phpreportmaker">Please enter search criteria</span>
	<?php } else { ?>
	<span class="phpreportmaker">No records found</span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($nTotalGrps > 0) { ?>
		<td nowrap>&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align="right" valign="top" nowrap><span class="phpreportmaker">Records Per Page&nbsp;
<select name="<?php echo EW_REPORT_TABLE_GROUP_PER_PAGE; ?>" onChange="this.form.submit();" class="phpreportmaker">
<option value="1"<?php if ($nDisplayGrps == 1) echo " selected" ?>>1</option>
<option value="2"<?php if ($nDisplayGrps == 2) echo " selected" ?>>2</option>
<option value="3"<?php if ($nDisplayGrps == 3) echo " selected" ?>>3</option>
<option value="4"<?php if ($nDisplayGrps == 4) echo " selected" ?>>4</option>
<option value="5"<?php if ($nDisplayGrps == 5) echo " selected" ?>>5</option>
<option value="10"<?php if ($nDisplayGrps == 10) echo " selected" ?>>10</option>
<option value="20"<?php if ($nDisplayGrps == 20) echo " selected" ?>>20</option>
<option value="50"<?php if ($nDisplayGrps == 50) echo " selected" ?>>50</option>
<option value="ALL"<?php if (@$_SESSION[EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE] == -1) echo " selected" ?>>All</option>
</select>
		</span></td>
<?php } ?>
	</tr>
</table>
</form>
</div>
</td></tr></table>
</div>
<!-- Summary Report Ends -->
	</div><br /></td>
	<!-- Center Container - Report (End) -->
	<!-- Right Container (Begin) -->
	<td valign="top"><div id="ewRight" class="phpreportmaker">
	<!-- Right slot -->
	</div></td>
	<!-- Right Container (End) -->
</tr>
<!-- Bottom Container (Begin) -->
<tr><td colspan="3" class="ewPadding"><div id="ewBottom" class="phpreportmaker">
	<!-- Bottom slot -->
<a name="cht_Gross_Total_per_Periods"></a>
<div id="div_Hourly_Total_by_Periods_Gross_Total_per_Periods"></div>
<?php

// Initialize chart data
$Gross_Total_per_Periods_cht_id = "Hourly_Total_by_Periods_Gross_Total_per_Periods"; // Chart ID
ewrpt_AddChartParam($Gross_Total_per_Periods_cht_parms, "type", "4", FALSE); // Chart type
ewrpt_AddChartParam($Gross_Total_per_Periods_cht_parms, "bgcolor", "#FCFCFC", TRUE); // Background color
ewrpt_AddChartParam($Gross_Total_per_Periods_cht_parms, "caption", "Gross Total per Periods", TRUE); // Chart caption
ewrpt_AddChartParam($Gross_Total_per_Periods_cht_parms, "xaxisname", "Period Date", TRUE); // X axis name
ewrpt_AddChartParam($Gross_Total_per_Periods_cht_parms, "yaxisname", "Gross", TRUE); // Y axis name
ewrpt_AddChartParam($Gross_Total_per_Periods_cht_parms, "shownames", "1", TRUE); // Show names
ewrpt_AddChartParam($Gross_Total_per_Periods_cht_parms, "showvalues", "1", TRUE); // Show values
ewrpt_AddChartParam($Gross_Total_per_Periods_cht_parms, "showhovercap", "1", TRUE); // Show hover
ewrpt_AddChartParam($Gross_Total_per_Periods_cht_parms, "alpha", "50", FALSE); // Chart alpha
ewrpt_AddChartParam($Gross_Total_per_Periods_cht_parms, "colorpalette", "#FF0000|#FF0080|#FF00FF|#8000FF|#FF8000|#FF3D3D|#7AFFFF|#0000FF|#FFFF00|#FF7A7A|#3DFFFF|#0080FF|#80FF00|#00FF00|#00FF80|#00FFFF", FALSE); // Chart color palette
?>
<?php
ewrpt_SetChartParam($Gross_Total_per_Periods_cht_parms, "showCanvasBg", "1", TRUE); // showCanvasBg
ewrpt_SetChartParam($Gross_Total_per_Periods_cht_parms, "showCanvasBase", "1", TRUE); // showCanvasBase
ewrpt_SetChartParam($Gross_Total_per_Periods_cht_parms, "showLimits", "1", TRUE); // showLimits
ewrpt_SetChartParam($Gross_Total_per_Periods_cht_parms, "animation", "1", TRUE); // animation
ewrpt_SetChartParam($Gross_Total_per_Periods_cht_parms, "rotateNames", "0", TRUE); // rotateNames
ewrpt_SetChartParam($Gross_Total_per_Periods_cht_parms, "yAxisMinValue", "0", TRUE); // yAxisMinValue
ewrpt_SetChartParam($Gross_Total_per_Periods_cht_parms, "yAxisMaxValue", "0", TRUE); // yAxisMaxValue
ewrpt_SetChartParam($Gross_Total_per_Periods_cht_parms, "showColumnShadow", "0", TRUE); // showColumnShadow
ewrpt_SetChartParam($Gross_Total_per_Periods_cht_parms, "showPercentageValues", "1", TRUE); // showPercentageValues
ewrpt_SetChartParam($Gross_Total_per_Periods_cht_parms, "showPercentageInLabel", "1", TRUE); // showPercentageInLabel
ewrpt_SetChartParam($Gross_Total_per_Periods_cht_parms, "showBarShadow", "0", TRUE); // showBarShadow
ewrpt_SetChartParam($Gross_Total_per_Periods_cht_parms, "showAnchors", "1", TRUE); // showAnchors
ewrpt_SetChartParam($Gross_Total_per_Periods_cht_parms, "showAreaBorder", "1", TRUE); // showAreaBorder
ewrpt_SetChartParam($Gross_Total_per_Periods_cht_parms, "showShadow", "1", TRUE); // showShadow
ewrpt_SetChartParam($Gross_Total_per_Periods_cht_parms, "formatNumber", "0", TRUE); // formatNumber
ewrpt_SetChartParam($Gross_Total_per_Periods_cht_parms, "formatNumberScale", "0", TRUE); // formatNumberScale
ewrpt_SetChartParam($Gross_Total_per_Periods_cht_parms, "decimalSeparator", ".", TRUE); // decimalSeparator
ewrpt_SetChartParam($Gross_Total_per_Periods_cht_parms, "thousandSeparator", ",", TRUE); // thousandSeparator
ewrpt_SetChartParam($Gross_Total_per_Periods_cht_parms, "decimalPrecision", "2", TRUE); // decimalPrecision
ewrpt_SetChartParam($Gross_Total_per_Periods_cht_parms, "divLineDecimalPrecision", "2", TRUE); // divLineDecimalPrecision
ewrpt_SetChartParam($Gross_Total_per_Periods_cht_parms, "limitsDecimalPrecision", "2", TRUE); // limitsDecimalPrecision
ewrpt_SetChartParam($Gross_Total_per_Periods_cht_parms, "zeroPlaneShowBorder", "1", TRUE); // zeroPlaneShowBorder
ewrpt_SetChartParam($Gross_Total_per_Periods_cht_parms, "showDivLineValue", "1", TRUE); // showDivLineValue
ewrpt_SetChartParam($Gross_Total_per_Periods_cht_parms, "showAlternateHGridColor", "0", TRUE); // showAlternateHGridColor
ewrpt_SetChartParam($Gross_Total_per_Periods_cht_parms, "showAlternateVGridColor", "0", TRUE); // showAlternateVGridColor
ewrpt_SetChartParam($Gross_Total_per_Periods_cht_parms, "hoverCapSepChar", ":", TRUE); // hoverCapSepChar

// Define trend lines
?>
<?php
$EW_REPORT_TABLE_SQL_CHART_BASE = "(" . ewrpt_BuildReportSql($EW_REPORT_TABLE_SQL_SELECT, $EW_REPORT_TABLE_SQL_WHERE, $EW_REPORT_TABLE_SQL_GROUPBY, $EW_REPORT_TABLE_SQL_HAVING, "", $sFilter, "") . ") EW_TMP_TABLE";

// Load chart data from sql directly
$EW_REPORT_CHART_GROSS_TOTAL_PER_PERIODS_SQL_SELECT .= $EW_REPORT_TABLE_SQL_CHART_BASE;
$sSql = ewrpt_BuildReportSql($EW_REPORT_CHART_GROSS_TOTAL_PER_PERIODS_SQL_SELECT, "", $EW_REPORT_CHART_GROSS_TOTAL_PER_PERIODS_SQL_GROUPBY, "", "", "", "");
if (!defined("EW_REPORT_DEBUG_ENABLED") && defined("EW_REPORT_DEBUG_CHART_ENABLED")) echo "Chart data sql: " . $sSql . "<br>";
ewrpt_LoadChartData($sSql, $Gross_Total_per_Periods_cht_smry, $EW_REPORT_CHART_GROSS_TOTAL_PER_PERIODS_DATE_TYPE);
ewrpt_SortChartData($Gross_Total_per_Periods_cht_smry, 0);
echo ewrpt_ShowChartFCF(4, $Gross_Total_per_Periods_cht_id, $Gross_Total_per_Periods_cht_parms, $Gross_Total_per_Periods_cht_trends, $Gross_Total_per_Periods_cht_smry, $Gross_Total_per_Periods_cht_series, 1000, 440, "");
?>
<a href="#top">Top</a>
<br /><br />
<a name="cht_Net_Total_per_Periods"></a>
<div id="div_Hourly_Total_by_Periods_Net_Total_per_Periods"></div>
<?php

// Initialize chart data
$Net_Total_per_Periods_cht_id = "Hourly_Total_by_Periods_Net_Total_per_Periods"; // Chart ID
ewrpt_AddChartParam($Net_Total_per_Periods_cht_parms, "type", "4", FALSE); // Chart type
ewrpt_AddChartParam($Net_Total_per_Periods_cht_parms, "bgcolor", "#FCFCFC", TRUE); // Background color
ewrpt_AddChartParam($Net_Total_per_Periods_cht_parms, "caption", "Net Total per Periods", TRUE); // Chart caption
ewrpt_AddChartParam($Net_Total_per_Periods_cht_parms, "xaxisname", "Date", TRUE); // X axis name
ewrpt_AddChartParam($Net_Total_per_Periods_cht_parms, "yaxisname", "Net Total", TRUE); // Y axis name
ewrpt_AddChartParam($Net_Total_per_Periods_cht_parms, "shownames", "1", TRUE); // Show names
ewrpt_AddChartParam($Net_Total_per_Periods_cht_parms, "showvalues", "1", TRUE); // Show values
ewrpt_AddChartParam($Net_Total_per_Periods_cht_parms, "showhovercap", "0", TRUE); // Show hover
ewrpt_AddChartParam($Net_Total_per_Periods_cht_parms, "alpha", "50", FALSE); // Chart alpha
ewrpt_AddChartParam($Net_Total_per_Periods_cht_parms, "colorpalette", "#FF0000|#FF0080|#FF00FF|#8000FF|#FF8000|#FF3D3D|#7AFFFF|#0000FF|#FFFF00|#FF7A7A|#3DFFFF|#0080FF|#80FF00|#00FF00|#00FF80|#00FFFF", FALSE); // Chart color palette
?>
<?php
ewrpt_SetChartParam($Net_Total_per_Periods_cht_parms, "showCanvasBg", "1", TRUE); // showCanvasBg
ewrpt_SetChartParam($Net_Total_per_Periods_cht_parms, "showCanvasBase", "1", TRUE); // showCanvasBase
ewrpt_SetChartParam($Net_Total_per_Periods_cht_parms, "showLimits", "1", TRUE); // showLimits
ewrpt_SetChartParam($Net_Total_per_Periods_cht_parms, "animation", "1", TRUE); // animation
ewrpt_SetChartParam($Net_Total_per_Periods_cht_parms, "rotateNames", "0", TRUE); // rotateNames
ewrpt_SetChartParam($Net_Total_per_Periods_cht_parms, "yAxisMinValue", "0", TRUE); // yAxisMinValue
ewrpt_SetChartParam($Net_Total_per_Periods_cht_parms, "yAxisMaxValue", "0", TRUE); // yAxisMaxValue
ewrpt_SetChartParam($Net_Total_per_Periods_cht_parms, "showColumnShadow", "0", TRUE); // showColumnShadow
ewrpt_SetChartParam($Net_Total_per_Periods_cht_parms, "showPercentageValues", "1", TRUE); // showPercentageValues
ewrpt_SetChartParam($Net_Total_per_Periods_cht_parms, "showPercentageInLabel", "1", TRUE); // showPercentageInLabel
ewrpt_SetChartParam($Net_Total_per_Periods_cht_parms, "showBarShadow", "0", TRUE); // showBarShadow
ewrpt_SetChartParam($Net_Total_per_Periods_cht_parms, "showAnchors", "1", TRUE); // showAnchors
ewrpt_SetChartParam($Net_Total_per_Periods_cht_parms, "showAreaBorder", "1", TRUE); // showAreaBorder
ewrpt_SetChartParam($Net_Total_per_Periods_cht_parms, "showShadow", "1", TRUE); // showShadow
ewrpt_SetChartParam($Net_Total_per_Periods_cht_parms, "formatNumber", "0", TRUE); // formatNumber
ewrpt_SetChartParam($Net_Total_per_Periods_cht_parms, "formatNumberScale", "0", TRUE); // formatNumberScale
ewrpt_SetChartParam($Net_Total_per_Periods_cht_parms, "decimalSeparator", ".", TRUE); // decimalSeparator
ewrpt_SetChartParam($Net_Total_per_Periods_cht_parms, "thousandSeparator", ",", TRUE); // thousandSeparator
ewrpt_SetChartParam($Net_Total_per_Periods_cht_parms, "decimalPrecision", "2", TRUE); // decimalPrecision
ewrpt_SetChartParam($Net_Total_per_Periods_cht_parms, "divLineDecimalPrecision", "2", TRUE); // divLineDecimalPrecision
ewrpt_SetChartParam($Net_Total_per_Periods_cht_parms, "limitsDecimalPrecision", "2", TRUE); // limitsDecimalPrecision
ewrpt_SetChartParam($Net_Total_per_Periods_cht_parms, "zeroPlaneShowBorder", "1", TRUE); // zeroPlaneShowBorder
ewrpt_SetChartParam($Net_Total_per_Periods_cht_parms, "showDivLineValue", "1", TRUE); // showDivLineValue
ewrpt_SetChartParam($Net_Total_per_Periods_cht_parms, "showAlternateHGridColor", "0", TRUE); // showAlternateHGridColor
ewrpt_SetChartParam($Net_Total_per_Periods_cht_parms, "showAlternateVGridColor", "0", TRUE); // showAlternateVGridColor
ewrpt_SetChartParam($Net_Total_per_Periods_cht_parms, "hoverCapSepChar", ":", TRUE); // hoverCapSepChar

// Define trend lines
?>
<?php
$EW_REPORT_TABLE_SQL_CHART_BASE = "(" . ewrpt_BuildReportSql($EW_REPORT_TABLE_SQL_SELECT, $EW_REPORT_TABLE_SQL_WHERE, $EW_REPORT_TABLE_SQL_GROUPBY, $EW_REPORT_TABLE_SQL_HAVING, "", $sFilter, "") . ") EW_TMP_TABLE";

// Load chart data from sql directly
$EW_REPORT_CHART_NET_TOTAL_PER_PERIODS_SQL_SELECT .= $EW_REPORT_TABLE_SQL_CHART_BASE;
$sSql = ewrpt_BuildReportSql($EW_REPORT_CHART_NET_TOTAL_PER_PERIODS_SQL_SELECT, "", $EW_REPORT_CHART_NET_TOTAL_PER_PERIODS_SQL_GROUPBY, "", "", "", "");
if (!defined("EW_REPORT_DEBUG_ENABLED") && defined("EW_REPORT_DEBUG_CHART_ENABLED")) echo "Chart data sql: " . $sSql . "<br>";
ewrpt_LoadChartData($sSql, $Net_Total_per_Periods_cht_smry, $EW_REPORT_CHART_NET_TOTAL_PER_PERIODS_DATE_TYPE);
ewrpt_SortChartData($Net_Total_per_Periods_cht_smry, 0);
echo ewrpt_ShowChartFCF(4, $Net_Total_per_Periods_cht_id, $Net_Total_per_Periods_cht_parms, $Net_Total_per_Periods_cht_trends, $Net_Total_per_Periods_cht_smry, $Net_Total_per_Periods_cht_series, 1000, 440, "");
?>
<a href="#top">Top</a>
<br /><br />
	</div><br /></td></tr>
<!-- Bottom Container (End) -->
</table>
<!-- Table Container (End) -->
<?php
$conn->Close();

// display elapsed time
if (defined("EW_REPORT_DEBUG_ENABLED"))
	echo ewrpt_calcElapsedTime($starttime);
?>
<?php include "phprptinc/footer.php"; ?>
<?php

// Accummulate summary
function AccumulateSummary() {
	global $smry, $cnt, $col, $val, $mn, $mx;
	$cntx = count($smry);
	for ($ix = 0; $ix < $cntx; $ix++) {
		$cnty = count($smry[$ix]);
		for ($iy = 1; $iy < $cnty; $iy++) {
			$cnt[$ix][$iy]++;
			if ($col[$iy]) {
				$valwrk = $val[$iy];
				if (is_null($valwrk) || !is_numeric($valwrk)) {

					// skip
				} else {
					$smry[$ix][$iy] += $valwrk;
					if (is_null($mn[$ix][$iy])) {
						$mn[$ix][$iy] = $valwrk;
						$mx[$ix][$iy] = $valwrk;
					} else {
						if ($mn[$ix][$iy] > $valwrk) $mn[$ix][$iy] = $valwrk;
						if ($mx[$ix][$iy] < $valwrk) $mx[$ix][$iy] = $valwrk;
					}
				}
			}
		}
	}
	$cntx = count($smry);
	for ($ix = 1; $ix < $cntx; $ix++) {
		$cnt[$ix][0]++;
	}
}

// Reset level summary
function ResetLevelSummary($lvl) {
	global $smry, $cnt, $col, $mn, $mx, $nRecCount;

	// Clear summary values
	$cntx = count($smry);
	for ($ix = $lvl; $ix < $cntx; $ix++) {
		$cnty = count($smry[$ix]);
		for ($iy = 1; $iy < $cnty; $iy++) {
			$cnt[$ix][$iy] = 0;
			if ($col[$iy]) {
				$smry[$ix][$iy] = 0;
				$mn[$ix][$iy] = NULL;
				$mx[$ix][$iy] = NULL;
			}
		}
	}
	$cntx = count($smry);
	for ($ix = $lvl; $ix < $cntx; $ix++) {
		$cnt[$ix][0] = 0;
	}

	// Clear old values
	// Reset record count

	$nRecCount = 0;
}

// Accummulate grand summary
function AccumulateGrandSummary() {
	global $cnt, $col, $val, $grandsmry, $grandmn, $grandmx;
	@$cnt[0][0]++;
	for ($iy = 1; $iy < count($grandsmry); $iy++) {
		if ($col[$iy]) {
			$valwrk = $val[$iy];
			if (is_null($valwrk) || !is_numeric($valwrk)) {

				// skip
			} else {
				$grandsmry[$iy] += $valwrk;
				if (is_null($grandmn[$iy])) {
					$grandmn[$iy] = $valwrk;
					$grandmx[$iy] = $valwrk;
				} else {
					if ($grandmn[$iy] > $valwrk) $grandmn[$iy] = $valwrk;
					if ($grandmx[$iy] < $valwrk) $grandmx[$iy] = $valwrk;
				}
			}
		}
	}
}

// Get count
function GetCnt($sql) {
	global $conn;

	//echo "sql (GetCnt): " . $sql . "<br>";
	$rscnt = $conn->Execute($sql);
	$cnt = ($rscnt) ? $rscnt->RecordCount() : 0;
	return $cnt;
}

// Get rs
function GetRs($sql, $start, $grps) {
	global $conn;
	$wrksql = $sql . " LIMIT " . ($start-1) . ", " . ($grps);

	//echo "wrksql: (rsgrp)" . $sSql . "<br>";
	$rswrk = $conn->Execute($wrksql);
	return $rswrk;
}

// Get row values
function GetRow($opt) {
	global $rs, $val;
	if (!$rs)
		return;
	if ($opt == 1) { // Get first row
		$rs->MoveFirst();
	} else { // Get next row
		$rs->MoveNext();
	}
	if (!$rs->EOF) {
		$GLOBALS['x_Gross_Total'] = $rs->fields('Gross Total');
		$GLOBALS['x_Net_Total'] = $rs->fields('Net Total');
		$GLOBALS['x_Date'] = $rs->fields('Date');
		$val[1] = $GLOBALS['x_Gross_Total'];
		$val[2] = $GLOBALS['x_Net_Total'];
		$val[3] = $GLOBALS['x_Date'];
	} else {
		$GLOBALS['x_Gross_Total'] = "";
		$GLOBALS['x_Net_Total'] = "";
		$GLOBALS['x_Date'] = "";
	}
}

//  Set up starting group
function SetUpStartGroup() {
	global $nStartGrp, $nTotalGrps, $nDisplayGrps;

	// Exit if no groups
	if ($nDisplayGrps == 0)
		return;

	// Check for a 'start' parameter
	if (@$_GET[EW_REPORT_TABLE_START_GROUP] != "") {
		$nStartGrp = $_GET[EW_REPORT_TABLE_START_GROUP];
		$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = $nStartGrp;
	} elseif (@$_GET["pageno"] != "") {
		$nPageNo = $_GET["pageno"];
		if (is_numeric($nPageNo)) {
			$nStartGrp = ($nPageNo-1)*$nDisplayGrps+1;
			if ($nStartGrp <= 0) {
				$nStartGrp = 1;
			} elseif ($nStartGrp >= intval(($nTotalGrps-1)/$nDisplayGrps)*$nDisplayGrps+1) {
				$nStartGrp = intval(($nTotalGrps-1)/$nDisplayGrps)*$nDisplayGrps+1;
			}
			$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = $nStartGrp;
		} else {
			$nStartGrp = @$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP];
		}
	} else {
		$nStartGrp = @$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP];	
	}

	// Check if correct start group counter
	if (!is_numeric($nStartGrp) || $nStartGrp == "") { // Avoid invalid start group counter
		$nStartGrp = 1; // Reset start group counter
		$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = $nStartGrp;
	} elseif (intval($nStartGrp) > intval($nTotalGrps)) { // Avoid starting group > total groups
		$nStartGrp = intval(($nTotalGrps-1)/$nDisplayGrps) * $nDisplayGrps + 1; // Point to last page first group
		$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = $nStartGrp;
	} elseif (($nStartGrp-1) % $nDisplayGrps <> 0) {
		$nStartGrp = intval(($nStartGrp-1)/$nDisplayGrps) * $nDisplayGrps + 1; // Point to page boundary
		$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = $nStartGrp;
	}
}

// Set up popup
function SetupPopup() {
	global $conn, $sFilter;

	// Initialize popup
	// Process post back form

	if (count($_POST) > 0) {
		$sName = @$_POST["popup"]; // Get popup form name
		if ($sName <> "") {
		$cntValues = (is_array(@$_POST["sel_$sName"])) ? count($_POST["sel_$sName"]) : 0;
			if ($cntValues > 0) {
				$arValues = ewrpt_StripSlashes($_POST["sel_$sName"]);
				if (trim($arValues[0]) == "") // Select all
					$arValues = EW_REPORT_INIT_VALUE;
				$_SESSION["sel_$sName"] = $arValues;
				$_SESSION["rf_$sName"] = ewrpt_StripSlashes(@$_POST["rf_$sName"]);
				$_SESSION["rt_$sName"] = ewrpt_StripSlashes(@$_POST["rt_$sName"]);
				ResetPager();
			}
		}

	// Get 'reset' command
	} elseif (@$_GET["cmd"] <> "") {
		$sCmd = $_GET["cmd"];
		if (strtolower($sCmd) == "reset") {
			ResetPager();
		}
	}

	// Load selection criteria to array
}

// Reset pager
function ResetPager() {

	// Reset start position (reset command)
	global $nStartGrp, $nTotalGrps;
	$nStartGrp = 1;
	$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = $nStartGrp;
}
?>
<?php

// Set up number of groups displayed per page
function SetUpDisplayGrps() {
	global $nDisplayGrps, $nStartGrp;
	$sWrk = @$_GET[EW_REPORT_TABLE_GROUP_PER_PAGE];
	if ($sWrk <> "") {
		if (is_numeric($sWrk)) {
			$nDisplayGrps = intval($sWrk);
		} else {
			if (strtoupper($sWrk) == "ALL") { // display all groups
				$nDisplayGrps = -1;
			} else {
				$nDisplayGrps = 5; // Non-numeric, load default
			}
		}
		$_SESSION[EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE] = $nDisplayGrps; // Save to session

		// Reset start position (reset command)
		$nStartGrp = 1;
		$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = $nStartGrp;
	} else {
		if (@$_SESSION[EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE] <> "") {
			$nDisplayGrps = $_SESSION[EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE]; // Restore from session
		} else {
			$nDisplayGrps = 5; // Load default
		}
	}
}
?>
<?php

// Return poup filter
function GetPopupFilter() {
	$sWrk = "";
	return $sWrk;
}
?>
<?php

//-------------------------------------------------------------------------------
// Function getSort
// - Return Sort parameters based on Sort Links clicked
// - Variables setup: Session[EW_REPORT_TABLE_SESSION_ORDER_BY], Session["sort_Table_Field"]
function getSort()
{

	// Check for a resetsort command
	if (strlen(@$_GET["cmd"]) > 0) {
		$sCmd = @$_GET["cmd"];
		if ($sCmd == "resetsort") {
			$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY] = "";
			$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = 1;
			$_SESSION["sort_Hourly_Total_by_Periods_Gross_Total"] = "";
			$_SESSION["sort_Hourly_Total_by_Periods_Net_Total"] = "";
			$_SESSION["sort_Hourly_Total_by_Periods_Date"] = "";
		}

	// Check for an Order parameter
	} elseif (strlen(@$_GET[EW_REPORT_TABLE_ORDER_BY]) > 0) {
		$sSortSql = "";
		$sSortField = "";
		$sOrder = @$_GET[EW_REPORT_TABLE_ORDER_BY];
		if (strlen(@$_GET[EW_REPORT_TABLE_ORDER_BY_TYPE]) > 0) {
			$sOrderType = @$_GET[EW_REPORT_TABLE_ORDER_BY_TYPE];
		} else {
			$sOrderType = "";
		}
	}
	return @$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY];
}
?>
