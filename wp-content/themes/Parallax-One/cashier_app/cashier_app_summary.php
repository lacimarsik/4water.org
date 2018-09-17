<?php
// =============================
// CASHIER APP - V1.0 Summary part

// Form part: cashier_app_summary.php (in the theme folder)
// Process part: cashier_app_process.php (in the root folder)

// OUTLINE
// 1. FUNCTIONS
// 1. SUMMARY CONTAINER
// 2. ATTENDANCE
// 3. MONTHLY REVENUES
// 4. WRAP-UP
// =============================

require_once('wp-config.php');
$connection_4w = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
mysqli_select_db($connection_4w, DB_NAME);

// =============================
// 1. FUNCTIONS
// =============================
// TODO: Refactor us to a service to avoid duplication among form/process/summary

function getCurrentBranchUrl($post, $connection) {
	$sql= "SELECT * FROM 4w_branches WHERE id = '" . $post['branch_id'] . "';";
	$result = $connection->query($sql);
	$row = mysqli_fetch_assoc($result);
	return '/' . strtolower($row['city']) . '/' . strtolower($row['activity']) . '/cashier';
}

function get_last_lesson($connection, $branch_id) {
	// Get the array of lessons depending on what days the branch has lessons
	// Array will be in the form "Class type, Level" => Timestamp
	$array_of_next_lessons = array();
	$sql= "SELECT * FROM 4w_branch_classes WHERE branch_id = " . $branch_id;
	$result = $connection->query($sql);
	while ($row = mysqli_fetch_assoc($result)) {
		if ((date('l') == $row['day']) && (date('H:i:s') > $row['time'])) {
			// if the lesson is today, and didn't yet start
			$day_as_string = strtolower($row['day']) . 'this week';
		} else {
			$day_as_string = 'last ' . strtolower($row['day']);
		}
		$array_of_next_lessons[$row['class_type'] . "," . $row['level']] = strtotime($day_as_string . ' ' . $row['time']);
	}
	arsort($array_of_next_lessons);
	reset($array_of_next_lessons);
	// Return only the closest lesson as: Timestamp, Class type, Level
	$class_type_level = explode(",", key($array_of_next_lessons));
	$timestamp = $array_of_next_lessons[key($array_of_next_lessons)];
	$class_type = $class_type_level[0];
	$level = $class_type_level[1];
	$result_array = array();
	array_push($result_array, $timestamp);
	array_push($result_array, $class_type);
	array_push($result_array, $level);
	return $result_array;
}

// @param $week [int]
// @param $year [int]
// @return [Array] the first day and last day of the week, in $ret['week_start'] and $ret['week_nd']
function getStartAndEndDate($week, $year) {
	$dto = new DateTime();
	$dto->setISODate($year, $week);
	$ret['week_start'] = $dto;
	$dto->modify('+6 days');
	$ret['week_end'] = $dto;
	return $ret;
}

// =============================
// 2. SUMMARY CONTAINER
// =============================
?>
<div class="content-wrap">
	<div class="container">

		<div id="primary" class="content-area col-md-12">
			<main id="main" class="site-main" role="main">
				<article id="post-38" class="post-38 page type-page status-publish hentry">
					<header class="entry-header">
						<h1 class="entry-title single-title">Cashier</h1>
						<div class="colored-line-left"></div>
						<div class="clearfix"></div>
						<?php if ($form_submitted) { ?>
						<div class="cashier-done">Thank you for cashiering! Below are the counts and money made.</div>
						<?php } ?>
				</article>
<?php

// =============================
// 2. ATTENDANCE
// =============================

// Set proper timezone
$sql= "SELECT * FROM 4w_branches WHERE id = '" . $_POST['branch_id'] . "';";
$result = $connection_4w->query($sql);
$row = mysqli_fetch_assoc($result);
$timezone = $row['timezone'];
date_default_timezone_set($timezone);

$last_lesson = get_last_lesson($connection_4w, $_POST['branch_id']);

