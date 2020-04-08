<?= "<?xml version=\"1.0\"?>\n" ?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:ObjectManager/etc/config.xsd">
    <preference for="<?= $use_entity_interface ?>" type="<?= $use_entity ?>"/>
    <preference for="<?= $use_entity_management_interface ?>" type="<?= $use_entity_management ?>"/>
    <preference for="<?= $use_entity_repository_interface ?>" type="<?= $use_entity_repository ?>"/>
    <preference for="<?= $use_search_results_interface ?>" type="Magento\Framework\Api\SearchResults"/>
</config>
