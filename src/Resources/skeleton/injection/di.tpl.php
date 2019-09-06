<?= "<?xml version=\"1.0\"?>\n" ?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:ObjectManager/etc/config.xsd">
  <type name="<?= $class_injection ?>">
    <arguments>
      <argument name="<?= $parameter ?>" xsi:type="object"><?= $injected_class ?></argument>
    </arguments>
  </type>
</config>
