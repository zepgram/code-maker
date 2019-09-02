<?= "<?xml version=\"1.0\"?>\n" ?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:App/etc/routes.xsd">
    <router id="standard">
        <route id="<?= $lower_module ?>_<?= $router ?>" frontName="<?= $router ?>">
            <module name="<?= $module_namespace ?>_<?= $module_name ?>"/>
        </route>
    </router>
</config>
