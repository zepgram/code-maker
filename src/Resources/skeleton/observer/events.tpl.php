<?= "<?xml version=\"1.0\"?>\n" ?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:Event/etc/events.xsd">
  <event name="<?= $event ?>">
    <observer name="<?= $use_snake_case_observer ?>" instance="<?= $use_observer ?>"/>
  </event>
</config>
