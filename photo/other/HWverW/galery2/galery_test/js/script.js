$(function() {
    InitAll();
});

function InitAll() {
    makeHoverable();
    initGallery();
    initButtons();
    initUploader();
}

/**/

function makeHoverable() { /* делает альбомы наводящимися подсвечивающимися) */
    var c;
    $(".bl_proj").hover(function() {
        c = $(this).find(".info_proj").css("color");
        $(this).find(".info_proj").css("color", "#fff");
    }, function() {
        $(this).find(".info_proj").css("color", c);
    });
}

function initGallery() {    
    $(".gall_img").magnificPopup({
            type:'image',
            closeOnContentClick: true,
            closeBtnInside: false,
            fixedContentPos: true,
            tClose: 'Закрыть (Esc)',
            tLoading: 'Загрузка...',
            zoom: {
                enabled: true,
                duration: 300 // don't foget to change the duration also in CSS
            },
            gallery: {
                enabled: true,
                tPrev: 'Предыдущее фото (клавиша Стрелка влево)',
                tNext: 'Слеюущее фото (клавиша Стрелка вправо)',
                tCounter: '%curr% из %total%'
            }
         });
}


function initButtons() { /* инициализация нажатий кнопок и других контролов) */
    /* папочки */
    $(".add_folder").click(onAddFolderClick);
    $(".edit_folder").click(onEditFolderClick);
    $(".delete_folder").click(onDeleteFolderClick);
    
    /* альбомчики */
    $(".add_album").click(onAddAlbumClick);
    $(".delete_album").click(onDeleteAlbumClick);
    $(".edit_album_title").click(onEditAlbumTitleClick);
    
    /* фоточки */
    $(".delete_photo").click(onDeletePhotoClick);
}

/*   события по нажатию на что-то (кнопки, например)    */

function onAddFolderClick() {
    if (title = prompt("Введите название для новой папки: ")) {
        cmd("add_folder", {title: title});
    }
}

function onEditFolderClick() { //редактирование папки альбомов.
    span = $(this);
    group_id = span.parent().attr("group_id");
    group_title = span.parent().attr("group_title");
    if (!group_id || !group_title) return false;
    
    if (new_title = prompt("Введите новое название для папки альбомов: ", group_title)) {
        cmd("edit_group_title", {group_id: group_id, group_title: group_title, new_title: new_title});
    }
}

function onDeleteFolderClick() { /* удаление папки альбомов. */
    span = $(this);
    group_id = span.parent().attr("group_id");
    group_title = span.parent().attr("group_title");
    if (!group_id || !group_title) return false;
    
    if (confirm("Вы действительно хотите безвозвратно удалить папку \""+group_title+"\" и все альбомы с фотографиями в ней?")) {
        cmd("delete_group", {group_id: group_id});
    }
}

function onAddAlbumClick() { //добавление альбома в группу
    span = $(this);
    group_id = span.parent().attr("group_id");
    group_title = span.parent().attr("group_title");
    if (!group_id || !group_title) return false;
    
    if (title = prompt('Введите название нового альбома для папки "' +group_title+ '": ')) {
        cmd("add_album", {group_id: group_id, album_title: title});
    }
}

function onDeleteAlbumClick(e) { //удаление альбома!
    e.preventDefault(); //предотвратить переход по ссылке по клику по альбому. 
    btn = $(this);
    
    album_id = btn.attr("album_id");
    album_title = btn.attr("album_title");
    
    if (confirm("Вы действительно хотите безвозвратно удалить альбом \""+album_title+"\" и все фотографии, находящиеся в нём?")) {
        cmd("delete_album", {album_id: album_id});
    } 
}

function onEditAlbumTitleClick(e) { //редактирование названия альбомчика :)
    e.preventDefault(); //предотвратить переход по ссылке по клику по альбому. 
    btn = $(this);
    
    album_id = btn.attr("album_id");
    album_title = btn.attr("album_title");
    
    if (new_title = prompt("Введите новое название для альбома: ", album_title)) {
        cmd("edit_album_title", {album_id: album_id, album_title: album_title, new_title: new_title});
    }
}

function onDeletePhotoClick(e) { /* удаление фотки */
    e.preventDefault();
    
    photo_id = $(this).attr("photo_id");
    
    if (confirm("Вы действительно хотите удалить это фото из этого альбома?")) {
        cmd("delete_photo", {photo_id: photo_id});
    }
}

/*****************************************************************************/

function getCurrentAlbumID() { //получить ID текущего открытого альбома. ДА! Альбом должен быть открыт для того!
    return $("#album_title").attr("album_id");
}

function getCurrentAlbumTitle() { //получить название текущего открытого альбома
    return $("#album_title").attr("album_title");
}

/**************/


