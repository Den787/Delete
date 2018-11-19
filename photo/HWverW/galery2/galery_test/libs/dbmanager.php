<?php

    /**
     * Скрипт для работы с базой. 
     * Содержит всякие функции для управления альбомами.
     * @author karamush
     * @date 03.08.015
     **/

include_once("safemysql.php");

$h_db = null; //db handle

function getDBObject() {
    global $h_db;
    if (!$h_db) {
        $opts = array(
                    "host" => DB_HOST,
                    "user" => DB_USER,
                    "db"   => DB_BASE,
                    "pass" => DB_PASS    
                );
        $h_db = new DBManager($opts);
    }
    return $h_db;
}

class DBManager {
    
    private $db;
    
    function __construct($opts = array()) {
        $this->db = new SafeMySQL($opts);    
    }
    
    /* получение инфы */
    
    /**
     * получить список всех групп
     */
    public function getAlbumsGroups() {
        return $this->db->getAll("SELECT `id`,`group_title` FROM `albums` WHERE `group_id` = 0");
    }
    
    /**
     * получить список всех альбомов
     */
    public function getAlbums() {
        return $this->db->getAll("SELECT `id`,`title`,`description`,`preview_url` FROM `albums` WHERE `group_id` <> 0");
    } 
    
    /**
     * получить список альбомов указанной группы
     * @param int $group_id -- идентификатор группы
     */
    public function getGroupAlbums($group_id) {
        return $this->db->getAll("SELECT `id`,`title`,`description`,`preview_url` FROM `albums` WHERE `group_id`=?i", $group_id);
    }
    
    /**
     * получить список фотографий в указанном альбоме
     * @param int $album_id -- идентификатор альбома
     */
    public function getAlbumPhotos($album_id) {
        return $this->db->getAll("SELECT * FROM `photos` WHERE `album_id`=?i", $album_id);
    }
    
    /**
     * получить одно фото
     * @param int $photo_id -- идентификатор фотографии
     */
    public function getPhoto($photo_id) {
        return $this->db->getRow("SELECT * FROM `photos` WHERE `id`=?i", $photo_id);
    }
    
    
    /**
     * получить первую фотку из альбома
     * это может быть полезно тогда, когда не задана превьюшка для самого альбома
     * 
     * @param int $album_id
     */
    public function getAlbumPrimaPhoto($album_id) {
        return $this->db->getRow("SELECT * FROM `photos` WHERE `album_id` = ?i LIMIT 1", $album_id);
    }
    
    /**/
    
    /**
     * получить информацию о группе по её ID
     * @param int $group_id
     */
    public function getGroup($group_id) {
        return $this->db->getRow("SELECT `id`,`group_title` FROM `albums` WHERE `id`=?i", $group_id);
    }
    
    /**
     * получить количество альбомов 
     * 
     * @param int $group_id -- идентификатор группы, количество альбомов которой нужно получить
     */
    public function getGroupAlbomsCount($group_id) {
        return $this->db->getOne("SELECT COUNT(*) FROM `albums` WHERE `group_id`=?i", $group_id);
    }
    
    /**
     * получить информацию об альбоме по его ID
     * @param int $album_id -- идентификатор альбома
     */
    public function getAlbum($album_id) {
       return $this->db->getRow("SELECT `id`,`title`,`description`,`preview_url` FROM `albums` WHERE `id`=?i AND `group_id` <> 0", $album_id); 
    }
    
    /**
     * получить количество фотографий в указанном альбоме
     */
    public function getAlbumPhotosCount($album_id) {
        return $this->db->getOne("SELECT COUNT(*) FROM `photos` WHERE `album_id` = ?i", $album_id);
    }
    
    /**/
    /* добавление групп, альбомов, фотографий */
    /**/
    
    /**
     * добавить новую группу
     * @param string $title -- название группы
     */
    public function addGroup($title) {
        if (!$this->db->query("INSERT INTO `albums`(`group_title`) VALUES(?s)", $title))
            return false;
        return $this->db->insertId();
    }
    
    /**
     * добавить новый альбом
     * @param int $group_id -- идентификатор существующей группы
     * @param string $title -- название альбома
     * @param string $description -- описание альбома (не обязательно) 
     */
    public function addAlbum($group_id, $title, $description = "") {
        if (!$this->db->query("INSERT INTO `albums`(`group_id`, `title`, `description`) VALUES(?i, ?s, ?s)", $group_id, $title, $description)) 
            return false;
        return $this->db->insertId();
    }
    
    /**
     * добавить новую фотографию
     * @param int $album_id -- идентификатор существующего альбома
     * @param string $title -- название (описание) фотографии
     * @param string $full_url -- путь к картинке полного размера
     * @param string $preview_url -- путь к превьюшке картинки 
     */
    public function addPhoto($album_id, $title, $full_url, $preview_url) {
        $sql = "INSERT INTO `photos`(`album_id`, `title`, `full_url`, `preview_url`, `upload_time`, `upload_ip`)
                VALUES (?i, ?s, ?s, ?s, ?i, ?s)";
        if (!$this->db->query($sql, $album_id, $title, $full_url, $preview_url, time(), $_SERVER['REMOTE_ADDR']))
            return false;
        return $this->db->insertId();
    } 
    
