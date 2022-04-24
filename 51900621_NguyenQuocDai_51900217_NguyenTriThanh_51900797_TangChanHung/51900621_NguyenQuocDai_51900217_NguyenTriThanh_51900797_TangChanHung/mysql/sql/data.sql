-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql-server
-- Generation Time: Jan 15, 2022 at 10:09 AM
-- Server version: 8.0.1-dmr
-- PHP Version: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `EmployeeN`
--
CREATE DATABASE IF NOT EXISTS `EmployeeN` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `EmployeeN`;

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(10) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `gender` int(11) NOT NULL,
  `birthday` varchar(255) DEFAULT NULL,
  `cmnd` int(255) NOT NULL,
  `ethnic` varchar(255) NOT NULL,
  `levels` varchar(255) NOT NULL,
  `phongban` varchar(255) NOT NULL,
  `MaPB` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `nation` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `dayOff` int(255) DEFAULT NULL,
  `dayOffUsed` int(255) DEFAULT NULL,
  `dayOffLeft` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `username`, `password`, `role`, `email`, `name`, `phone`, `gender`, `birthday`, `cmnd`, `ethnic`, `levels`, `phongban`, `MaPB`, `address`, `nation`, `image`, `dayOff`, `dayOffUsed`, `dayOffLeft`) VALUES
