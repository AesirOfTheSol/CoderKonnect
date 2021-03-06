<?php
    $dbhost = "localhost";
    $dbuser = "n_motta";
    $dbpass = "BostonHacks2018";
    $dbname = "CoderKonnect";

    $dbcon = new mysqli ($dbhost, $dbuser, $dbpass, $dbname);
    if ($dbcon->connect_error) die ($dbcon->connect_error);

    // do a query, check for error, return result
    function dbquery ($q)
    {
        global $dbcon;
        $r = $dbcon->query ($q);
        if (!$r) die ("$q error: $dbcon->error");
        return $r;
    }

    // easier than typing $dbcon->real_escape_string all over the place
    function dbescape ($s)
    {
        global $dbcon;
        return $dbcon->real_escape_string ($s);
    }
	
	// creates a password hash from a password
	function passhash ($password)
	{
		$salt = base64_encode (openssl_random_pseudo_bytes (17));
		$salt = '$2y$07$' . str_replace ('+', '.', substr ($salt, 0, 22));
		$hash = crypt ($password, $salt);
		return $hash;
	}
	
	// test input password with hashed database password
	function passtest ($password, $passhash)
	{
		if (strpos ($passhash, '$2y$07$') !== 0) return FALSE;
		$salt = substr ($passhash, 0, 29);
		$hash = crypt ($password, $salt);
		return $hash == $passhash;
	}
?>