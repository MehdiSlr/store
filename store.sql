-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 01, 2024 at 08:03 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `store`
--

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `bid` int(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `btn1_text` varchar(255) DEFAULT NULL,
  `btn1_link` varchar(255) DEFAULT NULL,
  `btn2_text` varchar(255) DEFAULT NULL,
  `btn2_link` varchar(255) DEFAULT NULL,
  `color` varchar(255) NOT NULL DEFAULT '#ffffff',
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`bid`, `title`, `text`, `btn1_text`, `btn1_link`, `btn2_text`, `btn2_link`, `color`, `image_url`) VALUES
(1, 'Best Savings on\r\nnew arrivals', 'Qui ex dolore at repellat, quia neque doloribus omnis adipisci, ipsum eos odio fugit ut eveniet blanditiis praesentium totam non nostrum dignissimos nihil eius facere et eaque. Qui, animi obcaecati.\r\n\r\n', 'Buy Now', '', 'See More', '', '#7fd7eb', ''),
(2, 'Gifts for your\r\nloved ones', 'Omnis ex nam laudantium odit illum harum, excepturi accusamus at corrupti, velit blanditiis unde perspiciatis, vitae minus culpa? Beatae at aut consequuntur porro adipisci aliquam eaque iste ducimus expedita accusantium?\r\n\r\n', 'Buy Now', '', 'See More', '', '#6926a5', '/images/banner/gifts.png');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cid` int(50) NOT NULL,
  `uid` int(50) NOT NULL,
  `pid` int(50) NOT NULL,
  `status` int(50) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cid`, `uid`, `pid`, `status`) VALUES
