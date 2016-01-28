<?php
require 'TreeNode.php';
require 'TreeRB.php';

$tree = new RBTree();

for ($i = 0; $i < 1000; ++$i) {
	$key = rand() % 9 + 1;
	if ($tree->findNode($key)) {
		$tree->deleteNode($key);
	}
	else {
		$tree->insertNode($key, null);
	}
}
print_r($tree);



?>
