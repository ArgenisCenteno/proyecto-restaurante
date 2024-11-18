-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 08-11-2024 a las 02:17:05
-- Versión del servidor: 8.0.30
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tienda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aperturas_caja`
--

CREATE TABLE `aperturas_caja` (
  `id` bigint UNSIGNED NOT NULL,
  `caja_id` bigint UNSIGNED NOT NULL,
  `usuario_id` bigint UNSIGNED NOT NULL,
  `monto_inicial_bolivares` decimal(15,2) NOT NULL DEFAULT '0.00',
  `monto_inicial_dolares` decimal(15,2) NOT NULL DEFAULT '0.00',
  `apertura` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cajas`
--

CREATE TABLE `cajas` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activa` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `status`, `created_at`, `updated_at`) VALUES
(7, 'Refrigeradores', 1, '2024-09-25 02:53:06', '2024-09-25 02:53:06'),
(8, 'Compresores', 1, '2024-09-25 02:53:18', '2024-09-25 02:53:18'),
(9, 'Accesorios', 1, '2024-09-25 02:53:42', '2024-09-25 02:53:42'),
(10, 'Repuestos', 1, '2024-09-25 02:53:54', '2024-09-25 02:53:54'),
(11, 'Herramientas', 1, '2024-09-25 02:54:04', '2024-09-25 02:54:04'),
(12, 'Electrónica', 1, '2024-09-25 02:54:17', '2024-09-25 02:54:17'),
(13, 'Electricidad', 1, '2024-09-25 02:54:28', '2024-09-25 02:54:28'),
(14, 'Mantenimiento', 1, '2024-09-25 02:54:36', '2024-09-25 02:54:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cierres_caja`
--

CREATE TABLE `cierres_caja` (
  `id` bigint UNSIGNED NOT NULL,
  `caja_id` bigint UNSIGNED NOT NULL,
  `usuario_id` bigint UNSIGNED NOT NULL,
  `monto_final_bolivares` decimal(15,2) NOT NULL,
  `monto_final_dolares` decimal(15,2) NOT NULL,
  `discrepancia_bolivares` decimal(15,2) NOT NULL DEFAULT '0.00',
  `discrepancia_dolares` decimal(15,2) NOT NULL DEFAULT '0.00',
  `cierre` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id` bigint UNSIGNED NOT NULL,
  `proveedor_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `monto_total` decimal(10,2) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `porcentaje_descuento` decimal(5,2) DEFAULT NULL,
  `pago_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id`, `proveedor_id`, `user_id`, `monto_total`, `status`, `porcentaje_descuento`, `pago_id`, `created_at`, `updated_at`) VALUES
