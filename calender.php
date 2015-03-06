<?php  header("content-type: text/html; charset=utf-8"); ?>
<?php  ?>
<table class="table table-striped table-hover">
	<?php
		//注：32位机器或者32位PHP版本可能只能计算到2038年之前的月份
		//若没有GET方法传入参数，则使用服务器本地当前日期；否则使用传入的参数，方便跳转月份
		$year=date("Y");
		$month=date("n");
		$alert="<div class='alert alert-warning'>输入的日期格式有误！</div>";
		$alertYear="<div class='alert alert-warning'>无法计算1901年以前的日历！</div>";
		if($_REQUEST) {

			$year=$_REQUEST["year"];
			$month=$_REQUEST["month"];
		}
		if(!in_array($month, array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"))) { echo $alert; exit;}
		if($year<1901){ echo $alertYear; exit;}
	?>
	<caption><h4><?php echo $year; ?>&nbsp;年&nbsp;<?php echo $month; ?>&nbsp;月</h4></caption>
	<?php 

		//计算当前日期，当月天数，获得星期数据，将默认星期天数字0改为7，方便处理循环
		$today=date("j");
		$days=date("t", strtotime("$year-$month-01"));
		$week=date("w", strtotime("$year-$month-01"));
		if($week==0) {$week=7;}
 	?>
 	<tr>
 		<th>一</th>
 		<th>二</th>
 		<th>三</th>
 		<th>四</th>
 		<th>五</th>
 		<th>六</th>
 		<th>日</th>
 	</tr>
 	<tr>
 	<?php
 		//插入空白无日期区域,循环次数为当前月第一天的星期数-1
 		for($space=1; $space<$week; $space++) {
 			echo "<td>-</td>";
 		}
 		//循环插入数据，当到达周日时换行输出；标记当前日期为红色
 		for($day=1; $day<=$days; $day++) {
 			if(($day+$week-1)%7===0) {
 				if($day==$today && $year==date("Y") && $month==date("n")) {
					echo "<td style='background-color: pink;'>$day</td>";
 					echo "</tr>";
 					echo "<tr>";
 				}
 				echo "<td>$day</td>";
 				echo "</tr>";
 				echo "<tr>";
 			}else {
 				if($day==$today && $year==date("Y") && $month==date("n")) {
					echo "<td style='background-color: pink;'>$day</td>";
 				} else {			
 					echo "<td>$day</td>";
 				}
 			}
 		}
 		//尾部补足
 		$spacing=36-$days-$week<0?43-$days-$week:36-$days-$week;
 		for($footer=1; $footer<=$spacing; $footer++) {
 			echo "<td>-</td>";
 		}
 	 ?>
 	</tr>
 </table>
	
