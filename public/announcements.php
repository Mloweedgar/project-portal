<?php

$sAnnouncementTPL = '
<div class="content-announcement">
    <span id="date">[+fs.date+]</span>
    <h4><a href="[+fs.url+]">[+fs.title+]</a></h4>
    <hr>
</div>';

$sResult = "";
// Announcements Total
$nTotal = 5;
$link = mysqli_connect("localhost", "znzppp_platform", "wLWhe%G2qcX{", "znzppp_platform");

if (!$link) {
  echo "DB CON ERROR";
  exit;
}else {

  $sSQL = "SELECT `name`,`description`,`slug` FROM global_announcements ORDER BY updated_at LIMIT ".$nTotal;
  mysqli_query($link,$sSQL);
  $result = mysqli_query($link,$sSQL);

  $nGlobalTotal = $result->num_rows;

  // Complete with projects announcements
  if( $nGlobalTotal < $nTotal )
  {
    $IndividualTotal = $nTotal-$nGlobalTotal;
    // GET latest announcements
    $sSQL = "SELECT p.id, a.`name`, a.`description`, a.`created_at`,p.id, p.`name` AS projectName FROM pd_announcements a JOIN projects p ON a.project_details_id=p.id WHERE a.published=1 AND p.active=1 AND active=1 ORDER BY a.id DESC LIMIT ".($nTotal - $nGlobalTotal);
    mysqli_query($link,$sSQL);
    $result = mysqli_query($link,$sSQL);
    while($row = $result->fetch_assoc()) {
      $sTmp = $sAnnouncementTPL;
      $sTmp = str_replace("[+fs.date+]",$row['created_at'],$sTmp);
      $sLink = "https://information-portal.zppp.go.tz/project/".$row['id'].'/'.strtolower(str_replace(" ","-",$row['name']))."#announcements-section";
      $sTmp = str_replace("[+fs.url+]",$sLink,$sTmp);
      $sTmp = str_replace("[+fs.title+]",$row['projectName'] ."-". $row['name'],$sTmp);
      $sResult .=$sTmp;
    }
  }

}
$sResult .= '<span class="view-announcement"><a href="https://information-portal.zppp.go.tz/announcements">
        View All Announcements <i class="fas fa-angle-right" aria-hidden="true"></i></a></span>';
$link->close();
header("Access-Control-Allow-Origin: *");
echo $sResult;


?>
