<?php

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



/**
 * Nodes of the Red-Black tree
 */
class TreeNode {
    /**
     * Key of the Node element
     * @var integer
     */
    public $key;
    /**
     * Value of the Node element
     * @var null
     */
    public $value;
    /**
     * Color of the Node element
     * @var (RBTree::COLOR_RED, RBTree::COLOR_BLACK)
     */
    public $color;
    /**
     * Reference to the left child
     * @var TreeNode
     */
    public $left_child;
    /**
     * Reference to the right child
     * @var TreeNode
     */
    public $right_child;
    /**
     * Reference to the parent Node
     * @var TreeNode
     */
    public $parent;

	public function __construct($color, $key=null, $value=null, TreeNode $parent=null, TreeNode $left=null, TreeNode $right=null){
		$this->color = $color;
		$this->key = $key;
		$this->value = $value;
		$this->parent = $parent;
		$this->left_child = $left;
		$this->right_child = $right;
	}
	
	public function __toString() {
		return (string)$this->value;
	}
};

class RBTree {
	const COLOR_BLACK = true;
	const COLOR_RED = false;
    /**
     * Leaves of the tree
     * @var TreeNode
     */
    static $nil;
    /**
     * Root of the tree
     * @var TreeNode
     */
    public $root;

	public function __construct() {
		self::$nil = new TreeNode(self::COLOR_BLACK);
		$this->root = self::$nil;
	}

    /**
     * Find tree node by its key
     * @param $key
     * @return bool|TreeNode
     */
    public function findNode($key) {
		$current_node = $this->root;

		while(!is_null($current_node->key)) {
			if ($key === $current_node->key) {
				return $current_node;
			}
			if ($key < $current_node->key) {
				$current_node = $current_node->left_child;
			}
			else {
				$current_node = $current_node->right_child;
			}
		}

        //echo "Node with key $key not found";
		return false;
	}

	/**
	 * @param $key
	 * @param $value
	 * @return TreeNode
	 */
	public function insertNode($key, $value) {
		// Find where node must be placed
		$current_node = $this->root;
		$parent = null;

		while (!is_null($current_node->key)) {
			if ($key === $current_node->key) {
				//echo "Node with key $key already exists";
				return $this->root;
			}
			$parent = $current_node;
			if ($key < $current_node->key) {
				$current_node = $current_node->left_child;
			}
			else {
				$current_node = $current_node->right_child;
			}
		}

		// Create new node
		$x = new TreeNode(self::COLOR_RED, $key, $value, $parent, self::$nil, self::$nil);
		// Insert node in tree
		if (!is_null($parent->key)) {
			if ($key < $parent->key) {
				$parent->left_child = $x;
			}
			else {
				$parent->right_child = $x;
			}
		}
		else {
			$this->root = $x;
		}

		$this->insertFixup($x);

		return $x;
	}

    /**
     * Maintain Red-Black tree balance after inserting node $x
     * @param TreeNode $x
     */
    private function insertFixup(TreeNode $x) {
		// Check Red-Black properties
		while ($x !== $this->root && $x->parent->color === self::COLOR_RED) {
			// The balance has been violated
			if ($x->parent === $x->parent->parent->left_child) {
                // $x's parent is a left child of its parent
				$uncle = $x->parent->parent->right_child;
				if ($uncle->color === self::COLOR_RED) {
					// Uncle is RED
					$x->parent->color = self::COLOR_BLACK;
					$uncle->color = self::COLOR_BLACK;
					$x->parent->parent->color = self::COLOR_RED;
					// Grandfather now is active node
					$x = $x->parent->parent;
				} else {
					// Uncle is BLACK
					if ($x === $x->parent->right_child) {
						// make $x a left child
						$x = $x->parent;
						$this->rotateLeft($x);
					}
					// Recolor and rotate
					$x->parent->color = self::COLOR_BLACK;
					$x->parent->parent->color = self::COLOR_RED;
					$this->rotateRight($x->parent->parent);
				}
			} else {
                // $x's parent is a right child of its parent
				$uncle = $x->parent->parent->left_child;
				if ($uncle->color === self::COLOR_RED) {
					// uncle is RED
					$x->parent->color = self::COLOR_BLACK;
					$uncle->color = self::COLOR_BLACK;
					$x->parent->parent->color = self::COLOR_RED;
					// Grandfather now is active node
					$x = $x->parent->parent;
				} else {
					// uncle is BLACK
					if ($x === $x->parent->left_child) {
						$x = $x->parent;
						$this->rotateRight($x);
					}
                    // Recolor and rotate
					$x->parent->color = self::COLOR_BLACK;
					$x->parent->parent->color = self::COLOR_RED;
					$this->rotateLeft($x->parent->parent);
				}
			}
		}
        // Set root color to BLACK
		$this->root->color = self::COLOR_BLACK;
	}

