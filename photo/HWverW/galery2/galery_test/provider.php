<?php

include_once("libs/utils.php");
include_once("libs/dbmanager.php");

$act = req("act");

$u = new Umsg();

if (empty($act)) {
    $u->addError("Не указано действие.");
    $u->sendResponse();
    exit;
}

if (!isAuth()) {
    $u->addError("Вы не авторизованы, поэтому у вас нет прав для выполнения каких-либо комманд.");
    $u->sendResponse();
    exit;
}

switch ($act) {
    case "test": $u->addInfo("It's works! ;) Va bene, senioro!"); break;
    //группы (папки)
    case "add_folder": onAddFolder($u); break;
    case "edit_group_title": onEditGroupTitle($u); break;
    case "delete_group":    onDeleteGroup($u); break;
    //альбомы
    case "add_album":   onAddAlbum($u); break;
    case "delete_album": onDeleteAlbum($u); break;
    case "edit_album_title": onEditAlbumTitle($u); break;
    //фоточки
    case "delete_photo":    onDeletePhoto($u); break;
    case "upload_photo":    onUploadPhoto($u); break;
    default: $u->addError("Неизвестное действие."); break;
}

$u->sendResponse();

/**************************************************************************************************************/


function checkDirs() {
    if (!is_dir("./images"))
        mkdir("./images/");
    if (!is_dir("./images/full/"))
        mkdir("./images/full/");
    if (!is_dir("./images/preview/"))
        mkdir("./images/preview/");
}

function onUploadPhoto($u) {
    $album_id = req("album_id");
    
    if (!isset($_FILES['file']) || empty($album_id)) return false;
    $tmp_img = $_FILES['file'];
    
    include_once("libs/imgresize.php");
    
    $db = getDBObject();
    
    if (!$album = $db->getAlbum($album_id)) {
        return false;
    }
    
    checkDirs();
    
    $si = new SimpleImage();
    if (!$si->load($tmp_img['tmp_name']))
        return false;
    
    $full_name = md5(filesize($tmp_img['tmp_name'] . $tmp_img['filename'])) . ".jpg";
    $full_url = "images/full/" . $full_name;
    $preview_name = $full_name;
    $preview_url = "images/preview/" . $preview_name;
    
    $si->save("./images/full/" . $full_name, IMAGETYPE_JPEG, 90);
    //$si->resize(280, 185);
    $si->resizeToWidth(280);
    $si->save("./images/preview/" . $preview_name);
    
    $photo_id = $db->addPhoto($album_id, "", $full_url, $preview_url);
    
    $u->addCMD("photo_uploaded", array("photo_id" => $photo_id, "full_url" => $full_url, "preview_url" => $preview_url));
}


function onAddFolder($u) {
    $title = req("title");
    
    if (empty($title)) {
        $u->addError("Название папки не может быть пустым.");
        return false;
    }
    
    $db = getDBObject();
    if ($gid = $db->addGroup($title)) {
        //$u->addInfo("Папка \"".$title."\" успешно создана");
        $u->addCMD("group_added", array("group_id" => $gid, "group_title" => $title));
    } else {
        $u->addError("Не удалось папку в базе создать...");
    }
}

function onEditGroupTitle($u) {
    $group_id = req("group_id");
    $new_title = req("new_title");
    $title = req("group_title");
    
    if (empty($group_id) || empty($new_title)) {
        $u->addError("Переданы не все важные данные.");
        return false;
    }
    
    $db = getDBObject();
    
    if (!$db->getGroup($group_id)) {
        $u->addError("Такой папки не существует.");
        return false;
    }
    
    if ($db->updateGroupTitle($group_id, $new_title)) {
        //$u->addInfo("Папка успешно переименована с \"$title\" на \"$new_title\"");
        $u->addCMD("group_title_changed", array("group_id" => $group_id, "new_title" => $new_title, "title" => $title));
    } else {
        $u->addError("Ошибка при сохранении изменений в базе. Папка не переименована.");
    }
}

function onDeleteGroup($u) {
    $group_id = req("group_id");
    if (empty($group_id)) {
        $u->addError("Не указан идентификатор папки, которую нужно удалить.");
        return false;
    }
    
    $db = getDBObject();
    
    if ($db->deleteGroup($group_id)) {
        //$u->addInfo("Папка и все находящиеся в ней альбомы с фотографиями успешно удалены!");
        $u->addCMD("group_deleted", array("group_id" => $group_id));
    } else {
        $u->addError("Ошибка при удалении папки из базы...");
    }
}

/****/

function onAddAlbum($u) {
    $group_id = req("group_id");
    $album_title = req("album_title");
    
    if (empty($group_id)) {
        $u->addError("Не указан идентификатор папки, которую нужно удалить.");
        return false;
    }
    
    if (empty($album_title)) {
        $u->addError("Не задано название альбома");
        return false;
    }
    
    $db = getDBObject();
    
    if (!$group = $db->getGroup($group_id)) {
        $u->addError("Такой папки не существует.");
        return false;
    }
    
    if ($album_id = $db->addAlbum($group_id, $album_title)) {
        //$u->addInfo("Альбома \"$album_title\" добавлена успешно.");
        $u->addCMD("album_added", array("album_id" => $album_id, "album_title" => $album_title, "group_id" => $group_id));
    } else {
        $u->addError("Ошибка при добавлении альбома в базу.");
    }
}

function onEditAlbumTitle($u) {
    $album_id = req("album_id");
    $album_title = req("album_title");
    $new_title = req("new_title");
    //
    if (empty($album_id) || empty($new_title)) {
        $u->addError("Переданы не все важные данные.");
        return false;
    }
    
    $db = getDBObject();
    
    if (!$album = $db->getAlbum($album_id)) {
        $u->addError("Такого альбома не существует...");
        return false;
    }
    
    if ($db->updateAlbumTitle($album_id, $new_title)) {
        //$u->addInfo("Название альбома успешно изменено с \"$album_title\" на \"$new_title\".");
        $u->addCMD("album_title_changed", array("album_id" => $album_id, "new_title" => $new_title, "title" => $album_title));
    } else {
        $u->addError("Ошибка при обновлении названия альбома в базе.");
    }
}

function onDeleteAlbum($u) {
    $album_id = req("album_id");
    $db = getDBObject();
    
    if ($db->deleteAlbum($album_id)) {
        //$u->addInfo("Альбом \"".$album['title']."\" и все его фотографии успешно удалены");
        $u->addCMD("album_deleted", array("album_id" => $album_id));
    } else {
        $u->addError("Ошибка при удалении альбома из базы.");
    }
}

/****/

function onDeletePhoto($u) {
    $photo_id = req("photo_id");
    $db = getDBObject();
    
    if ($db->deletePhoto($photo_id)) {
        //$u->addInfo("Фотография успешно удалена");
        $u->addCMD("photo_deleted", array("photo_id" => $photo_id));
    } else {
        $u->addError("Ошибка какая-то при удалении фотографии из базы.");
    }
}