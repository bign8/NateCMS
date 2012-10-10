<?php
//print_r($_SERVER);
/*
$fp = fsockopen($_SERVER['REMOTE_ADDR'], $_SERVER['REMOTE_PORT'], $errno, $errstr);
//udp,tcp, ssl, "ssl://".
if (!$fp) {
    echo "ERROR: $errno - $errstr<br />\n";
} else {
    fwrite($fp, "Demo\n");
    //echo fread($fp, 26);
    fclose($fp);
}
//*/
//echo print_r($_SERVER, true);
?>


<form id="webLogin" action="/loginClass.php" method="post" name="webLogin">
<h3>Web Administration Login</h3>
<!-- http://www.javascript-coder.com/html-form/html-form-submit.phtml -->
<table>
<tbody>
<tr>
<td><label for="username">Username:</label></td>
<td><input id="username" class="required" type="text" name="username" /></td>
</tr>
<tr class="test">
<td><label for="password">Password:</label></td>
<td><input id="password" class="required" type="password" name="password" /></td>
</tr>
<tr class="test" style="display: none;">
<td><label for="email">Email:</label></td>
<td><input id="email" class="required" type="text" name="email" /></td>
</tr>
<tr style="text-align: center;">
<td><input class="test" type="submit" name="login" value="Login" /><input class="test" style="display: none;" type="submit" name="check" value="Check" /></td>
<td><a class="test" onclick="$('.test').toggle();" href="#lost-pass">Forgot your password?</a><a class="test" style="display: none;" onclick="$('.test').toggle();" href="#lost-pass">Whoops, got it!</a></td>
</tr>
</tbody>
</table>
</form>