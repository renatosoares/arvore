<?php

/**
 * Nodes of the Red-Black tree
 */
class Node {
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
     * @var Node
     */
    public $left_child;
    /**
     * Reference to the right child
     * @var Node
     */
    public $right_child;
    /**
     * Reference to the parent Node
     * @var Node
     */
    public $parent;

	public function __construct($color, $key=null, $value=null, Node $parent=null, Node $left=null, Node $right=null){
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
 ?>
