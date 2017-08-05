<!DOCTYPE html>
<html>
<head>
<title>save</title>
<style>
body {font-size:48px;}
</style>
</head>
<body>
<div id="container">
<?php
$filename = 'my_current_external_ip.txt';
// create file if not exists
$fh = fopen($filename, 'a');
fclose($fh);

$ip = file_get_contents('https://api.ipify.org'); //call API
$ipFromLocalFile = file_get_contents($filename);

if ($ip!==$ipFromLocalFile)
{
file_put_contents($filename, $ip);
//login details
$ftp_server = '';
$ftp_user_name = '';
$ftp_user_pass = '';

$remote_file = $filename;

$conn_id = ftp_connect($ftp_server);
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

ftp_pasv($conn_id, true); //turn passive mode on

  if (ftp_put($conn_id, $remote_file, $filename, FTP_ASCII))
  {
    echo "Successfully uploaded $filename\n";
    exit;
  }
  else
  {
    echo "There was a problem while uploading $filename\n";
    exit;
  }
    ftp_close($conn_id);
}
else
{
  echo ('IP address has not changed since last check');
}
?>
<br />
</div>
<div id="date">
This page reloads automatically every <span id="reloadInterval"></span><br />
Last update: </div>
<script>
var reloadInterval = 60000; //type ms
setInterval(function() {
window.location.reload(true);
},reloadInterval); //reloads every reloadInterval
document.getElementById('reloadInterval').innerHTML += (reloadInterval/1000)+"sec";
var date = new Date();
var addZerosToItems = [date.getHours(),date.getMinutes(),date.getSeconds(),date.getDate(),date.getMonth()+1,date.getFullYear()];
for(i=0;i<addZerosToItems.length;i++) { if (addZerosToItems[i]<10) { addZerosToItems[i] = "0"+addZerosToItems[i] };}
var hour = addZerosToItems[0];
var minute = addZerosToItems[1];
var second = addZerosToItems[2];
var day = addZerosToItems[3];
var month = addZerosToItems[4];
var year = addZerosToItems[5];
document.getElementById('date').innerHTML += hour+":"+minute+":"+second+" | "+day+"/"+month+"/"+year;
</script>
</body>
</html>
