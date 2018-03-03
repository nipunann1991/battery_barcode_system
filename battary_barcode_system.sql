-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2018 at 05:25 AM
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

IF (pkg_qty = 1) THEN

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
  `remaining_stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grn`
--

INSERT INTO `grn` (`id`, `grn`, `item_id`, `total_stock`, `remaining_stock`) VALUES
(2, 1, 1, 40, 40),
(3, 1, 3, 30, 30);

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
(4945, 0, '103512581', 0, 0, 1),
(4946, 0, '103512582', 0, 0, 1),
(4947, 0, '103512583', 0, 0, 1),
(4948, 0, '103512584', 0, 0, 1),
(4949, 0, '103512585', 0, 0, 1),
(4950, 0, '103512586', 0, 0, 1),
(4951, 0, '103512587', 0, 0, 1),
(4952, 0, '103512588', 0, 0, 1),
(4953, 1, '103513589', 0, 0, 1),
(4954, 1, '1035135810', 0, 0, 1),
(4955, 1, '1035135811', 0, 0, 1),
(4956, 1, '1035135812', 0, 0, 1),
(4957, 1, '1035135813', 0, 0, 1),
(4958, 1, '1035135814', 0, 0, 1),
(4959, 1, '1035135815', 0, 0, 1),
(4960, 1, '1035135816', 0, 0, 1),
(4961, 2, '1035145817', 0, 0, 1),
(4962, 2, '1035145818', 0, 0, 1),
(4963, 2, '1035145819', 0, 0, 1),
(4964, 2, '1035145820', 0, 0, 1),
(4965, 2, '1035145821', 0, 0, 1),
(4966, 2, '1035145822', 0, 0, 1),
(4967, 2, '1035145823', 0, 0, 1),
(4968, 2, '1035145824', 0, 0, 1),
(4969, 3, '1035155825', 0, 0, 1),
(4970, 3, '1035155826', 0, 0, 1),
(4971, 3, '1035155827', 0, 0, 1),
(4972, 3, '1035155828', 0, 0, 1),
(4973, 3, '1035155829', 0, 0, 1),
(4974, 3, '1035155830', 0, 0, 1),
(4975, 3, '1035155831', 0, 0, 1),
(4976, 3, '1035155832', 0, 0, 1),
(4977, 4, '1035165833', 0, 0, 1),
(4978, 4, '1035165834', 0, 0, 1),
(4979, 4, '1035165835', 0, 0, 1),
(4980, 4, '1035165836', 0, 0, 1),
(4981, 4, '1035165837', 0, 0, 1),
(4982, 4, '1035165838', 0, 0, 1),
(4983, 4, '1035165839', 0, 0, 1),
(4984, 4, '1035165840', 0, 0, 1),
(4985, 5, '1123101', 0, 0, 1),
(4986, 5, '1123102', 0, 0, 1),
(4987, 5, '1123103', 0, 0, 1),
(4988, 5, '1123104', 0, 0, 1),
(4989, 5, '1123105', 0, 0, 1),
(4990, 5, '1123106', 0, 0, 1),
(4991, 5, '1123107', 0, 0, 1),
(4992, 5, '1123108', 0, 0, 1),
(4993, 5, '1123109', 0, 0, 1),
(4994, 5, '11231010', 0, 0, 1),
(4995, 6, '11331011', 0, 0, 1),
(4996, 6, '11331012', 0, 0, 1),
(4997, 6, '11331013', 0, 0, 1),
(4998, 6, '11331014', 0, 0, 1),
(4999, 6, '11331015', 0, 0, 1),
(5000, 6, '11331016', 0, 0, 1),
(5001, 6, '11331017', 0, 0, 1),
(5002, 6, '11331018', 0, 0, 1),
(5003, 6, '11331019', 0, 0, 1),
(5004, 6, '11331020', 0, 0, 1),
(5005, 7, '11431021', 0, 0, 1),
(5006, 7, '11431022', 0, 0, 1),
(5007, 7, '11431023', 0, 0, 1),
(5008, 7, '11431024', 0, 0, 1),
(5009, 7, '11431025', 0, 0, 1),
(5010, 7, '11431026', 0, 0, 1),
(5011, 7, '11431027', 0, 0, 1),
(5012, 7, '11431028', 0, 0, 1),
(5013, 7, '11431029', 0, 0, 1),
(5014, 7, '11431030', 0, 0, 1);

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
(0, 'P10351158', '1035', '', 1, '1', 8, 5, '03A', 0, 0, 1, 'first stock'),
(1, 'P10351258', '1035', '', 1, '1', 8, 5, '03A', 0, 0, 1, 'first stock'),
(2, 'P10351358', '1035', '', 1, '1', 8, 5, '03A', 0, 0, 1, 'first stock'),
(3, 'P10351458', '1035', '', 1, '1', 8, 5, '03A', 0, 0, 1, 'first stock'),
(4, 'P10351558', '1035', '', 1, '1', 8, 5, '03A', 0, 0, 1, 'first stock'),
(5, 'P111310', '1', '', 3, '1', 10, 3, '1', 0, 0, 1, ''),
(6, 'P112310', '1', '', 3, '1', 10, 3, '1', 0, 0, 1, ''),
(7, 'P113310', '1', '', 3, '1', 10, 3, '1', 0, 0, 1, '');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoice_id` double NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `item_barcode`
--
ALTER TABLE `item_barcode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5015;
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
