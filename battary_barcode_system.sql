-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2018 at 12:48 PM
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_bulk_stock` (IN `barcode` VARCHAR(50), IN `invoice_no` VARCHAR(20), IN `item_id` INT(0), IN `grn` INT(0), IN `bat_qty` INT(0), IN `pkg_qty` INT(0), IN `sup_id` VARCHAR(50), IN `package_id` INT(0), IN `status` INT(0))  BEGIN

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
    	
        SET new_barcode = CONCAT('P', invoice_no, grn, count1, pkg_qty , bat_qty); 
    	
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
(6, 'INV24022018130413', '2018-02-24', 10, 'Super Admin'),
(7, 'INV24022018130559', '2018-02-24', 2, 'Super Admin'),
(8, 'INV24022018143256', '2018-02-24', 13, 'Super Admin'),
(9, 'INV24022018155055', '2018-02-24', 22, 'Super Admin');

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
(4472, 0, '11451150210101', 6, 0, 0),
(4473, 0, '11451150210102', 6, 0, 0),
(4474, 0, '11451150210103', 6, 0, 0),
(4475, 0, '11451150210104', 6, 0, 0),
(4476, 0, '11451150210105', 6, 0, 0),
(4477, 0, '11451150210106', 6, 0, 0),
(4478, 0, '11451150210107', 6, 0, 0),
(4479, 0, '11451150210108', 6, 0, 0),
(4480, 0, '11451150210109', 6, 0, 0),
(4481, 0, '114511502101010', 6, 0, 0),
(4482, 1, '114511503101011', 8, 0, 0),
(4483, 1, '114511503101012', 8, 0, 0),
(4484, 1, '114511503101013', 8, 0, 0),
(4485, 1, '114511503101014', 9, 0, 0),
(4486, 1, '114511503101015', 9, 0, 0),
(4487, 1, '114511503101016', 0, 0, -1),
(4488, 1, '114511503101017', 0, 0, 1),
(4489, 1, '114511503101018', 7, 0, 0),
(4490, 1, '114511503101019', 0, 0, 1),
(4491, 1, '114511503101020', 7, 0, 0),
(4492, 2, '114511504101021', 8, 0, 0),
(4493, 2, '114511504101022', 8, 0, 0),
(4494, 2, '114511504101023', 8, 0, 0),
(4495, 2, '114511504101024', 8, 0, 0),
(4496, 2, '114511504101025', 8, 0, 0),
(4497, 2, '114511504101026', 8, 0, 0),
(4498, 2, '114511504101027', 8, 0, 0),
(4499, 2, '114511504101028', 8, 0, 0),
(4500, 2, '114511504101029', 8, 0, 0),
(4501, 2, '114511504101030', 8, 0, 0),
(4502, 3, '114511505101031', 0, 0, 1),
(4503, 3, '114511505101032', 0, 0, 1),
(4504, 3, '114511505101033', 0, 0, 1),
(4505, 3, '114511505101034', 0, 0, 1),
(4506, 3, '114511505101035', 0, 0, 1),
(4507, 3, '114511505101036', 0, 0, 1),
(4508, 3, '114511505101037', 0, 0, 1),
(4509, 3, '114511505101038', 0, 0, 1),
(4510, 3, '114511505101039', 0, 0, 1),
(4511, 3, '114511505101040', 0, 0, 1),
(4512, 4, '114511506101041', 0, 0, 1),
(4513, 4, '114511506101042', 0, 0, 1),
(4514, 4, '114511506101043', 0, 0, 1),
(4515, 4, '114511506101044', 0, 0, 1),
(4516, 4, '114511506101045', 0, 0, 1),
(4517, 4, '114511506101046', 0, 0, 1),
(4518, 4, '114511506101047', 0, 0, 1),
(4519, 4, '114511506101048', 0, 0, 1),
(4520, 4, '114511506101049', 0, 0, 1),
(4521, 4, '114511506101050', 0, 0, 1),
(4522, 5, '114511507101051', 0, 0, 1),
(4523, 5, '114511507101052', 0, 0, 1),
(4524, 5, '114511507101053', 0, 0, 1),
(4525, 5, '114511507101054', 0, 0, 1),
(4526, 5, '114511507101055', 0, 0, 1),
(4527, 5, '114511507101056', 0, 0, 1),
(4528, 5, '114511507101057', 0, 0, 1),
(4529, 5, '114511507101058', 0, 0, 1),
(4530, 5, '114511507101059', 0, 0, 1),
(4531, 5, '114511507101060', 0, 0, 1),
(4532, 6, '114511508101061', 0, 0, 1),
(4533, 6, '114511508101062', 0, 0, 1),
(4534, 6, '114511508101063', 0, 0, 1),
(4535, 6, '114511508101064', 0, 0, 1),
(4536, 6, '114511508101065', 0, 0, 1),
(4537, 6, '114511508101066', 0, 0, 1),
(4538, 6, '114511508101067', 0, 0, 1),
(4539, 6, '114511508101068', 0, 0, 1),
(4540, 6, '114511508101069', 0, 0, 1),
(4541, 6, '114511508101070', 0, 0, 1),
(4542, 7, '114511509101071', 0, 0, 1),
(4543, 7, '114511509101072', 0, 0, 1),
(4544, 7, '114511509101073', 0, 0, 1),
(4545, 7, '114511509101074', 0, 0, 1),
(4546, 7, '114511509101075', 0, 0, 1),
(4547, 7, '114511509101076', 0, 0, 1),
(4548, 7, '114511509101077', 0, 0, 1),
(4549, 7, '114511509101078', 0, 0, 1),
(4550, 7, '114511509101079', 0, 0, 1),
(4551, 7, '114511509101080', 0, 0, 1),
(4552, 8, '1145115010101081', 0, 0, 1),
(4553, 8, '1145115010101082', 0, 0, 1),
(4554, 8, '1145115010101083', 0, 0, 1),
(4555, 8, '1145115010101084', 0, 0, 1),
(4556, 8, '1145115010101085', 0, 0, 1),
(4557, 8, '1145115010101086', 0, 0, 1),
(4558, 8, '1145115010101087', 0, 0, 1),
(4559, 8, '1145115010101088', 0, 0, 1),
(4560, 8, '1145115010101089', 0, 0, 1),
(4561, 8, '1145115010101090', 0, 0, 1),
(4562, 9, '1145115011101091', 9, 0, 0),
(4563, 9, '1145115011101092', 9, 0, 0),
(4564, 9, '1145115011101093', 9, 0, 0),
(4565, 9, '1145115011101094', 9, 0, 0),
(4566, 9, '1145115011101095', 9, 0, 0),
(4567, 9, '1145115011101096', 9, 0, 0),
(4568, 9, '1145115011101097', 9, 0, 0),
(4569, 9, '1145115011101098', 9, 0, 0),
(4570, 9, '1145115011101099', 9, 0, 0),
(4571, 9, '11451150111010100', 9, 0, 0),
(4572, 10, '1563115121101', 9, 0, 0),
(4573, 10, '1563115121102', 9, 0, 0),
(4574, 10, '1563115121103', 9, 0, 0),
(4575, 10, '1563115121104', 9, 0, 0),
(4576, 10, '1563115121105', 9, 0, 0),
(4577, 10, '1563115121106', 9, 0, 0),
(4578, 10, '1563115121107', 9, 0, 0),
(4579, 10, '1563115121108', 9, 0, 0),
(4580, 10, '1563115121109', 9, 0, 0),
(4581, 10, '15631151211010', 9, 0, 0);

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
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_bulk_stock`
--

