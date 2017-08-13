<?php
// nalezy ustawic dane logowania do bazy
$host = 'localhost'; //host
$db_user = 'root'; //nazwa uzytkownika
$db_pass =''; //haslo
$database = 'db'; //nazwa bazy danych
$prefix = 'filelist_'; //prefix dodawany do poczatku nazwy bazy danych

$def_path = 'C:/'; // domyślna ścieżka w formacie C:/

// instalacja nastapi w przypadku braku odpowiedniej tabeli w bazie danych
$con = @new mysqli($host, $db_user, $db_pass, $database);
if ($con->connect_error)
{
    die('Błąd: Nie można ustanowić połączenia z bazą danych'.PHP_EOL.'</body>');
}

mysqli_select_db($con,'db');
$table_exists = mysqli_query($con, "SELECT * FROM ".$prefix."paths");

if($table_exists !== FALSE)
{
   //echo('Istnieją odpowiednie tabele w bazie danych<br />'.PHP_EOL);

} else if ($def_path == '') {
	echo ('Ustaw katalog główny w zmiennej $def_path aby przejść do instalacji<br />'.PHP_EOL);
	echo ('Może to być katalog, z którego uruchomiono skrypt:<br />'.PHP_EOL);
	$script_path = str_replace("\\","/",dirname(__FILE__));
	echo $script_path;
		$arr = str_split($script_path);
		$arr_count = count($arr);
		if ($arr[$arr_count-1] !== '/') {echo ('/');}
	echo PHP_EOL.'</body>';
	die();
}
else
{

$install_step_i = mysqli_query($con, "CREATE TABLE `".$prefix."paths` ( `id` INT(16) NOT NULL , `current_path` VARCHAR(255) NOT NULL , `current_key` INT(16) NOT NULL, `def` VARCHAR(255), PRIMARY KEY(`id`) ) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_unicode_ci");
$install_step_ii = mysqli_query($con, "INSERT INTO `".$prefix."paths` (`id`, `current_path`, `current_key`, `def`) VALUES ('1', '".$def_path."', '999', '".$def_path."')");

echo 'Witaj! Instalacja i pierwsze uruchomienie zakończyły się sukcesem!<br /><br />'.PHP_EOL;

}

mysqli_close($con);

//

if (!isset($_GET['key'])) {
	$_GET['key'] = '';
	$_GET['reset'] = true;
}

if (!isset($_GET['reset'])) {
	$_GET['reset'] = FALSE;
}

if (isset($_GET['open'])) {
	//echo $_GET['open'];
} else {
	$_GET['open'] = '';
	//echo '$_GET jest pusta';
}

$separator="/";

$con = @new mysqli($host, $db_user, $db_pass, $database);
if ($con->connect_error) {
    die('Błąd: Nie można ustanowić połączenia z bazą danych'.PHP_EOL.'</body>');
} else {
	//echo('Ustanowiono połączenie @ '.$host.'<br /><br />'); //Informacja o sukcesie w ustanowieniu połączenia
}

//sprawdzenie odświeżenia strony
	$result = mysqli_query($con, "SELECT current_key FROM ".$prefix."paths");
	$row = mysqli_fetch_row($result);
	$path = $row['0'];

	//echo 'Klucz z bazy: '.$row['0'].'<br />';
	//echo 'Klucz losowy: '.$_GET['key'].'<br /><br />';

	$strona_odswiezona = FALSE;

	if ($row['0']==$_GET['key']) {
			//echo('Strona odświeżona<br />');
			$strona_odswiezona = true;
	}

	mysqli_query($con, "UPDATE ".$prefix."paths SET current_key='".$_GET['key']."'");

