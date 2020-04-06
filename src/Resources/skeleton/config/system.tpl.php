<?php
use Zepgram\CodeMaker\FormatString;

?>
<?= "<?xml version=\"1.0\"?>\n" ?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:module:Magento_Config:etc/system_file.xsd">
    <system>
        <?php if ($is_new_tab): ?>
        <tab id="<?= $section ?>" translate="label">
            <label><?= FormatString::getPhraseUcWord($section) ?></label>
        </tab>
        <?php endif; ?>
        <section id="<?= $section ?>" translate="label" type="text" showInDefault="1" showInWebsite="1" showInStore="1">
            <label><?= FormatString::getPhraseUcWord($section) ?></label>
            <tab><?= $section ?></tab>
            <resource><?= $resource_id ?></resource>
            <group id="<?= $group ?>" translate="label" type="text" sortOrder="5" showInDefault="1" showInWebsite="1" showInStore="1">
                <label><?= FormatString::getPhraseUcWord($group) ?></label>
                <?php foreach ($config_fields as $field => $options): ?>
                <field id="<?= $field ?>" translate="label comment" type="<?= $options['type'] ?>" showInDefault="1" showInWebsite="1" showInStore="1">
                    <label><?= FormatString::getPhraseUcWord($field) ?></label>
                    <?php if ($options['comment'] !== null): ?>
                    <comment><?= FormatString::getPhrase($options['comment']) ?></comment>
                    <?php endif; ?>
                </field>
                <?php endforeach; ?>
            </group>
        </section>
    </system>
</config>
