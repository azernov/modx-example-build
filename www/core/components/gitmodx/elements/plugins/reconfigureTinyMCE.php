<?php
/**
 * Плагин, дополняющий конфигурацию TinyMCE в админке
 * TODO замените javascript на свой и добавьте плагин в файл plugins.inc.php
 */
if($modx->event->name != 'OnRichTextEditorRegister') return;

$modx->regClientStartupScript(<<<SCRIPT
<script>
    Tiny.config.extend_valid_elements = "+@[data-tooltip]";
</script>
SCRIPT
    ,true);