$sql= "SELECT * FROM 4w_accounting a JOIN 4w_branch_prices p ON a.price_type_id = p.id JOIN 4w_branches b ON a.branch_id = b.id WHERE b.id = " . $_POST['branch_id']. " AND a.date = '" . date('Y-m-d', $last_lesson[0]) . "'";
$result = $connection_4w->query($sql);

$total = 0;
$students = 0;
$students_manual = 0;
$currency = "";
$volunteer_name = "";

if ($form_submitted) {
	if (date('Y-m-d', $last_lesson[0]) == date('Y-m-d')) {
		?>
		<h2 class="report-heading">Today</h2>
		<?php
	} else {
		?>
		<h2 class="report-heading">Last class</h2>
		<?php
	}

	?>
	<table class="table table-striped">
		<?php
		while ($row = mysqli_fetch_assoc($result)) {
			$currency = $row['currency'];
			$volunteer_name = $row['volunteer_name'];
			$total += intval($row['price']) * intval($row['count']);
			if ($row['totals'] != "yes") {
				$students += intval($row['count']);
			} else {
				$students_manual = ($students_manual < $row['count']) ? $row['count'] : $students_manual;
			}
			echo '<tr>';
			echo '<td><strong class="bold">' . $row['price_type'] . '</strong></td>';
			echo '<td><span>' . $row['count'] . '</span></td>';
			echo '<td><span>' . intval($row['price']) * intval($row['count']) . ' ' . $row['currency'] . '</span></td>';
			echo '</tr>';
		}
		?>
		<?php $total_students = ($students_manual > $students) ? $students_manual : $students; ?>
		<tr class="success">
			<td><strong class="medium bold">Totals</strong></td>
			<td><span class="medium"><?php echo $total_students; ?></span></td>
			<td><span class="medium"><?php echo $total; ?><?php echo $currency; ?></span></td>
		</tr>
	</table>
	<p>Counted by: <strong class="bold"><?php echo $volunteer_name; ?></strong></p>
	<?php
	if ($form_submitted) {
		$last_lesson = get_last_lesson($connection_4w, $_POST['branch_id']);
		$branch_url = getCurrentBranchUrl($_POST, $connection_4w, "summary"); ?>
		<form action="<?php echo $branch_url; ?>" id="return-form" method="post">
			<input type="hidden" name="return" value="true">
			<input type="hidden" name="datetime" value="<?php echo $last_lesson[0]; ?>">
			<input type="hidden" name="class" value="<?php echo $last_lesson[1]; ?>">
			<input type="hidden" name="level" value="<?php echo $last_lesson[2]; ?>">
			<input class="submit-button" type="submit"
			       value="Edit last class (<?php echo $last_lesson[1] . ' ' . $last_lesson[2] . ')'; ?>">
		</form>
		<?php
	}
}
?>
				<script type="text/javascript">
					$(function() {
							Highcharts.setOptions( {
									lang: {
										decimalPoint: ",", thousandsSep: " "
									}
								}
							);
							Highcharts.getData=function(table, options) {
								var sliceNames=[];
								$("th", table).each(function(i) {
										if(i>0) {
											sliceNames.push(this.innerHTML)
										}
									}
								);
								options.series=[];
								$("tr", table).each(function(i) {
										var tr=this;
										$("th, td", tr).each(function(j) {
												if(j>0) {
													if(i==0) {
														options.series[j-1]= {
															name: this.innerHTML, data: []
														}
													}
													else {
														if(i==1) {
															options.series[j-1].data.push( {
																	sliced: true, selected: true, name: sliceNames[i-1], y: parseFloat(this.innerHTML)
																}
															)
														}
														else {
															options.series[j-1].data.push( {
																	name: sliceNames[i-1], y: parseFloat(this.innerHTML)
																}
															)
														}
													}
												}
											}
										)
									}
								)
							}
						}

					);
					$(function() {
							Highcharts.setOptions( {
									colors: ["#3bb479", "#4a99e3"]
								}
							);
							var table=document.getElementById("datatable_for_chart1");
							$("#chart1").highcharts( {
									data: {
										table: table
									}
									, chart: {
										type: "column"
									}
									, title: {
										text: table.caption.innerHTML
									}
									, xAxis: {}
									, yAxis: {
										title: {
											text: "<?php echo $currency; ?>"
										}
										, stackLabels: {
											enabled:true, style: {
												fontWeight: "bold", color: (Highcharts.theme&&Highcharts.theme.textColor)||"gray"
											}
											, formatter:function() {
												return Highcharts.numberFormat(this.total, "0")+" <?php echo $currency; ?>"
											}
										}
										, labels: {
											formatter:function() {
												return this.value
											}
										}
									}
									, tooltip: {
										formatter:function() {
											if(this.series.name=="Students") {
												return"Students: "+Highcharts.numberFormat(this.y, "2f")+" <?php echo $currency; ?><br/>"+"<b>All: "+Highcharts.numberFormat(this.point.stackTotal, "2f")+" <?php echo $currency; ?></b>"
											}
											else {
												return"Non-Students: "+Highcharts.numberFormat(this.y, "2f")+" <?php echo $currency; ?><br/>"+"<b>All: "+Highcharts.numberFormat(this.point.stackTotal, "2f")+" <?php echo $currency; ?></b>"
											}
										}
									}
									, plotOptions: {
										column: {
											stacking:"normal", dataLabels: {
												enabled:true, color:(Highcharts.theme&&Highcharts.theme.dataLabelsColor)||"white", style: {
													textShadow: "0 0 3px black, 0 0 3px black"
												}
												, formatter:function() {
													return Highcharts.numberFormat(this.point.y, "0")+" <?php echo $currency; ?>"
												}
											}
										}
									}
									, series:[ {
										pointWidth: 50
									}
										, {
											pointWidth: 50
										}
									]
								}
							)

						Highcharts.setOptions( {
								colors: ["#4a99e3", "#3bb479", "#434348", "#f9913d", "#7b62b5", "#db4646", "#abb479"]
							}
						);
						var table=document.getElementById("datatable_for_chart2");
						$("#chart2").highcharts( {
								data: {
									table: table
								}
								, chart: {
									type: "column"
								}
								, title: {
									text: table.caption.innerHTML
								}
								, xAxis: {}
								, yAxis: {
									title: {
										text: "Attended"
									}
									, stackLabels: {
										enabled:true, style: {
											fontWeight: "bold", color: (Highcharts.theme&&Highcharts.theme.textColor)||"gray"
										}
										, formatter:function() {
											return Highcharts.numberFormat(this.total, "0")
										}
									}
									, labels: {
										formatter:function() {
											return this.value
										}
									}
								}
								, tooltip: {
									formatter:function() {
										return "<b>Week "+(this.x + 1)+"</b><br/>"+"<b>"+this.series.name+": "+Highcharts.numberFormat(this.y, "2f")+"</b>"
									}
								}
								, plotOptions: {
									column: {
										stacking:"normal", dataLabels: {
											enabled:true, color:(Highcharts.theme&&Highcharts.theme.dataLabelsColor)||"white", style: {
												textShadow: "0 0 3px black, 0 0 3px black"
											}
											, formatter:function() {
												return ''//Highcharts.numberFormat(this.point.y, "0")
											}
										}
									}
								}
								, series:[ {
										pointWidth: 10
									}
									, {
										pointWidth: 10
									}, {
									pointWidth: 10
								}, {
									pointWidth: 10
								}, {
									pointWidth: 10
								}, {
									pointWidth: 10
								}, {
									pointWidth: 10
								}
								]
							}
						)
						}

					);
					$(function() {
							Highcharts.setOptions( {
									colors: ["#4a99e3", "#3bb479", "#434348", "#f9913d", "#7b62b5", "#db4646"]
								}
							);
						}

					);
				</script>
