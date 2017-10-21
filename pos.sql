-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2017 at 07:37 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `cat_name` varchar(30) NOT NULL,
  `cat_desc` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `cat_name`, `cat_desc`) VALUES
(1, 'Biscuit', 'All Kinds of Biscuits'),
(2, 'Noodles', 'All Kinds of Noodles Packets');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(200) NOT NULL,
  `tel` varchar(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `note` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `name`, `address`, `tel`, `email`, `note`) VALUES
(1, 'Zigma Web', '275/A Colombo Road, \nGampaha', '0332228887', 'nipunann0710@gmail.com', 'sdfsf');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `item_id` int(11) NOT NULL,
  `item_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_sinhala_ci NOT NULL,
  `item_display_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_sinhala_ci NOT NULL,
  `cat_id` int(11) NOT NULL,
  `image_url` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`item_id`, `item_name`, `item_display_name`, `cat_id`, `image_url`) VALUES
(1, 'Munchee  Milk Short Cake 85g1', 'Munchee  Milk Short Cake 85g', 1, 'assets/upload/milk.jpg'),
(2, 'PRIMA SPECIAL NOODLES 430G', 'PRIMA SPECIAL NOODLES 430G', 2, 'assets/upload/images1.jpg'),
(3, 'software', 'software', 1, 'assets/upload/8.png');

-- --------------------------------------------------------

--
-- Table structure for table `item_stock`
--

CREATE TABLE `item_stock` (
  `stock_id` int(11) NOT NULL,
  `barcode` varchar(50) NOT NULL,
  `item_id` int(11) NOT NULL,
  `manufacture_id` varchar(50) NOT NULL,
  `sup_id` int(11) NOT NULL,
  `buy_price` float NOT NULL,
  `sell_price` float NOT NULL,
  `quantity` int(11) NOT NULL,
  `reorder_level` int(11) NOT NULL,
  `curr_quantity` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `discount_type` int(11) NOT NULL,
  `net_amount` float NOT NULL,
  `price_changable` int(11) NOT NULL DEFAULT '0',
  `calc_item` int(11) NOT NULL DEFAULT '0',
  `purchase_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `archived` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_stock`
--

INSERT INTO `item_stock` (`stock_id`, `barcode`, `item_id`, `manufacture_id`, `sup_id`, `buy_price`, `sell_price`, `quantity`, `reorder_level`, `curr_quantity`, `discount`, `discount_type`, `net_amount`, `price_changable`, `calc_item`, `purchase_date`, `archived`) VALUES
(14, 'PM9546', 2, 'PM9', 100, 185, 200, 50, 1, 50, 1, 2, 198, 1, 1, '2017-09-10 18:28:15', 0),
(19, '10657373737009', 1, '0', 100, 45, 55, 100, 20, 100, 0, 1, 55, 0, 0, '2017-09-18 17:30:21', 0),
(20, '7754487530847195', 3, '1000', 100, 30, 30, 100, 1, 100, 20, 2, 24, 1, 1, '2017-09-19 08:11:10', 0),
(21, '5001409813407486', 2, '0', 100, 30, 70, 100, 10, 100, 10, 1, 60, 0, 0, '2017-09-19 10:30:54', 0),
(22, '9581427559753612', 4, '34', 100, 100, 120, 100, 10, 1, 0, 2, 120, 1, 1, '2017-09-19 17:46:44', 0),
(26, '1954596118413175', 3, '0', 0, 100, 150, 150, 20, 150, 10, 2, 135, 0, 0, '2017-09-23 03:50:11', 0);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `login_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`login_id`, `username`, `password`, `role_id`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 0),
(2, 'Nipuna', '656176c3a3131f7d729539cf642ac59e', 2),
(4, 'sameera@gmail.com', '6b10f545cf1888bde3edf30086068929', 2);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(0, 'Super Admin'),
(1, 'Admin'),
(2, 'Cashier');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `sup_id` int(11) NOT NULL,
  `sup_name` varchar(50) NOT NULL,
  `dealer` varchar(50) NOT NULL,
  `nic` varchar(20) NOT NULL,
  `address` varchar(150) NOT NULL,
  `tel` varchar(15) NOT NULL,
  `fax` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`sup_id`, `sup_name`, `dealer`, `nic`, `address`, `tel`, `fax`, `email`) VALUES
(100, 'User 1', 'Munchee', '910752839v', '', '0716378515', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `item_stock`
--
ALTER TABLE `item_stock`
  ADD PRIMARY KEY (`stock_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`login_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`sup_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `item_stock`
--
ALTER TABLE `item_stock`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `login_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
