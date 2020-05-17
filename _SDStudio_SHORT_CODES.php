<?php

// ----------------------------------------------------------
// START

// ---- Поиск и замена
//		https://www.isitwp.com/add-rel-lightbox-to-all-images-embedded-in-a-post/

/**
* Обрабатываем iFrame вставленные через Frontend Editor
* Используем v1🔗<iframe >🔗
    * Используем v2 `~<iframe >`~
        * @param $content
        * @return string|string[]|null
        */
        function sdstudio_iframe_replacer_for_frontend_editor( $content ) {

        //    $content = preg_replace_callback('/`~&lt;iframe(.*?)iframe&gt;`~/s', function ($match) {
        $content = preg_replace_callback('/(~@&lt;iframe(.*?)iframe&gt;~@|~@<iframe(.*?)iframe>~@)/s', function ($match) {

        // Если в коде есть спец символы, переведем их в норм. вид
        if (strpos($match[0], '&#038;') !== false || strpos($match[0], '&amp;') !== false || strpos($match[0], '&#39;') !== false ||strpos($match[0], '&gt;') !== false || strpos($match[0], '&quot;') !== false || strpos($match[0], '&lt;') !== false || strpos($match[0], 'p&gt;') !== false){
        $match[0] = html_entity_decode($match[0]);
        }
        $match[0] = preg_replace('/\&\#039\;/','\'',$match[0]);
        $match[0] = str_replace('”','"',$match[0]);
        $match[0] = str_replace('~@','',$match[0]);
        $match[0] = str_replace('`~','',$match[0]);
        $match[0] = str_replace('″','"',$match[0]);
        $match[0] = preg_replace('/’/',"'",$match[0]);

        return $match[0];
        }, $content);

        return $content;
        }
        add_filter( 'the_content', 'sdstudio_iframe_replacer_for_frontend_editor' );



        add_filter('the_content', 'sdstudio_iframe_replacer');
        function sdstudio_iframe_replacer($content) {
        global $post;

        /**
        * Заменяем все iframe на iframe  с отложенной загрузкой
        */
        // Применяем data-iframely-url место src
        $search = '~<iframe[^>]*\K(?=src)~i';
        $replace = 'data-iframely-url-';
        $content = preg_replace($search, $replace, $content);

        // Переименовываем data-iframely-url-src в data-iframely-url
        $search = 'data-iframely-url-src';
        $replace = 'data-iframely-url';
        $content = str_replace($search, $replace, $content);

        //            s($content );

        $search = '/<iframe(.*?)data-iframely-url=(".*?")(.*?)>/i';
        $replace = '<div class="iFrameLazyLoad" style="background:linear-gradient(rgba(0, 0, 0, 0.752), rgba(0, 0, 0, 0.52)), transparent url(/wp-content/plugins/sds-uapa-wpallimp/preloader.svg);left: 0; width: 100%; height: 0; position: relative; padding-bottom: 56.2493%;background-position: 50% 50%;background-repeat: no-repeat;margin-bottom: 25px;"><iframe data-iframely-url=$2 style="border: 0; top: 0; left: 0; width: 100%; height: 100%; position: absolute;" allowfullscreen scrolling="no">';
                $content = preg_replace($search, $replace, $content);

                $search = '/<\/iframe>/i';
                $replace = '</iframe></div>';
        $content = preg_replace($search, $replace, $content);
        return $content;
        }

        // ==============================



        // END
        // ----------------------------------------------------------


        /*🔒🔒*/
        /**
        * Теперь при помощи Frontend Editora достаточно поместить код между 🔒🔒, для того что бы ссылку поместить в social locker
        * //🔒🔒 Здесь ссылка на файл 🔒🔒
        * ~!Здесь ссылка на файл~!
        * ~~~
        * @param $content
        * @return string|string[]|null
        */
        function tcw_the_content_for_social_locker_in_frontend_editor( $content ) {

        //    $content = preg_replace_callback('/🔒🔒(.*?)🔒🔒/s',  function ($match) {
        //    $content = preg_replace_callback('/~`(.*?)~`/s',  function ($match) {
        $content = preg_replace_callback('/~!(.*?)~!/s',  function ($match) {
        //        $match[0] = preg_replace('/\<br \/\>/',"\r\n",$match[0]);
        $match[0] = preg_replace('/~!/',"",$match[0]);
        //        $match[0] = preg_replace('/`~~~/',"",$match[0]);
        $match[0] = preg_replace('/\>(.*?)\</',">Загрузить файл $1<",$match[0]);
    $match[0] = preg_replace('/href/',"target=\"_blank\" href",$match[0]);
    //        $match[0] = html_entity_decode($match[0]);
    //        $match[0] = preg_replace('/”/',"\"",$match[0]);
    //        $match[0] = preg_replace('/‘/',"'",$match[0]);
    //        $match[0] = preg_replace('/’/',"'",$match[0]);
    //        $match[0] = preg_replace('/<\/p>\n<p>/s', "\r\n", $match[0]);
        //        s($match[0]);
        /**
        * FileLocker
        * Обязательно указываем title ссылки в данном формате:
        * [MegaFile SDSL](Nex.zip)
        * То есть в начале тайтл (описание, название файла) далее пробел и "SDSL" (SDSL - SDStudioSocialLocker)
        */
        //        $search = '/\[(.*?)SDSL\]\((.*?)\)/';
        //        $replace = '<div class = "sociallocker"><a href = "'.$actual_link.'/$2" >Загрузить файл  $1</a></div>';
    //        $content = preg_replace($search, $replace, $content);

    return '<div class = "sociallocker">'.$match[0].'</div>';
    }, $content);

    return $content;
    }
    add_filter( 'the_content', 'tcw_the_content_for_social_locker_in_frontend_editor' );