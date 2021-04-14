CREATE TABLE `admin_list` (
  `admin_id` int(11) NOT NULL,
  `admin_email` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `admin_usrname` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `admin_passwd` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `admin_token` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `admin_yetki` varchar(255) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

INSERT INTO `admin_list` (`admin_id`, `admin_email`, `admin_usrname`, `admin_passwd`, `admin_token`, `admin_yetki`) VALUES
(1, 'alicangonullu@yahoo.com', 'alicangonullu', '060323f33140b4a86b53d01d726a45c7584a3a2b', '060323f33140b4a86b53d01d726a45c7584a3a2b', '1');

CREATE TABLE `boot_menu` (
  `boot_id` int(11) NOT NULL,
  `boot_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `boot_labelid` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `boot_isoname` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `boot_speconf` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `boot_othercfg` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `boot_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

INSERT INTO `boot_menu` (`boot_id`, `boot_name`, `boot_labelid`, `boot_isoname`, `boot_speconf`, `boot_othercfg`, `boot_date`) VALUES
(2, 'FreeDOS', '2', 'fdboot.img', 'append', '', '2020-10-22');

ALTER TABLE `admin_list`
  ADD PRIMARY KEY (`admin_id`);

ALTER TABLE `boot_menu`
  ADD PRIMARY KEY (`boot_id`);

ALTER TABLE `admin_list`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `boot_menu`
  MODIFY `boot_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;