(2, 1, 1, 962.80, 'Pagado', NULL, 14, '2024-10-23 04:46:40', '2024-10-23 04:46:40'),
(3, 1, 1, 962.80, 'Pagado', NULL, 15, '2024-10-23 04:47:01', '2024-10-23 04:47:01'),
(4, 1, 1, 1925.60, 'Pagado', NULL, 16, '2024-10-23 04:48:00', '2024-10-23 04:48:00'),
(5, 1, 1, 232.00, 'Pagado', NULL, 19, '2024-11-08 00:13:43', '2024-11-08 00:13:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compras`
--

CREATE TABLE `detalle_compras` (
  `id` bigint UNSIGNED NOT NULL,
  `id_producto` bigint UNSIGNED NOT NULL,
  `precio_producto` decimal(10,2) NOT NULL,
  `cantidad` int NOT NULL,
  `neto` decimal(10,2) NOT NULL,
  `impuesto` decimal(10,2) NOT NULL,
  `id_compra` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ventas`
--

CREATE TABLE `detalle_ventas` (
  `id` bigint UNSIGNED NOT NULL,
  `id_producto` bigint UNSIGNED NOT NULL,
  `precio_producto` decimal(10,2) NOT NULL,
  `cantidad` int NOT NULL,
  `neto` decimal(10,2) NOT NULL,
  `impuesto` decimal(10,2) DEFAULT NULL,
  `id_venta` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `talla` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detalle_ventas`
--

INSERT INTO `detalle_ventas` (`id`, `id_producto`, `precio_producto`, `cantidad`, `neto`, `impuesto`, `id_venta`, `created_at`, `updated_at`, `talla`) VALUES
(11, 9, 200.00, 5, 1000.00, 160.00, 11, '2024-11-08 00:56:15', '2024-11-08 00:56:15', 'XL'),
(12, 9, 200.00, 2, 400.00, 64.00, 12, '2024-11-08 01:03:37', '2024-11-08 01:03:37', 'M');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagen_productos`
--

CREATE TABLE `imagen_productos` (
  `id` bigint UNSIGNED NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `producto_id` bigint UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `imagen_productos`
--

INSERT INTO `imagen_productos` (`id`, `url`, `producto_id`, `status`, `created_at`, `updated_at`) VALUES
(26, '/productos/1731011093_FARMACIA.png', 9, 'Activo', '2024-11-08 00:24:53', '2024-11-08 00:24:53'),
(27, '/productos/1731011093_MAPA.png', 9, 'Activo', '2024-11-08 00:24:53', '2024-11-08 00:24:53'),
(28, '/productos/1731011093_UML.png', 9, 'Activo', '2024-11-08 00:24:53', '2024-11-08 00:24:53');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2024_06_30_005841_create_categorias_table', 1),
(7, '2024_06_30_010400_create_sub_categorias_table', 1),
(8, '2024_06_30_011659_create_productos_table', 1),
(9, '2024_06_30_012006_create_imagen_productos_table', 1),
(10, '2024_06_30_172736_create_pagos_table', 1),
(11, '2024_06_30_173250_create_ventas_table', 1),
(12, '2024_06_30_173358_create_detalle_ventas_table', 1),
(13, '2024_06_30_173438_create_recibos_table', 1),
(14, '2024_06_30_175213_create_cajas_table', 1),
(15, '2024_06_30_175240_create_apertura_cajas_table', 1),
(16, '2024_06_30_175250_create_cierre_cajas_table', 1),
(17, '2024_06_30_175314_create_movimiento_table', 1),
(18, '2024_06_30_175337_create_transaccions_table', 1),
(19, '2024_07_07_184346_add_slug_to_productos_table', 1),
(20, '2024_07_08_020534_create_tasas_table', 1),
(21, '2024_07_14_133407_add_fields_to_users_table', 1),
(22, '2024_07_14_140111_create_permission_tables', 1),
(23, '2024_08_04_152318_remove_columns_from_pagos_table', 1),
(24, '2024_08_04_153611_alter_forma_pago_in_ventas_table', 1),
(29, '2024_09_27_175329_add_genero_and_referencia_to_users_table', 2),
(30, '2024_08_04_191122_create_proveedores_table', 3),
(31, '2024_08_04_191544_create_compras_table', 3),
(32, '2024_08_04_192236_create_detalle_compras_table', 3),
(33, '2024_09_07_190950_create_notifications_table', 3),
(34, '2024_10_24_171444_create_promocions_table', 4),
(35, '2024_10_24_171935_create_producto_promocions_table', 5),
(36, '2024_10_30_213509_add_user_id_to_pagos_table', 6),
(37, '2024_11_07_191651_create_producto_tallas_table', 7),
(38, '2024_11_07_204439_add_talla_to_detalle_venta_table', 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 3),
(2, 'App\\Models\\User', 4),
(3, 'App\\Models\\User', 5),
(3, 'App\\Models\\User', 6),
(3, 'App\\Models\\User', 7),
(3, 'App\\Models\\User', 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos_caja`
--

CREATE TABLE `movimientos_caja` (
  `id` bigint UNSIGNED NOT NULL,
  `caja_id` bigint UNSIGNED NOT NULL,
  `usuario_id` bigint UNSIGNED NOT NULL,
  `tipo` enum('entrada','salida') COLLATE utf8mb4_unicode_ci NOT NULL,
  `monto_bolivares` decimal(15,2) NOT NULL DEFAULT '0.00',
  `monto_dolares` decimal(15,2) NOT NULL DEFAULT '0.00',
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('212900b7-1353-4216-a4e7-6cf142f92110', 'App\\Notifications\\VentaGenerada', 'App\\Models\\User', 1, '{\"venta_id\":6,\"monto_total\":139.2,\"fecha\":\"2024-10-23T00:08:00.000000Z\",\"message\":\"Se ha generado una nueva venta online.\",\"type\":\"Venta Online\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/ventas\\/6\"}', NULL, '2024-10-23 04:08:05', '2024-10-23 04:08:05'),
('7cf41b71-baf5-41d7-85ae-2bcb537966c4', 'App\\Notifications\\VentaGenerada', 'App\\Models\\User', 1, '{\"venta_id\":12,\"monto_total\":15716.000000000002,\"fecha\":\"2024-11-07T21:03:37.000000Z\",\"message\":\"Se ha generado una nueva venta online.\",\"type\":\"Venta Online\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/ventas\\/12\"}', NULL, '2024-11-08 01:03:39', '2024-11-08 01:03:39'),
('cadbf365-a3c2-4ccf-8549-63c0d621b6f0', 'App\\Notifications\\VentaGenerada', 'App\\Models\\User', 1, '{\"venta_id\":5,\"monto_total\":4640,\"fecha\":\"2024-10-22T23:11:02.000000Z\",\"message\":\"Se ha generado una nueva venta online.\",\"type\":\"Venta Online\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/ventas\\/5\"}', NULL, '2024-10-23 03:11:19', '2024-10-23 03:11:19'),
('d862a0e5-9535-4a8b-b770-ee0529f65b61', 'App\\Notifications\\VentaGenerada', 'App\\Models\\User', 1, '{\"venta_id\":11,\"monto_total\":39290,\"fecha\":\"2024-11-07T20:56:15.000000Z\",\"message\":\"Se ha generado una nueva venta online.\",\"type\":\"Venta Online\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/ventas\\/11\"}', NULL, '2024-11-08 00:56:30', '2024-11-08 00:56:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` bigint UNSIGNED NOT NULL,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_pago` date NOT NULL,
  `monto_total` decimal(10,2) NOT NULL,
  `monto_neto` decimal(10,2) NOT NULL,
  `descuento` decimal(10,2) DEFAULT NULL,
  `tasa_dolar` decimal(10,2) DEFAULT NULL,
  `forma_pago` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `comprobante_archivo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creado_id` bigint UNSIGNED NOT NULL,
  `porcentaje_descuento` decimal(5,2) DEFAULT NULL,
  `impuestos` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id`, `tipo`, `status`, `fecha_pago`, `monto_total`, `monto_neto`, `descuento`, `tasa_dolar`, `forma_pago`, `comprobante_archivo`, `creado_id`, `porcentaje_descuento`, `impuestos`, `created_at`, `updated_at`, `user_id`) VALUES
(1, 'Compra Regular', 'Pagado', '2024-09-22', 58.00, 50.00, NULL, NULL, 'null', NULL, 1, NULL, 8.00, '2024-09-22 23:39:22', '2024-09-22 23:39:22', NULL),
(2, 'Compra Regular', 'Pagado', '2024-09-22', 58.00, 50.00, NULL, NULL, '[{\"metodo\":null,\"cantidad\":57.99999999999999}]', NULL, 1, NULL, 8.00, '2024-09-22 23:44:28', '2024-09-22 23:44:28', NULL),
(3, 'Venta Online', 'Pagado', '2024-09-25', 42340.00, 36500.00, NULL, 0.00, '[{\"metodo\":\"PAGO MOVIL\",\"cantidad\":42340,\"banco_origen\":\"BANESCO\",\"banco_destino\":\"BANESCO\",\"numero_referencia\":\"12345678\",\"monto_bs\":42340,\"monto_dollar\":0}]', NULL, 1, NULL, 5840.00, '2024-09-25 04:42:13', '2024-10-24 16:32:33', NULL),
(4, 'Venta Online', 'Pagado', '2024-09-25', 42340.00, 36500.00, NULL, 0.00, '[{\"metodo\":\"PAGO MOVIL\",\"cantidad\":42340,\"banco_origen\":\"BANESCO\",\"banco_destino\":\"BANESCO\",\"numero_referencia\":\"12345678\",\"monto_bs\":42340,\"monto_dollar\":0}]', NULL, 1, NULL, 5840.00, '2024-09-25 04:43:10', '2024-10-24 16:34:32', NULL),
(5, 'Venta Online', 'Pagado', '2024-09-25', 42340.00, 36500.00, NULL, 0.00, '[{\"metodo\":\"PAGO MOVIL\",\"cantidad\":42340,\"banco_origen\":\"BANESCO\",\"banco_destino\":\"BANESCO\",\"numero_referencia\":\"12345678\",\"monto_bs\":42340,\"monto_dollar\":0}]', NULL, 1, NULL, 5840.00, '2024-09-25 04:43:34', '2024-09-27 22:32:33', NULL),
(6, 'Venta', 'Rechazado', '2024-09-27', 3480.00, 3000.00, NULL, 0.00, '[{\"metodo\":\"PAGO MOVIL\",\"cantidad\":3480,\"banco_origen\":\"BANESCO\",\"banco_destino\":\"BANESCO\",\"numero_referencia\":\"11111111\",\"monto_bs\":3480,\"monto_dollar\":0}]', NULL, 1, NULL, 480.00, '2024-09-27 22:39:58', '2024-09-27 23:25:56', NULL),
(7, 'Venta Online', 'Pagado', '2024-09-27', 6960.00, 6000.00, NULL, 0.00, '[{\"metodo\":\"PAGO MOVIL\",\"cantidad\":6960,\"banco_origen\":\"MERCANTIL\",\"banco_destino\":\"MERCANTIL\",\"numero_referencia\":\"12345678\",\"monto_bs\":6960,\"monto_dollar\":0}]', NULL, 1, NULL, 960.00, '2024-09-27 23:13:40', '2024-10-24 16:32:26', NULL),
(8, 'Compra Regular', 'Pagado', '2024-09-27', 1334.00, 1150.00, NULL, NULL, '[{\"metodo\":\"Transferencia\",\"cantidad\":1334}]', NULL, 1, NULL, 184.00, '2024-09-27 23:26:27', '2024-09-27 23:26:27', NULL),
(9, 'Compra Regular', 'Pagado', '2024-09-27', 1334.00, 1150.00, NULL, NULL, '[{\"metodo\":\"Efectivo\",\"cantidad\":1334}]', NULL, 1, NULL, 184.00, '2024-09-27 23:29:27', '2024-09-27 23:29:27', NULL),
(10, 'Venta', 'Pendiente', '2024-10-22', 4640.00, 4000.00, NULL, 0.00, '[{\"metodo\":\"PAGO MOVIL\",\"cantidad\":4640,\"banco_origen\":\"BANCO DE VENEZUELA\",\"banco_destino\":\"MERCANTIL\",\"numero_referencia\":\"12345678\",\"monto_bs\":4640,\"monto_dollar\":0}]', NULL, 1, NULL, 640.00, '2024-10-23 03:11:02', '2024-10-23 03:11:02', NULL),
(11, 'Venta', 'Pagado', '2024-10-23', 139.20, 120.00, NULL, 39.13, '[{\"metodo\":\"PAGO MOVIL\",\"cantidad\":139.2,\"banco_origen\":\"BANESCO\",\"banco_destino\":\"MERCANTIL\",\"numero_referencia\":\"12345678\",\"monto_bs\":139.2,\"monto_dollar\":0}]', NULL, 7, NULL, 19.20, '2024-10-23 04:08:00', '2024-10-24 16:32:18', NULL),
(12, 'Compra Regular', 'Pagado', '2024-10-23', 962.80, 830.00, NULL, NULL, '[{\"metodo\":\"Efectivo\",\"cantidad\":962.7999999999998}]', NULL, 1, NULL, 132.80, '2024-10-23 04:44:53', '2024-10-23 04:44:53', NULL),
(13, 'Compra Regular', 'Pagado', '2024-10-23', 962.80, 830.00, NULL, NULL, '[{\"metodo\":\"Efectivo\",\"cantidad\":962.7999999999998}]', NULL, 1, NULL, 132.80, '2024-10-23 04:45:40', '2024-10-23 04:45:40', NULL),
(14, 'Compra Regular', 'Pagado', '2024-10-23', 962.80, 830.00, NULL, NULL, '[{\"metodo\":\"Efectivo\",\"cantidad\":962.7999999999998}]', NULL, 1, NULL, 132.80, '2024-10-23 04:46:40', '2024-10-23 04:46:40', NULL),
(15, 'Compra Regular', 'Pagado', '2024-10-23', 962.80, 830.00, NULL, NULL, '[{\"metodo\":\"Efectivo\",\"cantidad\":962.7999999999998}]', NULL, 1, NULL, 132.80, '2024-10-23 04:47:01', '2024-10-23 04:47:01', NULL),
(16, 'Compra Regular', 'Pagado', '2024-10-23', 1925.60, 1660.00, NULL, NULL, '[{\"metodo\":\"Efectivo\",\"cantidad\":1925.5999999999997}]', NULL, 1, NULL, 265.60, '2024-10-23 04:48:00', '2024-10-24 16:32:11', NULL),
(17, 'Venta', 'Pagado', '2024-10-30', 52791.60, 45510.00, NULL, 39.13, '[{\"metodo\":\"PAGO MOVIL\",\"cantidad\":52791.6,\"banco_origen\":\"BANESCO\",\"banco_destino\":\"BANESCO\",\"numero_referencia\":\"55555555\",\"monto_bs\":52791.6,\"monto_dollar\":0}]', NULL, 1, NULL, 7281.60, '2024-10-31 01:19:55', '2024-10-31 01:20:15', NULL),
(18, 'Venta', 'Pendiente', '2024-10-30', 515.04, 444.00, NULL, 39.13, '[{\"metodo\":\"PAGO MOVIL\",\"cantidad\":515.04,\"banco_origen\":\"BANESCO\",\"banco_destino\":\"BANESCO\",\"numero_referencia\":\"55555555\",\"monto_bs\":515.04,\"monto_dollar\":0}]', NULL, 8, NULL, 71.04, '2024-10-31 01:39:29', '2024-10-31 01:39:29', 8),
(19, 'Compra Regular', 'Pagado', '2024-11-07', 232.00, 200.00, NULL, NULL, '[{\"metodo\":\"Efectivo\",\"cantidad\":231.99999999999997}]', NULL, 1, NULL, 32.00, '2024-11-08 00:13:43', '2024-11-08 00:13:43', NULL),
(20, 'Venta', 'Pendiente', '2024-11-07', 39290.00, 1000.00, NULL, 39.13, '[{\"metodo\":\"PAGO MOVIL\",\"cantidad\":39290,\"banco_origen\":\"BANESCO\",\"banco_destino\":\"MERCANTIL\",\"numero_referencia\":\"12345678\",\"monto_bs\":39290,\"monto_dollar\":0}]', NULL, 1, NULL, 160.00, '2024-11-08 00:52:24', '2024-11-08 00:52:24', NULL),
(21, 'Venta', 'Pendiente', '2024-11-07', 39290.00, 1000.00, NULL, 39.13, '[{\"metodo\":\"PAGO MOVIL\",\"cantidad\":39290,\"banco_origen\":\"BANESCO\",\"banco_destino\":\"MERCANTIL\",\"numero_referencia\":\"12345678\",\"monto_bs\":39290,\"monto_dollar\":0}]', NULL, 1, NULL, 160.00, '2024-11-08 00:53:45', '2024-11-08 00:53:45', NULL),
(22, 'Venta', 'Pagado', '2024-11-07', 39290.00, 1000.00, NULL, 39.13, '[{\"metodo\":\"PAGO MOVIL\",\"cantidad\":39290,\"banco_origen\":\"BANESCO\",\"banco_destino\":\"MERCANTIL\",\"numero_referencia\":\"12345678\",\"monto_bs\":39290,\"monto_dollar\":0}]', NULL, 1, NULL, 160.00, '2024-11-08 00:56:15', '2024-11-08 00:59:26', NULL),
(23, 'Venta', 'Pendiente', '2024-11-07', 15716.00, 400.00, NULL, 39.13, '[{\"metodo\":\"EFECTIVO\",\"cantidad\":15716.000000000002,\"banco_origen\":\"\",\"banco_destino\":\"\",\"numero_referencia\":null,\"monto_bs\":15716.000000000002,\"monto_dollar\":0}]', NULL, 1, NULL, 64.00, '2024-11-08 01:03:37', '2024-11-08 01:03:37', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `precio_compra` decimal(8,2) NOT NULL,
  `precio_venta` decimal(8,2) NOT NULL,
  `aplica_iva` tinyint(1) NOT NULL DEFAULT '0',
  `cantidad` int NOT NULL,
  `sub_categoria_id` bigint UNSIGNED NOT NULL,
  `disponible` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `slug`, `precio_compra`, `precio_venta`, `aplica_iva`, `cantidad`, `sub_categoria_id`, `disponible`, `created_at`, `updated_at`) VALUES
(9, 'Clotrimazol Imazol Crema 1% X 20 G', 'TEST', 'clotrimazol-imazol-crema-1-x-20-g', 12.00, 200.00, 1, -7, 10, 1, '2024-11-08 00:24:53', '2024-11-08 01:03:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_tallas`
--

CREATE TABLE `producto_tallas` (
  `id` bigint UNSIGNED NOT NULL,
  `producto_id` bigint UNSIGNED NOT NULL,
  `talla` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `producto_tallas`
--

INSERT INTO `producto_tallas` (`id`, `producto_id`, `talla`, `cantidad`, `created_at`, `updated_at`) VALUES
(4, 9, 'XL', 0, '2024-11-08 00:24:53', '2024-11-08 00:24:53'),
(5, 9, 'M', 0, '2024-11-08 00:24:53', '2024-11-08 00:24:53');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promociones`
--

CREATE TABLE `promociones` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descuento` decimal(5,2) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `promociones`
--

INSERT INTO `promociones` (`id`, `nombre`, `descuento`, `fecha_inicio`, `fecha_fin`, `created_at`, `updated_at`) VALUES
(1, 'test', 25.00, '2024-10-01', '2024-10-31', '2024-10-24 21:49:46', '2024-10-24 21:49:46'),
(2, 'test', 25.00, '2024-10-24', '2024-10-24', '2024-10-24 21:50:13', '2024-10-24 21:50:13'),
(3, 'Navidad', 25.00, '2024-11-07', '2024-11-30', '2024-11-08 01:09:34', '2024-11-08 01:09:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promocion_producto`
--

CREATE TABLE `promocion_producto` (
  `id` bigint UNSIGNED NOT NULL,
  `producto_id` bigint UNSIGNED NOT NULL,
  `promocion_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `promocion_producto`
--

INSERT INTO `promocion_producto` (`id`, `producto_id`, `promocion_id`, `created_at`, `updated_at`) VALUES
(3, 9, 3, '2024-11-08 01:09:34', '2024-11-08 01:09:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` bigint UNSIGNED NOT NULL,
  `razon_social` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `municipio` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parroquia` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rif` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `razon_social`, `telefono`, `email`, `estado`, `municipio`, `parroquia`, `rif`, `created_at`, `updated_at`) VALUES
(1, 'Samuel Pereira', '04128989729', 'superadmin@gmail.com', 'MONGAS', 'MATURIN', 'MATURIN', 'V279646572', '2024-10-23 04:46:23', '2024-10-23 04:46:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recibos`
--

CREATE TABLE `recibos` (
  `id` bigint UNSIGNED NOT NULL,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `estatus` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pago_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `observaciones` text COLLATE utf8mb4_unicode_ci,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `descuento` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `recibos`
--

INSERT INTO `recibos` (`id`, `tipo`, `monto`, `estatus`, `pago_id`, `user_id`, `observaciones`, `activo`, `descuento`, `created_at`, `updated_at`) VALUES
(1, 'Compra', 58.00, 'Pagado', 1, 1, NULL, 1, NULL, '2024-09-22 23:39:22', '2024-09-22 23:39:22'),
(2, 'Compra', 58.00, 'Pagado', 2, 1, NULL, 1, NULL, '2024-09-22 23:44:28', '2024-09-22 23:44:28'),
(3, 'Venta Online', 42340.00, 'Pendiente', 5, 1, NULL, 1, NULL, '2024-09-25 04:43:34', '2024-09-25 04:43:34'),
(4, 'Venta', 3480.00, 'Rechazado', 6, 1, NULL, 1, NULL, '2024-09-27 22:39:58', '2024-09-27 23:25:56'),
(5, 'Venta Online', 6960.00, 'Pendiente', 7, 1, NULL, 1, NULL, '2024-09-27 23:13:40', '2024-09-27 23:13:40'),
(6, 'Venta', 4640.00, 'Pendiente', 10, 1, NULL, 1, NULL, '2024-10-23 03:11:03', '2024-10-23 03:11:03'),
(7, 'Venta', 139.20, 'Pagado', 11, 7, NULL, 1, NULL, '2024-10-23 04:08:00', '2024-10-24 16:32:18'),
(8, 'Compra', 962.80, 'Pagado', 15, 1, NULL, 1, NULL, '2024-10-23 04:47:01', '2024-10-23 04:47:01'),
(9, 'Compra', 1925.60, 'Pagado', 16, 1, NULL, 1, NULL, '2024-10-23 04:48:00', '2024-10-23 04:48:00'),
(10, 'Venta', 52791.60, 'Pagado', 17, 1, NULL, 1, NULL, '2024-10-31 01:19:56', '2024-10-31 01:20:15'),
(11, 'Venta', 515.04, 'Pendiente', 18, 8, NULL, 1, NULL, '2024-10-31 01:39:29', '2024-10-31 01:39:29'),
(12, 'Venta', 39290.00, 'Pendiente', 22, 1, NULL, 1, NULL, '2024-11-08 00:56:15', '2024-11-08 00:56:15'),
(13, 'Venta', 15716.00, 'Pendiente', 23, 1, NULL, 1, NULL, '2024-11-08 01:03:37', '2024-11-08 01:03:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'superAdmin', 'web', '2024-09-22 19:59:20', '2024-09-22 19:59:20'),
(2, 'empleado', 'web', '2024-09-22 19:59:20', '2024-09-22 19:59:20'),
(3, 'cliente', 'web', '2024-09-22 19:59:20', '2024-09-22 19:59:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sub_categorias`
--

CREATE TABLE `sub_categorias` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `categoria_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sub_categorias`
--

INSERT INTO `sub_categorias` (`id`, `nombre`, `status`, `categoria_id`, `created_at`, `updated_at`) VALUES
(10, 'Refrigeradores Comerciales', 1, 7, '2024-09-25 02:55:52', '2024-09-25 02:55:52'),
(11, 'Refrigeradores Domésticos', 1, 7, '2024-09-25 02:56:07', '2024-09-25 02:56:07'),
(12, 'Compresores Herméticos', 1, 8, '2024-09-25 02:56:31', '2024-09-25 02:56:31'),
(13, 'Compresores Semiherméticos', 1, 8, '2024-09-25 02:56:45', '2024-09-25 02:56:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tasas`
--

CREATE TABLE `tasas` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valor` decimal(10,2) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tasas`
--

INSERT INTO `tasas` (`id`, `name`, `valor`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Dollar', 39.13, 'Activo', '2024-10-23 03:16:47', '2024-10-23 03:16:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transacciones`
--

CREATE TABLE `transacciones` (
  `id` bigint UNSIGNED NOT NULL,
  `caja_id` bigint UNSIGNED NOT NULL,
  `usuario_id` bigint UNSIGNED NOT NULL,
  `tipo` enum('venta','devolucion','compra') COLLATE utf8mb4_unicode_ci NOT NULL,
  `monto_total_bolivares` decimal(15,2) NOT NULL DEFAULT '0.00',
  `monto_total_dolares` decimal(15,2) NOT NULL DEFAULT '0.00',
  `metodo_pago` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `moneda` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `dni` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sector` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `calle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `casa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `genero` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referencia` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `dni`, `sector`, `calle`, `casa`, `status`, `genero`, `referencia`) VALUES
(1, 'Carlos Leonett', 'edgardobello@gmail.com', NULL, '$2y$12$B/mEoHTAQH.4DjkC986YWO1RmJLTxh6PKsFkeQIuekHhmHMKK9dwW', NULL, '2024-09-22 19:59:20', '2024-09-22 19:59:20', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Empleado', 'empleado@example.com', NULL, '$2y$12$PC.33znL6xbQG8Ib9IW8cOjsEqKBFv3n/KMPPRALO8xXdSXDJgr4q', NULL, '2024-09-22 19:59:21', '2024-09-22 19:59:21', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Cliente', 'cliente@example.com', NULL, '$2y$12$ewZGNnGnFNwCEg7F/ptB.egCXTUK3gke4YTASngomwZ2q4/hvu0tK', NULL, '2024-09-22 19:59:21', '2024-09-22 19:59:21', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'MANGO', 'MANGO@GMAILO.COM', NULL, '$2y$12$HHmEVX/yBlrFqdufAN8puurhlpurG7t23mdfknElO.X6h7CsyGtHG', NULL, '2024-09-22 23:36:50', '2024-10-31 01:47:22', '19090820', NULL, NULL, NULL, 'Activo', NULL, NULL),
(5, 'TEST', 'TEST@gmail.com', NULL, '$2y$12$4pPfH4fBKgpgp1icRt.X.eFBWWJ537vr10OQ/cizNZHCCsxQxleOa', NULL, '2024-09-23 00:12:33', '2024-09-23 00:12:33', NULL, 'ALTOS DE LOS GODOS', '1', '1', 'Activo', NULL, NULL),
(6, 'JUAN MANUEL', 'juanmanuel@gmail.com', NULL, '$2y$12$.Q6/SzG42EXg8sWHwhWXkuBCpmI5GY4Tt3up/5lfaLXH9Gwlc7yTq', NULL, '2024-09-27 21:56:22', '2024-09-27 21:56:22', NULL, 'tejero', '2', '16', 'Activo', 'male', 'frente una mata'),
(7, 'Manuel Campos', 'manuelcampos@gmail.com', NULL, '$2y$12$B/mEoHTAQH.4DjkC986YWO1RmJLTxh6PKsFkeQIuekHhmHMKK9dwW', NULL, '2024-10-23 03:26:26', '2024-10-23 03:26:26', NULL, 'Tejero', 'j', '2', 'Activo', NULL, NULL),
(8, 'JOSE RIVERA', 'joserivera@gmail.com', NULL, '$2y$12$V2G/KGWKzOcZasleZCSar.2FX3YkeLzxjs12qgqEBI1L2XMnE3CB.', NULL, '2024-10-31 01:24:54', '2024-10-31 01:24:54', NULL, 'Saman', 'Calle 2A casa 15', '12', 'Activo', 'male', 'Las avenidas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `monto_total` decimal(10,2) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `porcentaje_descuento` decimal(5,2) DEFAULT NULL,
  `pago_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `user_id`, `monto_total`, `status`, `porcentaje_descuento`, `pago_id`, `created_at`, `updated_at`) VALUES
(1, 1, 42340.00, 'Pagado', NULL, 4, '2024-09-25 04:43:10', '2024-10-24 16:34:32'),
(2, 1, 42340.00, 'Pendiente', NULL, 5, '2024-09-25 04:43:34', '2024-09-25 04:43:34'),
(3, 1, 3480.00, 'Rechazado', NULL, 6, '2024-09-27 22:39:58', '2024-09-27 23:25:56'),
(4, 1, 6960.00, 'Pendiente', NULL, 7, '2024-09-27 23:13:40', '2024-09-27 23:13:40'),
(5, 1, 4640.00, 'Pendiente', NULL, 10, '2024-10-23 03:11:02', '2024-10-23 03:11:02'),
(6, 7, 139.20, 'Pagado', NULL, 11, '2024-10-23 04:08:00', '2024-10-24 16:32:18'),
(7, 1, 52791.60, 'Pagado', NULL, 17, '2024-10-31 01:19:55', '2024-10-31 01:20:15'),
(8, 8, 515.04, 'Pendiente', NULL, 18, '2024-10-31 01:39:29', '2024-10-31 01:39:29'),
(9, 1, 39290.00, 'Pendiente', NULL, 20, '2024-11-08 00:52:24', '2024-11-08 00:52:24'),
(10, 1, 39290.00, 'Pendiente', NULL, 21, '2024-11-08 00:53:45', '2024-11-08 00:53:45'),
(11, 1, 39290.00, 'Pagado', NULL, 22, '2024-11-08 00:56:15', '2024-11-08 00:59:26'),
(12, 1, 15716.00, 'Pendiente', NULL, 23, '2024-11-08 01:03:37', '2024-11-08 01:03:37');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `aperturas_caja`
--
ALTER TABLE `aperturas_caja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aperturas_caja_caja_id_foreign` (`caja_id`),
  ADD KEY `aperturas_caja_usuario_id_foreign` (`usuario_id`);

--
-- Indices de la tabla `cajas`
--
ALTER TABLE `cajas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cierres_caja`
--
ALTER TABLE `cierres_caja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cierres_caja_caja_id_foreign` (`caja_id`),
  ADD KEY `cierres_caja_usuario_id_foreign` (`usuario_id`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `compras_proveedor_id_foreign` (`proveedor_id`),
  ADD KEY `compras_user_id_foreign` (`user_id`),
  ADD KEY `compras_pago_id_foreign` (`pago_id`);

--
-- Indices de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalle_compras_id_producto_foreign` (`id_producto`),
  ADD KEY `detalle_compras_id_compra_foreign` (`id_compra`);

--
-- Indices de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalle_ventas_id_producto_foreign` (`id_producto`),
  ADD KEY `detalle_ventas_id_venta_foreign` (`id_venta`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `imagen_productos`
--
ALTER TABLE `imagen_productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `imagen_productos_producto_id_foreign` (`producto_id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `movimientos_caja`
--
ALTER TABLE `movimientos_caja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movimientos_caja_caja_id_foreign` (`caja_id`),
  ADD KEY `movimientos_caja_usuario_id_foreign` (`usuario_id`);

--
-- Indices de la tabla `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pagos_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `productos_slug_unique` (`slug`),
  ADD KEY `productos_sub_categoria_id_foreign` (`sub_categoria_id`);

--
-- Indices de la tabla `producto_tallas`
--
ALTER TABLE `producto_tallas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producto_tallas_producto_id_foreign` (`producto_id`);

--
-- Indices de la tabla `promociones`
--
ALTER TABLE `promociones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `promocion_producto`
--
ALTER TABLE `promocion_producto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `promocion_producto_producto_id_foreign` (`producto_id`),
  ADD KEY `promocion_producto_promocion_id_foreign` (`promocion_id`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `proveedores_email_unique` (`email`),
  ADD UNIQUE KEY `proveedores_rif_unique` (`rif`);

--
-- Indices de la tabla `recibos`
--
ALTER TABLE `recibos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recibos_pago_id_foreign` (`pago_id`),
  ADD KEY `recibos_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indices de la tabla `sub_categorias`
--
ALTER TABLE `sub_categorias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_categorias_categoria_id_foreign` (`categoria_id`);

--
-- Indices de la tabla `tasas`
--
ALTER TABLE `tasas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `transacciones`
--
ALTER TABLE `transacciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transacciones_caja_id_foreign` (`caja_id`),
  ADD KEY `transacciones_usuario_id_foreign` (`usuario_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ventas_user_id_foreign` (`user_id`),
  ADD KEY `ventas_pago_id_foreign` (`pago_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `aperturas_caja`
--
ALTER TABLE `aperturas_caja`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cajas`
--
ALTER TABLE `cajas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `cierres_caja`
--
ALTER TABLE `cierres_caja`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `imagen_productos`
--
ALTER TABLE `imagen_productos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `movimientos_caja`
--
ALTER TABLE `movimientos_caja`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `producto_tallas`
--
ALTER TABLE `producto_tallas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `promociones`
--
ALTER TABLE `promociones`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `promocion_producto`
--
ALTER TABLE `promocion_producto`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `recibos`
--
ALTER TABLE `recibos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `sub_categorias`
--
ALTER TABLE `sub_categorias`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `tasas`
--
ALTER TABLE `tasas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `transacciones`
--
ALTER TABLE `transacciones`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `aperturas_caja`
--
ALTER TABLE `aperturas_caja`
  ADD CONSTRAINT `aperturas_caja_caja_id_foreign` FOREIGN KEY (`caja_id`) REFERENCES `cajas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `aperturas_caja_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `cierres_caja`
--
ALTER TABLE `cierres_caja`
  ADD CONSTRAINT `cierres_caja_caja_id_foreign` FOREIGN KEY (`caja_id`) REFERENCES `cajas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cierres_caja_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_pago_id_foreign` FOREIGN KEY (`pago_id`) REFERENCES `pagos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `compras_proveedor_id_foreign` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedores` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `compras_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  ADD CONSTRAINT `detalle_compras_id_compra_foreign` FOREIGN KEY (`id_compra`) REFERENCES `compras` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_compras_id_producto_foreign` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD CONSTRAINT `detalle_ventas_id_producto_foreign` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `detalle_ventas_id_venta_foreign` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `imagen_productos`
--
ALTER TABLE `imagen_productos`
  ADD CONSTRAINT `imagen_productos_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `movimientos_caja`
--
ALTER TABLE `movimientos_caja`
  ADD CONSTRAINT `movimientos_caja_caja_id_foreign` FOREIGN KEY (`caja_id`) REFERENCES `cajas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movimientos_caja_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_sub_categoria_id_foreign` FOREIGN KEY (`sub_categoria_id`) REFERENCES `sub_categorias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `producto_tallas`
--
ALTER TABLE `producto_tallas`
  ADD CONSTRAINT `producto_tallas_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `promocion_producto`
--
ALTER TABLE `promocion_producto`
  ADD CONSTRAINT `promocion_producto_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `promocion_producto_promocion_id_foreign` FOREIGN KEY (`promocion_id`) REFERENCES `promociones` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `recibos`
--
ALTER TABLE `recibos`
  ADD CONSTRAINT `recibos_pago_id_foreign` FOREIGN KEY (`pago_id`) REFERENCES `pagos` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `recibos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sub_categorias`
--
ALTER TABLE `sub_categorias`
  ADD CONSTRAINT `sub_categorias_categoria_id_foreign` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `transacciones`
--
ALTER TABLE `transacciones`
  ADD CONSTRAINT `transacciones_caja_id_foreign` FOREIGN KEY (`caja_id`) REFERENCES `cajas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transacciones_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_pago_id_foreign` FOREIGN KEY (`pago_id`) REFERENCES `pagos` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ventas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
