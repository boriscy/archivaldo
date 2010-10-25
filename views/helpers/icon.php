<?php
/**
 * Icon Helper.
 *
 * Usado para generar Iconos
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
 * @version      $Revision: 1 $
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
class IconHelper extends Helper
{
	var $iconsType = array('text/plain'=>'note.png',
                            'image/pjpeg'=>'image2.png',
                            'image/gif'=>'image2.png',
                            'image/jpeg'=>'image2.png',
                            'application/msword'=>'page_white_word.png',
                            'application/vnd.ms-excel'=>'page_excel.png',
                            'application/vnd.ms-powerpoint'=>'page_white_powerpoint.png',
                            'application/pdf'=>'page_white_acrobat.png',
                            'application/vnd.visio'=>'page_white_office.png'
            );
    
    var $iconsExt = array('txt'=>'note.png',
                          'php'=>'page_white_php.png',
                          'doc'=>'page_white_word.png',
                          'docx' => 'page_white_word.png',
                          'jpg' => 'image2.png',
                          'gif' => 'image2.png',
                          'png' => 'image2.png',
                          'xls' => 'page_excel.png',
                          'ppt' => 'page_white_powerpoint.png');
	var $src;
    
    /**
     *Constructor principal
     */
	function __construct(){
		$this->src = $this->url('/img/icons/');
	}
	
    /**
     *Cambia el URL principal donde se ecuentran los iconos
     *
     *@param string $newUrl
     *@return void
     */
	function setUrl($newUrl){
		$this->src = $newUrl;
	}
	
    /**
     *Crea el icono con el typo MIME de la aplicación y en caso de que no exista con la extensión
     *
     *@param string $type Tipo MIME del archivo
     *@param string $name Nombre de el archivo
     *@return string Retorna el html del tipo de imagen del archivo
     */
	function appIcon($type, $name = null){
		if(array_key_exists($type, $this->iconsType)){
			$src = $this->src.$this->iconsType[$type];
			return '<img src="'.$src.'" alt="'.$type.'" />';
		}else if($name!=null){
            return $this->appIconExt($name);
        }else{
            return '<img src="'.$this->src.'application.png" alt="'.$type.'" />';
        }
	}
    
    /**
     *Crea la imagen a partir de la extensión de un archivo
     *@$name
     */
    function appIconExt($name, $type=null){
        $val  = preg_replace('/^.*\.([a-z]+)$/i', "$1", $name);        
        
        if(array_key_exists($val, $this->iconsExt) )
            return '<img src="'.$this->src.$this->iconsExt[$val].'" alt="'.$val.'" />';
        else
            return '<img src="'.$this->src.'application.png" alt="'.$type.'" />';
    }

}
?>