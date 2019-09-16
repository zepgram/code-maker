<?= "<?xml version=\"1.0\"?>\n" ?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:ObjectManager/etc/config.xsd">
    <preference for="<?= $use_class_entity_interface ?>" type="<?= $use_class_entity ?>"/>
    <preference for="<?= $name_space_api ?>\<?= $class_entity ?>ManagementInterface" type="<?= $use_class_entity ?>Management"/>
    <preference for="<?= $name_space_api ?>\<?= $class_entity ?>RepositoryInterface" type="<?= $use_class_entity ?>Repository"/>
    <preference for="<?= $name_space_api_data ?>\<?= $class_entity ?>SearchResultsInterface" type="Magento\Framework\Api\SearchResults"/>
</config>
