<?php
/* SVN FILE: $Id$ */
/**
 * Short description for file.
 *
 * Long description for file
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework <http://www.cakephp.org/>
 * Copyright 2005-2008, Cake Software Foundation, Inc.
 *								1785 E. Sahara Avenue, Suite 490-204
 *								Las Vegas, Nevada 89104
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright		Copyright 2005-2008, Cake Software Foundation, Inc.
 * @link				http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package			cake
 * @subpackage		cake.app.config
 * @since			CakePHP(tm) v 0.10.8.2117
 * @version			$Revision$
 * @modifiedby		$LastChangedBy$
 * @lastmodified	$Date$
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 *
 * This file is loaded automatically by the app/webroot/index.php file after the core bootstrap.php is loaded
 * This is an application wide file to load any function that is not used within a class define.
 * You can also use this to include or require any files in your application.
 *
 */
/**
 * The settings below can be used to set additional paths to models, views and controllers.
 * This is related to Ticket #470 (https://trac.cakephp.org/ticket/470)
 *
 * $modelPaths = array('full path to models', 'second full path to models', 'etc...');
 * $viewPaths = array('this path to views', 'second full path to views', 'etc...');
 * $controllerPaths = array('this path to controllers', 'second full path to controllers', 'etc...');
 *
 */
//EOF
define('DATE_FORMAT', 'd-m-Y');
define('DB_DATE_FORMAT', 'Y-m-d');
define('PAGE_SIZE', 15);
define('PROG_NAME',  'Archivaldo');

//Retorna formateado la dimención de un archivo
function formatsize($size){
	$kb = 1024;
	$mb = 1048576;
	$gb = 1073741824;
	$size = intval($size);
	
	if($size<$kb){
		return $size.'Bytes';
	}
	if($size<$mb){
		return ceil($size/$kb).'Kb';
	}
	if($size<$gb){
		return ceil($size/$mb).'Mb';
	}
}
/**********************
 *Clase que da formato a las Fechas
 *@author Boris Barroso
 *@copyright Copyright (c) 2008 Boris Barroso
 *@example
 */
class dateFormat {
	/**
	 *@desc Verifica la lngitud de la fecha
	 *@param date(string) $date
	 *@param bool $time Indica si se presenta o no la fecha
	 *@return array
	 */
	private static function dateLen($date, $format) {
		
		$h = $i = $s = $t = '';
		if(strlen($date)>10) {
            list($da,$t) = split(" ",$date);
        }else{
            $da = $date;
        }
        
        switch($format){
            case 'd-m-Y':
                list($d, $m, $y) = split("-",$da);
            break;
            case 'Y-m-d':
                list($y, $m, $d) = split("-",$da);
            break;
        }
		
		return array('y'=>$y, 'm'=> $m, 'd'=> $d, 't'=>$t);
	}
	
	/**
	 *Funcion que da el formato de presentacions a las fechas obtenidas de Base de datos MySQL
	 *@param date $date
	 *@param bool $time default false
	 *@param string $format
	 *@return string
	 */
    static function mysql($date, $time = false, $format=DATE_FORMAT) {
        
        $arr = 	self::dateLen($date, $format);
        extract($arr);
		if($time){
			$format = DATE_FORMAT.' H:i:s';
		}
        
        switch($format)
        {
            case 'd-m-Y H:i:s':
                return "$d-$m-$y $t";
            break;
            case 'd-m-Y':
                return "$d-$m-$y";
            break;
			case 'm-d-Y':
				return "$m-$d-$y";
			break;
			case 'm-d-Y H:i:s':
				return "$m-$d-$y $t";
			break;
        }
		return false;
    }
	
	/**
	 *Funcion que da el formato para ingresar fechas a la Base de datos MySQL
	 *@param date $date
	 *@param bool $time default false
	 *@param string $format
	 *@return string
	 */
	static function mysqlIn($date, $time = true, $format=DATE_FORMAT) {
		
		$arr = self::dateLen($date, $time);
		extract($arr);
		
		if(strlen($date) > 10 ) {
			return "$y-$m-$d $t";	
		}else{
			return "$y-$m-$d";
		}
	}
}
//Clases para sanitize
uses('Sanitize');
/**
 *Clase que extiende Sanitize para realizar una secuencia de limpieza
 *distinta e implementar otros metodos de limpieza
 */
class Sanit extends Sanitize
{
    function cls($data, $options = array())
    {
		if (empty($data)) {
			return $data;
		}

		if (is_string($options)) {
			$options = array('connection' => $options);
		} else if (!is_array($options)) {
			$options = array();
		}

		$options = array_merge(array(
			'connection' => 'default',
			'images' => false,
            'scripts' => false,
			'escape' => true
		), $options);

		if (is_array($data)) {
			foreach ($data as $key => $val) {
				$data[$key] = Sanit::cls($val, $options);
			}
			return $data;
		} else {
            if ($options['images']) {
				$data = parent::stripImages($data);
			}
            if ($options['scripts']) {
				$data = parent::stripImages($data);
			}
			if ($options['escape']) {
				$data = parent::escape($data, $options['connection']);
			}
			
			return $data;
		}
    }
}

/**
 *Crea un array tipo lista a partir de un array tipo array('Model'=>array('field1'=>'val1', 'field2'=>'val2'))
 *y convirtiendolo en array('ModelField1'=>'val1','ModelField2'=>'val2')
 *@param array $data
 *@return array
 */
function listArray($data){
    $ret = array();
    foreach($data as $model=>$fields ){
        foreach($fields as $field=>$val){
            $nom = Inflector::camelize($model.'_'.$field);
            $ret[$nom] = $val;
        }
    }
    
    return $ret;
}
?>