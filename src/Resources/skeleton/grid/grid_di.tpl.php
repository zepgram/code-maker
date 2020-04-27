<?= "<?xml version=\"1.0\"?>\n" ?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:ObjectManager/etc/config.xsd">
    <virtualType name="<?= $use_model ?>\Grid\Collection" type="Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult">
        <arguments>
            <argument name="mainTable" xsi:type="string"><?= $table_name ?></argument>
            <argument name="resourceModel" xsi:type="string"><?= $use_collection ?></argument>
        </arguments>
    </virtualType>
    <type name="Magento\Framework\View\Element\UiComponent\DataProvider\CollectionFactory">
        <arguments>
            <argument name="collections" xsi:type="array">
                <item name="<?= $grid_name ?>_grid_data_source" xsi:type="string"><?= $use_model ?>\Grid\Collection</item>
            </argument>
        </arguments>
    </type>
</config>
