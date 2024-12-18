<?php
$products = [
    "Яблуко" => 15,
    "Груша" => 30,
    "Апельсин" => 25,
    "Банан" => 13,
];

$cart = isset($_COOKIE['cart']) ? explode(',', $_COOKIE['cart']) : [];

if (isset($_GET['clear'])) {
    setcookie('cart', '', time() - 3600, "/");
    header('Location: cart.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Кошик</title>
</head>
<body>
<header>
    <h1>Кошик</h1>
    <a href="index.php">Повернутися до товарів</a>
</header>
<main>
    <?php if (!empty($cart)): ?>
        <h2>Ваші товари:</h2>
        <ul>
            <?php
$total = 0;
foreach ($cart as $item):
    if (isset($products[$item])):
        $price = $products[$item];
        $total += $price;
        ?>
		                <li>
		                    <?php echo htmlspecialchars($item); ?> - <?php echo $price; ?> грн
		                </li>
		            <?php
    endif;
endforeach;
?>
        </ul>
        <p><strong>Загальна сума: <?php echo $total; ?> грн</strong></p>
        <a href="cart.php?clear=1">Очистити кошик</a>
    <?php else: ?>
        <p>Ваш кошик порожній.</p>
    <?php endif;?>
</main>
</body>
</html>
