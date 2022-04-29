<?= "<?xml version=\"1.0\"?>\n" ?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:ObjectManager/etc/config.xsd">
    <virtualType name="<?= $logger_handler ?>" type="Magento\Framework\Logger\Handler\Base">
        <arguments>
            <argument name="filesystem" xsi:type="object">Magento\Framework\Filesystem\Driver\File</argument>
            <argument name="fileName" xsi:type="string">var/log/<?= $lower_namespace ?>/<?= $filename ?>.log</argument>
        </arguments>
    </virtualType>
    <virtualType name="<?= $logger_class ?>" type="Magento\Framework\Logger\Monolog">
        <arguments>
            <argument name="handlers" xsi:type="array">
                <item name="system" xsi:type="object"><?= $logger_handler ?></item>
            </argument>
        </arguments>
    </virtualType>
</config>
