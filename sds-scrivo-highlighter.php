<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://sdstudio.top
 * @since             1.0.0
 * @package           Sds_Scrivo_Highlighter
 *
 * @wordpress-plugin
 * Plugin Name:       SDStudio scrivo highlight'er
 * Plugin URI:        https://techblog.sdstudio.top
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.1
 * Author:            Serhii Dudchenko
 * Author URI:        https://sdstudio.top
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sds-scrivo-highlighter
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SDS_SCRIVO_HIGHLIGHTER_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-sds-scrivo-highlighter-activator.php
 */
function activate_sds_scrivo_highlighter() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sds-scrivo-highlighter-activator.php';
	Sds_Scrivo_Highlighter_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-sds-scrivo-highlighter-deactivator.php
 */
function deactivate_sds_scrivo_highlighter() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sds-scrivo-highlighter-deactivator.php';
	Sds_Scrivo_Highlighter_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_sds_scrivo_highlighter' );
register_deactivation_hook( __FILE__, 'deactivate_sds_scrivo_highlighter' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-sds-scrivo-highlighter.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_sds_scrivo_highlighter() {

	$plugin = new Sds_Scrivo_Highlighter();
	$plugin->run();
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio_SHORT_CODES.php';
}
run_sds_scrivo_highlighter();



/**
 * ==================================================
 * ==================================================
 * ==================================================
 * _scrivo_highlight/vendor/scrivo/highlight_php/styles/androidstudio.css
 */

/**
 * И обрабатываем блоки кода только в случае если сайт просматривается пользователями.
 * Для редактора и администратора, отключаем обработку.
 */
include_once(ABSPATH . 'wp-includes/pluggable.php');
//|| current_user_can( 'editor' ) === false
if (current_user_can( 'administrator' ) === false ) {
    add_action('init', 'register_script');
    function register_script()
    {

        wp_register_script('highlight', plugins_url('/_scrivo_highlight/highlight/highlight.min.js', __FILE__));
        wp_register_script('highlightjs-line-numbers', plugins_url('/_scrivo_highlight/highlightjs-line-numbers/highlightjs-line-numbers.min.js', __FILE__));

        wp_register_script('toastr', plugins_url('/_copy_code/toastr.min.js', __FILE__));
        wp_register_script('SDStudio_clipboard', plugins_url('/_copy_code/clipboard.min.js', __FILE__));
        wp_register_script('SDStudio_copy_script', plugins_url('/_copy_code/__SDStudio_copy_script.js', __FILE__));


//    wp_register_style( 'androidstudio', plugins_url('/_scrivo_highlight/vendor/scrivo/highlight_php/styles/androidstudio.css', __FILE__), false, '1.0.0', 'all');
        wp_register_style('atom-one-dark', plugins_url('/_scrivo_highlight/vendor/scrivo/highlight_php/styles/atom-one-dark.css', __FILE__), false, '1.0.0', 'all');

        wp_register_style('toastr_css', plugins_url('/_copy_code/toastr.min.css', __FILE__), false, '1.0.0', 'all');
        wp_register_style('monokai_sublime', plugins_url('/_copy_code/monokai_sublime.min.css', __FILE__), false, '1.0.0', 'all');
    }

// use the registered jquery and style above
    add_action('wp_enqueue_scripts', 'enqueue_style');

    function enqueue_style()
    {
        wp_enqueue_script('highlight');
        wp_enqueue_script('highlightjs-line-numbers');
        wp_enqueue_script('toastr');
        wp_enqueue_script('SDStudio_clipboard');
        wp_enqueue_script('SDStudio_copy_script');

//    wp_enqueue_style( 'androidstudio' );
        wp_enqueue_style('atom-one-dark');

        wp_enqueue_style('toastr_css');
        wp_enqueue_style('monokai_sublime');
    }

    require_once plugin_dir_path(__FILE__) . '_scrivo_highlight/vendor/autoload.php';


    /**
     * PRE FEE
     */
    global $num_id;
    $num_id = 0;

    /**
     * WP Githuber MD
     * Автоматически вставим (а точнее подготовим) снипеты кода вставленные через редактор WP Githuber MD на стороне админки,
     * в наш снипет
     */
    function pre_SDStudio_fee_PRE_for_Markdown_MD_create($content)
    {
        $content = preg_replace_callback('/<pre><code class=\"language-(.*?)>(.*?)<\/code><\/pre>/s', function ($match) {

            // Если в коде есть спец символы, переведем их в норм. вид
            if (strpos($match[2], '&#038;') !== false || strpos($match[2], '&#8216;') !== false || strpos($match[2], '&#8211;') !== false || strpos($match[2], '&amp;') !== false || strpos($match[2], '&#39;') !== false || strpos($match[2], '&gt;') !== false || strpos($match[2], '&quot;') !== false || strpos($match[2], '&lt;') !== false || strpos($match[2], 'p&gt;') !== false) {
                $match[2] = preg_replace('/\&\#039\;/', '\'', $match[2]);
                $match[2] = preg_replace('/\&\lt\;/', '<', $match[2]);
                $match[2] = html_entity_decode($match[2]);
            }


            return '<pre class="SDStudio-fee-PRE-create" ><code>' . $match[2] . '</code></pre>';
        }, $content);
        return $content;
    }

    add_filter('the_content', 'pre_SDStudio_fee_PRE_for_Markdown_MD_create');

    /**
     * Счетчики для уникальных ID
     */
    global $num_id;
    $num_id = 0;

    /**
     * Frontend Editor
     * Обрабатываем код который был вставлен с фронтенда <pre class="language-SDStudio-hot-key-frontend">*</pre>
     * Горячие клавиши для вставки код Alt+P
     */
    function pre_SDStudio_fee_PRE_for_Frontend_Editor_create($content)
    {
        $content = preg_replace_callback('/<pre class=\"language-SDStudio-hot-key(.*?)>(.*?)<\/pre>/s', function ($match) {

            $match[2] = preg_replace('/\<br \/\>/', "\r\n", $match[2]);

            // Если в коде есть спец символы, переведем их в норм. вид
            // Если в коде есть спец символы, переведем их в норм. вид
            if (strpos($match[0], '&#8216;') !== false || strpos($match[2], '&amp;') !== false || strpos($match[2], '&#39;') !== false || strpos($match[2], '&gt;') !== false || strpos($match[2], '&quot;') !== false || strpos($match[2], '&lt;') !== false || strpos($match[2], 'p&gt;') !== false) {
                $match[2] = preg_replace('/\&\#039\;/', '\'', $match[2]);
                $match[2] = preg_replace('/\&\#039\;/', '\'', $match[2]);
                $match[2] = preg_replace('/\&\lt\;/', '<', $match[2]);
                $match[2] = html_entity_decode($match[2]);
                //        s($match[2]);
            }
//        $match[2] = html_entity_decode($match[2]);
//        s($match[2]);

            $hl = new \Highlight\Highlighter();
            $hl->setAutodetectLanguages(array('JavaScript', 'php', 'css', 'html', 'perl'));
//        s($match[2]);
            $highlighted = $hl->highlightAuto($match[2]);
//        s($highlighted);
            $highlighted_code = $highlighted->value;
            $highlighted_class = $highlighted->language;

            global $num_id;
            $num_id++;

            return '<div class="sds-scrivo-highlighter"><pre><div class="btn-copy" data-clipboard-target="#sds-fee-scrivo-' . $num_id . '" data-tooltip-sds-scrivo-highlighter="Скопировать код" ></div><code class="hljs ' . $highlighted_class . '" id="sds-fee-scrivo-' . $num_id . '">' . $highlighted_code . '</code></pre></div>';

        }, $content);


        return $content;

    }

    add_filter('the_content', 'pre_SDStudio_fee_PRE_for_Frontend_Editor_create');


    /**
     * Pars
     * Обрабатываем блоки вставленного кода в таком виде
     * <pre class="SDStudio-fee-PRE-create"
     */
    function pre_SDStudio_fee_PRE_create($content)
    {

        $content = preg_replace_callback('/<pre class=\"SDStudio-fee-PRE-create\"(.*?)><code>(.*?)<\/code><\/pre>/s', function ($match) {
//s('1️⃣'.$match[2] );
            $match[2] = preg_replace('/\<br \/\>/', "\r\n", $match[2]);


            $hl = new \Highlight\Highlighter();
            $hl->setAutodetectLanguages(array('python', 'php', 'css', 'html', 'perl'));
            $highlighted = $hl->highlightAuto($match[2]);
            $highlighted_code = $highlighted->value;
            $highlighted_class = $highlighted->language;


            $highlighted_code = html_entity_decode($highlighted_code);

//            return '<pre><code class=\"hljs \">' . $hl->highlightAuto($match[1]) . '</code></pre>';
            global $num_id;
            $num_id++;
            //s($num_id);
//s('2️⃣Вывод - '.$highlighted_code);
            return '<div class="sds-scrivo-highlighter"><pre><div class="btn-copy" data-clipboard-target="#sds-fee-scrivo-' . $num_id . '" data-tooltip-sds-scrivo-highlighter="Скопировать код" ></div><code class="hljs ' . $highlighted_class . '" id="sds-fee-scrivo-' . $num_id . '">' . $highlighted_code . '</code></pre></div>';
        }, $content);


        return $content;
    }

//add_filter( 'the_content', 'pre_SDStudio_fee_PRE_create' );


    /**
     * PRE
     */

    function tcw_the_content($content)
    {
//    dd($content);

        $content = preg_replace_callback('/<pre(.*?)><code(.*?)>(.*?)<\/code><\/pre>/s', function ($match) {

            $match[3] = preg_replace('/\<br \/\>/', "\r\n", $match[3]);
//s('1️⃣'.$match[2] );

            // Если в коде есть спец символы, переведем их в норм. вид
            // Если в коде есть спец символы, переведем их в норм. вид
            if (strpos($match[3], '&#038;') !== false || strpos($match[3], '&#8216;') !== false || strpos($match[3], '&#8211;') !== false || strpos($match[3], '&amp;') !== false || strpos($match[3], '&#39;') !== false || strpos($match[3], '&gt;') !== false || strpos($match[3], '&quot;') !== false || strpos($match[3], '&lt;') !== false || strpos($match[3], 'p&gt;') !== false) {
                $match[3] = preg_replace('/\&\#039\;/', '\'', $match[3]);
                $match[3] = preg_replace('/\&\lt\;/', '<', $match[3]);
                $match[3] = html_entity_decode($match[3]);
            }


            $hl = new \Highlight\Highlighter();
            $hl->setAutodetectLanguages(array('python', 'php', 'css', 'html', 'perl'));
            $highlighted = $hl->highlightAuto($match[3]);
            $highlighted_code = $highlighted->value;

            $highlighted_class = $highlighted->language;

            global $num_id;
            $num_id++;
//        s($highlighted_code);
//s('2️⃣Вывод - '.$highlighted_code);
            return '<div class="sds-scrivo-highlighter"><pre><div class="btn-copy" data-clipboard-target="#sds-scrivo-' . $num_id . '" data-tooltip-sds-scrivo-highlighter="Скопировать код" ></div><code class="hljs ' . $highlighted_class . '" id="sds-scrivo-' . $num_id . '">' . $highlighted_code . '</code></pre></div>';
        }, $content);

        return $content;
    }

    add_filter('the_content', 'tcw_the_content');

    /**
     * Теперь при помощи Frontend Editora достаточно поместить код между 📌📌, он автоматически будет обработан плагином
     * ~ Здесь пишем код ~
     * @param $content
     * @return string|string[]|null
     */
    function tcw_the_content_for_pre_in_frontend_editor($content)
    {

//        $content = preg_replace_callback('/📌📌(.*?)📌📌/s',  function ($match) {
        $content = preg_replace_callback('/\~\~(.*?)\~\~/s', function ($match) {


            $match[0] = preg_replace('/\<br \/\>/', "\r\n", $match[0]);
            $match[0] = preg_replace('/\~\~/', "", $match[0]);
            // Не срабатывает
//            $match[0] = preg_replace('/<!–/',"<!–-",$match[0]);
//            $match[0] = preg_replace('/ –>/'," -–>",$match[0]);

            // Если в коде есть спец символы, переведем их в норм. вид
            if (strpos($match[0], '&#038;') !== false || strpos($match[0], '&#8216;') !== false || strpos($match[0], '&#8211;') !== false || strpos($match[0], '&amp;') !== false || strpos($match[0], '&#39;') !== false || strpos($match[0], '&gt;') !== false || strpos($match[0], '&quot;') !== false || strpos($match[0], '&lt;') !== false || strpos($match[0], 'p&gt;') !== false) {
                $match[0] = html_entity_decode($match[0]);
//                $match[0] = preg_replace('/\&\#039\;/','\'',$match[0]);
                // HTML comments
//                $match[0] = preg_replace('/\&\#8211\;/','--',$match[0]);
//                $match[0] = preg_replace('/\&\#8211\;/','-',$match[0]);
//                $match[0] = preg_replace('/\&\lt\;/','<',$match[0]);
//                $match[0] = preg_replace('/\&\gt\;/','>',$match[0]);

//                $match[0] = html_entity_decode($match[0]);

            }

//            s($match[0] );
            // Если в коде есть спец символы, переведем их в норм. вид
            $match[0] = preg_replace('/\<!\– /', '<!–- ', $match[0]);
            $match[0] = preg_replace('/\ –>/', ' –->', $match[0]);
            $match[0] = preg_replace('/\ –>/', ' –->', $match[0]);

            $match[0] = preg_replace('/”/', "\"", $match[0]);
            $match[0] = preg_replace('/“/', "\"", $match[0]);
            $match[0] = preg_replace('/‘/', "'", $match[0]);
            $match[0] = preg_replace('/’/', "'", $match[0]);
            $match[0] = preg_replace('/′/', "'", $match[0]);
            $match[0] = preg_replace('/″/', "\"", $match[0]);
            $match[0] = preg_replace('/<\/p>\n<p>/s', "\r\n", $match[0]);
//            s($match[0]);


            $hl = new \Highlight\Highlighter();
            $hl->setAutodetectLanguages(array('python', 'php', 'css', 'html', 'perl'));
            $highlighted = $hl->highlightAuto($match[0]);
            $highlighted_code = $highlighted->value;

//        s($highlighted_code);


            $highlighted_class = $highlighted->language;

            global $num_id;
            $num_id++;
            //s($highlighted_code);
            return '<div class="sds-scrivo-highlighter"><pre><div class="btn-copy" data-clipboard-target="#sds-scrivo-' . $num_id . '" data-tooltip-sds-scrivo-highlighter="Скопировать код" ></div><code class="hljs ' . $highlighted_class . '" id="sds-scrivo-' . $num_id . '">' . $highlighted_code . '</code></pre></div>';
        }, $content);

        return $content;
    }

    add_filter('the_content', 'tcw_the_content_for_pre_in_frontend_editor');


    /**
     * CODE
     */
    global $num_id_for_code;
    $num_id_for_code = 0;
    function sdstudio_code_content($content)
    {
        $content = preg_replace_callback('/<code>(.*?)<\/code>/s', function ($match) {

            global $num_id_for_code;
            $num_id_for_code++;


            $hl = new \Highlight\Highlighter();
            //$hl->setAutodetectLanguages(array( 'python','php', 'css','html'));
            $highlighted = $hl->highlightAuto($match[1]);
            $highlighted_code = $highlighted->value;
            $highlighted_code = wp_specialchars_decode($highlighted_code);
            $highlighted_code_stock = wp_specialchars_decode($match[1]);
            $highlighted_class = $highlighted->language;

//            return '<pre><code class=\"hljs \">' . $hl->highlightAuto($match[1]) . '</code></pre>';

//        return '<div class="sds-scrivo-highlighter"><pre><div class="btn-copy" data-title="Скопировано"></div><code class="hljs '.$highlighted_class.'">' . $highlighted_code . '</code></pre></div>';
            //s($highlighted_code);
            return '<code class="hljs sds-scrivo-highlighter-code" id="sds-scrivo-code-' . $num_id_for_code . '" data-clipboard-target="#sds-scrivo-code-' . $num_id_for_code . '">' . $highlighted_code . '</code>';
//        return '<div class="sds-scrivo-highlighter-code"><code class="hljs">' . $highlighted_code_stock . '</code></div>';
        }, $content);
        //$content = preg_replace( '/`(.*?)`/', '<code>$1</code>', $content );
        //s($highlighted_code);
        return $content;
    }

    add_filter('the_content', 'sdstudio_code_content');
}

//_SDStudio_SHORT_CODES.php
//$id = 10069;
//$getpostdata = get_postdata(10069);
//dd($getpostdata);







