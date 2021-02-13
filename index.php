<?php

include_once("system/init.php")

?>

<!DOCTYPE html>
<html>

<head>
	<title>漳州职业技术学院 一键健康打卡</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdn.staticfile.org/popper.js/1.15.0/umd/popper.min.js"></script>
	<script src="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>

<body>

	<div class="container">

		<?php

		foreach ($insertdata as $k => $v) {

			$data = datavalue($insertdata[$k]);

			$post_data = json_encode($data, JSON_UNESCAPED_UNICODE); //转数组为json

			$r_data = send_post('https://yzsfw.fjzzit.edu.cn/app/saveJkDkInfo', $post_data);

			$r_data = json_decode($r_data, true);

			//print_r($r_data);//打印返回值

			$newdata = file_get_contents("https://yzsfw.fjzzit.edu.cn/app/getJkDkList?sign=$data[sign]&userType=1&userCode=$data[userCode]&unitCode=11314&isRead=0");

			$newdata = json_decode($newdata, true);

			//print_r($newdata[Rows][0][dkRq]);//打印返回值

		?>

			<?php if ($r_data["Rows"] == 1) { ?>
				<div class="alert alert-success">
					<strong><?php echo "$data[userName]"; ?>打卡成功!</strong> 最后打卡日期:<?php echo $newdata['Rows'][0]['dkRq']; ?>
				</div>
				<?php
				$body = $data['userName'] . "打卡成功! 最后打卡日期:" . $newdata['Rows'][0]['dkRq'];
				email($insertdata[$k]['email'], $body);
				?>
			<?php } else { ?>
				<div class="alert alert-danger">
					<strong><?php echo "$data[userName]"; ?>打卡失败!</strong> 最后打卡日期:<?php echo $newdata['Rows'][0]['dkRq']; ?>
				</div>
				<?php
				$body = $data['userName'] . "打卡失败! 最后打卡日期:" . $newdata['Rows'][0]['dkRq'];
				email($insertdata[$k]['email'], $body);
				?>
			<?php } ?>

		<?php } ?>

	</div>
</body>

</html>