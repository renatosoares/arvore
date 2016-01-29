<?php
require 'ITree.php';
interface ITreeRB extends ITree
{
  /**
   * Encontrar o nodo de árvore por sua chave e mostra-o
   * @param $key
   * @return bool|TreeNode
   */
  public function findNode($key);

  /**
   * @param $key
   * @param $value
   * @return TreeNode
   */
  public function insertNode($key, $value);

  /**
   * Delete node com chave $key
   * @param $key
   * @return bool
   */
  public function deleteNode($key);

}

// public interface InterfaceRN {
//
//     public abstract no incluir(Object key);
//
//     public abstract boolean isEmpty();
//
//     public abstract Object remover(Object key);
//
//     public abstract no getRaiz();
//
//     public abstract void emOrdemRN(N�RN no);
//
//     public abstract void preOrdemRN(N�RN no, int n);
//
//     public abstract void mostra(N�RN no, int A);
//
// }
?>
