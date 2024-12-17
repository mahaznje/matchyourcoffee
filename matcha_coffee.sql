-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3308
-- Généré le : mar. 17 déc. 2024 à 03:45
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `matcha_coffee`
--

-- --------------------------------------------------------

--
-- Structure de la table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` float NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `price`, `qty`) VALUES
(314, 66, 34, 49.9, 1);

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `number` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `address_type` varchar(50) DEFAULT NULL,
  `method` varchar(50) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `address`, `address_type`, `method`, `total_amount`, `date`, `status`) VALUES
(70, 66, 'Hattab Hattab Jemaik', '0762508897', 'maha.znine@gmail.com', 'Rue de l\'Abeille 3', 'Domicile', 'Paiement à la livraison', 71.88, '2024-10-04 00:49:25', 'En attente');

-- --------------------------------------------------------

--
-- Structure de la table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `price`, `qty`) VALUES
(33, 0, 30, 2.80, 1),
(34, 0, 28, 15.40, 1),
(35, 0, 29, 16.60, 1),
(36, 0, 22, 4.50, 1),
(37, 0, 31, 2.85, 11),
(160, 70, 34, 49.90, 1),
(161, 70, 35, 69.90, 1);

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` float NOT NULL,
  `image` varchar(100) NOT NULL,
  `product_detail` text NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `product_detail`, `type`) VALUES