(3, 1, 48, 2),
(16, 1, 2, 2),
(25, 1, 38, 2),
(26, 1, 37, 2),
(27, 1, 45, 2);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `gid` int(50) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`gid`, `name`) VALUES
(1, 'electronics'),
(2, 'jewelery'),
(3, 'men\'s clothing'),
(4, 'women\'s clothing');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `pid` int(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `gid` int(50) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`pid`, `title`, `price`, `image_url`, `description`, `gid`, `status`) VALUES
(2, 'Fjallraven - Foldsack No. 1 Backpack, Fits 15 Laptops', '109.95', 'https://fakestoreapi.com/img/81fPKd-2AYL._AC_SL1500_.jpg', 'Your perfect pack for everyday use and walks in the forest. Stash your laptop (up to 15 inches) in the padded sleeve, your everyday', 3, 1),
(3, 'Mens Casual Premium Slim Fit T-Shirts ', '22.3', 'https://fakestoreapi.com/img/71-3HjGNDUL._AC_SY879._SX._UX._SY._UY_.jpg', 'Slim-fitting style, contrast raglan long sleeve, three-button henley placket, light weight & soft fabric for breathable and comfortable wearing. And Solid stitched shirts with round neck made for durability and a great fit for casual fashion wear and diehard baseball fans. The Henley style round neckline includes a three-button placket.', 3, 1),
(4, 'Silicon Power 256GB SSD 3D NAND A55 SLC Cache Performance Boost SATA III 2.5', '109', 'https://fakestoreapi.com/img/71kWymZ+c+L._AC_SX679_.jpg', '3D NAND flash are applied to deliver high transfer speeds Remarkable transfer speeds that enable faster bootup and improved overall system performance. The advanced SLC Cache Technology allows performance boost and longer lifespan 7mm slim design suitable for Ultrabooks and Ultra-slim notebooks. Supports TRIM command, Garbage Collection technology, RAID, and ECC (Error Checking & Correction) to provide the optimized performance and enhanced reliability.', 1, 1),
(5, 'White Gold Plated Princess', '9', '/images/products/p5.png', 'Classic Created Wedding Engagement Solitaire Diamond Promise Ring for Her. Gifts to spoil your love more for Engagement, Wedding, Anniversary, Valentine\'s Day...', 2, 1),
(6, 'DANVOUY Womens T Shirt Casual Cotton Short', '12.99', 'https://fakestoreapi.com/img/61pHAEJ4NML._AC_UX679_.jpg', '95%Cotton,5%Spandex, Features: Casual, Short Sleeve, Letter Print,V-Neck,Fashion Tees, The fabric is soft and has some stretch., Occasion: Casual/Office/Beach/School/Home/Street. Season: Spring,Summer,Autumn,Winter.', 4, 1),
(37, 'Mens Cotton Jacket', '55.99', '/images/products/p37.jpg', 'great outerwear jackets for Spring/Autumn/Winter, suitable for many occasions, such as working, hiking, camping, mountain/rock climbing, cycling, traveling or other outdoors. Good gift choice for you or your family member. A warm hearted love to Father, husband or son in this thanksgiving or Christmas Day.', 3, 1),
(38, 'Mens Casual Slim Fit', '15.99', '/images/products/p38.jpg', 'The color could be slightly different between on the screen and in practice. / Please note that body builds vary by person, therefore, detailed size information should be reviewed below on the product description.', 3, 1),
(39, 'John Hardy Women\\\'s Legends Naga Gold & Silver Dragon Station Chain Bracelet', '695', '/images/products/p39.jpg', 'From our Legends Collection, the Naga was inspired by the mythical water dragon that protects the ocean\\\'s pearl. Wear facing inward to be bestowed with love and abundance, or outward for protection.', 2, 1),
(40, 'Solid Gold Petite Micropave ', '168', '/images/products/p40.jpg', 'Satisfaction Guaranteed. Return or exchange any order within 30 days.Designed and sold by Hafeez Center in the United States. Satisfaction Guaranteed. Return or exchange any order within 30 days.', 2, 1),
(41, 'Pierced Owl Rose Gold Plated Stainless Steel Double', '10.99', '/images/products/p41.jpg', 'Rose Gold Plated Double Flared Tunnel Plug Earrings. Made of 316L Stainless Steel', 2, 1),
(42, 'WD 2TB Elements Portable External Hard Drive - USB 3.0 ', '64', '/images/products/p42.jpg', 'USB 3.0 and USB 2.0 Compatibility Fast data transfers Improve PC Performance High Capacity; Compatibility Formatted NTFS for Windows 10, Windows 8.1, Windows 7; Reformatting may be required for other operating systems; Compatibility may vary depending on user’s hardware configuration and operating system', 1, 1),
(43, 'SanDisk SSD PLUS 1TB Internal SSD - SATA III 6 Gb/s', '109', '/images/products/p43.jpg', 'Easy upgrade for faster boot up, shutdown, application load and response (As compared to 5400 RPM SATA 2.5” hard drive; Based on published specifications and internal benchmarking tests using PCMark vantage scores) Boosts burst write performance, making it ideal for typical PC workloads The perfect balance of performance and reliability Read/write speeds of up to 535MB/s/450MB/s (Based on internal testing; Performance may vary depending upon drive capacity, host device, OS and application.)', 1, 1),
(44, 'WD 4TB Gaming Drive Works with Playstation 4 Portable External Hard Drive', '114', '/images/products/p44.jpg', 'Expand your PS4 gaming experience, Play anywhere Fast and easy, setup Sleek design with high capacity, 3-year manufacturer\\\'s limited warranty', 1, 1),
(45, 'Acer SB220Q bi 21.5 inches Full HD (1920 x 1080) IPS Ultra-Thin', '599', '/images/products/p45.jpg', '21. 5 inches Full HD (1920 x 1080) widescreen IPS display And Radeon free Sync technology. No compatibility for VESA Mount Refresh Rate: 75Hz - Using HDMI port Zero-frame design | ultra-thin | 4ms response time | IPS panel Aspect ratio - 16: 9. Color Supported - 16. 7 million colors. Brightness - 250 nit Tilt angle -5 degree to 15 degree. Horizontal viewing angle-178 degree. Vertical viewing angle-178 degree 75 hertz', 1, 1),
(46, 'Samsung 49-Inch CHG90 144Hz Curved Gaming Monitor (LC49HG90DMNXZA) – Super Ultrawide Screen QLED ', '999.99', '/images/products/p46.jpg', '49 INCH SUPER ULTRAWIDE 32:9 CURVED GAMING MONITOR with dual 27 inch screen side by side QUANTUM DOT (QLED) TECHNOLOGY, HDR support and factory calibration provides stunningly realistic and accurate color and contrast 144HZ HIGH REFRESH RATE and 1ms ultra fast response time work to eliminate motion blur, ghosting, and reduce input lag', 1, 1),
(47, 'BIYLACLESEN Women\\\'s 3-in-1 Snowboard Jacket Winter Coats', '56.99', '/images/products/p47.jpg', 'Note:The Jackets is US standard size, Please choose size as your usual wear Material: 100% Polyester; Detachable Liner Fabric: Warm Fleece. Detachable Functional Liner: Skin Friendly, Lightweigt and Warm.Stand Collar Liner jacket, keep you warm in cold weather. Zippered Pockets: 2 Zippered Hand Pockets, 2 Zippered Pockets on Chest (enough to keep cards or keys)and 1 Hidden Pocket Inside.Zippered Hand Pockets and Hidden Pocket keep your things secure. Humanized Design: Adjustable and Detachable Hood and Adjustable cuff to prevent the wind and water,for a comfortable fit. 3 in 1 Detachable Design provide more convenience, you can separate the coat and inner as needed, or wear it together. It is suitable for different season and help you adapt to different climates', 4, 1),
(48, 'Lock and Love Women\\\'s Removable Hooded Faux Leather Moto Biker Jacket', '29.95', '/images/products/p48.jpg', '100% POLYURETHANE(shell) 100% POLYESTER(lining) 75% POLYESTER 25% COTTON (SWEATER), Faux leather material for style and comfort / 2 pockets of front, 2-For-One Hooded denim style faux leather jacket, Button detail on waist / Detail stitching at sides, HAND WASH ONLY / DO NOT BLEACH / LINE DRY / DO NOT IRON', 4, 1),
(49, 'Rain Jacket Women Windbreaker Striped Climbing Raincoats', '39.99', '/images/products/p49.jpg', 'Lightweight perfet for trip or casual wear---Long sleeve with hooded, adjustable drawstring waist design. Button and zipper front closure raincoat, fully stripes Lined and The Raincoat has 2 side pockets are a good size to hold all kinds of things, it covers the hips, and the hood is generous but doesn\\\'t overdo it.Attached Cotton Lined Hood with Adjustable Drawstrings give it a real styled look.', 4, 1),
(50, 'MBJ Women\\\'s Solid Short Sleeve Boat Neck V ', '9.85', '/images/products/p50.jpg', '95% RAYON 5% SPANDEX, Made in USA or Imported, Do Not Bleach, Lightweight fabric with great stretch for comfort, Ribbed on sleeves and neckline / Double stitching on bottom hem', 4, 1),
(51, 'Opna Women\\\'s Short Sleeve Moisture', '7', '/images/products/p51.jpg', '100% Polyester, Machine wash, 100% cationic polyester interlock, Machine Wash & Pre Shrunk for a Great Fit, Lightweight, roomy and highly breathable with moisture wicking fabric which helps to keep moisture away, Soft Lightweight Fabric with comfortable V-neck collar and a slimmer fit, delivers a sleek, more feminine silhouette and Added Comfort', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `logo_url` varchar(255) NOT NULL,
  `map` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`map`)),
  `footer` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`footer`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `title`, `logo_url`, `map`, `footer`) VALUES
