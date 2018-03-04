-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2018 at 07:33 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `battary_barcode_system`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `archive_items_sp` (IN `stock_id1` INT, IN `grn1` INT, IN `item_id1` INT, IN `note1` VARCHAR(200))  NO SQL
BEGIN

	UPDATE `item_barcode` SET `status`= '-2' WHERE `stock_id`= stock_id1;
    
    UPDATE `item_bulk_stock` SET `status`= '-2', `note`= note1 WHERE `stock_id`= stock_id1; 
    
    UPDATE `grn` SET `remaining_stock`= 0, `archived` = 1 WHERE `grn`= grn1 AND `item_id`= item_id1;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_addInvoice` (IN `invoice_no` VARCHAR(25), IN `invoice_date` DATE, IN `no_of_items` INT, IN `invoiced_by` VARCHAR(25), IN `item_barcodes` TEXT)  BEGIN



 
SELECT item_barcodes;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_bulk_stock` (IN `barcode` VARCHAR(50), IN `invoice_no` VARCHAR(20), IN `item_id` INT(0), IN `grn` INT(0), IN `bat_qty` INT(0), IN `pkg_qty` INT(0), IN `sup_id` VARCHAR(50), IN `package_id` INT(0), IN `status` INT(0), IN `note` VARCHAR(200))  BEGIN

DECLARE stk_id int;
DECLARE x int;
DECLARE count1 int;
DECLARE new_barcode VARCHAR(50);
DECLARE new_barcode_pkg VARCHAR(50);
DECLARE total_stock int;

SET total_stock = bat_qty * pkg_qty;

SET stk_id = (SELECT stock_id FROM item_bulk_stock ORDER BY stock_id DESC LIMIT 1);

IF stk_id IS NULL THEN
	SET stk_id = 0;
ELSE
	SET stk_id = stk_id + 1;
END IF;

SET x = 1;
SET count1 = 1;

IF (bat_qty = 1) THEN

    SET new_barcode = CONCAT('P', invoice_no, grn, count1, pkg_qty , bat_qty); 
            
    INSERT INTO item_bulk_stock
    (stock_id, barcode, invoice_no, item_id, grn, bat_qty, pkg_qty, sup_id, package_id, status, note) VALUES (stk_id, CONCAT(new_barcode), invoice_no, item_id, grn, bat_qty , pkg_qty, CONCAT(sup_id), package_id, status, note);

    SET new_barcode = CONCAT(invoice_no,grn,count1,pkg_qty,bat_qty,x);  

    INSERT INTO `item_barcode`(`stock_id`, `barcode`, `status`) VALUES (stk_id, new_barcode ,'1');
    
    
    INSERT INTO `grn`( `grn`, `item_id`, `total_stock`, `remaining_stock`) VALUES (grn, item_id, bat_qty, bat_qty);
    
ELSE

    WHILE x <= bat_qty * pkg_qty  DO
     	
        	 IF ( x = total_stock ) THEN
       
       	  INSERT INTO `grn`( `grn`, `item_id`, `total_stock`, `remaining_stock`) VALUES (grn, item_id, total_stock, total_stock);
          
       END IF;
       
        IF (x % (bat_qty) = 1) THEN
        
        	IF (x != 1) THEN
            	SET stk_id = stk_id + 1;
            END IF;
        	
            SET new_barcode = CONCAT('P', invoice_no, grn, count1, pkg_qty , bat_qty); 
        	
            INSERT INTO item_bulk_stock
            (stock_id, barcode, invoice_no, item_id, grn, bat_qty, pkg_qty, sup_id, package_id, status, note) VALUES (stk_id, CONCAT(new_barcode), invoice_no, item_id, grn, bat_qty , pkg_qty, CONCAT(sup_id), package_id, status, note);
            
        	
            SET count1 = count1 + 1;  
          
        END IF;
         

    	SET new_barcode = CONCAT(invoice_no,grn,count1,pkg_qty,bat_qty,x);  

        INSERT INTO `item_barcode`(`stock_id`, `barcode`, `status`) VALUES
        (stk_id, new_barcode ,'1');

        SET  x = x + 1; 
       

        
    END WHILE;