<?php

// =============================
// 3. MONTHLY REVENUES
// =============================

$sql= 'SELECT EXTRACT(YEAR_MONTH FROM a.date) as month, sum(case when p.student = 1 then (a.count * p.price) else 0 end) as students_money_made, sum(case when p.student = 0 then (a.count * p.price) else 0 end) as non_students_money_made, p.currency FROM 4w_accounting a JOIN 4w_branch_prices p ON a.price_type_id = p.id JOIN 4w_branches b ON a.branch_id = b.id WHERE a.branch_id = "' . $_POST['branch_id'] . '" GROUP BY month ORDER BY month;';
$result = $connection_4w->query($sql);
?>

				<h2 class="report-heading">Monthly</h2>
					<div id="chart1" class="report-column-small">
					</div>

					<table id="datatable_for_chart1" class="report-datatable">
						<caption>Money collected</caption>
						<thead>
						<tr>
							<th>Month</th>
							<th>Students</th>
							<th>Non-Students</th>
						</tr>
						</thead>
						<tbody>
<?php
						while ($row = mysqli_fetch_assoc($result)) {
?>
							<tr>
								<td><?php echo date('F', mktime(0, 0, 0, substr($row['month'], 4), 10)) . " " . substr($row['month'], 0, 4); ?></td>
								<td><?php echo $row['students_money_made']; ?></td>
								<td><?php echo $row['non_students_money_made']; ?></td>
							</tr>
<?php
						}
