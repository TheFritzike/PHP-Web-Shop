<?php
// verificam daca parametrul Id e specificat in URL
if (isset($_GET['id'])) {
    // Preparare si executare
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    // Fetch produs din Db si returnam intr-un Array
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    // Verificam daca produsul exista (array nu este gol)
    if (!$product) {
        // Eroare simpla daca e gol[nu exista produs]
        exit('Product does not exist!');
    }
} else {
    // Eroare simpla in cazul in care nu gasim produsul in URL
    exit('Product does not exist!');
}
?>
<?=template_header('Product')?>

<div class="product content-wrapper">
    <img src="assets/imgs/<?=$product['img']?>" width="500" height="500" alt="<?=$product['name']?>">
    <div>
        <h1 class="name"><?=$product['name']?></h1>
        <span class="price">
            &euro;<?=$product['price']?>
            <?php if ($product['rrp'] > 0): ?>
            <span class="rrp">&euro;<?=$product['rrp']?></span>
            <?php endif; ?>
        </span>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?page=cart'); ?>" method="post">
            <input type="number" name="quantity" value="1" min="1" max="<?=$product['quantity']?>" placeholder="Quantity" required>
            <input type="hidden" name="product_id" value="<?=$product['id']?>">
            <input type="hidden" name="action" value="add_to_cart">
            <input type="submit" value="Adaugă în coș">
        </form>

        <div class="description">
            <?=$product['desc']?>
        </div>
    </div>
</div>

<?=template_footer()?>