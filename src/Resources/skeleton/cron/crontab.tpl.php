<?= "<?xml version=\"1.0\"?>\n" ?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:module:Magento_Cron:etc/crontab.xsd">
    <group id="default">
        <job name="<?= $observer_snake_case ?>" instance="<?= $use_observer ?>" method="execute">
            <schedule><?= $schedule ?></schedule>
        </job>
    </group>
</config>
