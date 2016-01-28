<?php
/**
 *
 */
class TreeRB {
  const COLOR_BLACK = true;
  const COLOR_RED = false;
  /**
   * Folhas da árvore
   * @var TreeNode
   */
   static $nil;
   /**
    * Raiz da árvore
    * @var TreeNode
    */
   public $root;

   public function __construct() {
     self::$nil = new TreeNode(self::COLOR_BLACK);
     $this->root = self::$nil;
   }


   	/**
   	 * @param $key
   	 * @param $value
   	 * @return TreeNode
   	 */
   	public function insertNode($key, $value) {
   		// Encontrar onde o nodo deve ser colocado
   		$current_node = $this->root;
   		$parent = null;

   		while (!is_null($current_node->key)) {
   			if ($key === $current_node->key) {
   				//echo "Já existe nó com chave $key";
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

   		// cria novo node
   		$x = new TreeNode(self::COLOR_RED, $key, $value, $parent, self::$nil, self::$nil);
   		// Inserir o node na árvore
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

}
?>
