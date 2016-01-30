<?php
require 'Node.php';

/**
 *
 */
class TreeRB  {
  const COLOR_BLACK = true;
  const COLOR_RED = false;
  /**
   * Folhas da árvore
   * @var Node
   */
   static $nil;
   /**
    * Raiz da árvore
    * @var Node
    */
   public $root;

   public function __construct() {
     self::$nil = new Node(self::COLOR_BLACK);
     $this->root = self::$nil;
   }

// ############# inicio preOrder ###############

public function preOrder($n)
{
  if ($n != null) {
    print("eee");
    preOrder($n->left_child);
    preOrder($n->right_child);
  }
}

// ############# fim preOrder ###############

// ############# inicio que busca nodes ###############

   /**
    * Encontrar o nodo de árvore por sua chave
    * @param $key
    * @return bool|Node
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

       //echo "Node com a chave $key não encontrado";
   return false;
 }

// ############# fim que busca nodes ###############

   	/**
   	 * @param $key
   	 * @param $value
   	 * @return Node
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
   		$x = new Node(self::COLOR_RED, $key, $value, $parent, self::$nil, self::$nil);
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
     * @param Node $x
     */
    private function insertFixup(Node $x) {
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


//################### início delete ####################


    /**
     * Delete node com chave $key
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
			$x = new Node(self::COLOR_BLACK, null, null, $y->parent);
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
     * @param Node $x
     */
    private function deleteFixup(Node $x) {
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


//################### fim delete ####################

    /**
     * Rotate node $x para esquerda
     * @param Node $x
     */
    private function rotateLeft(Node $x) {
		$y = $x->right_child;
		// Estabelecer $x->right link
		$x->right_child = $y->left_child;
		if (!is_null($y->left_child->key)) {
			$y->left_child->parent = $x;
		}
		// Estabelecer $y->parent link
		$y->parent = $x->parent;
		if ($x->parent && !is_null($x->parent->key)) {
			if ($x === $x->parent->left_child) {
                // $x e sub-arvore esquerda
				$x->parent->left_child = $y;
			} else {
				$x->parent->right_child = $y;
			}
		}
		else {
			$this->root = $y;
		}
		// link $x e $y
		$y->left_child = $x;
		$x->parent = $y;
	}

    /**
     * Rotate node x to right
     * @param Node $x
     */
    private function rotateRight(Node $x) {
		$y = $x->left_child;
		// Estabelecer $x->left link
		$x->left_child = $y->right_child;
		if (!is_null($y->right_child->key)) {
			$y->right_child->parent = $x;
		}
		// Estabelecer $y->parent link
		$y->parent = $x->parent;
		if ($x->parent && !is_null($x->parent->key)) {
			if ($x === $x->parent->left_child) {
                // $x e sub-arvore esquerda
				$x->parent->left_child = $y;
			}
			else {
				$x->parent->right_child = $y;
			}
		}
		else {
			$this->root = $y;
		}
		// link $x e $y
		$y->right_child = $x;
		$x->parent = $y;
	}

}
?>
