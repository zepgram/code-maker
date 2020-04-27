<?php
use Zepgram\CodeMaker\Str;
$module_name = $module_namespace.'_'.$module_name;
$title = Str::getPhraseUcWord($module_name);
$table_title = Str::getPhraseUcWord($table_name);
?>
<?= "<?xml version=\"1.0\"?>\n" ?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:module:Magento_Backend:etc/menu.xsd">
    <menu>
        <add id="<?= $module_name ?>::parent" title="<?= $title ?>" sortOrder="10"
             module="<?= $module_name ?>" dependsOnModule="<?= $module_name ?>"
             resource="<?= $module_name ?>::parent" />
        <add id="<?= $module_name ?>::<?= $table_name ?>" title="<?= $table_title ?>" sortOrder="20"
             module="<?= $module_name ?>" dependsOnModule="<?= $module_name ?>"
             parent="<?= $module_name ?>::parent"
             action="<?= $router ?>/<?= Str::asSnakeCase($controller) ?>"
             resource="<?= $module_name ?>::<?= $table_name ?>" />
    </menu>
</config>
