<?php 
require_once "inc/header.php";

$phones = new Phone();
$phones = $phones->selectAll();

?>

<div class="container" style="margin-top: 70px">
    <div class="row">
        <?php foreach($phones as $phone): ?>
            <div class="col-md-3 pr-1">
                <div class="card" onclick="openAdView(<?= $phone['ad_id']; ?>)">
                    <?php   
                        $folderPath = "uploads/" . $phone['images'];
                        $files = array_diff(scandir($folderPath), array('..', '.'));
                        //rsort($files);
                        $firstImage = reset($files);
                    ?>
                    <img style="width: 200px; height: 200px; margin-top: 5%;" src="uploads/<?=$phone['images'] . "/" . $firstImage;?>" alt="">
                    <div class="card-body">
                        <h5 class=""><?= $phone['title']; ?></h5>
                        <p class=""><?= ($phone['state'] == "0") ? "Novo" : "Koriscen"; ?></p>
                        <p class=""><?= $phone['price']; ?> €</p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once "inc/footer.php"; ?>

<script>
    function openAdView(ad_id){
        window.location.href = "ad_view.php?ad_id=" + ad_id;
    }
</script>