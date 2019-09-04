<?= "<?xml version=\"1.0\"?>\n" ?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:App/etc/routes.xsd">
  <router id="<?= $router_id ?>">
    <route id="<?= $route_id ?>" frontName="<?= $router ?>">
        <module<?= $router_id === 'admin' ? ' before="Magento_Backend"': '' ?> name="<?= $module_namespace ?>_<?= $module_name ?>"/>
    </route>
  </router>
</config>
