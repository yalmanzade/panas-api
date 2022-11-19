<?php
require_once './models/course.php';
require_once './models/database.php';
require_once './models/meeting.php';
$daysoftheweek = array("Monday", "Tuesday", "Wednesday","Thursday ","Friday", "Saturday");
$hoursMorning = array("10","11","12");
$hoursAfternoon = array("1","2","3");
$minutes = array("00","10","20","30","40","50");
$adminCodes = array(2353212312,1287686522,4353456420,6436634575,4356436532,5644564562);
$db = new Database();
$courseObj = new Course($db);
$courses = $courseObj->getCourses();

?>