function parseResponse(data) {
    if (!data) return false;
    act = data.act;
    
    delete data.act; //удалить поля, которые не нужны уже дальше.
    delete data.srv_time;
    
    switch (act) { //обработка входящей команды.
        case "info": alert("Инфо: " + data.text); break;
        case "error": alert("Ошибка: " + data.text); break;
        //
        case "group_added": onGroupAdded(data); break;
        
        case "group_title_changed": {
            $("#group_" + data.group_id).find(".group_title").text(data.new_title);
        } break;
        
        case "group_deleted": {
            $("#group_" + data.group_id).fadeOut(200, function() {
                $("#group_" + data.group_id).remove();
            });
        } break;
        
        case "album_added": onAlbumAdded(data); break
        
        case "album_title_changed": {
            $("#album_" + data.album_id).find(".album_title").text(data.new_title);
        } break;
        
        case "album_deleted": {
            var a = $("#album_a_" + data.album_id);
            a.fadeOut(200, function() {
                a.remove();
            })
        } break;
        
        case "photo_deleted": {
            $("#img_div_" + data.photo_id).fadeOut(250, function() {
                $("#img_div_" + data.photo_id).remove();
            });
        } break;
        
        case "photo_uploaded": onPhotoUploaded(data); break;
    }
}


/** ответные функции от ответного сервера. сервер в ответе за свои ответы. **/


function onPhotoUploaded(data) {
    div = $('<div class="bl_proj" id="img_div_'+data.photo_id+'"></div>');
    div.append($('<div class="del delete_photo" photo_id="'+data.photo_id+'">X</div>').click(onDeletePhotoClick));
    div.append('<img class="gall_img" src="'+data.preview_url+'" data-mfp-src="'+data.full_url+'" />');
    
    div.insertBefore(".upload");
}

function onGroupAdded(data) { //когда добавлена новая папочка.
    m_div = $('<div class="folder group" id="group_'+data.group_id+'" group_id="'+data.group_id+'"></div>');
    div = $("<div class='port'></div>");
    d2 = $("<div class='fn_proj' id='group_"+data.group_id+"' group_id='"+data.group_id+"' group_title='"+data.group_title+"'></div>");
    
    d2.append('<span class="group_title">' + data.group_title + '</span>'); 
    d2.append($('<span class="btn_control edit_folder">Редактировать</span>').click(onEditFolderClick));
    d2.append($('<span class="btn_control delete_folder">Удалить</span>').click(onDeleteFolderClick));
    d2.append($('<span class="btn_control add_album">Добавить альбом</span>').click(onAddAlbumClick));
    
    div.append(d2);      
    m_div.append(div);
    $(".projects").append(m_div);
}

function onAlbumAdded(data) {
    a = $('<a id="album_a_'+data.album_id+'" href="?a=v&album='+data.album_id+'" title="Нажмите, что бы просмотреть фотографии в этом альбоме."></a>');
    
    div = $('<div class="bl_proj empty_preview" album_id="'+data.album_id+'"></div>');
    div.append($('<div class="info_proj" id="album_'+data.album_id+'"><span class="album_title">'+data.album_title+'</span></div>').append(
        $('<span class="edit edit_album_title" album_id="'+data.album_id+'" album_title="'+data.album_title+'">Edit</span>').click(onEditAlbumTitleClick)
    ));
    div.append($('<div class="del delete_album" album_id="'+data.album_id+'" album_title="'+data.album_title+'">X</div>').click(onDeleteAlbumClick));
    
    a.append(div);                       
                    
    $("#group_" + data.group_id).append(a);
}

/***********/




function postJSON(url, data, callback) {
    $.post(url, data, function(data) {
        if (!data) return false;
        
        for(i=0; i<data.length; i++) //парсинг всех ответов
            parseResponse(data[i]);
            
        if (callback)
            callback(data);
            
    }, "json").fail(function() {
        alert("Ошибка при получении json-данных в ajax-запросе.");
    });
};

function cmd(acmd, params, callback, noClearStatuses) {
    if (!params) {
        params = {}
    }
    params.act = acmd;
    postJSON("provider.php", params, callback);
}

function initUploader() {
    $(".upload").dmUploader({
        url: 'provider.php',
        dataType: 'json',
        allowedTypes: 'image/*',
        extraData: {"act": "upload_photo", album_id: getCurrentAlbumID()},
        onInit: function() {
              
        },
        onBeforeUpload: function(id){
            
        },
        onUploadProgress: function(id, percent, count){
            var percentStr = percent + '%';
            $(".upload").find(".status").text(percentStr);
        },
        onUploadSuccess: function(id, data){ 
            for(i=0; i<data.length; i++)
                parseResponse(data[i]);
        },
        onUploadError: function(id, message){
          alert("Ошибка при загрузке изображения: " + message);
        },
      });
}