INSERT INTO `item_bulk_stock` (`stock_id`, `barcode`, `invoice_no`, `manufacture_id`, `item_id`, `grn`, `bat_qty`, `pkg_qty`, `sup_id`, `package_id`, `invoice_id`, `status`) VALUES
(0, 'P1145115011010', '1145', '', 1, '1150', 10, 10, '1', 0, 6, 0),
(1, 'P1145115021010', '1145', '', 1, '1150', 10, 10, '1', 0, 0, 1),
(2, 'P1145115031010', '1145', '', 1, '1150', 10, 10, '1', 0, 8, 0),
(3, 'P1145115041010', '1145', '', 1, '1150', 10, 10, '1', 0, 0, 1),
(4, 'P1145115051010', '1145', '', 1, '1150', 10, 10, '1', 0, 0, 1),
(5, 'P1145115061010', '1145', '', 1, '1150', 10, 10, '1', 0, 0, 1),
(6, 'P1145115071010', '1145', '', 1, '1150', 10, 10, '1', 0, 0, 1),
(7, 'P1145115081010', '1145', '', 1, '1150', 10, 10, '1', 0, 0, 1),
(8, 'P1145115091010', '1145', '', 1, '1150', 10, 10, '1', 0, 0, 1),
(9, 'P11451150101010', '1145', '', 1, '1150', 10, 10, '1', 0, 9, 0),
(10, 'P156311511110', '1563', '', 1, '1151', 10, 1, '03A', 0, 9, 0);

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
  `date` varchar(20) NOT NULL,
  `remarks` varchar(200) NOT NULL
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

--
-- Dumping data for table `return_stock`
--

INSERT INTO `return_stock` (`id`, `barcode`, `rep_name`, `return_date`, `remarks`) VALUES
(1, '114511503101019', 'Nuwan', 'Wed Feb 14 2018 00:0', 'Not working');

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
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoice_id` double NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `item_barcode`
--
ALTER TABLE `item_barcode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4582;
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
--
-- AUTO_INCREMENT for table `return_stock`
--
ALTER TABLE `return_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
