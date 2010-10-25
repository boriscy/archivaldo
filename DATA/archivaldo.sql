-- phpMyAdmin SQL Dump
-- version 2.11.7-rc1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 12-07-2008 a las 09:21:03
-- Versión del servidor: 5.0.51
-- Versión de PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `archivaldo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acos`
--

CREATE TABLE IF NOT EXISTS `acos` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `parent_id` int(10) default NULL,
  `model` varchar(255) default '',
  `foreign_key` int(10) unsigned default NULL,
  `alias` varchar(255) default '',
  `lft` int(10) default NULL,
  `rght` int(10) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `aros` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `parent_id` int(10) default NULL,
  `model` varchar(255) default '',
  `foreign_key` int(10) unsigned default NULL,
  `alias` varchar(255) default '',
  `lft` int(10) default NULL,
  `rght` int(10) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Estructura de tabla para la tabla `aros_acos`
--

CREATE TABLE IF NOT EXISTS `aros_acos` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `aro_id` int(10) unsigned NOT NULL,
  `aco_id` int(10) unsigned NOT NULL,
  `_create` char(2) NOT NULL default '0',
  `_read` char(2) NOT NULL default '0',
  `_update` char(2) NOT NULL default '0',
  `_delete` char(2) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Estructura de tabla para la tabla `archivos`
--

CREATE TABLE IF NOT EXISTS `archivos` (
  `id` char(36) collate utf8_unicode_ci NOT NULL,
  `categoria_id` char(36) collate utf8_unicode_ci NOT NULL,
  `usuario_id` char(36) collate utf8_unicode_ci NOT NULL,
  `nombre` varchar(255) collate utf8_unicode_ci default NULL,
  `descripcion` varchar(255) collate utf8_unicode_ci default NULL,
  `deleted` tinyint(1) default '0',
  `active` tinyint(1) default '0',
  `type` varchar(30) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `Index_FKusuario_id` (`usuario_id`),
  KEY `Index_FKcategoria_id` (`categoria_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Estructura de tabla para la tabla `archivos`
--

CREATE TABLE IF NOT EXISTS `archivos` (
  `id` char(36) collate utf8_unicode_ci NOT NULL,
  `categoria_id` char(36) collate utf8_unicode_ci NOT NULL,
  `usuario_id` char(36) collate utf8_unicode_ci NOT NULL,
  `nombre` varchar(255) collate utf8_unicode_ci default NULL,
  `descripcion` varchar(255) collate utf8_unicode_ci default NULL,
  `deleted` tinyint(1) default '0',
  `active` tinyint(1) default '0',
  `type` varchar(30) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `Index_FKusuario_id` (`usuario_id`),
  KEY `Index_FKcategoria_id` (`categoria_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE IF NOT EXISTS `categorias` (
  `id` char(36) collate utf8_unicode_ci NOT NULL,
  `usuario_id` char(36) collate utf8_unicode_ci NOT NULL,
  `parent_id` char(36) collate utf8_unicode_ci default NULL,
  `nombre` varchar(50) collate utf8_unicode_ci default NULL,
  `descripcion` text collate utf8_unicode_ci,
  `lft` int(10) unsigned default NULL,
  `rght` int(10) unsigned default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `deleted` tinyint(1) default '0',
  PRIMARY KEY  (`id`),
  KEY `Index_parent_id` (`parent_id`),
  KEY `Index_FKusuario_id` (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE IF NOT EXISTS `permisos` (
  `id` char(36) collate utf8_unicode_ci NOT NULL,
  `usuario_id` char(36) collate utf8_unicode_ci NOT NULL,
  `archivo_id` char(36) collate utf8_unicode_ci NOT NULL,
  `read` tinyint(1) default '1',
  `write` tinyint(1) default '0',
  `modify` tinyint(1) default '0',
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `Index_FKusuario_id` (`usuario_id`),
  KEY `Index_FKarchivo_id` (`archivo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` char(36) collate utf8_unicode_ci NOT NULL,
  `login` char(16) collate utf8_unicode_ci default NULL,
  `pass` char(32) collate utf8_unicode_ci default NULL,
  `nombres` varchar(50) collate utf8_unicode_ci default NULL,
  `apellido_p` varchar(50) collate utf8_unicode_ci default NULL,
  `apellido_m` varchar(50) collate utf8_unicode_ci default NULL,
  `nombre_c` varchar(150) collate utf8_unicode_ci default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `deleted` tinyint(1) default '0',
  `alias_acl` varchar(50) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `Index_nombre_c` (`nombre_c`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcar la base de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `login`, `pass`, `nombres`, `apellido_p`, `apellido_m`, `nombre_c`, `created`, `modified`, `deleted`, `alias_acl`) VALUES
('47efb3fe-3018-4aed-b334-09c45340dbed', 'admin', '0c7540eb7e65b553ec1ba6b20de79608', 'Archivaldo', '', '', 'Archivaldo', '2008-03-30 12:38:38', '2008-03-31 20:36:40', 0, 'Admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `versiones`
--

CREATE TABLE IF NOT EXISTS `versiones` (
  `id` char(36) collate utf8_unicode_ci NOT NULL,
  `usuario_id` char(36) collate utf8_unicode_ci NOT NULL,
  `archivo_id` char(36) collate utf8_unicode_ci NOT NULL,
  `numero` int(10) unsigned NOT NULL default '1',
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `size` int(10) unsigned default NULL,
  `type` varchar(30) collate utf8_unicode_ci default NULL,
  `ultima` tinyint(1) default '1',
  `nombre` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `Index_FKarchivo_id` (`archivo_id`),
  KEY `Index_FKusuario_id` (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

