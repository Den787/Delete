$(document).ready(function(){
// Выполняется при загрузке страницы
    var preventClick=false;
    $(".pic a").bind("click",function(e){

        if(preventClick)
        {
            e.stopImmediatePropagation();
            e.preventDefault();
        }
    });

    $(".pic").draggable({

        /* Преобразовуем изображения в объекты, которые можно переносить */
        containment: 'parent',
        start: function(e,ui){
            /* Во время переноса будут отключены клики */
            preventClick=true;
        },
        stop: function(e, ui) {
            /* Подождать 250 милисекунд перед включением возможности кликать вновь */
            setTimeout(function(){ preventClick=false; }, 250);
        }
    });

    $('.pic').mousedown(function(e){
        /* Executed on image click */
        var maxZ = 0;

        /* Найти максимальное свойство z-index: */
        $('.pic').each(function(){
            var thisZ = parseInt($(this).css('zIndex'))
            if(thisZ>maxZ) maxZ=thisZ;
        });

        if($(e.target).hasClass("pic"))
        {
            /* Показать кликнутое изображение поверх всех остальных : */
            $(e.target).css({zIndex:maxZ+1});
        }
        else $(e.target).closest('.pic').css({zIndex:maxZ+1});
    });

    /* Преобразуем все ссылки для ссылок лайтбокса */
    $("a.fancybox").fancybox({
        zoomSpeedIn: 300,
        zoomSpeedOut: 300,
        overlayShow:false
    });

    $('.drop-box').droppable({
        hoverClass: 'active',
        drop:function(event,ui){

            $('#url').val(location.href.replace(location.hash,'')+'#' + ui.draggable.attr('id'));
            $('#modal').dialog('open');
        }
    });

    /* Преобразовует div с id="modal" в модальное окно */
    $("#modal").dialog({
        bgiframe: true,
        modal: true,
        autoOpen:false,

        buttons: {
            Ok: function() {
                $(this).dialog('close');
            }
        }
    });

    if(location.hash.indexOf('#pic-')!=-1)
    {

        $(location.hash+' a.fancybox').click();
    }
});