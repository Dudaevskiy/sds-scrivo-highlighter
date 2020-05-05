<?php
require_once('vendor/autoload.php');

$hl = new \Highlight\Highlighter();
$hl->setAutodetectLanguages(array('ruby', 'python', 'perl'));
$MyCode = '


<pre data-initialized="true" data-gclp-id="0"><code>add_filter( \'wpcf7_form_elements\', \'delicious_wpcf7_form_elements\' );

function delicious_wpcf7_form_elements( $form ) {
$form = do_shortcode( $form );
return $form;
}</code></pre>

';
// $highlighted = $hl->highlightAuto(file_get_contents('some_ruby_script.rb'));
$highlighted = $hl->highlightAuto($MyCode);

echo '<pre><code class=\"hljs {$highlighted->language}\">";
echo $highlighted->value;
echo "</code></pre>";