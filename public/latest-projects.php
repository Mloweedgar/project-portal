<?php
$sAnnouncementTPL = '
<div class="col-6">
    <hgroup>
        <h2><a href="[+fs.url+]">[+fs.title+]</a></h2>
    </hgroup>
    <p>[+fs.description+]</p>
</div>';

$sResult = "";
// Announcements Total
$nTotal = 2;
$link = mysqli_connect("localhost", "znzppp_platform", "wLWhe%G2qcX{", "znzppp_platform");

if (!$link) {
  echo "DB CON ERROR";
  exit;
}else {

    $sSQL = "SELECT p.id,p.`name`,i.project_need FROM projects p join project_information i ON p.id=i.project_id ORDER BY p.created_at DESC LIMIT ".$nTotal;
    mysqli_query($link,$sSQL);
    $result = mysqli_query($link,$sSQL);
    while($row = $result->fetch_assoc()) {
      $sTmp = $sAnnouncementTPL;
      $sUrl = "/project/".$row["id"]."/".strtolower(str_replace(" ","-",$row["name"]));
      $sTmp = str_replace("[+fs.url+]",$sUrl,$sTmp);
      $sTmp = str_replace("[+fs.title+]",$row['name'],$sTmp);
      $sTmp = str_replace("[+fs.description+]",strlen($row['project_need'])>0?$row['project_need']:'Information will be published as soon as it is available.',$sTmp);
      $sResult .=$sTmp;
    }
}
$link->close();
header("Access-Control-Allow-Origin: *");
echo $sResult;
?>
