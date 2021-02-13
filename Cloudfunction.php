<?php
function main_handler(){
    include_once("system/init.php");
    foreach ($insertdata as $k =>$v){
        $data=datavalue($insertdata[$k]);
        $post_data=json_encode($data,JSON_UNESCAPED_UNICODE);//转数组为json
        $r_data=send_post('https://yzsfw.fjzzit.edu.cn/app/saveJkDkInfo', $post_data);
        $r_data=json_decode($r_data,true);
        //print_r($r_data);//打印返回值
        $newdata=file_get_contents("https://yzsfw.fjzzit.edu.cn/app/getJkDkList?sign=$data[sign]&userType=1&userCode=$data[userCode]&unitCode=11314&isRead=0");
        $newdata=json_decode($newdata,true);
        if($r_data["Rows"]==1){
            $body=$data['userName']."打卡成功! 最后打卡日期:".$newdata['Rows'][0]['dkRq'];
			email($insertdata[$k]['email'],$body);
        }else{
            $body=$data['userName']."打卡失败! 最后打卡日期:".$newdata['Rows'][0]['dkRq'];
			email($insertdata[$k]['email'],$body);
        }
    }
}