(1, 'admin', '$2y$10$Htw.t2mNOUKcwRFm1/jxQ.W5eigd/xpIWnjmJamZGCOcJeLhPlpzK', 1, 'admin@gmail.com', 'Nguyen Quoc Dai', '0399254549', 1, NULL, 123456789, 'Kinh', 'Giam Doc', 'CEO', '', 'Lam Dong', 'Viet Nam', '1-male.jpg', NULL, NULL, NULL),
(46, 'vothihoaian', '$2y$10$NIDU3HjKLLKxMuFa2j6jaOpyFow0I3pYaCUUUoD1I4tv5vTriUKo2', 2, 'vothihoaian@gmail.com', 'Võ Thị Hoài An', '869577133', 2, '1998-11-19', 233259790, 'Kinh', 'Trưởng phòng', 'Kế toán', 'KT01', '02 Nguyễn Huệ, phương Bến Nghé, quận 1', 'Việt Nam', '46-256556025_3239092299655596_630092824881654241_n.jpg', 15, 5, 10),
(47, 'nguyenthitruclinh', '$2y$10$AcK72LnlZpIWO56EgTXpCOYNMMf1sTQBOwYtt3XCj18EtH46FayDm', 3, 'nguyenthitruclinh@gmail.com', 'Nguyễn Thị Trúc Linh', '902318877', 2, '1997', 233259791, 'Kinh', 'Nhân viên', 'Kế toán', 'KT01', '10 Bùi Viện, phương Phạm Ngũ Lão, quận 1', 'Việt Nam', 'female.jpg', 12, 2, 10),
(48, 'lethitructhi', '$2y$10$MpD5oqTgTuqxpUxhVIw2p.DSUAQlRBbWJhDLul03f6a/q11Z2I1S.', 3, 'lethitructhi@gmail.com', 'Lê Thị Trúc Thi', '913777399', 2, '1997', 233259792, 'Kinh', 'Nhân viên', 'Kế toán', 'KT01', '11 rạch Thầy Tiêu, phương Tân Phú, quận 7', 'Việt Nam', 'female.jpg', 12, 0, 12),
(49, 'hoanggiakhiem', '$2y$10$Dx5r6xd3Jq5w0LJhKJ5UWeBGClq.KGAwB5xqFQWIHgoK6gdA9QEEe', 3, 'hoanggiakhiem@gmail.com', 'Hoàng Gia Khiêm', '966821010', 1, '2000', 233259793, 'Kinh', 'Nhân viên', 'Kế toán', 'KT01', '875 Cách Mạng Tháng Tám, phương 15, quận 10', 'Việt Nam', 'male.jpg', 12, 0, 12),
(50, 'nguyenquockhanh', '$2y$10$.9UC3SU9naItgQkm2XGzkefMm0MoqCdRAKAr46n03iu5PDv4R4Pb.', 3, 'nguyenquockhanh@gmail.com', 'Nguyễn Quốc Khánh', '931427504', 1, '1999', 233259794, 'Kinh', 'Nhân viên', 'Kế toán', 'KT01', '3 Hòa Bình, phương 3, quận 11', 'Việt Nam', 'male.jpg', 12, 0, 12),
(51, 'nguyenvancuong', '$2y$10$kV5jcqjSEUJJT2mv0He4fOvteSL9OKXb4NQcNkngBrcTm7cJUq6cq', 2, 'nguyenvancuong@gmail.com', 'Nguyễn Văn Cường', '913917779', 1, '1999', 233259795, 'Kinh', 'Trưởng phòng', 'Tài chính', 'TC01', '2 Nguyễn Bỉnh Khiêm, phương Bến Nghé, quận 1', 'Việt Nam', 'male.jpg', 15, 0, 15),
(52, 'trandinhthang', '$2y$10$WXBKVxEJHs2l8e58C1MVeekkfSoTkMe8wfcAbCfVojA8hf1Z20c6O', 3, 'trandinhthang@gmail.com', 'Trần Đình Thắng', '378676975', 1, '1996', 233259796, 'Kinh', 'Nhân viên', 'Tài chính', 'TC01', '120 Xa Lộ Hà Nội, phương Tân Phú, quận 9', 'Việt Nam', 'male.jpg', 12, 0, 12),
(53, 'lamtunganh', '$2y$10$sxOiGOVR0DW9yFHssnTDVO5ApoBTbdZ1QxEaAQcirFijc0XjLMSje', 3, 'lamtunganh@gmail.com', 'Lâm Tùng Anh', '378593296', 1, '1998', 233259797, 'Kinh', 'Nhân viên', 'Tài chính', 'TC01', '125 Đồng Văn Cống, phương Thạnh Mỹ Lơi, quận 2', 'Việt Nam', 'male.jpg', 12, 0, 12),
(54, 'nguyenkhanhhuy', '$2y$10$fsZDRBfwN6rSmHoNEq/YKuouX5vA0BXn8Msdtz7lUaAfOjRFW7vMG', 3, 'nguyenkhanhhuy@gmail.com', 'Nguyễn Khánh Huy', '903186883', 1, '1999', 233259798, 'Kinh', 'Nhân viên', 'Tài chính', 'TC01', '1 công xã Paris, phương Bến Nghé, quận 1', 'Việt Nam', 'male.jpg', 12, 0, 12),
(55, 'tranthimyphuong', '$2y$10$AL2aAGR2NOMmcuikX0zqPeHua81E/CqEzCoyLU3nnV6zkGg40ivLG', 3, 'tranthimyphuong@gmail.com', 'Trần Thị Mỹ Phương', '842322345', 2, '1998', 233259800, 'Kinh', 'Nhân viên', 'Tài chính', 'TC01', '30 Phan Bội Châu, phương Bến Thành, quận 1', 'Việt Nam', 'female.jpg', 12, 0, 12),
(56, 'lenhattruong', '$2y$10$s2XImt/0KtvZKf8Vj3BN3u5TxfUkaUMNMXAMRE7nJoi1RblZz5hz2', 3, 'lenhattruong@gmail.com', 'Lê Nhật Trường', '986875637', 1, '1999', 233259801, 'Kinh', 'Nhân viên', 'Kỹ thuật', 'KTH01', '7 Công trương Lam Sơn, phương Bến Nghé, quận 1', 'Việt Nam', 'male.jpg', 12, 0, 12),
(57, 'vuminhtri', '$2y$10$7jwhXGXeIKZ/XgsZ3ebLDux0stM.VOnmjzX98z56rjhYfNgGZdB3m', 3, 'vuminhtri@gmail.com', 'Vũ Minh Trí', '707420453', 1, '2000', 233256888, 'Kinh', 'Nhân viên', 'Kỹ thuật', 'KTH01', '135 Nam Kỳ Khơi Nghĩa, phương Bến Thành, quận 1', 'Việt Nam', 'male.jpg', 12, 0, 12),
(58, 'trangiahuan', '$2y$10$ovzmihEiy2WJKxGiAkjX4uvcA6wBzvaBFRdVNhZdRwKPy6ZNpNuw2', 2, 'trangiahuan@gmail.com', 'Trần Gia Huân', '906656542', 1, '2000', 233259802, 'Kinh', 'Trưởng phòng', 'Kỹ thuật', 'KTH01', '97A Phó Đức Chính, phương Nguyễn Thái Bình, quận 1', 'Việt Nam', 'male.jpg', 15, 3, 12),
(59, 'nguyenminhdang', '$2y$10$z11.dILFQtLt3SeWftrv1uZUz22rbOkaDvMb6r6pKSsvfeGHrM/jK', 3, 'nguyenminhdang@gmail.com', 'Nguyễn Minh Đăng', '982630450', 1, '1998', 233259803, 'Kinh', 'Nhân viên', 'Kỹ thuật', 'KTH01', '1 Nguyễn Tất Thành, phương 12, quận 4', 'Việt Nam', 'male.jpg', 12, 0, 12),
(60, 'doquanghuy', '$2y$10$jloHG5UZ08t5MAjhp4w0/O3Nv16zEz4BoY39knN1XMGspfUwclR8G', 3, 'doquanghuy@gmail.com', 'Đỗ Quang Huy', '902418869', 1, '1999', 233259804, 'Kinh', 'Nhân viên', 'Kỹ thuật', 'KTH01', '42 Nguyễn Huệ, phương bến Nghé, quận 1', 'Việt Nam', 'male.jpg', 12, 0, 12),
(61, 'phanthanhbinh', '$2y$10$jPf0cklT9laISY5li1GVzevxIAUZDu94eKjeM7aIqfz7TXPMbgA3W', 2, 'phanthanhbinh@gmail.com', 'Phan Thanh Bình', '866623723', 1, '1999', 233259805, 'Kinh', 'Trưởng phòng', 'Nhân sự', 'NS01', '208 Nguyễn Hữu Cảnh, phương 22, quận Bình Thạnh', 'Việt Nam', 'male.jpg', 15, 0, 15),
(62, 'vohongyen', '$2y$10$UXVsnCVJ9Qu.xT.ZWiku7u7LHfgxm5QcpK1eOwy4O9FR2JbytbLDy', 3, 'vohongyen@gmail.com', 'Võ Hồng Yến', '902963115', 2, '1995', 233259806, 'Kinh', 'Nhân viên', 'Nhân sự', 'NS01', '04 đương số 9, khu đô thị mơi Him Lam, phương Tân Hưng, quận 7', 'Việt Nam', 'female.jpg', 12, 0, 12),
(63, 'nguyenvanhai', '$2y$10$AxmOB37dFi5Qu9UjkhVT2.UkROFJLoSIpQ0yXKMfLbx2hh/QmKHJW', 3, 'nguyenvanhai@gmail.com', 'Nguyễn Văn Hải', '908320002', 1, '1994', 233259807, 'Kinh', 'Nhân viên', 'Nhân sự', 'NS01', '15A Lê Thánh Tôn, phương Bến Thành, quận 1', 'Việt Nam', 'male.jpg', 12, 0, 12),
(64, 'hokimyen', '$2y$10$uVljOMt45/5Ie1IwHGAvG.XhIt4dxnvqzt4tEAyHX7KSlxI1oNZcu', 3, 'hokimyen@gmail.com', 'Hồ Kim Yến', '909138400', 2, '1999', 233259808, 'Kinh', 'Nhân viên', 'Nhân sự', 'NS01', '188/1 Nguyễn Văn Hương, phương Thảo Điền, quận 2', 'Việt Nam', 'female.jpg', 12, 0, 12),
(65, 'huynhminhquan', '$2y$10$6ShROUqtCHWEgUjGJb5/4uyZ5oUzZNk4aCTP/FZoYCLZ4vY.BQn8i', 3, 'huynhminhquan@gmail.com', 'Huỳnh Minh Quân', '937132382', 1, '1998', 233259809, 'Kinh', 'Nhân viên', 'Nhân sự', 'NS01', '99 Nguyễn Huệ, phương Bến Nghé, quận 1', 'Việt Nam', 'male.jpg', 12, 0, 12),
(66, 'nguyenkhanhhuyen', '$2y$10$OZPZediEGI58KqSqPbBTDeTBE8itpDPSXwtvI8x92HQIysTVcec7O', 2, 'nguyenkhanhhuyen@gmail.com', 'Nguyễn Khánh Huyền', '981689486', 2, '1996', 233259810, 'Kinh', 'Trưởng phòng', 'Thư ký', 'TK01', '202 Võ Thị Sáu, phương 7 quận 3', 'Việt Nam', 'female.jpg', 15, 0, 15),
(67, 'trananhthu', '$2y$10$PfR88k/uktjOpaB7YKC0W.eRdFwydtwWxHHVq87kKcH2JboiNJEcy', 3, 'trananhthu@gmail.com', 'Trần Anh Thư', '913117677', 2, '1998', 233259811, 'Kinh', 'Nhân viên', 'Thư ký', 'TK01', '1058 Nguyễn Văn Linh, phương Tân Phong, quận 7 ', 'Việt Nam', 'female.jpg', 12, 0, 12),
(68, 'nguyenthivananh', '$2y$10$FBtuLPTtl6vqbRbUyjL5a.oBjubm.fjwIjSqUuQD7lNCs5I9eyYUa', 3, 'nguyenthivananh@gmail.com', 'Nguyễn Thị Vân Anh', '969176053', 2, '1997', 233259812, 'Kinh', 'Nhân viên', 'Thư ký', 'TK01', '81 Nguyễn Xiển, phương Long Bình, quận 9', 'Việt Nam', 'female.jpg', 12, 0, 12),
(69, 'lethithutrang', '$2y$10$nLN74bdVwOpNZeXt.CyWb.1kX6H81Klb5xAkcA33Q/4Jr4/p/Enzy', 3, 'lethithutrang@gmail.com', 'Lê Thị Thu Trang', '902881396', 2, '1998', 233259813, 'Kinh', 'Nhân viên', 'Thư ký', 'TK01', '175/19 Phạm Ngũ Lão, quận 1', 'Việt Nam', 'female.jpg', 12, 0, 12),
(70, 'lymyuyen', '$2y$10$jvS2Y8P4lgaIA5x11MN3cOhocSH.0c1zPQiZOh5DFoRHr6S9WSyAK', 3, 'lymyuyen@gmail.com', 'Lý Mỹ Uyên', '908376664', 2, '1993', 233259814, 'Kinh', 'Nhân viên', 'Thư ký', 'TK01', '25 Nguyễn Văn Bình, phương Bến Nghé, quận 1', 'Việt Nam', 'female.jpg', 12, 0, 12);

