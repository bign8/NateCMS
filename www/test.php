<?php
echo '<pre>';
print_r($_REQUEST);
print_r($_REQUEST['a']);

echo json_encode($_REQUEST['a']) . "\n";

echo '$.param({\'a["tx"]\':\'b\',\'a["br"]\':\'c\'}) = a%5B%22tx%22%5D=b&a%5B%22br%22%5D=c' . "\n\n" ;

?>
encode/decode all content this way?

or, have another column `encoded` type = enum('yes', 'no') and decode based on that