$sql= 'SELECT WEEK(date, 1) as week, sum(case when (WEEKDAY(date) = 0) then (a.count) else 0 end) as attendance_monday, sum(case when (WEEKDAY(date) = 1) then (a.count) else 0 end) as attendance_tuesday, sum(case when (WEEKDAY(date) = 2) then (a.count) else 0 end) as attendance_wednesday, sum(case when (WEEKDAY(date) = 3) then (a.count) else 0 end) as attendance_thursday, sum(case when (WEEKDAY(date) = 4) then (a.count) else 0 end) as attendance_friday, sum(case when (WEEKDAY(date) = 5) then (a.count) else 0 end) as attendance_saturday, sum(case when (WEEKDAY(date) = 6) then (a.count) else 0 end) as attendance_sunday FROM 4w_accounting a JOIN 4w_branch_prices p ON a.price_type_id = p.id JOIN 4w_branches b ON a.branch_id = b.id WHERE a.branch_id = "' . $_POST['branch_id'] . '" GROUP BY week ORDER BY week;';
$result = $connection_4w->query($sql);
?>

<h2 class="report-heading">Weekly attendance</h2>
<div id="chart2" class="report-column-small">
</div>

<table id="datatable_for_chart2" class="report-datatable">
	<caption>Attendance</caption>
	<thead>
	<tr>
		<th>Week</th>
		<th>Monday</th>
		<th>Tuesday</th>
		<th>Wednesday</th>
		<th>Thursday</th>
		<th>Friday</th>
		<th>Saturday</th>
		<th>Sunday</th>
	</tr>
	</thead>
	<tbody>
	<?php
	$num_weeks = 0;
	while ($row = mysqli_fetch_assoc($result)) {
		$num_weeks++;
		$year = (($row['week'] - 39) > 0) ? 2017 : 2018;
		$first_day = getStartAndEndDate($row['week'], $year)['week_start']->format('d.m.');
		$week_number_from_october = (($row['week'] - 39) > 0) ? ($row['week'] - 39) :  ($row['week'] + 9);
		?>
		<tr>
			<td><?php echo $week_number_from_october; ?></td>
			<td><?php echo $row['attendance_monday']; ?></td>
			<td><?php echo $row['attendance_tuesday']; ?></td>
			<td><?php echo $row['attendance_wednesday']; ?></td>
			<td><?php echo $row['attendance_thursday']; ?></td>
			<td><?php echo $row['attendance_friday']; ?></td>
			<td><?php echo $row['attendance_saturday']; ?></td>
			<td><?php echo $row['attendance_sunday']; ?></td>
		</tr>
		<?php
		echo "<!--" . $first_day . "-->";
	}
	?>
						</tbody>
					</table>

				</div>
