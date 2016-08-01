<?php

#Make Connection to DB
$host = '104.236.109.87';
$user = 'node-1-app-1';
$pswd ='Lepor!da3FfS';
$con = new mysqli($host, $user, $pswd, 'jobs');

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

#Register Worker
$rand = rand(1000, 1999);
$worker = $rand;
$app = 1;
$register = mysqli_query($con,"INSERT INTO workers (worker,app) VALUES ($worker,$app)");

#Fetch Job
$job = mysqli_fetch_assoc(mysqli_query($con, "SELECT `id`, `target` FROM `jobs` WHERE `worker` = '0' ORDER BY `id` ASC LIMIT 1"));
$job_ID = $job['id'];
$lock = mysqli_query($con, "UPDATE `jobs` SET `worker` = $worker WHERE `id` = $job_ID");

#Do Job
$target_IP = $job['target'];
exec("fping -c 1 -p 1 $target_IP", $output);

#Offload Data
foreach($output as $target){
	$host = explode(" :", $target);
	$host = $host[0];

	$time = explode(" ", $target);
	$time = $time[5];

	$data = mysqli_query($con,"INSERT INTO pings (target,ptime) VALUES ('$host',$time)");

}

#Remove Worker
$delete = mysqli_query($con,"DELETE FROM workers WHERE worker = $worker");
#close DB Connection
mysqli_close($con);
