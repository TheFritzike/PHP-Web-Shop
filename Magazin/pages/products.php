<?php
// Numarul de produse afisate pe pagina
$num_products_on_each_page = 4;
// Pagina curenta, in URL va aparea ca index.php?page=products&p=1, index.php?page=products&p=2, etc...
$current_page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;
// Selectam produsele in functie de data adaugarii
$stmt = $pdo->prepare('SELECT * FROM products ORDER BY date_added DESC LIMIT ?,?');
// bindValue sa putem folosi integer in the SQL statement, avem nevoie ca sa putem folosi LIMIT
$stmt->bindValue(1, ($current_page - 1) * $num_products_on_each_page, PDO::PARAM_INT);
$stmt->bindValue(2, $num_products_on_each_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch produsele din db si returnam rezultatul intr-un Array
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Gasim numarul total de produse
$total_products = $pdo->query('SELECT * FROM products')->rowCount();
?>
<?=template_header('Products')?>

<div class="products content-wrapper">
    <!--<h1>Produse</h1>-->
    <p><?=$total_products?> Produse</p>
    <div class="products-wrapper">
        <?php foreach ($products as $product): ?>
        <a href="index.php?page=product&id=<?=$product['id']?>" class="product">
            <img src="assets/imgs/<?=$product['img']?>" width="200" height="200" alt="<?=$product['name']?>">
            <span class="name"><?=$product['name']?></span>
            <span class="price">
                &euro;<?=$product['price']?>
                <?php if ($product['rrp'] > 0): ?>
                <span class="rrp">&euro;<?=$product['rrp']?></span>
                <?php endif; ?>
            </span>
        </a>
        <?php endforeach; ?>
    </div>
    <div class="buttons">
        <?php if ($current_page > 1): ?>
        <a href="index.php?page=products&p=<?=$current_page-1?>">Prev</a>
        <?php endif; ?>
        <?php if ($total_products > ($current_page * $num_products_on_each_page) - $num_products_on_each_page + count($products)): ?>
        <a href="index.php?page=products&p=<?=$current_page+1?>">Next</a>
        <?php endif; ?>
    </div>
</div>

<?=template_footer()?>