<?php

require 'TreeRB.php';

$tree = new TreeRB();

for ($i = 0; $i < 1000; ++$i) {
	$key = rand() % 4 + 1;
	if ($tree->findNode($key)) {
		$tree->deleteNode($key);
	}
	else {
		$tree->insertNode($key, "A");
	}
}
$tree->preOrder($Tree->root);
//print_r($tree);
//print_r($tree->root);

print("iiii");


?>
