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


    /**
     * Manter o equilíbrio de árvore rubro-negra depois de inserir o nó $x
     * @param TreeNode $x
     */
    private function insertFixup(TreeNode $x) {
		// Verificar as propriedades do rubro-negro
		while ($x !== $this->root && $x->parent->color === self::COLOR_RED) {
			// O balanceamento foi violado
			if ($x->parent === $x->parent->parent->left_child) {
                // pai do $x é um filho esquerdo de seu pai
				$uncle = $x->parent->parent->right_child;
				if ($uncle->color === self::COLOR_RED) {
					// Tio é vermelho
					$x->parent->color = self::COLOR_BLACK;
					$uncle->color = self::COLOR_BLACK;
					$x->parent->parent->color = self::COLOR_RED;
					// Avô agora é nó ativo
					$x = $x->parent->parent;
				} else {
					// Tio e negro
					if ($x === $x->parent->right_child) {
						// fazer $x um filho esquerdo
						$x = $x->parent;
						$this->rotateLeft($x);
					}
					// recoloração e rotação
					$x->parent->color = self::COLOR_BLACK;
					$x->parent->parent->color = self::COLOR_RED;
					$this->rotateRight($x->parent->parent);
				}
			} else {
                // pai de $x é um filho direito de seu pai
				$uncle = $x->parent->parent->left_child;
				if ($uncle->color === self::COLOR_RED) {
					// Tio é VERMELHO
					$x->parent->color = self::COLOR_BLACK;
					$uncle->color = self::COLOR_BLACK;
					$x->parent->parent->color = self::COLOR_RED;
					// Avô agora é um nó ativo
					$x = $x->parent->parent;
				} else {
					// Tio é NEGRO
					if ($x === $x->parent->left_child) {
						$x = $x->parent;
						$this->rotateRight($x);
					}
                    // Recoloração é rotação
					$x->parent->color = self::COLOR_BLACK;
					$x->parent->parent->color = self::COLOR_RED;
					$this->rotateLeft($x->parent->parent);
				}
			}
		}
        // Definir a cor da raiz para NEGRO
		$this->root->color = self::COLOR_BLACK;
	}

}
?>
