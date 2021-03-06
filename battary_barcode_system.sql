-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 16, 2018 at 03:07 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_bulk_stock` (IN `barcode` VARCHAR(50), IN `invoice_no` VARCHAR(20), IN `item_id` INT(0), IN `grn` INT(0), IN `bat_qty` INT(0), IN `pkg_qty` INT(0), IN `sup_id` VARCHAR(50), IN `package_id` INT(0), IN `status` INT(0), IN `note` VARCHAR(200), IN `manufacture_id1` VARCHAR(50))  BEGIN

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
    (stock_id, barcode, invoice_no, item_id, grn, bat_qty, pkg_qty, sup_id, package_id, status, note, manufacture_id) VALUES (stk_id, CONCAT(new_barcode), invoice_no, item_id, grn, bat_qty , pkg_qty, CONCAT(sup_id), package_id, status, note, manufacture_id1);

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
            (stock_id, barcode, invoice_no, item_id, grn, bat_qty, pkg_qty, sup_id, package_id, status, note, manufacture_id) VALUES (stk_id, CONCAT(new_barcode), invoice_no, item_id, grn, bat_qty , pkg_qty, CONCAT(sup_id), package_id, status, note, manufacture_id1);
            
        	
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
(2, 'Ups Battery', 'UPS Batteries'),
(3, 'Mobile Battery', 'as  asd');

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
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `tel` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_name`, `address`, `tel`) VALUES
(1, 'Nipuna Nanayakkara', '275/A  Colombo Road, Gampaha', '0716378515'),
(2, 'Nuwan Gamage', '32 Colombo Road, Mahara,\nKadawatha', '0332259754'),
(3, 'Samantha Perera', '354 Kandy road, Yakkala', '0716969467');

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
  `archived` int(11) NOT NULL,
  `in_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grn`
--

INSERT INTO `grn` (`id`, `grn`, `item_id`, `total_stock`, `remaining_stock`, `archived`, `in_date`) VALUES
(17, 1, 1, 8, 0, 1, '2018-03-16 01:44:19'),
(18, 1, 1, 24, 0, 0, '2018-03-16 01:44:19'),
(19, 2, 1, 4, 1, 0, '2018-03-16 01:44:19'),
(20, 1, 3, 24, 23, 0, '2018-03-16 01:44:19'),
(21, 2, 3, 16, 16, 0, '2018-03-16 01:44:19'),
(22, 1, 4, 4, 4, 0, '2018-03-16 01:44:19'),
(23, 2, 4, 4, 4, 0, '2018-03-16 01:44:19'),
(24, 3, 4, 4, 4, 0, '2018-03-16 01:44:19'),
(25, 4, 2, 20, 10, 0, '2018-03-16 01:44:19'),
(26, 5, 2, 10, 10, 0, '2018-03-16 01:44:19'),
(27, 5, 1, 1, 14, 1, '2018-03-16 01:44:19'),
(28, 3, 1, 40, 30, 0, '2018-03-16 01:44:19'),
(29, 5, 1, 16, 14, 1, '2018-03-16 01:44:19'),
(30, 5, 1, 24, 14, 0, '2018-03-16 01:44:19'),
(31, 4, 4, 5, 5, 0, '2018-03-16 01:44:19'),
(32, 5, 4, 10, 10, 0, '2018-03-16 01:44:19'),
(33, 6, 4, 5, 5, 0, '2018-03-16 01:44:19'),
(34, 7, 4, 5, 5, 0, '2018-03-16 01:44:19'),
(35, 7, 1, 16, 14, 0, '2018-03-16 01:44:19'),
(36, 1, 5, 20, 20, 0, '2018-03-16 01:44:19'),
(37, 7, 5, 20, 10, 0, '2018-03-16 01:49:35');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoice_id` double NOT NULL,
  `invoice_no` varchar(25) NOT NULL,
  `invoice_date` date NOT NULL,
  `no_of_items` int(11) NOT NULL,
  `invoiced_by` varchar(25) NOT NULL,
  `customer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`invoice_id`, `invoice_no`, `invoice_date`, `no_of_items`, `invoiced_by`, `customer_id`) VALUES