    /**/
    /* обновление инфы: названий групп, альбомов, перенос фоток между альбомами,
        перенос альбомов в другие группы, обновление инфы о фотках
     */
    /**/
    
    /**
     * обновить название группы
     * @param int $group_id -- идентификатор группы
     * @param string $new_title -- новое название для группы
     */ 
    public function updateGroupTitle($group_id, $new_title) {
        if (!$this->db->query("UPDATE `albums` SET `group_title` = ?s WHERE `id` = ?i AND `group_id` = 0", $new_title, $group_id))
            return false;
        return ($this->db->affectedRows() > 0);
    }
    
    /**
     * обновить название альбома
     * @param int $album_id -- идентификатор альбома
     * @param string $new_title -- новое название для альбома
     */ 
    public function updateAlbumTitle($album_id, $new_title) {
        if (!$this->db->query("UPDATE `albums` SET `title` = ?s WHERE `id` = ?i AND `group_id` <> 0", $new_title, $album_id))
            return false;
        return ($this->db->affectedRows() > 0);
    }
    
    /**
     * обновить название фотографии
     * @param int $photo_id -- идентификатор фотографии
     * @param string $new_title -- новое название фотографии
     */ 
    public function updatePhotoTitle($photo_id, $new_title) {
    if (!$this->db->query("UPDATE `photos` SET `title`=?s WHERE `id`=?i", $new_title, $photo_id))
            return false;
        return ($this->db->affectedRows() > 0);    
    }
    
    /**
     * обновить URL-адрес полноразмерной картинки указанной фотографии
     * @param int $photo_id -- Идентификатор обновляемой фотографии
     * @param string $new_full_url -- новый путь к полноразмерному изображению
     */ 
    public function updatePhotoFullURL($photo_id, $new_full_url) {
        if (!$this->db->query("UPDATE `photos` SET `full_url`=?s WHERE `id`=?i", $new_full_url, $photo_id))
            return false;
        return ($this->db->affectedRows() > 0);            
    }
    
    /**
     * обновить URL-адрес превьюшки указанной фотографии
     * @param int $photo_id -- Идентификатор обновляемой фотографии
     * @param string $new_preview_url -- новый путь к превьюшке
     */ 
    public function updatePhotoPreviewURL($photo_id, $new_preview_url) {
        if (!$this->db->query("UPDATE `photos` SET `preview_url`=?s WHERE `id`=?i", $new_preview_url, $photo_id))
            return false;
        return ($this->db->affectedRows() > 0);    
    }
    
    /**
     * обновить комбинированную информацию о фотографии
     * @param int $photo_id -- Идентификатор обновляемой фотографии
     * @param string $new_title -- новое название фотографии
     * @param string $new_full_url -- новый путь к полноразмерному изображению
     * @param string $new_preview_url -- новый путь к превьюшке
     */ 
    public function updatePhoto($photo_id, $new_title, $new_full_url, $new_preview_url) {
        if (!$this->db->query("UPDATE `photos` SET `title`=?s, `full_url`=?s, `preview_url`=?s WHERE `id`=?i", $new_title, $new_full_url, $new_preview_url, $photo_id))
            return false;
        return ($this->db->affectedRows() > 0);    
    }
    
    /* перемещение */
    
    /**
     * переместить указанный альбом в другую группу альбомов
     * @param int $album_id -- идентификатор перемещаемого альбома
     * @param int $new_group_id -- идентификатор группы, куда нужно переместить альбом
     */
    public function moveAlbum($album_id, $new_group_id) {
        if (!$this->db->query("UPDATE `albums` SET `group_id`=?i WHERE `id`=?i", $new_group_id, $album_id)) 
            return false;
        return ($this->db->affectedRows() > 0);   
    }
    
    /**
     * переместить фотографию в другой альбом
     * @param int $photo_id -- идентификатор фотографии
     * @param int $new_album_id -- идентификатор альбома, куда нужно переместить фотографию
     */
    public function movePhoto($photo_id, $new_album_id) {
        if (!$this->db->query("UPDATE `photos` SET `album_id`=?i WHERE `id`=?i", $new_album_id, $photo_id)) 
            return false;
        return ($this->db->affectedRows() > 0);
    }
    
    /**/
    /* удаление инфы: групп, альбомов, фоток. */
    /**/
    
    /**
     * удалить группу и все её альбомы с фотографиями внутри 
     * @param int $group_id -- идентификатор группы
     */
    public function deleteGroup($group_id) {
        $this->db->query("DELETE FROM `photos` WHERE `id` IN (SELECT `id` FROM `albums` WHERE `group_id`=?i)", $group_id);
        $this->db->query("DELETE FROM `albums` WHERE `group_id`=?i", $group_id);
        return $this->db->query("DELETE FROM `albums` WHERE `id`=?i", $group_id);
    }
    
    /**
     * удалить альбом со всеми находящимися в нём фотографиями
     * @param int $album_id
     */
    public function deleteAlbum($album_id) {
        $this->db->query("DELETE FROM `photos` WHERE `album_id`=?i", $album_id);
        return $this->db->query("DELETE FROM `albums` WHERE `id`=?i", $album_id);
    }
    
    /**
     * удалить фотографию
     * @param int $photo_id
     */
    public function deletePhoto($photo_id) {
        return $this->db->query("DELETE FROM `photos` WHERE `id`=?i", $photo_id);
    }
    
    
}
