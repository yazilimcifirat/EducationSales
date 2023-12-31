<?php
class sqlProcess
{
    function __construct()
    {
        try {
            //PDO sınıfının constructor'ında, veritabanı sunucusunun adresi (localhost), veritabanı adı (db), karakter seti (utf8), kullanıcı adı (root) ve şifre ('') gibi bilgiler yer alır. Bu bilgiler, veritabanı sunucusuna bağlanmak için gereklidir.
            $db = new PDO("mysql:host=localhost; dbname=db; charset=utf8", 'root', '');
            //echo "veri tabanı bağlantısı başarılı";
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    function siralammodal_ForDelete($exampleModal, $butonName)
    {
        echo '<div class="modal fade" id="' . $exampleModal . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">';
        echo '<div class="modal-dialog">';
        echo '<div class="modal-content">';
        echo '<div class="modal-header">';
        echo '<h1 class="modal-title fs-5" id="exampleModalLabel">UYARI..!</h1>';
        echo ' <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
        echo '</div>';
        echo '<div class="modal-body">';
        echo 'Silmek istediğinize emin misiniz?';
        echo '</div>';
        echo '<div class="modal-footer">';
        echo '<button type="submit" class="submit-btn bg-danger inputOval" data-bs-dismiss="modal">Kapat</button>';
        echo '<button type="submit" name="' . $butonName . '" class="submit-btn bg-danger inputOval">Sil</button>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    function loginControl($post, $query, $name, $pass, $who)
    {
        if (isset($_POST[$post])) {
            $username = $_POST[$name];
            $password = $_POST[$pass];

            global $db;
            // Assuming $db is your database connection object
            $kullanici_sor = $db->prepare($query);
            $kullanici_sor->execute([$username, $password]);
            $say = $kullanici_sor->rowCount();

            if ($say == 1) {
                $_SESSION["LoggedIn"] = true;
                $_SESSION["username"] = $username;
                if ($who == 'admin') {
                } else {
                    goAndComeBack("index.php", 2, 1);
                }
            } else {
                $_SESSION["LoggedIn"] = false;
                echo '<script>alert("Kullanıcı adı veya şifre hatalı.");</script>';
                goAndComeBack(0, 0.1);
                exit;
            }
        }
    }
    function sqlsorgu($requestQuery, $query, $params, $choos = 0, $query2, $params2)
    {
        if (isset($_POST[$requestQuery])) {
            global $db, $params, $kayitSayisi;
            if ($choos != 0) {
                //alttaki 3 satır ile verilen params2 ile verilen verinin kaçtane olduğunu sorgu ile aratıyor.
                $sorgu = $db->prepare($query2);
                $guncelle = $sorgu->execute(($params2));
                $kayitSayisi = $sorgu->fetchColumn();
                if ($kayitSayisi == 0) {
                    $sorgu = $db->prepare($query);
                    $guncelle = $sorgu->execute(($params));
                }
            } else {
                $sorgu = $db->prepare($query);
                $guncelle = $sorgu->execute(($params));
            }
            if ($guncelle) {
                echo '<script>alert("işlem Başarılı.");</script>';
            } else {
                echo '<script>alert("Bir hata oluştu, tekrar kontrol edin.");</script>';
            }
        }
    }
}