END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_category` (IN `id` INT, IN `cat_name` VARCHAR(50), IN `cat_desc` VARCHAR(50))  BEGIN 
INSERT INTO categories(id,cat_name,cat_desc) VALUES (id,cat_name,cat_desc);

SELECT * from categories;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_login` (IN `r_id` INT)  BEGIN
SELECT * FROM login WHERE role_id = r_id;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_stock` (IN `invoice_id1` INT, IN `barcode1` VARCHAR(50), IN `status` INT)  BEGIN

DECLARE remaining_stock1 int;
DECLARE item_id1 int;
DECLARE grn1 int;


UPDATE `item_barcode` SET `status`= status, `invoice_id`= invoice_id1 WHERE `barcode`= CONCAT(barcode1);


SET item_id1 = (SELECT ibs.item_id FROM `item_bulk_stock` ibs, `item_barcode` ib WHERE ibs.stock_id=ib.stock_id AND ib.barcode = barcode1);

SET grn1 = (SELECT ibs.grn FROM `item_bulk_stock` ibs, `item_barcode` ib WHERE ibs.stock_id=ib.stock_id AND ib.barcode = barcode1);

SET remaining_stock1 = (SELECT `remaining_stock` FROM `grn` WHERE `item_id` = item_id1 AND `grn` = grn1 AND archived = 0);

SET remaining_stock1 = remaining_stock1 - 1;

UPDATE `grn` SET `remaining_stock`= remaining_stock1 WHERE `item_id` = item_id1 AND `grn` = grn1;



END$$

DELIMITER ;

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
(1, 'Car Battery', 'Car Battery Items'),
(2, 'Ups Battery', 'UPS Batteries');

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
(1, 'Mike Flora Pvt Ltd', '275/A Colombo Road, \nGampaha', '0332228887', 'nipunann0710@gmail.com', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.');

-- --------------------------------------------------------

--
-- Table structure for table `grn`
--

CREATE TABLE `grn` (
  `id` int(11) NOT NULL,
  `grn` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `total_stock` int(11) NOT NULL,
  `remaining_stock` int(11) NOT NULL,
  `archived` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grn`
--