(1, 'nu3 ORGANIQUE MATCHA', 19.4, 'prod1.webp', 'Le matcha est profondément enraciné dans la culture japonaise et est depuis longtemps très apprécié. Seules les meilleures feuilles de thé vert fraîchement cueillies sont utilisées pour fabriquer la poudre fine de nu3, ce qui lui confère un goût particulièrement aromatique. Après la récolte, les feuilles sont triées et broyées en tencha. Celui-ci est ensuite lentement broyé en une fine poudre dans des broyeurs en granit. Le Matcha vient de la région de Kagoshima, au sud-ouest du Japon, où les méthodes de culture traditionnelles et la plus haute qualité vont de pair. Avant la récolte, les plants de thé sont couverts pour augmenter la teneur en chlorophylle et réduire la teneur en fructose. Cela donne un goût particulier.', 'matcha'),
(2, 'Mövenpick caffé Crème', 11.5, 'prod1.png', 'Mövenpick Kaffeebohnen Crema est un café samtweicher et aromatischer, der aus 100% Arabica Bohnen du Hochland produit wurde. Le café facile à utiliser avec un arôme intense est idéal pour un café au lait, un expresso, un cappuccino ou un latte macchiato.', 'coffee'),
(3, 'Café Royal Honduras Crema Intenso 500g', 15, 'prod.png', 'Les amateurs de café aux arômes intenses adoreront notre Honduras Crema Intenso: ce café Arabica séduit par sa crème puissante et corsée. Produits au Honduras, les grains sont issus à 100% de l’agriculture durable. Pour chaque paquet vendu, CHF 0,50 supplémentaires sont reversés à nos caféiculteurs ainsi qu\'à des initiatives locales. Nos grains portent le label Fairtrade®.\r\n', 'coffee'),
(5, 'Matcha à la Mangue', 29, 'prod2.png', 'Voyagez sous les tropiques avec la combinaison rafraîchissante de matcha et de mangues exotiques d\'Inde. Poudre de matcha à l\'extrait de mangue, édulcorée au fructose naturel de mangue. Un délice qui se déguste froid. 180g - 30 portions. Croyez-nous. Si vous aimez le matcha et les mangues, vous allez les adorer ensemble !', 'matcha'),
(6, 'Matcha Biologique', 39, 'prod3.png', 'Cueillies à la main dans les champs de thé vert d\'Osaka, où seules les feuilles les plus jeunes et les plus vertes sont broyées sur pierre et pulvérisées. Matcha biologique pur de la plus haute qualité pour votre plaisir riche en énergie. 60g - 60 portions.\r\n\r\n\r\n', 'matcha'),
(7, 'Matcha Vanille', 29, 'prod8.png', 'Découvrez la combinaison magique du matcha et de la vanille des profondeurs de la forêt tropicale de Madagascar. Poudre de Matcha à l\'extrait de vanille, sucrée au sucre vanillé. 180g - 30 portions.', 'matcha'),
(8, 'Matcha Chai', 29, 'prod9.png', 'Une fusion de saveurs de thés japonais et indiens. Le matcha, le gingembre, la cannelle et les clous de girofle créent une aventure de thé épicée et aromatique. Légèrement sucré. 180g - 30 portions.', 'matcha'),
(9, 'Café Royal Espresso Forte', 10.5, 'prod5.png', 'Savourez le Café Royal Espresso Forte – un café puissant avec une pointe de chocolat noir, rehaussé d’arômes fruités. Il se marie parfaitement avec des cantuccini, des biscuits italiens aux amandes.', 'coffee'),
(10, 'ILLY Caffè in Grani Tostato Intenso 250 gr', 5.89, 'prod6.png', 'La saveur INTENSE du mélange unique illy 100% Arabica exprime une légè\r\n\r\n1 boîte 250 gr\r\n\r\n', 'coffee'),
(11, 'Matcha Love Japanese Green Tea', 15.8, 'prod7.png', 'Découvrez l\'enchantement du thé vert japonais Matcha Love avec cette boîte de 10 unités. Fabriqué avec du vrai matcha, ce thé biologique de qualité cérémonielle offre un goût authentique et de haute qualité qui vous transportera dans les cérémonies traditionnelles du thé au Japon. Chaque sachet de thé est rempli de poudre de thé vert japonais Matcha Love de première qualité, garantissant que chaque gorgée est de la plus haute qualité. Le mélange spécial de ce thé a été soigneusement élaboré pour offrir une saveur délicieuse et naturelle à la fois rafraîchissante et savoureuse. Non seulement ce thé vert japonais Matcha Love a un goût incroyable, mais il est également incroyablement sain.', 'matcha'),
(20, 'Café Royal Caramel 10 capsules', 4.5, 'prod12.png', 'Café Royal Caramel est un espresso élégant qui remplit le palais d’une fine acidité. La touche sucrée de caramel garantit une expérience gustative incomparable. Ce café est produit de manière durable et certifié 100% Rainforest Alliance. La plus haute qualité est garantie.', 'coffee'),
(21, 'Pack découverte Dosette de café CoffeeB Café Royal', 27.4, 'prod13.png', 'Les boules de café CoffeeB by Café Royal sont composées de matières premières d\'origines végétales, ces capsules sans capsule sont donc sans aluminium et sans plastique, 100% compostable et 100% compensé en Co2. \r\nLe café des boules CoffeeB est certifié Rainforest Alliance, pour des méthodes du culture plus durables, assurant un meilleur avenir pour l\'homme et la nature.\r\n\r\nComposition du pack découverte :\r\nRetrouvez dans ce pack une boite de chaque référence CoffeeB by Café Royal, il y a 9 Coffee Balls par boite.\r\n\r\nLe Lungo est composé de grains 100% Arabica. Doux et raffiné, vous retrouverez des notes de chocolat, de groseille et de noix.\r\nLe Lungo Forte est un blend composé de grains Arabica et Robusta. Aromatique et riche, vous retrouverez des notes de cacao, de caramel et de poivre.\r\nLe Decaffeinato est composé de grains 100% Arabica. Aromatique et épicé, vous retrouverez des notes de caramel, de groseille et de noix de muscade.\r\nL\'Espresso est composé de grains 100% Arabica. Élégant et équilibré, vous retrouverez des notes de biscuit et de caramel.\r\nL\'Espresso Forte est un blend composé de grains Arabica et Robusta. Aromatique et complexe, vous retrouverez des notes de cacao, de mûron et de noix de muscade.\r\nLe Ristretto est un blend composé de grains Arabica et Robusta. Fort et italien, vous retrouverez des notes de réglisse, de barrique et d\'amande fumée.\r\nLe Lungo Bio de Café Royal est composé de grains 100% Arabica. Délicat et rafraîchissant, vous retrouverez des notes d\'agrumes, de céréales, et de mélisse.\r\nL\'Espresso Bio est composé de grains Arabica et Robusta. Intense et épicé, vous retrouverez des notes de cassis, de poivre, et de caramel.', 'coffee'),
(22, 'Café Royal Noisette 10 capsules', 4.5, 'prod11.png', 'Café Royal Noisette est un espresso élégant qui enveloppe votre palais d’une acidité délicate. Cette variante aux arômes harmonieux de noisettes vous procurera une expérience gustative incomparable. Un café produit de manière durable et certifié 100% Rainforest Alliance. Une garantie de qualité.\r\nMarque:\r\nCafe Royal', 'coffee'),
(24, 'Sirop de café sans sucre au caramel', 3.85, 'sirop1.png', 'Caramel aromatique sans sucre.\r\n\r\nVous pouvez désormais ajouter le goût d\'un caramel riche et rond - sans sucre.\r\n\r\nAvec ce sirop, votre latte macchiato, cappuccino ou cacao peut être particulièrement délicieux - sans sucre.', 'sirop'),
(25, 'Sirop de café sans sucre vanillé', 3.85, 'sirop2.png', 'Se faire dorloter davantage sans mauvaise conscience.\r\n\r\nSi vous aimez une expérience supplémentaire dans votre café – avec plus de douceur et d\'arôme, alors cela est généralement associé au sucre.\r\n\r\nAvec cette variante, vous pouvez donner à votre cappuccino, caffé latte ou cacao une touche de vanille douce et chaleureuse - entièrement sans sucre.', 'sirop'),
(26, 'Monin Cinnamon Roll', 10.4, 'sirop3.png', '\r\nLa Cannelle est une épice obtenue à partir des gousses fermentées de différentes espèces d\'orchidées. Pour le sirop de Cannelle Monin, seule la Cannelle, spécialement aromatique et de haute qualité, est utilisée. Comme dans la cuisine et la pâtisserie, le sirop de Cannelle Monin peut être utilisé de différentes manières. Dans le café, les boissons lactées, les desserts et les milk-shakes.', 'sirop'),
(27, 'Monin Sirop de vanille', 10.4, 'sirop4.png', 'La vanille est une épice obtenue à partir des gousses fermentées de différentes espèces d\'orchidées. Pour le sirop de vanille Monin, seule la vanille de Madagascar, spécialement aromatique et de haute qualité, est utilisée. Comme dans la cuisine et la pâtisserie, le sirop de vanille Monin peut être utilisé de différentes manières. Dans le café, les boissons lactées, les desserts et les milk-shakes.', 'sirop'),
(28, 'Monin Sirop Caramel Premium', 15.4, 'sirop5.png', 'Le sirop Caramel MONIN s\'est imposé comme l\'un des sirops les plus populaires. La polyvalence du sirop Caramel se reflète dans les possibilités infinies de combinaisons. Agrémentez votre latte macchiato, votre capuchino ou n\'importe quelle autre boisson chaude de cet arôme très apprécié. Le sirop brille d\'un or foncé avec des reflets jaunes. Il est végétalien, sans gluten ni lactose et sans arômes artificiels.', 'sirop'),
(29, 'Monin Caramel Salé', 16.6, 'sirop6.png\r\n', 'Le sirop de caramel fait partie des arômes les plus utilisés pour affiner le café. Le nouveau sirop Monin Salty Caramel est une alternative intéressante à ce classique. Une expérience gustative particulière qui jouit non seulement d\'une popularité croissante auprès des gourmets, mais qui rehausse également le chocolat de qualité, les confiseries, les glaces et autres desserts.', 'sirop'),
(30, 'Sirop de caramel salé - Street Joe\'s', 2.8, 'sirop7.png', 'Faites-vous plaisir avec le goût riche du sirop de café au caramel salé Street Joe\'s. Un mélange parfait de sucré et de salé. Ce délicieux ajout à votre café est créé de main de maître pour   ravir vos papilles gustatives. Une petite quantité de 2 cl transforme votre café quotidien en une expérience gourmande. Que vous souhaitiez commencer votre journée avec un goût spécial ou offrir à vos amis une pause café impressionnante, le sirop de caramel salé Street Joe\'s vous facilite la tâche. Essayez-le aujourd\'hui et transformez votre café ordinaire en quelque chose d\'extraordinaire !', 'sirop'),
(31, 'Sirop sans sucre Caramel Salé - Street Joe\'s', 2.85, 'sirop8.png', 'Découvrez le goût irrésistible du Caramel Salé Street Joe\'s sans sucre. Ce sirop donne à votre café une touche particulière avec une association de caramel salé. Avec seulement 2 cl de sirop par tasse, vous pouvez créer l’expérience gustative parfaite. Idéal pour les amateurs de café qui veulent éviter le sucre mais pas le goût. Essayez-le et enchantez votre café avec le délicat arôme du caramel salé. C\'est plus qu\'un sirop ; c\'est une invitation à déguster le café d\'une manière nouvelle et passionnante.', 'sirop'),
(32, 'Fouet en bambou Matcha (Chasen)', 15.5, 'kite1.png', 'La façon traditionnelle japonaise de mélanger le matcha est d\'utiliser ce fouet. Fabriqué à la main à partir d\'une seule pièce de bambou.', 'kite'),
(33, 'Bol à Matcha (Chawan)', 19, 'kite2.png', 'Ce bol à matcha simple et élégant est parfait pour une préparation traditionnelle. Il est doté d\'un bec verseur pratique et est fabriqué à partir de porcelaine fabriquée à la main. Lave-vaisselle.\r\n\r\n', 'kite'),
(34, ' Coffret matcha complet 4 pièces « Akatsuki »', 49.9, 'kite3.png', 'Un ensemble à matcha élégant et pratique comprenant un bol, une cuillère, un balai et un porte-balai avec emballage cadeau.', 'kite'),
(35, 'Service à matcha trois pièces avec bol, cuillère e', 69.9, 'kite4.png', 'Plongez dans l\'univers de la cérémonie traditionnelle du thé japonaise avec notre service à matcha exclusif en céramique japonaise et bambou.', 'kite');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `user_type`) VALUES
(66, 'maha', 'maha.znine@gmail.com', '$2y$10$GuBa.pPn4X5aQhaBlN1UhuFDewP2Gd8wRU.g7fmhjG/yYk/ulZ6kC', ''),
(67, 'hattab', 'hattabhj@gmail.com', '$2y$10$mEuE9YJLysJYOB4AoRLvoOeD4SNZlp8e9XTr9URWZqB1oX/9262jK', ''),
(68, 'hattab', 'hattab@gmail.com', '$2y$10$d2gtTA87fF9xQGdM0WR/A.SOKUAdSdivMlaukeK6b5lQm48tXYNiO', '');

-- --------------------------------------------------------

--
-- Structure de la table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `product_id`, `price`) VALUES
(42, 67, 9, 10.5),
(43, 67, 10, 5.89),
(44, 67, 27, 10.4),
(66, 66, 9, 10.5),
(67, 66, 5, 29),
(70, 66, 3, 15);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `order_id` (`order_id`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Index pour la table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=315;

--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT pour la table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT pour la table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