(1, 'Giftos', '/images/logo.png', '{\"lat\":\"36.32608614683248\",\"long\":\"59.53668889477313\"}', '{\"social\":{\"facebook\":\"\",\"twitter\":\"\",\"instagram\":\"https://instagram.com\",\"youtube\":\"\"},\"descriptions\":{\"t1_title\":\"ABOUT US\",\"t1_desc\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed doLorem ipsum dolor sit amet, consectetur adipiscing elit, sed doLorem ipsum dolor sit amet,\",\"t2_title\":\"NEED HELP\",\"t2_desc\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed doLorem ipsum dolor sit amet, consectetur adipiscing elit, sed doLorem ipsum dolor sit amet,\"},\"contact\":{\"phone\":\"989210928198\",\"email\":\"mahdi.salari79@yahoo.com\",\"loc_name\":\"Sepidar Co.\",\"loc_link\":\"https://maps.app.goo.gl/vPE5KeU3piaRRA7BA\"}}');

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `sid` int(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `btn_text` varchar(255) DEFAULT NULL,
  `btn_url` varchar(255) DEFAULT NULL,
  `color` varchar(255) NOT NULL DEFAULT '#ffffff',
  `image_url` varchar(255) DEFAULT NULL,
  `page` varchar(255) NOT NULL DEFAULT 'home',
  `status` varchar(255) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`sid`, `title`, `text`, `btn_text`, `btn_url`, `color`, `image_url`, `page`, `status`) VALUES
