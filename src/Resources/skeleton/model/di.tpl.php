<?= "<?xml version=\"1.0\"?>\n" ?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:ObjectManager/etc/config.xsd">
<?php if (isset($generate_grid)): ?>
    <virtualType name="<?= $use_model ?>\Grid\Collection" type="Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult">
        <arguments>
            <argument name="mainTable" xsi:type="string"><?= $table_name ?></argument>
            <argument name="resourceModel" xsi:type="string"><?= $use_resource ?></argument>
        </arguments>
    </virtualType>
    <type name="Magento\Framework\View\Element\UiComponent\DataProvider\CollectionFactory">
        <arguments>
            <argument name="collections" xsi:type="array">
                <item name="<?= $grid_name ?>_grid_data_source" xsi:type="string"><?= $use_model ?>\Grid\Collection</item>
            </argument>
        </arguments>
    </type>
<?php endif; ?>
<?php if (isset($use_entity_interface)): ?>
    <preference for="<?= $use_entity_interface ?>" type="<?= $use_entity ?>"/>
    <preference for="<?= $use_entity_management_interface ?>" type="<?= $use_entity_management ?>"/>
    <preference for="<?= $use_entity_repository_interface ?>" type="<?= $use_entity_repository ?>"/>
    <preference for="<?= $use_search_results_interface ?>" type="Magento\Framework\Api\SearchResults"/>
<?php endif; ?>
</config>
