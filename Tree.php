<?php
 require 'ITree.php';
/**
 *
 */
class Tree implements ITree
{

  public function __construct()
  {

  }

  public function Root()
  {
      return $this->root;
  }

 public function isEmpty()
 {
     return $this->root === null;
 }
 public function preOrder($no)
 {
  //  visite(v)
  //  para cada filho w de v
  //  preorder (w)
 }
}


?>
