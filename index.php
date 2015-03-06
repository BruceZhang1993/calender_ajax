<!doctype html>
<html lang="zh">
<head>
	<meta charset="UTF-8">
	<title>日历的Ajax实现</title>
	<!--简单样式-->
	<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css">
	<!--<link rel="stylesheet" href="css/bootstrap.css">-->
	<script src="js/ajax.js"></script>
	<style>
		.textbox {
			width: 40px;
		}
		div {padding: 0;margin: 0;}

		#jump {
			margin-bottom: 20px;
			margin-top: 20px;
		}

		
	</style>
	<script>
	var cache = [];
	function call(url) {
		var ajax = Ajax();
		var obj = document.getElementById("table");
		if(cache[url] == undefined) {
			ajax.get(url, function(data) {
				obj.innerHTML = data;
				cache[url] = data;
			});
		}else {
			obj.innerHTML = cache[url];
		}
	}
	function prev() {
		if(month == 1) {
			year = year - 1;
			month = 12;
		}else {
			month = month - 1;
		}
		call('calender.php?year='+year+'&month='+month);
	}
	function next() {
		if(month == 12) {
			year = year + 1;
			month = 1;
		}else {
			month = month + 1;
		}
		call('calender.php?year='+year+'&month='+month);
	}
	function curr() {
		var oDate = new Date();
		year = oDate.getFullYear();
		month = oDate.getMonth() + 1;
		call('calender.php');
	}
	function jump() {
		year = document.getElementById("year").value;
		month = document.getElementById("month").value;

		call('calender.php?year='+year+'&month='+month);

	}
	</script>
</head>
<body onload="curr()">
	<div id="jump" class="container">
		<form role="form" class="form-inline">
			<div class="pull-right">
				<div class="form-group">
	    			<div class="input-group">
	      				<input class="form-control" type="text" name="year" id="year">
	      				<div class="input-group-addon">年</div>
	    			</div>
	    			<div class="input-group">
	      				<input class="form-control" type="text" name="month" id="month">
	      				<div class="input-group-addon">月</div>
	    			</div>
	    			<div class="input-group">
	    				<input type="button" class="btn btn-default" onclick="jump()" value="跳转">
	    			</div>
	  			</div>
	  		</div>
			<!--计算下一月或上一月的日期，通过地址栏传递参数-->
			<div class="pull-left">
				<a type="button" class="btn btn-default" href="javascript:prev()">上一月</a>
				<a type="button" class="btn btn-default" href="javascript:curr()">当前月</a>
				<a type="button" class="btn btn-default" href="javascript:next()">下一月</a>
			</div>
		</form>
	</div>
	<div class="container" id="table">

	</div>
</body>
</html>