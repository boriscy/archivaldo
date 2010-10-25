<?php 
/**
 * Tree Helper.
 *
 * Used the generate nested representations of hierarchial data
 *
 * PHP versions 5
 *
 * Copyright (c), Boris Barroso
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright    Copyright (c) 2008, Boris Barroso
 * @package      noswad
 * @subpackage   noswad.app.views.helpers
 * @since        Noswad site version 1
 * @version      $Revision: 10 $
 * @created      21/02/2008
 * @modifiedby   $LastChangedBy: boriscy $
 * @lastmodified $Date: 2008-02-24 18:29:29 +0100 (Thu, 29 Nov 2007) $
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 */

/**
 * Tree helper
 *
 * Helper to generate tree representations of MPTT or recursively nested data
 */
class TreeHelper extends AppHelper
{
	private $id = 'id';
	private $parent_id = 'parent_id';
	private $ext = false;
	private $extText = '';
	
    /**
     *Constructor principal
     */
    function __construct(){
        return parent::__construct();
    }
    
    /**
     *Busca un nodo parent al cual se le añadira el nodo que se esta creando
     *@param array $tree
     *@param string $parent_id
     *@return array
     */
	private function &searchNode(&$tree, $parent_id)
	{
		$node = null;
		foreach($tree as &$v){
			if($v['id']==$parent_id){
				$node =& $v;				
				break;
			}
			
			if(isset($v['children'])){
				$node =& $this->searchNode($v['children'], $parent_id);
			}
		}
		return $node;
	}
	
    /**
     *Crea un nodo en caso de que $this->ext===true crea para manejar en el formato de arboles Ext
     *
     *@param string $id
     *@param string $parent_id
     *@param array $data
     *@param array $fields
     *@return array
     *@access private
     */
	private function createNode($id, $parent_id, $data, $fields = array()){
        $node = array('id'=>$id, 'parent_id'=>$parent_id);
        
        if($this->ext){
            $node['text'] = $data[$this->extText];
            $node['leaf'] = '[]';
            $node['cls'] = 'folder';
            $node['expanded'] = true;
            unset($node['parent_id']);
        }
        foreach($fields as $val){
            $node[$val] = $data[$val];
        }
		
	    return $node;
	}
	
    /**
     *Crea un arbol en forma de array PHP a partir de un array plano (lista)
     *
     *@param array $data datos
     *@param array $fields Campos incluidos en el arbol
     *@return array
     *@access public
     */
	public function createTree($data, $fields = array() )
	{
        $tree = array();
        if(isset($fields['id'])){
                $this->id = $fields['id'];
                unset($fields['id']);
        }
        if(isset($fields['parent_id'])){
                $this->parent_id = $fields['parent_id'];
                unset($fields['parent_id']);
        }
        if($this->ext){
                $this->extText = $fields['text'];
                unset($fields['text']);
        }
                
        $i = 0;
        
        foreach($data as $k=>$v)
        {
            if($v[$this->parent_id]==''){			
                    $node = $this->createNode($v[$this->id], null, $v, $fields);
                    array_push($tree, $node);
            }else{
                    $node = $this->createNode($v[$this->id], $v[$this->parent_id], $v, $fields);
                    $current =& $this->searchNode($tree, $v[$this->parent_id]);				
                    $current['children'][] = $node;
                    if($this->ext){
                            $current['leaf'] = false;
                    }
            }
        }
        return $tree;
	}
	
    /**
     *Crea un array especifico para la libreria Extjs que despues debe
     *Debe ser un array obtenido de una consulta al TreeBehavior con orden lft ASC
     *
     *@param array $data datos
     *@param array $fields son los campos seleccionados para presentar datos
     *@return array
     *@access public
     *$data['id'] campo con el id del nodo
     *$data['parent_id'] campo con el parent del nodo
     *$data['text'] texto campo con el texto del nodo
     */
	public function extTree($data, $fields = array())
	{
	    $this->ext = true;
	    return $this->createTree($data, $fields);
	}
}
?> 