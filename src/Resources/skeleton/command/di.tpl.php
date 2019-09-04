<?= "<?xml version=\"1.0\"?>\n" ?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:ObjectManager/etc/config.xsd">
  <type name="Magento\Framework\Console\CommandListInterface">
    <arguments>
      <argument name="commands" xsi:type="array">
        <item name="<?= $class_command_node ?>" xsi:type="object"><?= $use_command ?></item>
      </argument>
    </arguments>
  </type>
</config>
