<?php
use Zepgram\CodeMaker\Str;

?>
<?= "<?xml version=\"1.0\"?>\n" ?>
<routes xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:noNamespaceSchemaLocation="urn:magento:module:Magento_Webapi:etc/webapi.xsd">
    <route url="<?= $url ?>" method="<?= $http_method ?>">
        <service class="<?= $service_class ?>" method="<?= $service_method ?>"/>
        <resources>
            <resource ref="<?= $resource ?>"/>
        </resources>
    </route>
</routes>
