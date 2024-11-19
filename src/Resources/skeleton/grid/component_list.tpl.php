<?php
use Zepgram\CodeMaker\Str;

$provider = $grid_name . '_list.' . $grid_name . '_grid_data_source';
?>
<?= "<?xml version=\"1.0\"?>\n" ?>
<listing xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:module:Magento_Ui:etc/ui_configuration.xsd">
    <argument name="data" xsi:type="array">
        <item name="js_config" xsi:type="array">
            <item name="provider" xsi:type="string"><?= $provider ?></item>
        </item>
    </argument>
    <settings>
        <spinner><?= $grid_name ?>_list_columns</spinner>
        <deps>
            <dep><?= $provider ?></dep>
        </deps>
    </settings>
    <dataSource name="<?= $grid_name . '_grid_data_source' ?>" component="Magento_Ui/js/grid/provider">
        <settings>
            <updateUrl path="mui/index/render"/>
        </settings>
        <aclResource><?= $module_namespace ?>_<?= $module_name ?>::<?= $table_name ?></aclResource>
        <dataProvider class="Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider"
                      name="<?= $grid_name . '_grid_data_source' ?>">
            <settings>
                <requestFieldName>id</requestFieldName>
                <primaryFieldName><?= $primary_key ?></primaryFieldName>
            </settings>
        </dataProvider>
    </dataSource>
    <listingToolbar name="listing_top">
        <settings>
            <sticky>true</sticky>
        </settings>
        <paging name="listing_paging"/>
        <columnsControls name="columns_controls"/>
        <exportButton name="export_button"/>
        <filters name="listing_filters"/>
    </listingToolbar>
    <columns name="<?= $grid_name ?>_list_columns">
        <selectionsColumn name="ids">
            <settings>
                <indexField><?= $primary_key ?></indexField>
            </settings>
        </selectionsColumn>
        <column name="<?= $primary_key ?>">
            <settings>
                <filter>text</filter>
                <label translate="true"><?= Str::getPhraseUcWord($primary_key) ?></label>
                <sorting>desc</sorting>
            </settings>
        </column>
<?php foreach ($option_fields as $field => $option):
    $dbType = $option['db_type'];
    $field = Str::asSnakeCase($field);
    $comment = Str::getPhraseUcWord($field);
    ?>
<?php switch ($dbType):
        case 'date': ?>
        <column name="<?= $field ?>" class="Magento\Ui\Component\Listing\Columns\Date" component="Magento_Ui/js/grid/columns/date">
            <settings>
                <timezone>false</timezone>
                <dateFormat>MMM d, y</dateFormat>
                <skipTimeZoneConversion>true</skipTimeZoneConversion>
                <filter>dateRange</filter>
                <dataType>date</dataType>
                <label translate="true"><?= $comment ?></label>
            </settings>
        </column>
<?php break; ?>
<?php
case 'timestamp':
case 'timestamp_on_update': ?>
        <column name="<?= $field ?>" class="Magento\Ui\Component\Listing\Columns\Date" component="Magento_Ui/js/grid/columns/date">
            <settings>
                <filter>dateRange</filter>
                <dataType>date</dataType>
                <label translate="true"><?= $comment ?></label>
            </settings>
        </column>
<?php break; ?>
<?php
case 'boolean': ?>
        <column name="<?= $field ?>" component="Magento_Ui/js/grid/columns/select">
            <settings>
                <options class="Magento\Config\Model\Config\Source\Yesno"/>
                <filter>select</filter>
                <editor>
                    <editorType>select</editorType>
                </editor>
                <dataType>select</dataType>
                <label translate="true"><?= $comment ?></label>
            </settings>
        </column>
<?php break; ?>
<?php default: ?>
        <column name="<?= $field ?>">
            <settings>
                <filter>text</filter>
                <label translate="true"><?= $comment ?></label>
            </settings>
        </column>
<?php endswitch; ?>
<?php endforeach; ?>
    </columns>
</listing>