//Powrót do katalogu domyślnego
if ($_GET['reset'] == true) {

	$result = mysqli_query($con, "SELECT def FROM ".$prefix."paths");
	$row = mysqli_fetch_row($result);
	$path = $row['0'];
	mysqli_query($con, "UPDATE ".$prefix."paths SET current_path='".$path."'");
	echo 'Obecny katalog - katalog domyślny '.$row['0'].'<br /><br />';

//Przegladanie
} else {
	$result = mysqli_query($con, "SELECT current_path FROM ".$prefix."paths");
		$result_def = mysqli_query($con, "SELECT def FROM ".$prefix."paths");
	$row = mysqli_fetch_row($result);
	$path = $row['0'];
		$row_def = mysqli_fetch_row($result_def);
		$path_def = $row_def['0'];
		if ($path_def == $path) {$separator = '';}
	$new_path = $path.$separator.$_GET['open'];
		if ($strona_odswiezona==FALSE)
		{
				mysqli_query($con, "UPDATE ".$prefix."paths SET current_path='".$new_path."'");
		}

	$result = mysqli_query($con, "SELECT current_path FROM ".$prefix."paths");

	$row = mysqli_fetch_row($result);
	echo 'Obecny katalog: '.$row['0'].'<br /><br />'.PHP_EOL;
	$path = $row['0'];
	$separator = '/';
}

echo ('<a href="'.basename(__FILE__).'?reset=true">/...</a><br /><br />'.PHP_EOL);

//Nowy losowy klucz przeciw odswiezaniu
$key = rand(1001,9999);

$file_list = @scandir($path);
if ($file_list == false) {
	die('<a href="'.basename(__FILE__).'?open=..&key='.$key.'">/..</a><br /><br />'.PHP_EOL.
	'Nie udało się otworzyć folderu <br /><br />'.PHP_EOL.
	'<a href="'.basename(__FILE__).'?reset=true">/...</a>'.PHP_EOL.
	'</body>');
}

$ile_elementow=count($file_list);

$ile_elementow_popr = $ile_elementow-2;
if (!$file_list == false) {
//echo 'Elementów: '.$ile_elementow_popr.'<br /><br />'.PHP_EOL;
}
//Lista
for ($i=0; $i<$ile_elementow; $i++) {
		if ($i==0 && $file_list[$i]=='.') {} //omiń kropkę będacą linkiem do bieżącego folderu
		else {
			$fullpath = $path.$separator.$file_list[$i];
			if (is_dir($fullpath) == true)
			{
			echo '<p><a href="'.basename(__FILE__).'?open='.$file_list[$i].'&key='.$key.'">';
			print "/"; //znacznik folderu
			print ($file_list[$i]);
			echo '</a></p>';
			//print('<br />');
			if ($i==1 && $file_list[$i]=='..') {echo '<br />';} // przełam linię po linku typu wstecz
			}
			else
			{
			echo ('<p>'.$file_list[$i].'</p>');
			//echo '<br />';
			}
			echo PHP_EOL;
	}
}
mysqli_close($con); //zamyka polaczenie

if (!$ile_elementow_popr == 0) {echo '<br />';} //nie łam linii gdy lista plików jest pusta
echo ('<p><a href="'.basename(__FILE__).'?reset=true">/...</a></p>');

//echo '<br /><br /> Script executed: '.basename(__FILE__).' @ '.dirname(__FILE__);
//echo basename(__FILE__, '.php');   //removes extension
//dirname(__FILE__); 			//folder path without file name;
//echo '<br />Absolute script path is '.(__FILE__);
?>

<div></div>

<script>
var a = document.getElementsByTagName('p');
var l = a.length;
for (m=0;m<l;m++) {
a[m].className ="hidden";
}
var j = 0;
var showLinks = setInterval(function(){
a[j].className = "shown";
j++;
if (j>=l) {clearInterval(showLinks)}
},
10
 //interval [ms]
);
</script>

<script>
var timeoutID;
var text = " >>";
var getLinks = document.getElementsByTagName('a');

var linksQuantity = getLinks.length;
var i = 0;
for (i;i<linksQuantity;i++)
{
getLinks[i].addEventListener('click', clickAction )
//console.log(getLinks[i]);
}

function clickAction() {
event.preventDefault();

this.className = "clicked";

var newDiv = document.createElement('div');

document.getElementsByTagName('div')[0].appendChild(newDiv);
newDiv.className = 'loading';
newDiv.innerHTML = "Loading...";
window.setTimeout(function() {newDiv.innerHTML = "Building structure...";},200);
window.setTimeout(function() {newDiv.innerHTML = "Making list...";},400);
var href = this.href;
window.setTimeout(function() { window.location.href = href} , 800)
	}
</script>
