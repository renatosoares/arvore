<?php

interface ITree{

  /** Posição dos nodes ----------------------------------------------------- */
  /** retorna um objeto armazenado nesta posição */
  public function element();


  /** Métodos de acesso ---------------------------------------------------- */
  /** retornar a raiz da árvore */
  public function root();

  /** retorna o pai de v. */
  public function parent($no);

  /** retornar uma coleção iterável contendo os filhos do nó v */
  public function children($no);


  /** Métodos de consulta -------------------------------------------------- */
  /** Verifica se o nó é interno  */
  public function isInternal($no);

  /** Verifica se o nó é externo */
  public function isExternal($no);

  /** Verifica se o nó é raiz*/
  public function isRoot();


  /** Métodos genêricos ---------------------------------------------------- */
  /** retorna o número de nós da arvore*/
  public function size();

  /** Testar se a árvore tem quaisquer nós ou não.*/
  public function isEmpty();

  /** retorna um interador de todos elementos armazanados no nodes da árvore */
  public function iterator();

  /** retorna uma coleção interável de todos os nodes da árvore */
  public function positions();

  /** Substituir por $o e retornar o elemento armazenado no $no.*/
  public function replace($no, $o);






}
?>