<?php
$sql= 'SELECT sum(case when (WEEKDAY(date) = 0) then (a.count) else 0 end) as attendance_monday, sum(case when (WEEKDAY(date) = 1) then (a.count) else 0 end) as attendance_tuesday, sum(case when (WEEKDAY(date) = 2) then (a.count) else 0 end) as attendance_wednesday, sum(case when (WEEKDAY(date) = 3) then (a.count) else 0 end) as attendance_thursday, sum(case when (WEEKDAY(date) = 4) then (a.count) else 0 end) as attendance_friday, sum(case when (WEEKDAY(date) = 5) then (a.count) else 0 end) as attendance_saturday, sum(case when (WEEKDAY(date) = 6) then (a.count) else 0 end) as attendance_sunday FROM 4w_accounting a JOIN 4w_branch_prices p ON a.price_type_id = p.id JOIN 4w_branches b ON a.branch_id = b.id WHERE a.branch_id = "' . $_POST['branch_id'] . '"';
$result = $connection_4w->query($sql);

	?>
	<h2 class="report-heading">Stats</h2>
		<table class="table table-striped">
			<tr>
				<td></td>
				<td>Monday classes</td>
				<td>Wednesday classes</td>
				<td>Thursday classes</td>
			</tr>
			<?php
			while ($row = mysqli_fetch_assoc($result)) {
				# FIX only for 2018:
				$num_weeks = 33;
				?>
				<tr>
					<td>AVERAGE ATTENDANCE (from <?php echo $num_weeks; ?> weeks)</td>
					<td><?php echo round($row['attendance_monday'] / $num_weeks, 2); ?></td>
					<td><?php echo round($row['attendance_wednesday'] / $num_weeks, 2); ?></td>
					<td><?php echo round($row['attendance_thursday'] / $num_weeks, 2); ?></td>
				</tr>
				<tr>
					<td>TOTAL STUDENTS CAME PER CLASS</td>
					<td><?php echo $row['attendance_monday']; ?></td>
					<td><?php echo $row['attendance_wednesday']; ?></td>
					<td><?php echo $row['attendance_thursday']; ?></td>
				</tr>
				<tr>
					<td>TOTAL STUDENTS CAME</td>
					<td colspan="3"><?php echo $row['attendance_monday'] + $row['attendance_wednesday'] + $row['attendance_thursday']; ?></td>
				</tr>
			<?php
			}
			?>
		</table>

	<?php
		$sql= 'SELECT sum(case when p.student = 1 then (a.count * p.price) else 0 end) as students_money_made, sum(case when p.student = 0 then (a.count * p.price) else 0 end) as non_students_money_made, p.currency FROM 4w_accounting a JOIN 4w_branch_prices p ON a.price_type_id = p.id JOIN 4w_branches b ON a.branch_id = b.id WHERE a.branch_id = "' . $_POST['branch_id'] . '"';
		$result = $connection_4w->query($sql);

		?>
		<table class="table table-striped">
			<tr>
				<td></td>
				<td>Students</td>
				<td>Non-Students</td>
			</tr>
			<?php
			while ($row = mysqli_fetch_assoc($result)) {
				?>
				<tr>
					<td>TOTAL REVENUES PER TYPE</td>
					<td><?php echo $row['students_money_made']; ?></td>
					<td><?php echo $row['non_students_money_made']; ?></td>
				</tr>
				<tr>
					<td>TOTAL REVENUES</td>
					<td colspan="2"><?php echo $row['students_money_made'] + $row['non_students_money_made']; ?></td>
				</tr>
				<?php
			}
			?>
		</table>

		<?php
		$sql= 'SELECT sum(case when a.price_type_id = 1 then (a.count * p.price) else 0 end) as students_one_time, sum(case when a.price_type_id = 2 then (a.count * p.price) else 0 end) as non_students_one_time, sum(case when a.price_type_id = 3 then (a.count * p.price) else 0 end) as students_voucher, sum(case when a.price_type_id = 4 then (a.count * p.price) else 0 end) as non_students_voucher, sum(case when a.price_type_id = 1 then (a.count) else 0 end) as students_one_time_count, sum(case when a.price_type_id = 2 then (a.count) else 0 end) as non_students_one_time_count, sum(case when a.price_type_id = 3 then (a.count) else 0 end) as students_voucher_count, sum(case when a.price_type_id = 4 then (a.count) else 0 end) as non_students_voucher_count, p.currency FROM 4w_accounting a JOIN 4w_branch_prices p ON a.price_type_id = p.id JOIN 4w_branches b ON a.branch_id = b.id WHERE a.branch_id = "' . $_POST['branch_id'] . '"';
		$result = $connection_4w->query($sql);

		?>
		<table class="table table-striped">
			<tr>
				<td></td>
				<td>Student 1x</td>
				<td>Non-Student 1x</td>
				<td>Student Voucher</td>
				<td>Non-Student Voucher</td>
			</tr>
			<?php
			while ($row = mysqli_fetch_assoc($result)) {
				?>
				<tr>
					<td>TOTAL REVENUES PER TYPE</td>
					<?php # FIX only for 2018: ?>
					<td><?php echo 44344;#$row['students_one_time']; ?></td>
					<td><?php echo 146034;#$row['non_students_one_time']; ?></td>
					<td><?php echo 56628;#$row['students_voucher']; ?></td>
					<td><?php echo 67953;#$row['non_students_voucher']; ?></td>
				</tr>
				<tr>
					<td>TOTAL REVENUES 1x vs Voucher</td>
					<?php # FIX only for 2018: ?>
					<td colspan="2"><?php echo 190379;#echo $row['students_one_time'] + $row['non_students_one_time']; ?></td>
					<td colspan="2"><?php echo 124581;#echo $row['students_voucher'] + $row['non_students_voucher']; ?></td>
				</tr>
				<tr>
					<td>ENTRANCES 1x vs Voucher</td>
					<td colspan="2"><?php echo 2014;#echo $row['students_one_time_count'] + $row['non_students_one_time_count']; ?></td>
					<td colspan="2"><?php echo 198;#echo $row['students_voucher_count'] + $row['non_students_voucher_count']; ?> x 10</td>
				</tr>
				<?php
			}
			?>
		</table>
