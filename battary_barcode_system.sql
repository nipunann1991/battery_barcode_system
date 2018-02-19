-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 19, 2018 at 06:51 PM
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_bulk_stock` (IN `barcode` VARCHAR(50), IN `invoice_no` VARCHAR(20), IN `item_id` INT(0), IN `grn` INT(0), IN `bat_qty` INT(0), IN `pkg_qty` INT(0), IN `sup_id` INT(0), IN `package_id` INT(0), IN `status` INT(0))  BEGIN

DECLARE stk_id int;
DECLARE x int;
DECLARE count1 int;
DECLARE new_barcode VARCHAR(50);
DECLARE new_barcode_pkg VARCHAR(50);

SET stk_id = (SELECT stock_id FROM item_bulk_stock ORDER BY stock_id DESC LIMIT 1);

IF stk_id IS NULL THEN
	SET stk_id = 0;
ELSE
	SET stk_id = stk_id + 1;
END IF;

SET x = 1;
SET count1 = 1;

WHILE x <= bat_qty * pkg_qty  DO
 	
    IF (x % (bat_qty) = 1) THEN
    
    	IF (x != 1) THEN
        	SET stk_id = stk_id + 1;
        END IF;
    	
        SET new_barcode = CONCAT( invoice_no, grn, count1, pkg_qty , bat_qty); 
    	
        INSERT INTO item_bulk_stock
        (stock_id, barcode, invoice_no, item_id, grn, bat_qty, pkg_qty, sup_id, package_id, status) VALUES (stk_id, CONCAT(new_barcode), invoice_no, item_id, grn, bat_qty , pkg_qty, CONCAT(sup_id), package_id, status );
        
    	
        SET count1 = count1 + 1;  
      
    END IF;
     

	SET new_barcode = CONCAT(invoice_no,grn,count1,pkg_qty,bat_qty,x);  

    INSERT INTO `item_barcode`(`stock_id`, `barcode`, `status`) VALUES
    (stk_id, new_barcode ,'1');

    SET  x = x + 1; 
   
    
END WHILE;

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
(1, '35435346', '2017-12-21', 12, 'Admin'),
(2, 'INV24122017145812', '2017-12-24', 2, 'Cashier'),
(3, '546496498', '2017-12-21', 3, 'Admin'),
(4, 'INV06012018084635', '2018-01-06', 1, 'Super Admin');

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
(2, 'SW5-6C', 'SW5-6C', 1, 'assets/upload/');

-- --------------------------------------------------------

--
-- Table structure for table `item_barcode`
--

CREATE TABLE `item_barcode` (
  `id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `barcode` varchar(50) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_barcode`
--

INSERT INTO `item_barcode` (`id`, `stock_id`, `barcode`, `status`) VALUES
(3731, 0, '122562581', 1),
(3732, 0, '122562582', 1),
(3733, 0, '122562583', 1),
(3734, 0, '122562584', 1),
(3735, 0, '122562585', 1),
(3736, 0, '122562586', 1),
(3737, 0, '122562587', 1),
(3738, 0, '122562588', 1),
(3739, 1, '122563589', 1),
(3740, 1, '1225635810', 1),
(3741, 1, '1225635811', 1),
(3742, 1, '1225635812', 1),
(3743, 1, '1225635813', 1),
(3744, 1, '1225635814', 1),
(3745, 1, '1225635815', 1),
(3746, 1, '1225635816', 1),
(3747, 2, '1225645817', 1),
(3748, 2, '1225645818', 1),
(3749, 2, '1225645819', 1),
(3750, 2, '1225645820', 1),
(3751, 2, '1225645821', 1),
(3752, 2, '1225645822', 1),
(3753, 2, '1225645823', 1),
(3754, 2, '1225645824', 1),
(3755, 3, '1225655825', 1),
(3756, 3, '1225655826', 1),
(3757, 3, '1225655827', 1),
(3758, 3, '1225655828', 1),
(3759, 3, '1225655829', 1),
(3760, 3, '1225655830', 1),
(3761, 3, '1225655831', 1),
(3762, 3, '1225655832', 1),
(3763, 4, '1225665833', 1),
(3764, 4, '1225665834', 1),
(3765, 4, '1225665835', 1),
(3766, 4, '1225665836', 1),
(3767, 4, '1225665837', 1),
(3768, 4, '1225665838', 1),
(3769, 4, '1225665839', 1),
(3770, 4, '1225665840', 1),
(3771, 5, '154542581', 1),
(3772, 5, '154542582', 1),
(3773, 5, '154542583', 1),
(3774, 5, '154542584', 1),
(3775, 5, '154542585', 1),
(3776, 5, '154542586', 1),
(3777, 5, '154542587', 1),
(3778, 5, '154542588', 1),
(3779, 6, '154543589', 1),
(3780, 6, '1545435810', 1),
(3781, 6, '1545435811', 1),
(3782, 6, '1545435812', 1),
(3783, 6, '1545435813', 1),
(3784, 6, '1545435814', 1),
(3785, 6, '1545435815', 1),
(3786, 6, '1545435816', 1),
(3787, 7, '1545445817', 1),
(3788, 7, '1545445818', 1),
(3789, 7, '1545445819', 1),
(3790, 7, '1545445820', 1),
(3791, 7, '1545445821', 1),
(3792, 7, '1545445822', 1),
(3793, 7, '1545445823', 1),
(3794, 7, '1545445824', 1),
(3795, 8, '1545455825', 1),
(3796, 8, '1545455826', 1),
(3797, 8, '1545455827', 1),
(3798, 8, '1545455828', 1),
(3799, 8, '1545455829', 1),
(3800, 8, '1545455830', 1),
(3801, 8, '1545455831', 1),
(3802, 8, '1545455832', 1),
(3803, 9, '1545465833', 1),
(3804, 9, '1545465834', 1),
(3805, 9, '1545465835', 1),
(3806, 9, '1545465836', 1),
(3807, 9, '1545465837', 1),
(3808, 9, '1545465838', 1),
(3809, 9, '1545465839', 1),
(3810, 9, '1545465840', 1),
(3811, 10, '8A12062281', 1),
(3812, 10, '8A12062282', 1),
(3813, 10, '8A12062283', 1),
(3814, 10, '8A12062284', 1),
(3815, 10, '8A12062285', 1),
(3816, 10, '8A12062286', 1),
(3817, 10, '8A12062287', 1),
(3818, 10, '8A12062288', 1),
(3819, 11, '8A12063289', 1),
(3820, 11, '8A120632810', 1),
(3821, 11, '8A120632811', 1),
(3822, 11, '8A120632812', 1),
(3823, 11, '8A120632813', 1),
(3824, 11, '8A120632814', 1),
(3825, 11, '8A120632815', 1),
(3826, 11, '8A120632816', 1),
(3827, 12, '121351111', 1);

-- --------------------------------------------------------

--
-- Table structure for table `item_bulk_stock`
--

CREATE TABLE `item_bulk_stock` (
  `stock_id` int(11) NOT NULL,
  `barcode` varchar(50) NOT NULL,
  `invoice_no` varchar(30) NOT NULL,
  `item_id` int(11) NOT NULL,
  `grn` varchar(20) NOT NULL,
  `bat_qty` int(11) NOT NULL,
  `pkg_qty` int(11) NOT NULL,
  `sup_id` varchar(50) CHARACTER SET utf16 COLLATE utf16_bin DEFAULT NULL,
  `package_id` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_bulk_stock`
