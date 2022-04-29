<?= "<?xml version=\"1.0\"?>\n" ?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:ObjectManager/etc/config.xsd">
    <type name="<?= $target_class ?>">
        <plugin name="<?= $use_snake_case_plugin ?>" type="<?= $use_plugin ?>"/>
    </type>
</config>
