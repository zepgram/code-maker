<?= "<?xml version=\"1.0\"?>\n" ?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:module:Magento_Store:etc/config.xsd">
    <default>
        <<?= $section ?>>
            <<?= $group ?>>
                <?php foreach ($config_fields as $field => $options): ?>
                <<?= $field ?>><?= $options['default_value'] ?></<?= $field ?>>
                <?php endforeach; ?>
            </<?= $group ?>>
        </<?= $section ?>>
    </default>
</config>