(1, 'Welcome To Our\r\nGift Shop', 'Sequi perspiciatis nulla reiciendis, rem, tenetur impedit, eveniet non necessitatibus error distinctio mollitia suscipit. Nostrum fugit doloribus consequatur distinctio esse, possimus maiores aliquid repellat beatae cum, perspiciatis enim, accusantium perSequi perspiciatis nulla reiciendis, rem, tenetur impedit, eveniet non necessitatibus error distinctio mollitia suscipit. Nostrum fugit doloribus consequatur distinctio esse, possimus maiores aliquid repellat beatae cum, perspiciatis enim, accusantium perferendis.', 'Contact Us', '/#contact-us', '#f89cab', '/images/slider/s1.png', 'home', '1'),
(2, 'Best Savings on\r\nnew arrivals', 'Qui ex dolore at repellat, quia neque doloribus omnis adipisci, ipsum eos odio fugit ut eveniet blanditiis praesentium totam non nostrum dignissimos nihil eius facere et eaque. Qui, animi obcaecati.\r\n', 'Buy Now', '/shop', '#7fd7eb', '/images/slider/s2.png', 'home', '1'),
(6, 'Hello Guys!', 'Now!\r\nWe have a new watch.', 'Buy Now!', '', '#ffffff', NULL, 'home', 'delete'),
(8, 'Hello Guys!', 'Now!\r\nWe have a new watch.', 'Buy Now!', '', '#ffffff', 'C:/xampp/htdocs/images/slider/s8.png', 'home', 'delete'),
(9, 'Hello Guys!', 'Now!\r\nWe have a new watch.', 'Buy Now!', '', '#ffffff', '/images/slider/s9.png', 'home', '1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `access` int(11) NOT NULL DEFAULT 3
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `name`, `email`, `pass`, `status`, `access`) VALUES
(1, 'Mehdi Salari', 'mahdi.salari79@yahoo.com', '6a182a16e66268d7ce85fcfe945df787', NULL, 0),
(2, 'Negar Ebrahimi', 'negarebrahimi1181@gmail.com', '2ac2406e835bd49c70469acae337d292', NULL, 1),
(3, 'Ali Alavi', 'ali.alavi@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, 2),
(4, 'Reza Rezaei', 'reza.rezaei@gmail.com', '250cf8b51c773f3f8dc8b4be867a9a02', NULL, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`bid`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`gid`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`pid`),
  ADD KEY `gid` (`gid`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cid` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `gid` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `pid` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `sid` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`gid`) REFERENCES `category` (`gid`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