--

INSERT INTO `item_bulk_stock` (`stock_id`, `barcode`, `invoice_no`, `item_id`, `grn`, `bat_qty`, `pkg_qty`, `sup_id`, `package_id`, `status`) VALUES
(0, '12256158', '122', 2, '56', 8, 5, '1', 0, 1),
(1, '12256258', '122', 2, '56', 8, 5, '1', 0, 1),
(2, '12256358', '122', 2, '56', 8, 5, '1', 0, 1),
(3, '12256458', '122', 2, '56', 8, 5, '1', 0, 1),
(4, '12256558', '122', 2, '56', 8, 5, '1', 0, 1),
(5, '15454158', '1545', 2, '4', 8, 5, '1', 0, 1),
(6, '15454258', '1545', 2, '4', 8, 5, '1', 0, 1),
(7, '15454358', '1545', 2, '4', 8, 5, '1', 0, 1),
(8, '15454458', '1545', 2, '4', 8, 5, '1', 0, 1),
(9, '15454558', '1545', 2, '4', 8, 5, '1', 0, 1),
(10, '8A1206128', '8A120', 2, '6', 8, 2, '1', 0, 1),
(11, '8A1206228', '8A120', 2, '6', 8, 2, '1', 0, 1);

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
-- Indexes for table `package`
--
ALTER TABLE `package`
  ADD PRIMARY KEY (`pkg_id`);

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
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoice_id` double NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `item_barcode`
--
ALTER TABLE `item_barcode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3828;
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
-- AUTO_INCREMENT for table `package`
--
ALTER TABLE `package`
  MODIFY `pkg_id` double NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