INSERT INTO `grn` (`id`, `grn`, `item_id`, `total_stock`, `remaining_stock`, `archived`) VALUES
(17, 1, 1, 8, 15, 1),
(18, 1, 1, 24, 15, 0),
(19, 2, 1, 4, 4, 0),
(20, 1, 3, 24, 24, 0),
(21, 2, 3, 16, 16, 0),
(22, 1, 4, 4, 4, 0),
(23, 2, 4, 4, 4, 0),
(24, 3, 4, 4, 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoice_id` double NOT NULL,
  `invoice_no` varchar(25) NOT NULL,
  `invoice_date` date NOT NULL,
  `no_of_items` int(11) NOT NULL,
  `invoiced_by` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`invoice_id`, `invoice_no`, `invoice_date`, `no_of_items`, `invoiced_by`) VALUES
(25, 'INV04032018232332', '2018-03-04', 2, 'Super Admin'),
(26, 'INV04032018232508', '2018-03-04', 7, 'Super Admin');

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
(1, 'SW4. 5-6', 'SW4. 5-6', 1, 'assets/upload/'),
(2, 'SW5-6C', 'SW5-6C', 1, 'assets/upload/'),
(3, 'YB40', 'YB40', 1, 'assets/upload/'),
(4, 'YB41', 'YB41', 1, 'assets/upload/');

-- --------------------------------------------------------

--
-- Table structure for table `item_barcode`
--

CREATE TABLE `item_barcode` (
  `id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `barcode` varchar(50) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `single_item` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_barcode`
--

INSERT INTO `item_barcode` (`id`, `stock_id`, `barcode`, `invoice_id`, `single_item`, `status`) VALUES
(5280, 0, '81212181', 0, 0, -2),
(5281, 0, '81212182', 0, 0, -2),
(5282, 0, '81212183', 0, 0, -2),
(5283, 0, '81212184', 0, 0, -2),
(5284, 0, '81212185', 0, 0, -2),
(5285, 0, '81212186', 0, 0, -2),
(5286, 0, '81212187', 0, 0, -2),
(5287, 0, '81212188', 0, 0, -2),
(5288, 1, '112312381', 25, 0, 0),
(5289, 1, '112312382', 25, 0, 0),
(5290, 1, '112312383', 26, 0, 0),
(5291, 1, '112312384', 26, 0, 0),
(5292, 1, '112312385', 26, 0, 0),
(5293, 1, '112312386', 26, 0, 0),
(5294, 1, '112312387', 26, 0, 0),
(5295, 1, '112312388', 26, 0, 0),
(5296, 2, '112313389', 26, 0, 0),
(5297, 2, '1123133810', 0, 0, 1),
(5298, 2, '1123133811', 0, 0, 1),
(5299, 2, '1123133812', 0, 0, 1),
(5300, 2, '1123133813', 0, 0, 1),
(5301, 2, '1123133814', 0, 0, 1),
(5302, 2, '1123133815', 0, 0, 1),
(5303, 2, '1123133816', 0, 0, 1),
(5304, 3, '1123143817', 0, 0, 1),
(5305, 3, '1123143818', 0, 0, 1),
(5306, 3, '1123143819', 0, 0, 1),
(5307, 3, '1123143820', 0, 0, 1),
(5308, 3, '1123143821', 0, 0, 1),
(5309, 3, '1123143822', 0, 0, 1),
(5310, 3, '1123143823', 0, 0, 1),
(5311, 3, '1123143824', 0, 0, 1),
(5312, 4, '125422221', 0, 0, 1),
(5313, 4, '125422222', 0, 0, 1),
(5314, 5, '125423223', 0, 0, 1),
(5315, 5, '125423224', 0, 0, 1),
(5316, 6, '15612381', 0, 0, 1),
(5317, 6, '15612382', 0, 0, 1),
(5318, 6, '15612383', 0, 0, 1),
(5319, 6, '15612384', 0, 0, 1),
(5320, 6, '15612385', 0, 0, 1),
(5321, 6, '15612386', 0, 0, 1),
(5322, 6, '15612387', 0, 0, 1),
(5323, 6, '15612388', 0, 0, 1),
(5324, 7, '15613389', 0, 0, 1),
(5325, 7, '156133810', 0, 0, 1),
(5326, 7, '156133811', 0, 0, 1),
(5327, 7, '156133812', 0, 0, 1),
(5328, 7, '156133813', 0, 0, 1),
(5329, 7, '156133814', 0, 0, 1),
(5330, 7, '156133815', 0, 0, 1),
(5331, 7, '156133816', 0, 0, 1),
(5332, 8, '156143817', 0, 0, 1),
(5333, 8, '156143818', 0, 0, 1),
(5334, 8, '156143819', 0, 0, 1),
(5335, 8, '156143820', 0, 0, 1),
(5336, 8, '156143821', 0, 0, 1),
(5337, 8, '156143822', 0, 0, 1),
(5338, 8, '156143823', 0, 0, 1),
(5339, 8, '156143824', 0, 0, 1),
(5340, 9, '56522281', 0, 0, 1),
(5341, 9, '56522282', 0, 0, 1),
(5342, 9, '56522283', 0, 0, 1),
(5343, 9, '56522284', 0, 0, 1),
(5344, 9, '56522285', 0, 0, 1),
(5345, 9, '56522286', 0, 0, 1),
(5346, 9, '56522287', 0, 0, 1),
(5347, 9, '56522288', 0, 0, 1),
(5348, 10, '56523289', 0, 0, 1),
(5349, 10, '565232810', 0, 0, 1),
(5350, 10, '565232811', 0, 0, 1),
(5351, 10, '565232812', 0, 0, 1),
(5352, 10, '565232813', 0, 0, 1),
(5353, 10, '565232814', 0, 0, 1),
(5354, 10, '565232815', 0, 0, 1),
(5355, 10, '565232816', 0, 0, 1),
(5356, 11, '20112221', 0, 0, 1),
(5357, 11, '20112222', 0, 0, 1),
(5358, 12, '20113223', 0, 0, 1),
(5359, 12, '20113224', 0, 0, 1),
(5360, 13, '12322221', 0, 0, 1),
(5361, 13, '12322222', 0, 0, 1),
(5362, 14, '12323223', 0, 0, 1),
(5363, 14, '12323224', 0, 0, 1),
(5364, 15, '16532221', 0, 0, 1),
(5365, 15, '16532222', 0, 0, 1),
(5366, 16, '16533223', 0, 0, 1),
(5367, 16, '16533224', 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `item_bulk_stock`
--

CREATE TABLE `item_bulk_stock` (
  `stock_id` int(11) NOT NULL,
  `barcode` varchar(50) NOT NULL,
  `invoice_no` varchar(30) NOT NULL,
  `manufacture_id` varchar(50) NOT NULL,
  `item_id` int(11) NOT NULL,
  `grn` varchar(20) NOT NULL,
  `bat_qty` int(11) NOT NULL,
  `pkg_qty` int(11) NOT NULL,
  `sup_id` varchar(50) NOT NULL,
  `package_id` int(11) NOT NULL DEFAULT '0',
  `invoice_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `note` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_bulk_stock`
--

INSERT INTO `item_bulk_stock` (`stock_id`, `barcode`, `invoice_no`, `manufacture_id`, `item_id`, `grn`, `bat_qty`, `pkg_qty`, `sup_id`, `package_id`, `invoice_id`, `status`, `note`) VALUES
(0, 'P8121118', '812', '', 1, '1', 8, 1, '03A', 0, 0, -2, 'wrong count'),
(1, 'P11231138', '1123', '', 1, '1', 8, 3, '03A', 0, 26, 0, ''),
(2, 'P11231238', '1123', '', 1, '1', 8, 3, '03A', 0, 0, 1, ''),
(3, 'P11231338', '1123', '', 1, '1', 8, 3, '03A', 0, 0, 1, ''),
(4, 'P12542122', '1254', '', 1, '2', 2, 2, '03A', 0, 0, 1, ''),
(5, 'P12542222', '1254', '', 1, '2', 2, 2, '03A', 0, 0, 1, ''),
(6, 'P1561138', '156', '', 3, '1', 8, 3, '03A', 0, 0, 1, ''),
(7, 'P1561238', '156', '', 3, '1', 8, 3, '03A', 0, 0, 1, ''),
(8, 'P1561338', '156', '', 3, '1', 8, 3, '03A', 0, 0, 1, ''),
(9, 'P5652128', '565', '', 3, '2', 8, 2, '03A', 0, 0, 1, ''),
(10, 'P5652228', '565', '', 3, '2', 8, 2, '03A', 0, 0, 1, ''),
(11, 'P2011122', '201', '', 4, '1', 2, 2, '03A', 0, 0, 1, ''),
(12, 'P2011222', '201', '', 4, '1', 2, 2, '03A', 0, 0, 1, ''),
(13, 'P1232122', '123', '', 4, '2', 2, 2, '03A', 0, 0, 1, ''),
(14, 'P1232222', '123', '', 4, '2', 2, 2, '03A', 0, 0, 1, ''),
(15, 'P1653122', '165', '', 4, '3', 2, 2, '1', 0, 0, 1, ''),
(16, 'P1653222', '165', '', 4, '3', 2, 2, '1', 0, 0, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `item_stock`
--

CREATE TABLE `item_stock` (
  `stock_id` int(11) NOT NULL,
  `barcode` varchar(50) NOT NULL,
  `invoice_no` varchar(30) NOT NULL,
  `item_id` int(11) NOT NULL,
  `manufacture_id` varchar(50) NOT NULL,
  `sup_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL,
  `invoice_id` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(2, 'nipuna', '656176c3a3131f7d729539cf642ac59e', 1);

-- --------------------------------------------------------

--
-- Table structure for table `log_tbl`
--

CREATE TABLE `log_tbl` (
  `id` int(11) NOT NULL,
  `login_id` int(11) NOT NULL,
  `token` varchar(50) NOT NULL,
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `missing`
--

CREATE TABLE `missing` (
  `id` int(11) NOT NULL,
  `barcode` varchar(50) NOT NULL,
  `date` date DEFAULT NULL,
  `remarks` varchar(200) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

CREATE TABLE `package` (
  `pkg_id` double NOT NULL,
  `pkg_barcode` varchar(50) NOT NULL,
  `pkg_items` varchar(1000) NOT NULL,
  `note` varchar(200) NOT NULL,
  `status` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `created_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `return_stock`
--

CREATE TABLE `return_stock` (
  `id` int(11) NOT NULL,
  `barcode` varchar(50) NOT NULL,
  `rep_name` varchar(50) NOT NULL,
  `return_date` varchar(20) NOT NULL,
  `remarks` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(1, 'Cashier');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `sup_id` varchar(50) NOT NULL,
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
('03A', 'Nipuna', '', '', '', '0332228887', '', ''),
('1', 'Zhangahou', 'Zhangahou Power Supply', '', '', '86-595-36306708', '', '');

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
-- Indexes for table `grn`
--
ALTER TABLE `grn`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `item_barcode`
--
ALTER TABLE `item_barcode`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `barcode` (`barcode`);

--
-- Indexes for table `item_bulk_stock`
--
ALTER TABLE `item_bulk_stock`
  ADD PRIMARY KEY (`stock_id`),
  ADD UNIQUE KEY `barcode` (`barcode`);

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
-- Indexes for table `missing`
--
ALTER TABLE `missing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `package`
--
ALTER TABLE `package`
  ADD PRIMARY KEY (`pkg_id`);

--
-- Indexes for table `return_stock`
--
ALTER TABLE `return_stock`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `grn`
--
ALTER TABLE `grn`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoice_id` double NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `item_barcode`
--
ALTER TABLE `item_barcode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5368;
--
-- AUTO_INCREMENT for table `item_stock`
--
ALTER TABLE `item_stock`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `login_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `missing`
--
ALTER TABLE `missing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `package`
--
ALTER TABLE `package`
  MODIFY `pkg_id` double NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `return_stock`
--
ALTER TABLE `return_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