(25, 'INV04032018232332', '2018-03-04', 2, 'Super Admin', 1),
(26, 'INV04032018232508', '2018-03-04', 7, 'Super Admin', 1),
(27, 'INV10032018140844', '2018-03-10', 7, 'Super Admin', 1),
(28, 'INV12032018003909', '2018-03-12', 1, 'Super Admin', 2),
(29, 'L-12032018014407', '2018-03-12', 1, 'Super Admin', 0),
(30, 'L-12032018020808', '2018-03-12', 2, 'Super Admin', 0),
(31, 'INV12032018020845', '2018-03-12', 6, 'Super Admin', 3),
(32, 'L-12032018210736', '2018-03-12', 10, 'Super Admin', 0),
(33, 'INV14032018002125', '2018-03-14', 10, 'Super Admin', 0),
(34, 'INV15032018234755', '2018-03-15', 8, 'Super Admin', 3),
(35, 'INV16032018060535', '2018-03-16', 1, 'Super Admin', 1),
(36, 'INV16032018060617', '2018-03-16', 1, 'Super Admin', 2),
(37, 'INV16032018060736', '2018-03-16', 2, 'Super Admin', 3),
(38, 'INV16032018072001', '2018-03-16', 10, 'Super Admin', 2),
(39, 'INV16032018072255', '2018-03-16', 2, 'Super Admin', 2);

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
(4, 'YB41', 'YB41', 1, 'assets/upload/'),
(5, 'MB 25', 'MB25', 3, 'assets/upload/232397481-wallpaper-dubai-beach.jpg');

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
(5297, 2, '1123133810', 27, 0, 0),
(5298, 2, '1123133811', 27, 0, 0),
(5299, 2, '1123133812', 27, 0, 0),
(5300, 2, '1123133813', 27, 0, 0),
(5301, 2, '1123133814', 27, 0, 0),
(5302, 2, '1123133815', 27, 0, 0),
(5303, 2, '1123133816', 27, 0, 0),
(5304, 3, '1123143817', 31, 0, 0),
(5305, 3, '1123143818', 31, 0, 0),
(5306, 3, '1123143819', 31, 0, 0),
(5307, 3, '1123143820', 31, 0, 0),
(5308, 3, '1123143821', 31, 0, 0),
(5309, 3, '1123143822', 30, 0, -1),
(5310, 3, '1123143823', 31, 0, 0),
(5311, 3, '1123143824', 30, 0, -1),
(5312, 4, '125422221', 0, 0, 1),
(5313, 4, '125422222', 29, 0, -1),
(5314, 5, '125423223', 37, 0, 0),
(5315, 5, '125423224', 37, 0, 0),
(5316, 6, '15612381', 0, 0, 1),
(5317, 6, '15612382', 0, 0, 1),
(5318, 6, '15612383', 0, 0, 1),
(5319, 6, '15612384', 0, 0, 1),
(5320, 6, '15612385', 0, 0, 1),
(5321, 6, '15612386', 0, 0, 1),
(5322, 6, '15612387', 0, 0, 1),
(5323, 6, '15612388', 28, 0, 0),
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
(5367, 16, '16533224', 0, 0, 1),
(5368, 17, '46422101', 32, 0, -1),
(5369, 17, '46422102', 32, 0, -1),
(5370, 17, '46422103', 32, 0, -1),
(5371, 17, '46422104', 32, 0, -1),
(5372, 17, '46422105', 32, 0, -1),
(5373, 17, '46422106', 32, 0, -1),
(5374, 17, '46422107', 32, 0, -1),
(5375, 17, '46422108', 32, 0, -1),
(5376, 17, '46422109', 32, 0, -1),
(5377, 17, '464221010', 32, 0, -1),
(5378, 18, '464321011', 0, 0, 1),
(5379, 18, '464321012', 0, 0, 1),
(5380, 18, '464321013', 0, 0, 1),
(5381, 18, '464321014', 0, 0, 1),
(5382, 18, '464321015', 0, 0, 1),
(5383, 18, '464321016', 0, 0, 1),
(5384, 18, '464321017', 0, 0, 1),
(5385, 18, '464321018', 0, 0, 1),
(5386, 18, '464321019', 0, 0, 1),
(5387, 18, '464321020', 0, 0, 1),
(5388, 19, '45521101', 0, 0, 1),
(5389, 19, '45521102', 0, 0, 1),
(5390, 19, '45521103', 0, 0, 1),
(5391, 19, '45521104', 0, 0, 1),
(5392, 19, '45521105', 0, 0, 1),
(5393, 19, '45521106', 0, 0, 1),
(5394, 19, '45521107', 0, 0, 1),
(5395, 19, '45521108', 0, 0, 1),
(5396, 19, '45521109', 0, 0, 1),
(5397, 19, '455211010', 0, 0, 1),
(5398, 20, '16551111', 0, 0, -2),
(5399, 21, '561132581', 0, 0, 1),
(5400, 21, '561132582', 0, 0, 1),
(5401, 21, '561132583', 0, 0, 1),
(5402, 21, '561132584', 0, 0, 1),
(5403, 21, '561132585', 0, 0, 1),
(5404, 21, '561132586', 0, 0, 1),
(5405, 21, '561132587', 0, 0, 1),
(5406, 21, '561132588', 0, 0, 1),
(5407, 22, '561133589', 0, 0, 1),
(5408, 22, '5611335810', 0, 0, 1),
(5409, 22, '5611335811', 0, 0, 1),
(5410, 22, '5611335812', 0, 0, 1),
(5411, 22, '5611335813', 33, 0, 0),
(5412, 22, '5611335814', 0, 0, 1),
(5413, 22, '5611335815', 0, 0, 1),
(5414, 22, '5611335816', 33, 0, 0),
(5415, 23, '5611345817', 0, 0, 1),
(5416, 23, '5611345818', 0, 0, 1),
(5417, 23, '5611345819', 0, 0, 1),
(5418, 23, '5611345820', 0, 0, 1),
(5419, 23, '5611345821', 0, 0, 1),
(5420, 23, '5611345822', 0, 0, 1),
(5421, 23, '5611345823', 0, 0, 1),
(5422, 23, '5611345824', 0, 0, 1),
(5423, 24, '5611355825', 34, 0, 0),
(5424, 24, '5611355826', 34, 0, 0),
(5425, 24, '5611355827', 34, 0, 0),
(5426, 24, '5611355828', 34, 0, 0),
(5427, 24, '5611355829', 34, 0, 0),
(5428, 24, '5611355830', 34, 0, 0),
(5429, 24, '5611355831', 34, 0, 0),
(5430, 24, '5611355832', 34, 0, 0),
(5431, 25, '5611365833', 0, 0, 1),
(5432, 25, '5611365834', 0, 0, 1),
(5433, 25, '5611365835', 0, 0, 1),
(5434, 25, '5611365836', 0, 0, 1),
(5435, 25, '5611365837', 0, 0, 1),
(5436, 25, '5611365838', 0, 0, 1),
(5437, 25, '5611365839', 0, 0, 1),
(5438, 25, '5611365840', 0, 0, 1),
(5439, 26, '16152281', 0, 0, -2),
(5440, 26, '16152282', 0, 0, -2),
(5441, 26, '16152283', 0, 0, -2),
(5442, 26, '16152284', 0, 0, -2),
(5443, 26, '16152285', 0, 0, -2),
(5444, 26, '16152286', 0, 0, -2),
(5445, 26, '16152287', 0, 0, -2),
(5446, 26, '16152288', 0, 0, -2),
(5447, 27, '16153289', 0, 0, -2),
(5448, 27, '161532810', 0, 0, -2),
(5449, 27, '161532811', 0, 0, -2),
(5450, 27, '161532812', 0, 0, -2),
(5451, 27, '161532813', 0, 0, -2),
(5452, 27, '161532814', 0, 0, -2),
(5453, 27, '161532815', 0, 0, -2),
(5454, 27, '161532816', 0, 0, -2),
(5455, 28, '15252381', 33, 0, 0),
(5456, 28, '15252382', 33, 0, 0),
(5457, 28, '15252383', 33, 0, 0),
(5458, 28, '15252384', 33, 0, 0),
(5459, 28, '15252385', 33, 0, 0),
(5460, 28, '15252386', 33, 0, 0),
(5461, 28, '15252387', 33, 0, 0),
(5462, 28, '15252388', 33, 0, 0),
(5463, 29, '15253389', 0, 0, 1),
(5464, 29, '152533810', 0, 0, 1),
(5465, 29, '152533811', 36, 0, 0),
(5466, 29, '152533812', 35, 0, 0),
(5467, 29, '152533813', 0, 0, 1),
(5468, 29, '152533814', 0, 0, 1),
(5469, 29, '152533815', 0, 0, 1),
(5470, 29, '152533816', 0, 0, 1),
(5471, 30, '152543817', 0, 0, 1),
(5472, 30, '152543818', 0, 0, 1),
(5473, 30, '152543819', 0, 0, 1),
(5474, 30, '152543820', 0, 0, 1),
(5475, 30, '152543821', 0, 0, 1),
(5476, 30, '152543822', 0, 0, 1),
(5477, 30, '152543823', 0, 0, 1),
(5478, 30, '152543824', 0, 0, 1),
(5479, 31, '156442151', 0, 0, 1),
(5480, 31, '156442152', 0, 0, 1),
(5481, 31, '156442153', 0, 0, 1),
(5482, 31, '156442154', 0, 0, 1),
(5483, 31, '156442155', 0, 0, 1),
(5484, 32, '1552251', 0, 0, 1),
(5485, 32, '1552252', 0, 0, 1),
(5486, 32, '1552253', 0, 0, 1),
(5487, 32, '1552254', 0, 0, 1),
(5488, 32, '1552255', 0, 0, 1),
(5489, 33, '1553256', 0, 0, 1),
(5490, 33, '1553257', 0, 0, 1),
(5491, 33, '1553258', 0, 0, 1),
(5492, 33, '1553259', 0, 0, 1),
(5493, 33, '15532510', 0, 0, 1),
(5494, 34, '162151', 0, 0, 1),
(5495, 34, '162152', 0, 0, 1),
(5496, 34, '162153', 0, 0, 1),
(5497, 34, '162154', 0, 0, 1),
(5498, 34, '162155', 0, 0, 1),
(5499, 35, '2572151', 0, 0, 1),
(5500, 35, '2572152', 0, 0, 1),
(5501, 35, '2572153', 0, 0, 1),
(5502, 35, '2572154', 0, 0, 1),
(5503, 35, '2572155', 0, 0, 1),
(5504, 36, '1269AE72281', 0, 0, 1),
(5505, 36, '1269AE72282', 39, 0, 0),
(5506, 36, '1269AE72283', 39, 0, 0),
(5507, 36, '1269AE72284', 0, 0, 1),
(5508, 36, '1269AE72285', 0, 0, 1),
(5509, 36, '1269AE72286', 0, 0, 1),
(5510, 36, '1269AE72287', 0, 0, 1),
(5511, 36, '1269AE72288', 0, 0, 1),
(5512, 37, '1269AE73289', 0, 0, 1),
(5513, 37, '1269AE732810', 0, 0, 1),
(5514, 37, '1269AE732811', 0, 0, 1),
(5515, 37, '1269AE732812', 0, 0, 1),
(5516, 37, '1269AE732813', 0, 0, 1),
(5517, 37, '1269AE732814', 0, 0, 1),
(5518, 37, '1269AE732815', 0, 0, 1),
(5519, 37, '1269AE732816', 0, 0, 1),
(5520, 38, '1589122101', 0, 0, 1),
(5521, 38, '1589122102', 0, 0, 1),
(5522, 38, '1589122103', 0, 0, 1),
(5523, 38, '1589122104', 0, 0, 1),
(5524, 38, '1589122105', 0, 0, 1),
(5525, 38, '1589122106', 0, 0, 1),
(5526, 38, '1589122107', 0, 0, 1),
(5527, 38, '1589122108', 0, 0, 1),
(5528, 38, '1589122109', 0, 0, 1),
(5529, 38, '15891221010', 0, 0, 1),
(5530, 39, '15891321011', 0, 0, 1),
(5531, 39, '15891321012', 0, 0, 1),
(5532, 39, '15891321013', 0, 0, 1),
(5533, 39, '15891321014', 0, 0, 1),
(5534, 39, '15891321015', 0, 0, 1),
(5535, 39, '15891321016', 0, 0, 1),
(5536, 39, '15891321017', 0, 0, 1),
(5537, 39, '15891321018', 0, 0, 1),
(5538, 39, '15891321019', 0, 0, 1),
(5539, 39, '15891321020', 0, 0, 1),
(5540, 40, '10722101', 0, 0, 1),
(5541, 40, '10722102', 0, 0, 1),
(5542, 40, '10722103', 0, 0, 1),
(5543, 40, '10722104', 0, 0, 1),
(5544, 40, '10722105', 0, 0, 1),
(5545, 40, '10722106', 0, 0, 1),
(5546, 40, '10722107', 0, 0, 1),
(5547, 40, '10722108', 0, 0, 1),
(5548, 40, '10722109', 0, 0, 1),
(5549, 40, '107221010', 0, 0, 1),
(5550, 41, '107321011', 38, 0, 0),
(5551, 41, '107321012', 38, 0, 0),
(5552, 41, '107321013', 38, 0, 0),
(5553, 41, '107321014', 38, 0, 0),
(5554, 41, '107321015', 38, 0, 0),
(5555, 41, '107321016', 38, 0, 0),
(5556, 41, '107321017', 38, 0, 0),
(5557, 41, '107321018', 38, 0, 0),
(5558, 41, '107321019', 38, 0, 0),
(5559, 41, '107321020', 38, 0, 0);

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
  `note` varchar(200) NOT NULL,
  `in_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_bulk_stock`