    /**
     * Delete node with $key key
     * @param $key
     * @return bool
     */
    public function deleteNode($key) {
        // At first find node to delete
        $node = $this->findNode($key);
        if (!$node) {
            return false;
        }

        if (is_null($node->left_child->key) || is_null($node->right_child->key)) {
            // $node has a NIL node as a child
            $y = $node;
        } else {
            // Find node with a NIL node as a child
            $y = $node->right_child;
            while (!is_null($y->left_child->key)) {
                $y = $y->left_child;
            }
        }

        // $x is $y's only child
        if (!is_null($y->left_child->key)) {
            $x = $y->left_child;
        }
        else{
            $x = $y->right_child;
        }

        // Remove $y from the parent chain
        if (!is_null($x->key)) {
            $x->parent = $y->parent;
		}
		else {
			$x = new TreeNode(self::COLOR_BLACK, null, null, $y->parent);
		}

        if (!is_null($y->parent->key)) {
            if ($y === $y->parent->left_child) {
				$y->parent->left_child = $x;
			}
			else {
				$y->parent->right_child = $x;
			}
        }
        else {
            $this->root = $x;
        }

        if ($y !== $node) {
            $node->key = $y->key;
            $node->value = $y->value;
        }

        if ($y->color === self::COLOR_BLACK) {
            $this->deleteFixup($x);
        }
    }

    /**
     * Maintain Red-Black tree balance after deleting node $x
     * @param TreeNode $x
     */
    private function deleteFixup(TreeNode $x) {
        while ($x !== $this->root && $x->color === self::COLOR_BLACK) {
            if ($x === $x->parent->left_child) {
				// $x is a left child of its parent
                $brother = $x->parent->right_child;
                if ($brother->color === self::COLOR_RED) {
					$brother->color = self::COLOR_BLACK;
                    $x->parent->color = self::COLOR_RED;
                    $this->rotateLeft($x->parent);
					$brother = $x->parent->right_child;
                }
                if ($brother->left_child->color === self::COLOR_BLACK && $brother->right_child->color === self::COLOR_BLACK) {
					// Both of the $brother's children are BLACK
					$brother->color = self::COLOR_RED;
                    $x = $x->parent;
                }
                else {
                    if ($brother->right_child->color === self::COLOR_BLACK) {
						// $brother's left child is RED and right child is BLACK
						$brother->left_child->color = self::COLOR_BLACK;
						$brother->color = self::COLOR_RED;
                        $this->rotateRight($brother);
						$brother = $x->parent->right_child;
                    }
					$brother->color = $x->parent->color;
                    $x->parent->color = self::COLOR_BLACK;
					$brother->right_child->color = self::COLOR_BLACK;
                    $this->rotateLeft($x->parent);
                    $x = $this->root;
                }
            }
            else {
				// $x is a right child of its parent
				$brother = $x->parent->left_child;
                if ($brother->color === self::COLOR_RED) {
					$brother->color = self::COLOR_BLACK;
                    $x->parent->color = self::COLOR_RED;
                    $this->rotateRight($x->parent);
					$brother = $x->parent->left_child;
                }
                if ($brother->right_child->color === self::COLOR_BLACK && $brother->left_child->color === self::COLOR_BLACK) {
					// Both of the $brother's children are BLACK
					$brother->color = self::COLOR_RED;
                    $x = $x->parent;
                }
                else {
                    if ($brother->left_child->color === self::COLOR_BLACK) {
						// $brother's left child is BLACK and right child is RED
						$brother->right_child->color = self::COLOR_BLACK;
						$brother->color = self::COLOR_RED;
                        $this->rotateLeft($brother);
						$brother = $x->parent->left_child;
                    }
					$brother->color = $x->parent->color;
                    $x->parent->color = self::COLOR_BLACK;
					$brother->left_child->color = self::COLOR_BLACK;
                    $this->rotateRight($x->parent);
                    $x = $this->root;
                }
            }
        }
        $x->color = self::COLOR_BLACK;
    }

    /**
     * Rotate node $x to left
     * @param TreeNode $x
     */
    private function rotateLeft(TreeNode $x) {
		$y = $x->right_child;
		// Establish $x->right link
		$x->right_child = $y->left_child;
		if (!is_null($y->left_child->key)) {
			$y->left_child->parent = $x;
		}
		// Establish $y->parent link
		$y->parent = $x->parent;
		if ($x->parent && !is_null($x->parent->key)) {
			if ($x === $x->parent->left_child) {
                // $x is left subtree
				$x->parent->left_child = $y;
			} else {
				$x->parent->right_child = $y;
			}
		}
		else {
			$this->root = $y;
		}
		// link $x and $y
		$y->left_child = $x;
		$x->parent = $y;
	}

    /**
     * Rotate node x to right
     * @param TreeNode $x
     */
    private function rotateRight(TreeNode $x) {
		$y = $x->left_child;
		// Establish $x->left link
		$x->left_child = $y->right_child;
		if (!is_null($y->right_child->key)) {
			$y->right_child->parent = $x;
		}
		// Establish $y->parent link
		$y->parent = $x->parent;
		if ($x->parent && !is_null($x->parent->key)) {
			if ($x === $x->parent->left_child) {
                // $x is left subtree
				$x->parent->left_child = $y;
			}
			else {
				$x->parent->right_child = $y;
			}
		}
		else {
			$this->root = $y;
		}
		// link $x and $y
		$y->right_child = $x;
		$x->parent = $y;
	}
}