-- --------------------------------------------------------

--
-- Table structure for table `dayOff`
--

CREATE TABLE `dayOff` (
  `idDayOff` int(255) NOT NULL,
  `dayOff` int(255) DEFAULT NULL,
  `dayOffUsed` int(255) DEFAULT NULL,
  `dayOffWant` int(255) DEFAULT NULL,
  `dayOffLeft` int(255) DEFAULT NULL,
  `Status` varchar(255) DEFAULT NULL,
  `idStatus` int(255) DEFAULT NULL,
  `idPerson` int(255) DEFAULT NULL,
  `namePerson` varchar(255) DEFAULT NULL,
  `rolePerson` int(255) DEFAULT NULL,
  `idPersonPer` int(255) DEFAULT NULL,
  `namePersonPer` varchar(255) DEFAULT NULL,
  `fileDayOff` varchar(255) DEFAULT NULL,
  `reason` text,
  `dayOffFrom` varchar(255) DEFAULT NULL,
  `dayApplyOff` varchar(255) DEFAULT NULL,
  `idDepartment` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dayOff`
--

INSERT INTO `dayOff` (`idDayOff`, `dayOff`, `dayOffUsed`, `dayOffWant`, `dayOffLeft`, `Status`, `idStatus`, `idPerson`, `namePerson`, `rolePerson`, `idPersonPer`, `namePersonPer`, `fileDayOff`, `reason`, `dayOffFrom`, `dayApplyOff`, `idDepartment`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 12, 2, 2, 10, 'Approved', 2, 47, 'Nguyễn Thị Trúc Linh', 3, 46, 'Võ Thị Hoài An', '2-', 'nghỉ vì nhà có việc đột xuất', '2022-01-16', '2022-01-15', 'KT01'),
(3, 15, 5, 5, 10, 'Approved', 2, 46, 'Võ Thị Hoài An', 2, 1, 'Nguyen Quoc Dai', '3-', 'Nghỉ chống dịch ạ', '2022-01-20', '2022-01-15', 'KT01'),
(4, 15, 0, 4, 15, 'Waiting', 1, 51, 'Nguyễn Văn Cường', 2, NULL, NULL, '4-test.txt', 'xin nghỉ chống dịch', '2022-01-16', '2022-01-15', 'TC01'),
(5, 15, 3, 3, 12, 'Approved', 2, 58, 'Trần Gia Huân', 2, 1, 'Nguyen Quoc Dai', '5-tdt-logo.png', 'xin nghỉ vì sốt', '2022-01-16', '2022-01-15', 'KTH01'),
(6, 15, 0, 3, 15, 'Waiting', 1, 61, 'Phan Thanh Bình', 2, NULL, NULL, '6-', 'xin nghỉ vì nhà có việc', '2022-01-28', '2022-01-15', 'NS01'),
(7, 15, 0, 3, 15, 'Waiting', 1, 66, 'Nguyễn Khánh Huyền', 2, NULL, NULL, '7-home-icon.png', 'xin nghỉ vì con nhỏ ốm', '2022-01-16', '2022-01-15', 'TK01'),
(8, 12, 0, 4, 12, 'Waiting', 1, 48, 'Lê Thị Trúc Thi', 3, NULL, NULL, '8-', 'xin nghỉ ốm', '2022-01-22', '2022-01-15', 'KT01'),
(9, 12, 0, 2, 12, 'Waiting', 1, 50, 'Nguyễn Quốc Khánh', 3, NULL, NULL, '9-test.txt', 'có việc đột xuất', '2022-01-20', '2022-01-15', 'KT01');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `numberofrooms` int(3) DEFAULT NULL,
  `usernameTP` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idUsername` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `name`, `description`, `numberofrooms`, `usernameTP`, `idUsername`) VALUES
