<?php
include("config.php");

/*
	*variabler som kan bli hämtade testa dem så de int egör något skumt mot databasen
	*hämta data från mysql db
	*presentera datan från databasen som json objekt
*/
//creates a connection to server
$conn = mysqli_connect(HOST, USER, PASSWORD, DATABASE) or die(mysqli_error());
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 
$sql_main = "SET NAMES 'utf8'";
$sql_second ="CHARSET 'utf8'";
$conn->query($sql_main);
$conn->query($sql_second);
//mysqli::set_charset('utf8'); // when using mysqli
//sets utf-8 as CHARSET in mySQL§
function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
    
}

function randomID($location){
	global $conn;
	$x = 0;
	$result = true;
	while ($result){
		$randomString =  generateRandomString(16);
		//generera ett random id på 16 tecken och kolla så att det inte är taget. om taget 
		$sql = "SELECT id FROM `users` WHERE `id` = '$randomString';";
		/*
			select 1 
			from (
			    select username as username from tbl1
			    union all
			    select username from tbl2
			    union all
			    select username from tbl3
			) a
			where username = 'someuser'
		*/
		$result = $conn->query($sql);

		if ($result->num_rows == 0){
			var_dump($randomString);
			$result = false;
			
		}else{
			echo "$randomString<br>";
		}


		$x++;
	}

}
$method = "select";

	switch ($method) {
		case 'insert':
			/*new user*/
			$id = randomID('users');
			$sql = "INSERT INTO `dethandeengrrej`.`users` (`id`, `nickname`, `password`, `email`, `userlevel`, `created`, `lastlogdin`) VALUES ('random string of 16 characters', 'username', 'password hased', 'E-mail', 'userlvl', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";
			break;
		case 'select':
		$id = randomID('users');
			$sql = "SELECT * FROM `users`;";
			# code...
			break;
		default:
			# code...
			break;
	}

/*presenterar datan som json*/

$myArray = array();
if ($result = $conn->query($sql)) {

    while($row = $result->fetch_array(MYSQL_ASSOC)) {
            $myArray[] = $row;
    }
    echo json_encode($myArray);
}

$result->close();
$conn->close();





?>