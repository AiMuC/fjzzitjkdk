<?php

/**

 * 发送post请求

 * @param string $url 请求地址

 * @param array $post_data post键值对数据

 * @return string

 */

function send_post($url, $post_data)
{


	$postdata = $post_data;

	//$postdata = http_build_query($post_data);拼接数据

	$options = array(

		'http' => array(

			'method' => 'POST',

			'header' => 'Content-type:application/json;charset=UTF-8',

			'content' => $postdata,

			'timeout' => 15 * 60 // 超时时间（单位:s）

		)

	);

	$context = stream_context_create($options);

	$result = file_get_contents($url, false, $context);



	return $result;
}

function datavalue($insertdata)
{

	$post_data = array(

		'sign' => $insertdata["sign"],

		'userType' => '1',

		'userCode' => $insertdata["userCode"],

		'userName' => $insertdata["userName"],

		'unitCode' => '11314',

		//'szDq' => ["福建省","漳州市","芗城区"],

		'szDq' => $insertdata["dq"],

		'jrTw' => '36.5',

		'jkZk' => ["健康"],

		'isJcs' => '0',

		'isWhJc' => '0',

		'jd' => '117.65391',

		'wd' => '24.51067',
	);

	//print_r($post_data);

	return $post_data;
}
