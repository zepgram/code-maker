<?php
use Zepgram\CodeMaker\Str;

?>
<?= "<?xml version=\"1.0\"?>\n" ?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:module:Magento_Config:etc/system_file.xsd">
    <system>
        <?php if ($is_new_section): ?>
        <tab id="<?= $section ?>" translate="label">
            <label><?= Str::getPhraseUcWord($section) ?></label>
        </tab>
        <?php endif; ?>
        <section id="<?= $section ?>" translate="label" type="text" showInDefault="1" showInWebsite="1" showInStore="1">
            <?php if ($is_new_section): ?>
            <label><?= Str::getPhraseUcWord($section) ?></label>
            <tab><?= $section ?></tab>
            <resource><?= $resource_id ?></resource>
            <?php endif; ?>
            <group id="<?= $group ?>" translate="label" type="text" sortOrder="5" showInDefault="1" showInWebsite="1" showInStore="1">
                <label><?= Str::getPhraseUcWord($group) ?></label>
                <?php foreach ($option_fields as $field => $options): ?>
                <field id="<?= $field ?>" translate="label comment" type="<?= $options['type'] ?>" showInDefault="1" showInWebsite="1" showInStore="1">
                    <label><?= Str::getPhraseUcWord($field) ?></label>
                    <?php if ($options['comment'] !== null): ?>
                    <comment><?= Str::getPhrase($options['comment']) ?></comment>
                    <?php endif; ?>
                </field>
                <?php endforeach; ?>
            </group>
        </section>
    </system>
</config>
