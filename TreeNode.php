<?php 

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
 ?>
