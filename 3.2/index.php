<?php
$products = [
    "Яблуко" => 15,
    "Груша" => 30,
    "Апельсин" => 25,
    "Банан" => 13,
];

$cart = isset($_COOKIE['cart']) ? explode(',', $_COOKIE['cart']) : [];

if (isset($_GET['name'])) {
    $productId = $_GET['name'];

    $cart[] = $productId;
    $cartString = implode(',', $cart);
    setcookie('cart', $cartString, time() + 3600, "/");

    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<header>
    <h1>Інтернет-магазин</h1>
    <div>
        <a href="cart.php">Кошик (<?php echo count($cart); ?>)</a>
    </div>
</header>
<main>
    <h2>Список товарів</h2>
    <ul>
        <?php foreach ($products as $product): ?>
            <li>
                <?php echo $product[0]; ?> - <?php echo $product[1]; ?> грн
                <a href="index.php?name=<?php echo urlencode($product[0]); ?>">Додати в кошик</a>
            </li>
        <?php endforeach; ?>
    </ul>
</main>
</body>
</html>
