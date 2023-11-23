<?php require_once "inc/header.php"; 

$phone = new Phone();
$phone = $phone->read($_GET['ad_id']);

if($phone == NULL){
    // moze i da se odradi da se prikaze da nema oglasa stranica
    header("Location: index.php");
    exit();
}

$folderPath = "uploads/" . $phone['images'];
$files = array_diff(scandir($folderPath), array('..', '.'));
//rsort($files);
$firstImage = reset($files);
?>

<div class="container" style="margin-top: 70px" >
    <div class="row">
        <div class="col-lg-6 pl-5">
            <img style="width: 400px; height: 400px;" id="first-image"
             src="uploads/<?=$phone['images'] . "/" . $firstImage;?>" alt="">
            <div id="strelice">
                <button id="levo-strelica" class="strelica"><</button>
                <button id="desno-strelica" class="strelica">></button>
            </div>
            <div id="images-div">
                <?php foreach($files as $file): ?>
                    <img style="width: 100px; height: 100px;" id="small-images"
                    src="uploads/<?=$phone['images'] . "/" . $file;?>" alt="">
                <?php endforeach; ?>
            </div>
        </div>
        <div class="col-lg-6">
            <h3 class=""><?= $phone['title']; ?></h3>
            <p class="">Brand: <?= $phone['brand']; ?></p>
            <p class="">Model: <?= $phone['model']; ?></p>
            <p class=""><?= ($phone['state'] == "0") ? "Novo" : "Koriscen"; ?></p>
            <p class=""><?= $phone['description']; ?></p>
            <h5 class=""><?= $phone['price']; ?> €</h5>
        </div>
    </div>
</div>

<?php require_once "inc/footer.php"; ?>

<script>
        const galerija = document.getElementById('images-div');
        const velikaSlika = document.getElementById('first-image');
        const levoStrelica = document.getElementById("levo-strelica");
        const desnoStrelica = document.getElementById("desno-strelica");

        galerija.addEventListener("click", function (event) {
            if (event.target.tagName === "IMG") {
                velikaSlika.src = event.target.src;
            }
        });

        let trenutnaSlikaIndex = 0;
        const slike = Array.from(galerija.querySelectorAll("img"));

        function prikaziSliku(index) {
            velikaSlika.src = slike[index].src;
            trenutnaSlikaIndex = index;
        }

        galerija.addEventListener("click", function (event) {
            if (event.target.tagName === "IMG") {
                prikaziSliku(slike.indexOf(event.target));
            }
        });

        function prethodnaSlika() {
            if (trenutnaSlikaIndex > 0) {
                prikaziSliku(trenutnaSlikaIndex - 1);
            } else {
                prikaziSliku(slike.length - 1); 
                // Vrati se na poslednju sliku ako ste na prvoj slici.
            }
        }

        function sledećaSlika() {
            if (trenutnaSlikaIndex < slike.length - 1) {
                prikaziSliku(trenutnaSlikaIndex + 1);
            } else {
                prikaziSliku(0);
            }
        }

        levoStrelica.addEventListener("click", prethodnaSlika);
        desnoStrelica.addEventListener("click", sledećaSlika);

        document.addEventListener("keydown", function (event) {
            if (event.key === "ArrowLeft") {
                prethodnaSlika();
            } else if (event.key === "ArrowRight") {
                sledećaSlika();
            }
        });


</script>