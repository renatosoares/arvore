<?php

require 'TreeRB.php';

$tree = new TreeRB();
//populando array
$alfa = range("A", "R");
for ($i = 0; $i < 1000; ++$i) {
	$key = rand() % 9 + 1;
	if ($tree->findNode($key)) {
		$tree->deleteNode($key);
	}
	else {


		$tree->insertNode($key, $alfa[$key]);
	}
}
//$tree->preOrder($Tree->root);
// foreach ($tree->root as $va1lue) {
// 	echo $va1lue . "<br>";
// }
print_r($tree);
//print_r($tree->root);
echo "<br>";
//print("iiii");
$tree->preOrder($tree->root);




?>
