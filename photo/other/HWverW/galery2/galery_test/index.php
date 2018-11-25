<?php
    include_once("configs.php");
    include_once("libs/utils.php");
    include_once("libs/dbmanager.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/magnific_popup.css" />
    <title>Проверка галереи</title>
    <link rel="icon" href="/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
<script src="//yastatic.net/jquery/2.1.4/jquery.min.js"></script>
<script src="js/magnpopup.js"></script>
<script src="js/uploader.js"></script>
<script src="js/script.js"></script>
</head>
<body>

<div class="projects">

<div class="port">
<a href="index.php" title="Перейти на главную">
<img src="http://skpool.ru/img/logo.png" />
</a>
</div>

<?php


if (isAuth()) {
    echo "<a class='login_a' href='?a=logout' title='Нажмите, что бы выйти'>Выйти</a>";
} else {
    //echo "<a class='login_a' href='auth.php' title='Нажмите, что бы войти'>Войти</a>";
}

$act = get("a");

if (isAuth() && empty($act)) {
    echo '<span class="btn_control add_folder">Добавить папку</span>';
}

switch ($act) {
    case "v": viewAlbum(); break;
    case "logout": logout(); break;
    default: printGroupsAlbums(); break; //по умолчанию вывести список груп и альбомов.
}

/***********************************************/

function printUpPhotosDiv() {
    ?>
    <div class="bl_proj upload" title="Кликните для выбора или перетащите сюда файлы для загрузки">
        <input type="file" multiple="true" style="opacity: .0; width: 100%; height: 100%; cursor: pointer;" title="Кликните для выбора или перетащите сюда файлы для загрузки" />
    </div>
    <?php
}

/**/

function viewAlbum() {
    $album_id = (int)get("album");
    
    if (!$album_id) {
        echo "<div class='bl_proj'>Ошибка! Не указан номер альбома.</div>";
        return false;
    }
    
    $db = getDBObject();
    if (!$album = $db->getAlbum($album_id)) {
        echo "<div class='bl_proj'>Ошибка! Такого альбома не существует!</div>";
        return false;   
    }
    
    $photos = $db->getAlbumPhotos($album_id);
    
    ?>
    <div class="port">
        <div class="fn_proj" id="album_title" album_title="<?php echo($album['title']); ?>" album_id="<?php echo $album['id']; ?>"><?php echo($album['title']); ?> (фотографий: <?php echo count($photos); ?>)</div>
    </div>
    <?php
    
    foreach($photos as $ph) {
        ?>
        <div class="bl_proj" class="img_div" id="img_div_<?php echo $ph['id']; ?>">
            <?php if (isAuth()) { ?>
                <div class="del delete_photo" photo_id="<?php echo $ph['id']; ?>">X</div>
            <?php } ?>
            <img class="gall_img" src="<?php echo $ph['preview_url']; ?>" data-mfp-src="<?php echo $ph['full_url']; ?>" title="<?php echo $ph['title']; ?>" />
        </div>
        <?php
    }
    
    if (isAuth()) //если авторизованы,
        printUpPhotosDiv(); //отобразить блок для загрузки фоточек )
}

function printGroupsAlbums() {
    $db = getDBObject();

    $groups = $db->getAlbumsGroups();

    if (!$groups || !count($groups)) {
        echo "Фотографий пока нет вообще!";
    } else {
        foreach($groups as $group) { //вывод групп альбомов.
            $albums = $db->getGroupAlbums($group['id']); //получение альбомов в текущей группе.
            ?>
            <div class="folder group" id="group_<?php echo $group['id']; ?>" group_id="<?php echo $group['id']; ?>">
            <div class="port">
                <div class="fn_proj" group_id="<?php echo $group['id']; ?>" group_title="<?php echo $group['group_title']; ?>">
                    <span class="group_title">
                    <?php 
                        echo($group['group_title']);
                    ?>
                    </span>
                    <?php if (isAuth()) { ?>
                        <span class="btn_control edit_folder">Редактировать</span>
                        <span class="btn_control delete_folder">Удалить</span>
                        <span class="btn_control add_album">Добавить альбом</span>
                    <?php } ?>
                </div>
            </div>
            <?
            
                foreach($albums as $album) { //вывод альбомов текущей группы.
                    if (empty($album['preview_url'])) { //если у альбома не задана превьюшка
                        $ph = $db->getAlbumPrimaPhoto($album['id']); //то можно попробовать получить превьюшку по первой картинке в альбоме.
                        $album['preview_url'] = $ph['preview_url'];
                    }
                    ?>
                    <a id="album_a_<?php echo $album['id']; ?>" href="?a=v&album=<?php echo $album['id']; ?>" title='Нажмите, что бы просмотреть фотографии в этом альбоме.'>                    
                    <div class="bl_proj <?php if (empty($album['preview_url'])) echo 'empty_preview'; ?>" album_id="<?php echo $album['id']; ?>">
                            <div class="info_proj" id="album_<?php echo $album['id']; ?>">
                            <?php 
                                echo "<span class='album_title'>" . $album['title'] . "</span>"; 
                                if (isAuth()) {
                                    echo '<span class="edit edit_album_title" title="Сменить название альбома!" album_id="'.$album['id'].'" album_title="'.$album['title'].'">Ред.</span>';
                                }
                            ?></div>
                            <?php 
                                if (isAuth())
                                    echo '<div class="del delete_album" title="Удалить этот альбом к чертям!" album_id="'.$album['id'].'" album_title="'.$album['title'].'">X</div>';
                            
                                if (!empty($album['preview_url']))
                                    echo '<img src="' . $album['preview_url']. '" />';
                            ?>                        
                    </div>
                    </a>                    
                    <?php                
                } // ./foreach albums
            echo "</div>";
        } //. foreach groups
    }
}

?>

</div> <!-- ./project div -->

</body>
</html>