<?php

// =============================
// 4. WRAP-UP
// =============================

?>
		<div class="cashier-done">Results as: <a href="http://4waterdev.org/wp-content/themes/Parallax-One/cashier_app/results/cashier-3-2018-results.csv">CSV</a></div>
		<div class="cashier-done">Missed classes: <strong>10%</strong></div>
		<div class="cashier-done">See the REAL counts + how the estimations of missed classes were made: <a href="http://4water.org/wp-content/themes/Parallax-One/cashier_app/results/cashier-3-2018-fixes-1.png">revenues</a> <a href="http://4water.org/wp-content/themes/Parallax-One/cashier_app/results/cashier-3-2018-fixes-2.png">attendance</a> <a href="http://4water.org/wp-content/themes/Parallax-One/cashier_app/results/cashier-3-2018-fixes-3.png">stats</a></div>
<?php

	if ($form_submitted) {
		$branch_url = getCurrentBranchUrl($_POST, $connection_4w, "cashier");
		$closest_lesson = get_closest_lesson($connection_4w, $_POST['branch_id']);
?>
				<div class="report-footer">
				<a href="<?php echo $branch_url; ?>"><button>Cashier next class (<?php echo $closest_lesson[1] . ' ' . $closest_lesson[2] . ')'; ?></button></a>
				</div>
<?php
	}
?>