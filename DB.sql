-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-05-2022 a las 03:51:05
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignars`
--

CREATE TABLE `asignars` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `rol_asignacion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `asignars`
--

INSERT INTO `asignars` (`id`, `user_id`, `rol_asignacion`, `created_at`, `updated_at`) VALUES
(6, 6, 'SuperAdmin', '2022-05-30 07:42:16', '2022-05-30 07:42:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `avisos`
--

CREATE TABLE `avisos` (
  `id` int(10) UNSIGNED NOT NULL,
  `aviso` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` date NOT NULL,
  `cliente_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bibliotecas`
--

CREATE TABLE `bibliotecas` (
  `id` int(10) UNSIGNED NOT NULL,
  `avatar` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `avatarurl` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `productos_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacoras`
--

CREATE TABLE `bitacoras` (
  `id` int(10) UNSIGNED NOT NULL,
  `fecha_inicio` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `fecha_salida` date NOT NULL,
  `hora_salida` time NOT NULL,
  `users_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'Membranas', 'Mendras asfaltica para humedad', '2021-06-14 21:50:29', '2021-07-17 04:53:03'),
(2, 'Griferia', 'Grifos de todo', '2021-06-14 21:51:04', '2021-06-14 21:51:04'),
(3, 'Baldes', 'Un sencillo y clásico balde de construcción en color negro que frecuentemente se utiliza para verter las mezclas de cemento', '2021-07-17 04:53:42', '2021-07-28 04:50:15'),
(4, 'LLave de Paso', 'Generalmente de metal, usado para dar paso a cortar el flujo de agua u otro fluido por una tuberia', '2021-07-17 04:55:10', '2021-07-17 04:55:10'),
(5, 'Filtros para Frotacho', 'Fratacho Plástico Goma Espuma', '2021-07-17 04:57:50', '2021-07-17 05:12:12'),
(6, 'Discos', 'Discos de corte o desgaste', '2021-07-17 05:08:36', '2021-07-17 05:08:36'),
(7, 'Sella Rocas', 'Un pegamento de alto sellado e instantaneo', '2021-07-17 05:10:01', '2021-07-17 05:10:01'),
(8, 'Corrugados', 'Es un conducto de PVC que se usa para el guiado y protección de cables en instalaciones eléctricas o telecomunicaciones', '2021-07-17 05:11:35', '2021-07-17 05:11:35'),
(9, 'Tarrajas', 'una herramienta manual de corte que se utiliza para el roscado manual  de tuberías', '2021-07-17 05:17:15', '2021-07-17 05:17:15'),
(12, 'Codos', 'Codo para tuveria', '2021-07-19 13:21:10', '2021-07-19 13:21:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(10) UNSIGNED NOT NULL,
  `cli_usuario` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cli_password` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cli_nombres` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cli_apellidos` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cli_celular` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuotas`
--

CREATE TABLE `cuotas` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_entrega` datetime NOT NULL,
  `hora` time NOT NULL,
  `cliente_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dato_clientes`
--

CREATE TABLE `dato_clientes` (
  `id` int(10) UNSIGNED NOT NULL,
  `direccion` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` int(11) DEFAULT NULL,
  `ci` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cliente_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `depositos`
--

CREATE TABLE `depositos` (
  `id` int(10) UNSIGNED NOT NULL,
  `asunto` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `monto` double(250,2) NOT NULL,
  `foto` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `fotoweb` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `estado` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` datetime NOT NULL,
  `cliente_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrada_inventarios`
--

CREATE TABLE `entrada_inventarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `cantidad_unidad` int(11) NOT NULL,
  `cantidad_caja` double(250,2) NOT NULL,
  `precio_compra_unidad` double(250,2) NOT NULL,
  `precio_venta_unidad` double(250,2) NOT NULL,
  `inventario_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `id` int(10) UNSIGNED NOT NULL,
  `factura` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `facturapdf` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facturaurl` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cliente_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_pedido`
--

CREATE TABLE `factura_pedido` (
  `id` int(10) UNSIGNED NOT NULL,
  `factura_id` int(10) UNSIGNED NOT NULL,
  `pedido_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventarios`
--

CREATE TABLE `inventarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `producto_id` int(10) UNSIGNED NOT NULL,
  `cantidad_unidad_caja` int(11) NOT NULL,
  `cantidad_unidad_almacen` int(11) NOT NULL,
  `cantidad_caja_almacen` double(250,2) NOT NULL,
  `cantidad_unidad_almacen_dis` int(11) NOT NULL,
  `cantidad_caja_almacen_dis` double(250,2) NOT NULL,
  `precio_compra_unidad` double(250,2) NOT NULL,
  `precio_venta_unidad` double(250,2) NOT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `publicado` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_pedido`
--

CREATE TABLE `inventario_pedido` (
  `id` int(10) UNSIGNED NOT NULL,
  `fecha_pedido` date NOT NULL,
  `precio_venta_unidad` double(250,2) NOT NULL,
  `precio_total_pedido` double(250,2) NOT NULL,
  `cantidad_unidad` int(11) NOT NULL,
  `cantidad_caja` double(250,2) NOT NULL,
  `pedido_id` int(10) UNSIGNED NOT NULL,
  `inventario_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kadex_generals`
--

CREATE TABLE `kadex_generals` (
  `id` int(10) UNSIGNED NOT NULL,
  `inventario_id` int(10) UNSIGNED NOT NULL,
  `cantidad_unidad_entrada` int(11) DEFAULT NULL,
  `cantidad_caja_entrada` double(250,2) DEFAULT NULL,
  `precio_compra_unidad_entrada` double(250,2) DEFAULT NULL,
  `precio_venta_unidad_entrada` double(250,2) DEFAULT NULL,
  `cantidad_unidad_salida` int(11) DEFAULT NULL,
  `cantidad_caja_salida` double(250,2) DEFAULT NULL,
  `precio_venta_unidad_salida` double(250,2) DEFAULT NULL,
  `detalle_salida` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_salida` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cantidad_total` int(11) NOT NULL,
  `saldototal` double(250,2) NOT NULL,
  `saldototalventa` double(250,2) NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `precioanterior` double(250,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `id` int(10) UNSIGNED NOT NULL,
  `tipo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `titulo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mensaje` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `imagen` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cliente_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_01_08_173055_create_categorias_table', 1),
(4, '2019_09_16_221137_create_asignars_table', 1),
(5, '2019_10_21_145853_create_perfils_table', 1),
(6, '2019_11_03_214804_create_productos_table', 1),
(7, '2019_11_09_125706_create_inventarios_table', 1),
(8, '2019_11_12_125248_create_clientes_table', 1),
(9, '2019_11_26_232450_create_bibliotecas_table', 1),
(10, '2019_11_26_232617_create_pedidos_table', 1),
(11, '2019_11_26_232812_create_dato_clientes_table', 1),
(12, '2019_12_09_232941_create_ofertas_table', 1),
(13, '2020_06_09_191336_create_pagos_table', 1),
(14, '2020_06_22_184227_create_inventario_pedido_table', 1),
(15, '2020_06_27_204804_create_depositos_table', 1),
(16, '2021_01_12_123930_create_facturas_table', 1),
(17, '2021_01_12_155422_create_factura_pedido_table', 1),
(18, '2021_05_28_152841_create_cuotas_table', 1),
(19, '2021_06_14_155146_create_sugerencias_table', 1),
(20, '2021_06_14_164251_create_entrada_inventarios_table', 1),
(21, '2021_06_14_164312_create_salida_inventarios_table', 1),
(22, '2021_06_14_170013_create_saldo_inventarios_table', 1),
(23, '2021_06_14_173202_create_mensajes_table', 1),
(24, '2021_06_20_183240_create_tokes_table', 2),
(25, '2021_06_25_225946_create_bitacoras_table', 3),
(26, '2021_07_22_012838_create_kadex_generals_table', 4),
(27, '2021_08_16_222300_create_avisos_table', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ofertas`
--

CREATE TABLE `ofertas` (
  `id` int(10) UNSIGNED NOT NULL,
  `precio_venta_nuevo` double(250,2) NOT NULL,
  `cantidad_unidadxcaja` int(11) NOT NULL,
  `unidad_almacen` int(11) NOT NULL,
  `caja_almacen` double(250,2) NOT NULL,
  `unidad_disponible` int(11) NOT NULL,
  `caja_disponible` double(250,2) NOT NULL,
  `oferta` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` datetime NOT NULL,
  `inventario_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` int(10) UNSIGNED NOT NULL,
  `forma_pago` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_pago` datetime NOT NULL,
  `monto` double(250,2) NOT NULL,
  `foto_pago` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `foto_url` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `fecha_entrega` datetime NOT NULL,
  `fecha_deposito` datetime DEFAULT NULL,
  `status` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cliente_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(10) UNSIGNED NOT NULL,
  `cantidad_unidad` int(11) DEFAULT NULL,
  `cantidad_caja` int(11) DEFAULT NULL,
  `precio_unidad` double(250,2) DEFAULT NULL,
  `precio_total` double(250,2) DEFAULT NULL,
  `fecha_entrega` datetime NOT NULL,
  `estatus` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_compra` datetime NOT NULL,
  `oferta` int(11) DEFAULT NULL,
  `cliente_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfils`
--

CREATE TABLE `perfils` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `apellido` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `celular` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `perfils`
--

INSERT INTO `perfils` (`id`, `user_id`, `apellido`, `direccion`, `celular`, `avatar`, `created_at`, `updated_at`) VALUES
(6, 6, 'admin', 'admin S/N', '12345678', '1653896638images.webp', '2022-05-30 07:42:16', '2022-05-30 07:44:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marca` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modelo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `medida` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `serie` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `descripcion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `nota` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `avatar` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `avatarurl` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `categoria_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `marca`, `modelo`, `medida`, `serie`, `descripcion`, `nota`, `avatar`, `avatarurl`, `categoria_id`, `created_at`, `updated_at`) VALUES
(1, 'Membrana 1x15', 'Mega Flex', 'mediano', '15 cm por 10m', 'null', 'Membrana Asfaltica', 'Venta unicamente por Caja', '1626579652membranaa.jpg', 'http://192.168.42.132/proyectofinal/PROYECTO/public/images/product/1626579652membranaa.jpg', 1, '2021-06-14 21:52:02', '2022-01-18 01:16:52'),
(2, 'Grifo Plateado', 'Fv', 'Plateado  llave T', '3/4', 'null', 'Grifo', 'Venta unicamente por Caja', '1626574998grifoT.png', 'http://192.168.42.132/proyectofinal/PROYECTO/public/images/product/1626574998grifoT.png', 2, '2021-06-14 21:52:43', '2021-07-18 02:23:18'),
(3, 'Membrana 1x10', 'MegaFlex', 'Impermeable', '1 m x 10 m', 'null', 'Membrana Asfaltica', 'Venta unicamente por Unidad', '1626579186membrana.png', 'http://192.168.42.132/proyectofinal/PROYECTO/public/images/product/1626579186membrana.png', 1, '2021-06-22 04:00:57', '2021-07-28 04:50:44'),
(4, 'Grifo Plateado Cruz Fija', 'Fv', 'Plateado', '3/4', 'null', 'Canilla para manguera, aprobada y reforzada, con volante cruz fija', 'Venta unicamente por Caja', '1626574817grifo.png', 'http://192.168.42.132/proyectofinal/PROYECTO/public/images/product/1626574817grifo.png', 2, '2021-07-06 05:57:10', '2021-07-18 02:20:17'),
(7, 'Caño Corrugado 1/2', 'Losaplast Huferjo', 'Naranja', '1/2', NULL, 'Caño de Corrugado proteccion de cableado', 'Venta unicamente por Caja', '16265684370436.01-15.png', 'http://192.168.42.132/proyectofinal/PROYECTO/public/images/product/16265684370436.01-15.png', 8, '2021-07-18 00:33:57', '2021-07-18 00:33:57'),
(8, 'Caño Corrugado 3/4', 'Losaplast Huferjo', 'Standar', '3/4 largo de 25 metros', NULL, 'Caño de Corrugado proteccion de cableado de 3/4', 'Venta unicamente por Caja', '16265687710436.01-16.png', 'http://192.168.42.132/proyectofinal/PROYECTO/public/images/product/16265687710436.01-16.png', 8, '2021-07-18 00:39:31', '2021-07-18 00:39:31'),
(9, 'Caño Corrugado 7/8', 'Losaplast Huferjo', 'Standar Naranja', '7/8 Larog de 25mt', NULL, 'Caño de Corrugado proteccion de cableado', 'Venta unicamente por Caja', '16265691010436.01-17.png', 'http://192.168.42.132/proyectofinal/PROYECTO/public/images/product/16265691010436.01-17.png', 8, '2021-07-18 00:45:01', '2021-07-18 00:45:01'),
(10, 'Disco de Corte N4', 'Norton', 'Rpm13370', 'Numero 4', NULL, 'Disco de Corte o desgaste', 'Venta unicamente por Caja', '16265707220436.01-18.png', 'http://192.168.42.132/proyectofinal/PROYECTO/public/images/product/16265707220436.01-18.png', 6, '2021-07-18 01:12:02', '2021-07-18 01:12:02'),
(11, 'Disco de Corte N7', 'Norton', 'Rpm850', 'Numero 7', 'null', 'Disco de Corte o desgaste', 'Venta unicamente por Caja', '1626573041disco7.png', 'http://192.168.42.132/proyectofinal/PROYECTO/public/images/product/1626573041disco7.png', 6, '2021-07-18 01:41:43', '2021-07-18 01:50:41'),
(12, 'Disco de Corte N9', 'Norton', 'Rpm13370', 'Numero 9', NULL, 'Disco de Corte o desgaste', 'Venta unicamente por Caja', '16265738870disco9.png', 'http://192.168.42.132/proyectofinal/PROYECTO/public/images/product/16265738870disco9.png', 6, '2021-07-18 02:04:47', '2021-07-18 02:04:47'),
(13, 'Frotacho de Plastico Mediano', 'Voss', 'Frotacho', '20 cm', 'null', 'Fratacho Plastico Goma Espuma para revoque', 'Venta unicamente por Caja', '1626574655frotachogrande.png', 'http://192.168.42.132/proyectofinal/PROYECTO/public/images/product/1626574655frotachogrande.png', 5, '2021-07-18 02:12:56', '2021-07-18 02:17:35'),
(14, 'Frotacho de Plastico Grande', 'Voss', 'Frotacho', '30 cm', NULL, 'Fratacho Plastico Goma Espuma para revoque', 'Venta unicamente por Caja', '1626574643frotachogrande.png', 'http://192.168.42.132/proyectofinal/PROYECTO/public/images/product/1626574643frotachogrande.png', 5, '2021-07-18 02:17:23', '2021-07-18 02:17:23'),
(15, 'Canilla con cierre esférico', 'Fv', 'Plateado', '1/2', NULL, 'Canilla para manguera con cierre esferico', 'Venta unicamente por Caja', '1626575365canilla.png', 'http://192.168.42.132/proyectofinal/PROYECTO/public/images/product/1626575365canilla.png', 2, '2021-07-18 02:29:25', '2021-07-18 02:29:25'),
(16, 'Canilla con pico elevado', 'Fv', 'Cromo', '1/2', NULL, 'Canilla para mesada, de una sola agua, con pico levantado y cruz fija', 'Venta unicamente por Caja', '16265764310436.01-13-Recuperado.png', 'http://192.168.42.132/proyectofinal/PROYECTO/public/images/product/16265764310436.01-13-Recuperado.png', 2, '2021-07-18 02:47:11', '2021-07-18 02:47:11'),
(17, 'Canilla con pico movil', 'Fv', 'Tadicional', '1/2', NULL, 'Canilla para pared, de una sola agua, con pico móvil', 'Venta unicamente por Caja', '16265768600436.01-20-Recuperado.png', 'http://192.168.42.132/proyectofinal/PROYECTO/public/images/product/16265768600436.01-20-Recuperado.png', 2, '2021-07-18 02:54:20', '2021-07-18 02:54:20'),
(18, 'Canilla con pico alto', 'Fv', 'Tradicional', '1/2', NULL, 'Canilla para mesada, de una sola agua, con pico móvil alto', 'Venta unicamente por Caja', '16265770340436.01-21.png', 'http://192.168.42.132/proyectofinal/PROYECTO/public/images/product/16265770340436.01-21.png', 2, '2021-07-18 02:57:14', '2021-07-18 02:57:14'),
(19, 'Grifo plastico', 'Uduke', 'HT20', '1/2', 'null', 'Grifo de plastico', 'Venta unicamente por Caja', '1626577499grifoplastico.png', 'http://192.168.42.132/proyectofinal/PROYECTO/public/images/product/1626577499grifoplastico.png', 2, '2021-07-18 03:04:59', '2021-07-28 04:49:52'),
(20, 'Canilla de jardin', 'Fv', 'Bronce', '1/2', NULL, 'Canilla para jardin', 'Venta unicamente por Caja', '1626577845canillabronce.png', 'http://192.168.42.132/proyectofinal/PROYECTO/public/images/product/1626577845canillabronce.png', 2, '2021-07-18 03:10:45', '2021-07-18 03:10:45'),
(21, 'Válvula con llave de flor', 'Fv', 'Bronce', '1/2', NULL, 'Válvula esclusa para caño de hierro', 'Venta unicamente por Caja', '1626578863llavepaso.png', 'http://192.168.42.132/proyectofinal/PROYECTO/public/images/product/1626578863llavepaso.png', 4, '2021-07-18 03:27:43', '2021-07-18 03:27:43'),
(22, 'Llave de paso volante de cruz', 'Fv', 'Cromo', '1/2', NULL, 'Llave de paso para caños de hierro, aprobada, M-H, con volante cruz fija', 'Venta unicamente por Caja', '1626578997cruz.png', 'http://192.168.42.132/proyectofinal/PROYECTO/public/images/product/1626578997cruz.png', 4, '2021-07-18 03:29:57', '2021-07-18 03:29:57'),
(23, 'Sella Rocas 50Cc', 'Hidro 3', 'H3', '50Cc', NULL, 'Adhesivos Para sellar y pegar roscas de caño', 'Venta unicamente por Caja', '1626579821sellaroscas.jpg', 'http://192.168.42.132/proyectofinal/PROYECTO/public/images/product/1626579821sellaroscas.jpg', 7, '2021-07-18 03:43:41', '2021-07-18 03:43:41'),
(24, 'Tarraja Pvc de Acero', 'Sanogass', 'Sp/ Hexagonal', '1/2 3/4', 'null', 'Tarraja de acero', 'Venta unicamente por Unidad', '1626637070Tarraja.jpg', 'http://192.168.42.132/proyectofinal/PROYECTO/public/images/product/1626637070Tarraja.jpg', 9, '2021-07-18 03:46:38', '2021-07-18 19:37:50'),
(25, 'Balde Plastico', 'Voss', 'Reforzado', 'null', 'null', 'Balde Albañil Plastico Reforzado Primera Calidad Negro Obra', 'Venta unicamente por Caja', '1626637022valde.jpg', 'http://192.168.42.132/proyectofinal/PROYECTO/public/images/product/1626637022valde.jpg', 3, '2021-07-18 03:49:23', '2021-07-28 04:50:31'),
(27, 'Codo HH IPS', 'Acqua System', 'HH IPS 1/2', '1/2', NULL, 'Codo HH IPS', 'Venta unicamente por Caja', '16267009240436.01-14.png', 'http://192.168.42.132/proyectofinal/PROYECTO/public/images/product/16267009240436.01-14.png', 12, '2021-07-19 13:22:04', '2021-07-19 13:22:04'),
(28, 'Codo fusion Hembra', 'Acqua System', 'Fusion-rh', '3/4', NULL, 'Codo de rosca hembra', 'Venta unicamente por Caja', '16303293950436.01-13.png', 'http://192.168.42.132/proyectofinal/PROYECTO/public/images/product/16303293950436.01-13.png', 12, '2021-08-30 13:16:35', '2021-08-30 13:16:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `saldo_inventarios`
--

CREATE TABLE `saldo_inventarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `cantidad_total` int(11) NOT NULL,
  `saldototal` double(250,2) NOT NULL,
  `saldototalventa` double(250,2) NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `precioanterior` double(250,2) NOT NULL,
  `inventario_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salida_inventarios`
--

CREATE TABLE `salida_inventarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `cantidad_unidad` int(11) NOT NULL,
  `cantidad_caja` double(250,2) NOT NULL,
  `precio_venta_unidad` double(250,2) NOT NULL,
  `detalle` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `inventario_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sugerencias`
--

CREATE TABLE `sugerencias` (
  `id` int(10) UNSIGNED NOT NULL,
  `sugerencias` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cliente_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tes`
--

CREATE TABLE `tes` (
  `id` int(11) NOT NULL,
  `messagge` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `send` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tokes`
--

CREATE TABLE `tokes` (
  `id` int(10) UNSIGNED NOT NULL,
  `tokens` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cliente_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(6, 'admin', 'admin@gmail.com', NULL, '$2y$10$A9PDnzZyGEmXWHEmNKfvlurDr.Iy25sp8w6CH6T3zUAUR4hiY.dBK', NULL, '2022-05-30 07:42:16', '2022-05-30 07:42:16');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asignars`
--
ALTER TABLE `asignars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asignars_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `avisos`
--
ALTER TABLE `avisos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `avisos_cliente_id_foreign` (`cliente_id`),
  ADD KEY `avisos_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `bibliotecas`
--
ALTER TABLE `bibliotecas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bibliotecas_productos_id_foreign` (`productos_id`);

--
-- Indices de la tabla `bitacoras`
--
ALTER TABLE `bitacoras`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clientes_cli_usuario_unique` (`cli_usuario`);

--
-- Indices de la tabla `cuotas`
--
ALTER TABLE `cuotas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cuotas_cliente_id_foreign` (`cliente_id`),
  ADD KEY `cuotas_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `dato_clientes`
--
ALTER TABLE `dato_clientes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dato_clientes_cliente_id_foreign` (`cliente_id`);

--
-- Indices de la tabla `depositos`
--
ALTER TABLE `depositos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `depositos_cliente_id_foreign` (`cliente_id`);

--
-- Indices de la tabla `entrada_inventarios`
--
ALTER TABLE `entrada_inventarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `entrada_inventarios_inventario_id_foreign` (`inventario_id`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `facturas_cliente_id_foreign` (`cliente_id`);

--
-- Indices de la tabla `factura_pedido`
--
ALTER TABLE `factura_pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `factura_pedido_pedido_id_foreign` (`pedido_id`),
  ADD KEY `factura_pedido_factura_id_foreign` (`factura_id`);

--
-- Indices de la tabla `inventarios`
--
ALTER TABLE `inventarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventarios_producto_id_foreign` (`producto_id`);

--
-- Indices de la tabla `inventario_pedido`
--
ALTER TABLE `inventario_pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventario_pedido_pedido_id_foreign` (`pedido_id`),
  ADD KEY `inventario_pedido_inventario_id_foreign` (`inventario_id`);

--
-- Indices de la tabla `kadex_generals`
--
ALTER TABLE `kadex_generals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kadex_generals_inventario_id_foreign` (`inventario_id`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mensajes_cliente_id_foreign` (`cliente_id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ofertas`
--
ALTER TABLE `ofertas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ofertas_inventario_id_foreign` (`inventario_id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pagos_cliente_id_foreign` (`cliente_id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedidos_cliente_id_foreign` (`cliente_id`),
  ADD KEY `pedidos_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `perfils`
--
ALTER TABLE `perfils`
  ADD PRIMARY KEY (`id`),
  ADD KEY `perfils_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productos_categoria_id_foreign` (`categoria_id`);

--
-- Indices de la tabla `saldo_inventarios`
--
ALTER TABLE `saldo_inventarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `saldo_inventarios_inventario_id_foreign` (`inventario_id`);

--
-- Indices de la tabla `salida_inventarios`
--
ALTER TABLE `salida_inventarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `salida_inventarios_inventario_id_foreign` (`inventario_id`);

--
-- Indices de la tabla `sugerencias`
--
ALTER TABLE `sugerencias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sugerencias_cliente_id_foreign` (`cliente_id`);

--
-- Indices de la tabla `tes`
--
ALTER TABLE `tes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tokes`
--
ALTER TABLE `tokes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tokes_cliente_id_foreign` (`cliente_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asignars`
--
ALTER TABLE `asignars`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `avisos`
--
ALTER TABLE `avisos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `bibliotecas`
--
ALTER TABLE `bibliotecas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `bitacoras`
--
ALTER TABLE `bitacoras`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `cuotas`
--
ALTER TABLE `cuotas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `dato_clientes`
--
ALTER TABLE `dato_clientes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `depositos`
--
ALTER TABLE `depositos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `entrada_inventarios`
--
ALTER TABLE `entrada_inventarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `factura_pedido`
--
ALTER TABLE `factura_pedido`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `inventarios`
--
ALTER TABLE `inventarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `inventario_pedido`
--
ALTER TABLE `inventario_pedido`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `kadex_generals`
--
ALTER TABLE `kadex_generals`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=224;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `ofertas`
--
ALTER TABLE `ofertas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `perfils`
--
ALTER TABLE `perfils`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `saldo_inventarios`
--
ALTER TABLE `saldo_inventarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT de la tabla `salida_inventarios`
--
ALTER TABLE `salida_inventarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `sugerencias`
--
ALTER TABLE `sugerencias`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `tes`
--
ALTER TABLE `tes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tokes`
--
ALTER TABLE `tokes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asignars`
--
ALTER TABLE `asignars`
  ADD CONSTRAINT `asignars_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `avisos`
--
ALTER TABLE `avisos`
  ADD CONSTRAINT `avisos_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `avisos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `bibliotecas`
--
ALTER TABLE `bibliotecas`
  ADD CONSTRAINT `bibliotecas_productos_id_foreign` FOREIGN KEY (`productos_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `cuotas`
--
ALTER TABLE `cuotas`
  ADD CONSTRAINT `cuotas_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cuotas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `dato_clientes`
--
ALTER TABLE `dato_clientes`
  ADD CONSTRAINT `dato_clientes_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `depositos`
--
ALTER TABLE `depositos`
  ADD CONSTRAINT `depositos_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `entrada_inventarios`
--
ALTER TABLE `entrada_inventarios`
  ADD CONSTRAINT `entrada_inventarios_inventario_id_foreign` FOREIGN KEY (`inventario_id`) REFERENCES `inventarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD CONSTRAINT `facturas_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `factura_pedido`
--
ALTER TABLE `factura_pedido`
  ADD CONSTRAINT `factura_pedido_factura_id_foreign` FOREIGN KEY (`factura_id`) REFERENCES `facturas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `factura_pedido_pedido_id_foreign` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `inventarios`
--
ALTER TABLE `inventarios`
  ADD CONSTRAINT `inventarios_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `inventario_pedido`
--
ALTER TABLE `inventario_pedido`
  ADD CONSTRAINT `inventario_pedido_inventario_id_foreign` FOREIGN KEY (`inventario_id`) REFERENCES `inventarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventario_pedido_pedido_id_foreign` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `kadex_generals`
--
ALTER TABLE `kadex_generals`
  ADD CONSTRAINT `kadex_generals_inventario_id_foreign` FOREIGN KEY (`inventario_id`) REFERENCES `inventarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD CONSTRAINT `mensajes_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ofertas`
--
ALTER TABLE `ofertas`
  ADD CONSTRAINT `ofertas_inventario_id_foreign` FOREIGN KEY (`inventario_id`) REFERENCES `inventarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pedidos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `perfils`
--
ALTER TABLE `perfils`
  ADD CONSTRAINT `perfils_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_categoria_id_foreign` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `saldo_inventarios`
--
ALTER TABLE `saldo_inventarios`
  ADD CONSTRAINT `saldo_inventarios_inventario_id_foreign` FOREIGN KEY (`inventario_id`) REFERENCES `inventarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `salida_inventarios`
--
ALTER TABLE `salida_inventarios`
  ADD CONSTRAINT `salida_inventarios_inventario_id_foreign` FOREIGN KEY (`inventario_id`) REFERENCES `inventarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sugerencias`
--
ALTER TABLE `sugerencias`
  ADD CONSTRAINT `sugerencias_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tokes`
--
ALTER TABLE `tokes`
  ADD CONSTRAINT `tokes_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
