<?php 
require_once("connect.php");


if(isset($_REQUEST["Sayfalama"])){
    $GelenSayfalama     =   $_REQUEST["Sayfalama"];
}
else{
    $GelenSayfalama     =   1;
}

$SayfalamaIcinSolVeSagButonSayisi   =    2;
$SayfaBasınaGosterilecekKayitSayisi =    5;
$ToplamKayitSayisiSorgusu           =    $VeritabaniBaglantisi->prepare("SELECT * FROM products");
$ToplamKayitSayisiSorgusu->execute();
$ToplamKayitSayisi                  =    $ToplamKayitSayisiSorgusu->rowCount();
$SayfalamayaBaslanacakKayitSayisi   =    ($GelenSayfalama * $SayfaBasınaGosterilecekKayitSayisi)-$SayfaBasınaGosterilecekKayitSayisi;
$BulunanSayfaSayisi                 =    ceil($ToplamKayitSayisi/$SayfaBasınaGosterilecekKayitSayisi);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table align="center" width="500" border="0" cellpadding="0" cellspacing="0">
        <?php  
        $UrunSorgusu                =       $VeritabaniBaglantisi->prepare("SELECT * FROM products ORDER BY id ASC LIMIT $SayfalamayaBaslanacakKayitSayisi,$SayfaBasınaGosterilecekKayitSayisi");
        $UrunSorgusu->execute();
        $UrunSorgusuKayitSayisi     =       $UrunSorgusu->rowCount();
        $UrunSorguKayitlari         =       $UrunSorgusu->fetchAll(PDO::FETCH_ASSOC);

        foreach($UrunSorguKayitlari as $Kayitlar){
            echo "<tr height='30'>";
            echo "<td width='25' align='left'>" . $Kayitlar["id"] . "<td>";
            echo "<td width='375' align='left'>" . $Kayitlar["isim"] . "<td>";
            echo "<td width='100' align='right'> " . $Kayitlar["price"] . " " . $Kayitlar["currency"] . "<td>";
            echo "</tr>";

        }
        ?>
    </table>

    <div class="sayfalamaAlaniKapsayicisi">
        <div class="SayflamaAlanıIciNetinAlaniKapsayicisi">
            Toplam <?php echo $BulunanSayfaSayisi ; ?> sayfada , <?php echo $ToplamKayitSayisi; ?> adet kayıt bulunmaktadır.
        </div>
        <div class="SayflamaAlanıIciNumaralandırmaAlaniKapsayicisi">
            <?php 
            if($GelenSayfalama>1){
                echo "<span class='Pasif'><a href='index.php?Sayfalama=1'><< </a></span>";
                $SayfalamaIcinSayfaDegeriniBirGeriAl    =   $GelenSayfalama-1;
                echo " <span class='Pasif'><a href='index.php?Sayfalama=" . $SayfalamaIcinSayfaDegeriniBirGeriAl . "'><</a></span> ";
            }
            
            
            for($SayfalamaIcınSayfaIndexDegeri=$GelenSayfalama-$SayfalamaIcinSolVeSagButonSayisi;$SayfalamaIcınSayfaIndexDegeri<=$GelenSayfalama+$SayfalamaIcinSolVeSagButonSayisi;$SayfalamaIcınSayfaIndexDegeri++){
                
                if(($SayfalamaIcınSayfaIndexDegeri>0) and ($SayfalamaIcınSayfaIndexDegeri<=$BulunanSayfaSayisi)){
                    
                    echo "<a href='index.php?Sayfalama=" . $SayfalamaIcınSayfaIndexDegeri . "'>" .$SayfalamaIcınSayfaIndexDegeri . "</a>"; 

                }
                
                
            }



            if($GelenSayfalama!=$BulunanSayfaSayisi){
                $SayfalamaIcinSayfaDegeriniBirIleriAl    =   $GelenSayfalama+1;
                echo " <span class='Pasif'><a href='index.php?Sayfalama=" . $SayfalamaIcinSayfaDegeriniBirIleriAl . "'>> </a></span>";
                echo "<span class='Pasif'><a href='index.php?Sayfalama=" . $BulunanSayfaSayisi . "'>>></a></span>";
            }


            ?>

        </div>
    </div>

</body>
</html>