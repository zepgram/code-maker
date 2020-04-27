<?php
use Zepgram\CodeMaker\Str;

?>
<?= "<?xml version=\"1.0\"?>\n" ?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:Acl/etc/acl.xsd">
    <acl>
        <resources>
            <resource id="Magento_Backend::admin">
                <resource id="<?= $module_namespace ?>_<?= $module_name ?>::parent" title="<?= Str::getPhraseUcWord($module_namespace.'_'.$module_name) ?>" sortOrder="10">
                    <resource id="<?= $module_namespace ?>_<?= $module_name ?>::<?= $table_name ?>" title="<?= Str::getPhraseUcWord($table_name) ?>" translate="title"/>
                </resource>
            </resource>
        </resources>
    </acl>
</config>
