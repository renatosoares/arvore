<?php

/**
 *
 */
class Tree implements ITree
{
  protected $root; // the root node of our tree
  public function __construct()
  {
       $this->root = null;
  }

  public function getRoot()
  {
      return $this->root;
  }

 public function isEmpty()
 {
     return $this->root === null;
 }
}


?>