('KT01', 'Kế toán', 'Giờ làm việc: 7:00 - 15:00\r\nTính toán doanh thu', 1, 'vothihoaian', 46),
('KTH01', 'Kỹ thuật', 'Giờ làm việc: 8:00 - 17:00\r\nLo liệu các công việc liên quan đến máy móc', 2, 'trangiahuan', 58),
('NS01', 'Nhân sự', 'Giờ làm việc: 9:00 - 16:00\r\nTuyển nhân viên và quản lý các nhân viên', 1, 'phanthanhbinh', 61),
('TC01', 'Tài chính', 'Giờ làm việc từ 7:00 - 16:00\r\nCác hoạt động liên quan tới tiền bạc', 2, 'nguyenvancuong', 51),
('TK01', 'Thư ký', 'Giờ làm việc: 8:00 - 15:00\r\nLo liệu các công việc mà giám đốc giao', 1, 'nguyenkhanhhuyen', 66);

-- --------------------------------------------------------

--
-- Table structure for table `Task`
--

CREATE TABLE `Task` (
  `idTask` int(255) NOT NULL,
  `nameEmployee` varchar(255) NOT NULL,
  `statusTask` varchar(255) DEFAULT NULL,
  `idStatus` int(255) DEFAULT NULL,
  `idManager` int(255) NOT NULL,
  `idEmployee` int(255) NOT NULL,
  `nameManager` varchar(255) NOT NULL,
  `titleTask` text NOT NULL,
  `detailTask` text NOT NULL,
  `timeTask` varchar(255) DEFAULT NULL,
  `deadlineTask` varchar(255) NOT NULL,
  `idDepartment` varchar(255) NOT NULL,
  `messenger` text,
  `fileSend` varchar(255) DEFAULT NULL,
  `fileSubmit` varchar(255) DEFAULT NULL,
  `note` text,
  `dateTimeAuto` varchar(255) DEFAULT NULL,
  `rate` varchar(255) DEFAULT NULL,
  `dateDiff` varchar(255) DEFAULT NULL,
  `fileExtra` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Task`
--

INSERT INTO `Task` (`idTask`, `nameEmployee`, `statusTask`, `idStatus`, `idManager`, `idEmployee`, `nameManager`, `titleTask`, `detailTask`, `timeTask`, `deadlineTask`, `idDepartment`, `messenger`, `fileSend`, `fileSubmit`, `note`, `dateTimeAuto`, `rate`, `dateDiff`, `fileExtra`) VALUES
(76, 'Nguyễn Thị Trúc Linh', 'In progress', 2, 46, 47, 'Võ Thị Hoài An', 'Tổng hợp doanh thu quý 1 2021', 'Tính doanh thu về tất cả sản phẩm của khách hàng dưới 18 tuổi', '2022-01-15 ', '2022-01-19', 'KT01', NULL, 'idEmp-47-KT01-test.txt', NULL, NULL, NULL, NULL, NULL, NULL),
(77, 'Lê Thị Trúc Thi', 'Completed', 5, 46, 48, 'Võ Thị Hoài An', 'Tính tổng doanh thu quý 2 2021', 'tính doanh thu của sản phẩm của khách trên 18 tuổi', '2022-01-15 ', '2022-01-22', 'KT01', 'Đã làm xong ạ', 'idEmp-48-KT01-test.txt', 'submit-77-asdas.docx', NULL, '2022-01-15', 'Good', '604800', NULL),
(78, 'Hoàng Gia Khiêm', 'Canceled', 6, 46, 49, 'Võ Thị Hoài An', 'tỉnh tổng doanh thu quý 4 2021', 'tính doanh thu của sản phẩm của khách trên 18 tuổi', '2022-01-15 ', '2022-01-23', 'KT01', NULL, 'idEmp-49-KT01-test.txt', NULL, NULL, NULL, NULL, NULL, NULL),
(79, 'Nguyễn Quốc Khánh', 'Waiting', 3, 46, 50, 'Võ Thị Hoài An', 'tính tổng doanh thu quý 4 2021', 'tính doanh thu của sản phẩm của khách dưới18 tuổi', '2022-01-15 ', '2022-01-16', 'KT01', 'đã làm xong ạ', 'idEmp-50-KT01-test.txt', 'submit-79-', NULL, '2022-01-15', NULL, NULL, NULL),
(80, 'Hoàng Gia Khiêm', 'Rejected', 4, 46, 49, 'Võ Thị Hoài An', 'tính tổng doanh thu quý 3 2021', 'tính doanh thu của sản phẩm của khách trên 18 tuổi', '2022-01-15 ', '2022-01-13', 'KT01', 'đã làm xong ạ', 'idEmp-49-KT01-test.txt', 'submit-80-asdas.docx', 'làm chưa đúng lắm. Làm lại đi em', '2022-01-15', NULL, NULL, 'reject-80-asdas.docx'),
(81, 'Nguyễn Thị Trúc Linh', 'In progress', 2, 46, 47, 'Võ Thị Hoài An', 'Tính toán các giá trị sản phẩm sắp ra mắt', 'Chỉ tính giá thành bán ra chứ không tính cụ thể', '2022-01-15 ', '2022-01-30', 'KT01', NULL, 'idEmp-47-KT01-', NULL, NULL, NULL, NULL, NULL, NULL),
(82, 'Trần Đình Thắng', 'Waiting', 3, 51, 52, 'Nguyễn Văn Cường', 'Tính toán lời lỗ quý 1 ', 'Chỉ tính trên đầu người', '2022-01-15 ', '2022-01-23', 'TC01', 'đã làm xong', 'idEmp-52-TC01-test.txt', 'submit-82-submit-77-asdas.docx', NULL, '2022-01-15', NULL, NULL, NULL),
(83, 'Lâm Tùng Anh', 'Rejected', 4, 51, 53, 'Nguyễn Văn Cường', 'Tính toán lời lỗ quý 2', 'Chỉ tính trên đầu người', '2022-01-15 ', '2022-01-16', 'TC01', 'đã làm xong', 'idEmp-53-TC01-test.txt', 'submit-83-', 'chưa nộp file', '2022-01-15', NULL, NULL, 'reject-83-'),
(84, 'Nguyễn Khánh Huy', 'In progress', 2, 51, 54, 'Nguyễn Văn Cường', 'Tính toán lời lỗ quý 3', 'Chỉ tính trên đầu người', '2022-01-15 ', '2022-01-20', 'TC01', NULL, 'idEmp-54-TC01-', NULL, NULL, NULL, NULL, NULL, NULL),
(85, 'Trần Thị Mỹ Phương', 'Canceled', 6, 51, 55, 'Nguyễn Văn Cường', 'Tính toán lời lỗ quý 4', 'Chỉ tính trên đầu người', '2022-01-15 ', '2022-01-22', 'TC01', NULL, 'idEmp-55-TC01-test.txt', NULL, NULL, NULL, NULL, NULL, NULL),
(86, 'Trần Thị Mỹ Phương', 'New', 1, 51, 55, 'Nguyễn Văn Cường', 'Tính toán lời lỗ quý 4', 'tính toán trên đầu người', '2022-01-15 ', '2022-01-23', 'TC01', NULL, 'idEmp-55-TC01-test.txt', NULL, NULL, NULL, NULL, NULL, NULL),
(87, 'Lê Nhật Trường', 'Waiting', 3, 58, 56, 'Trần Gia Huân', 'Gia công tủ sắt', 'Gia công tủ sắt dưới 5 triệu', '2022-01-15 ', '2022-01-29', 'KTH01', 'đã làm xong\r\n', 'idEmp-56-KTH01-test.txt', 'submit-87-test.txt', NULL, '2022-01-15', NULL, NULL, NULL),
(88, 'Vũ Minh Trí', 'In progress', 2, 58, 57, 'Trần Gia Huân', 'Gia công tủ gỗ ', 'Gia công tủ gỗdưới 5 triệu', '2022-01-15 ', '2022-01-23', 'KTH01', NULL, 'idEmp-57-KTH01-test.txt', NULL, NULL, NULL, NULL, NULL, NULL),
(89, 'Nguyễn Minh Đăng', 'Canceled', 6, 58, 59, 'Trần Gia Huân', 'cưa gỗ', 'cưa cây gỗ sau công ty', '2022-01-15 ', '2022-01-23', 'KTH01', NULL, 'idEmp-59-KTH01-', NULL, NULL, NULL, NULL, NULL, NULL),
(90, 'Đỗ Quang Huy', 'Rejected', 4, 58, 60, 'Trần Gia Huân', 'sửa máy tính', 'sửa máy tính phòng thư ký', '2022-01-15 ', '2022-01-16', 'KTH01', 'đã làm xong\r\n', 'idEmp-60-KTH01-test.txt', 'submit-90-', 'ko có file submit', '2022-01-15', NULL, NULL, 'reject-90-'),
(91, 'Nguyễn Minh Đăng', 'New', 1, 58, 59, 'Trần Gia Huân', 'sửa máy tính ', 'sửa máy tính phòng kế toán', '2022-01-15 ', '2022-01-16', 'KTH01', NULL, 'idEmp-59-KTH01-', NULL, NULL, NULL, NULL, NULL, NULL),
(92, 'Võ Hồng Yến', 'Waiting', 3, 61, 62, 'Phan Thanh Bình', 'tuyển nhân viên', 'tuyển 2 nhân viên có thông tin như file đính kèm', '2022-01-15 ', '2022-01-16', 'NS01', 'đã làm xong', 'idEmp-62-NS01-test.txt', 'submit-92-test.txt', NULL, '2022-01-15', NULL, NULL, NULL),
(93, 'Nguyễn Văn Hải', 'In progress', 2, 61, 63, 'Phan Thanh Bình', 'tuyển nhân viên', 'tuyển 2 nhân viên cho phòng kỹ thuật có thông tin như file đính kèm', '2022-01-15 ', '2022-01-20', 'NS01', NULL, 'idEmp-63-NS01-test.txt', NULL, NULL, NULL, NULL, NULL, NULL),
(94, 'Võ Hồng Yến', 'Canceled', 6, 61, 62, 'Phan Thanh Bình', 'tuyển nhân viên', 'tuyển nhân viên như ảnh', '2022-01-15 ', '2022-01-23', 'NS01', NULL, 'idEmp-62-NS01-', NULL, NULL, NULL, NULL, NULL, NULL),
(95, 'Hồ Kim Yến', 'Rejected', 4, 61, 64, 'Phan Thanh Bình', 'xem xét kỷ luật nhân viên', 'xem xét kỷ luật nhân viên trong phòng thư ký', '2022-01-15 ', '2022-01-19', 'NS01', 'đã làm xong\r\n', 'idEmp-64-NS01-test.txt', 'submit-95-', 'chưa có kết quả', '2022-01-15', NULL, NULL, 'reject-95-test.txt'),
(96, 'Huỳnh Minh Quân', 'Completed', 5, 61, 65, 'Phan Thanh Bình', 'Kiểm tra điểm danh', 'Kiểm tra điểm danh mỗi ngày của nhân viên các phòng ban', '2022-01-15 ', '2022-01-28', 'NS01', 'đã làm xong', 'idEmp-65-NS01-test.txt', 'submit-96-test.txt', NULL, '2022-01-15', 'OK', '1123200', NULL),
(97, 'Võ Hồng Yến', 'New', 1, 61, 62, 'Phan Thanh Bình', 'làm thêm nhiệm vụ', 'làm thêm nhiệm vụ kiểm tra điểm danh', '2022-01-15 ', '2022-01-29', 'NS01', NULL, 'idEmp-62-NS01-test.txt', NULL, NULL, NULL, NULL, NULL, NULL),
(98, 'Trần Anh Thư', 'Waiting', 3, 66, 67, 'Nguyễn Khánh Huyền', 'sắp xếp lịch họp', 'sắp xếp lịch họp cho sếp vào ngày 20', '2022-01-15 ', '2022-01-19', 'TK01', 'đã làm xong', 'idEmp-67-TK01-test.txt', 'submit-98-test.txt', NULL, '2022-01-15', NULL, NULL, NULL),
(99, 'Trần Anh Thư', 'Canceled', 6, 66, 67, 'Nguyễn Khánh Huyền', 'sắp xếp ký hợp đồng', 'sắp xếp ký hợp đồng bị hủy', '2022-01-15 ', '2022-01-16', 'TK01', NULL, 'idEmp-67-TK01-', NULL, NULL, NULL, NULL, NULL, NULL),
(100, 'Nguyễn Thị Vân Anh', 'Rejected', 4, 66, 68, 'Nguyễn Khánh Huyền', 'sắp xếp ký hợp đồng', 'sắp xếp ký hợp đồng với công ty ABC vào ngày 19', '2022-01-15 ', '2022-01-17', 'TK01', 'đã làm xong\r\n', 'idEmp-68-TK01-test.txt', 'submit-100-', 'sếp chưa hài lòng', '2022-01-15', NULL, NULL, 'reject-100-'),
(101, 'Lê Thị Thu Trang', 'Completed', 5, 66, 69, 'Nguyễn Khánh Huyền', 'Thu xếp thay tài xế', 'tài xế có kỹ năng cao theo yêu cầu của sếp', '2022-01-15 ', '2022-01-29', 'TK01', 'đã làm xong', 'idEmp-69-TK01-test.txt', 'submit-101-', NULL, '2022-01-15', 'Bad', '1209600', NULL),
(102, 'Lý Mỹ Uyên', 'In progress', 2, 66, 70, 'Nguyễn Khánh Huyền', 'chở sếp di cắt tóc', 'chở sếp di cắt tóc ở quận 1', '2022-01-15 ', '2022-01-16', 'TK01', NULL, 'idEmp-70-TK01-test.txt', NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dayOff`
--
ALTER TABLE `dayOff`
  ADD PRIMARY KEY (`idDayOff`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Task`
--
ALTER TABLE `Task`
  ADD PRIMARY KEY (`idTask`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `Task`
--
ALTER TABLE `Task`
  MODIFY `idTask` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