--

INSERT INTO `item_bulk_stock` (`stock_id`, `barcode`, `invoice_no`, `manufacture_id`, `item_id`, `grn`, `bat_qty`, `pkg_qty`, `sup_id`, `package_id`, `invoice_id`, `status`, `note`, `in_date`) VALUES
(0, 'P8121118', '812', '', 1, '1', 8, 1, '03A', 0, 0, -2, 'wrong count', '0000-00-00 00:00:00'),
(1, 'P11231138', '1123', '', 1, '1', 8, 3, '03A', 0, 26, 0, '', '0000-00-00 00:00:00'),
(2, 'P11231238', '1123', '', 1, '1', 8, 3, '03A', 0, 27, 0, '', '0000-00-00 00:00:00'),
(3, 'P11231338', '1123', '', 1, '1', 8, 3, '03A', 0, 31, 0, '', '0000-00-00 00:00:00'),
(4, 'P12542122', '1254', '', 1, '2', 2, 2, '03A', 0, 0, 1, '', '0000-00-00 00:00:00'),
(5, 'P12542222', '1254', '', 1, '2', 2, 2, '03A', 0, 0, 1, '', '0000-00-00 00:00:00'),
(6, 'P1561138', '156', '', 3, '1', 8, 3, '03A', 0, 0, 1, '', '0000-00-00 00:00:00'),
(7, 'P1561238', '156', '', 3, '1', 8, 3, '03A', 0, 0, 1, '', '0000-00-00 00:00:00'),
(8, 'P1561338', '156', '', 3, '1', 8, 3, '03A', 0, 0, 1, '', '0000-00-00 00:00:00'),
(9, 'P5652128', '565', '', 3, '2', 8, 2, '03A', 0, 0, 1, '', '0000-00-00 00:00:00'),
(10, 'P5652228', '565', '', 3, '2', 8, 2, '03A', 0, 0, 1, '', '0000-00-00 00:00:00'),
(11, 'P2011122', '201', '', 4, '1', 2, 2, '03A', 0, 0, 1, '', '0000-00-00 00:00:00'),
(12, 'P2011222', '201', '', 4, '1', 2, 2, '03A', 0, 0, 1, '', '0000-00-00 00:00:00'),
(13, 'P1232122', '123', '', 4, '2', 2, 2, '03A', 0, 0, 1, '', '0000-00-00 00:00:00'),
(14, 'P1232222', '123', '', 4, '2', 2, 2, '03A', 0, 0, 1, '', '0000-00-00 00:00:00'),
(15, 'P1653122', '165', '', 4, '3', 2, 2, '1', 0, 0, 1, '', '0000-00-00 00:00:00'),
(16, 'P1653222', '165', '', 4, '3', 2, 2, '1', 0, 0, 1, '', '0000-00-00 00:00:00'),
(17, 'P4641210', '46', '', 2, '4', 10, 2, '03A', 0, 32, -1, '', '0000-00-00 00:00:00'),
(18, 'P4642210', '46', '', 2, '4', 10, 2, '03A', 0, 0, 1, '', '0000-00-00 00:00:00'),
(19, 'P4551110', '45', '', 2, '5', 10, 1, '03A', 0, 0, 1, '', '0000-00-00 00:00:00'),
(20, 'P1655111', '165', '', 1, '5', 1, 1, '1', 0, 0, -2, 'not needed', '0000-00-00 00:00:00'),
(21, 'P56113158', '5611', '', 1, '3', 8, 5, '1', 0, 0, 1, '', '0000-00-00 00:00:00'),
(22, 'P56113258', '5611', '', 1, '3', 8, 5, '1', 0, 0, 1, '', '0000-00-00 00:00:00'),
(23, 'P56113358', '5611', '', 1, '3', 8, 5, '1', 0, 0, 1, '', '0000-00-00 00:00:00'),
(24, 'P56113458', '5611', '', 1, '3', 8, 5, '1', 0, 34, 0, '', '0000-00-00 00:00:00'),
(25, 'P56113558', '5611', '', 1, '3', 8, 5, '1', 0, 0, 1, '', '0000-00-00 00:00:00'),
(26, 'P1615128', '161', '', 1, '5', 8, 2, '1', 0, 0, -2, 'Wrong Data', '0000-00-00 00:00:00'),
(27, 'P1615228', '161', '', 1, '5', 8, 2, '1', 0, 0, -2, 'Wrong Data', '0000-00-00 00:00:00'),
(28, 'P1525138', '152', '', 1, '5', 8, 3, '03A', 0, 33, 0, '', '0000-00-00 00:00:00'),
(29, 'P1525238', '152', '', 1, '5', 8, 3, '03A', 0, 0, 1, '', '0000-00-00 00:00:00'),
(30, 'P1525338', '152', '', 1, '5', 8, 3, '03A', 0, 0, 1, '', '0000-00-00 00:00:00'),
(31, 'P15644115', '1564', '', 4, '4', 5, 1, '03A', 0, 0, 1, '', '0000-00-00 00:00:00'),
(32, 'P155125', '15', '', 4, '5', 5, 2, '1', 0, 0, 1, 'a asd', '0000-00-00 00:00:00'),
(33, 'P155225', '15', '', 4, '5', 5, 2, '1', 0, 0, 1, 'a asd', '0000-00-00 00:00:00'),
(34, 'P16115', '1', '', 4, '6', 5, 1, '1', 0, 0, 1, '', '0000-00-00 00:00:00'),
(35, 'P257115', '25', '651', 4, '7', 5, 1, '1', 0, 0, 1, '', '0000-00-00 00:00:00'),
(36, 'P1269AE7128', '1269AE', '65EAQ', 1, '7', 8, 2, '1', 0, 0, 1, 'Battery', '2018-03-15 17:05:59'),
(37, 'P1269AE7228', '1269AE', '65EAQ1', 1, '7', 8, 2, '1', 0, 0, 1, 'Battery', '2018-03-15 17:05:59'),
(38, 'P158911210', '1589', 'A985644', 5, '1', 10, 2, '998AE45', 0, 0, 1, '', '2018-03-15 17:24:55'),
(39, 'P158912210', '1589', 'A985644', 5, '1', 10, 2, '998AE45', 0, 0, 1, '', '2018-03-15 17:24:55'),
(40, 'P1071210', '10', '16565', 5, '7', 10, 2, '03A', 0, 0, 1, '', '2018-03-16 01:49:35'),
(41, 'P1072210', '10', '16565', 5, '7', 10, 2, '03A', 0, 38, 0, '', '2018-03-16 01:49:35');

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
(2, 'nipuna', '656176c3a3131f7d729539cf642ac59e', 1),
(3, 'nimal.perera', '75659cc9ffe9ceba60fa5db397523c31', 0);

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
  `rep_name` varchar(100) NOT NULL,
  `return_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `remarks` varchar(150) NOT NULL,
  `added_by` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `return_stock`
--

INSERT INTO `return_stock` (`id`, `barcode`, `rep_name`, `return_date`, `remarks`, `added_by`) VALUES
(1, '112312381', 'Amal', '0000-00-00 00:00:00', 'Not working, battery dead', ''),
(2, '125423223', 'Samantha Perera', '2018-03-16 00:48:00', 'not good item', 'admin');

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
('1', 'Zhangahou', 'Zhangahou Power Supply', '', '', '86-595-36306708', '', ''),
('998AE45', 'Chi Zen', 'Chi Zen', '', '', '035897494', '', '');

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
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

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
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `grn`
--
ALTER TABLE `grn`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoice_id` double NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `item_barcode`
--
ALTER TABLE `item_barcode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5560;

--
-- AUTO_INCREMENT for table `item_stock`
--
ALTER TABLE `item_stock`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `login_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
