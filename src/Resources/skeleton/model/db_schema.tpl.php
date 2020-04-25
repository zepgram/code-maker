<?php
use Zepgram\CodeMaker\Str;

?>
<?= "<?xml version=\"1.0\"?>\n" ?>
<schema xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:Setup/Declaration/Schema/etc/schema.xsd">
    <table name="<?= $table_name ?>" resource="default" engine="innodb" comment="<?= Str::getPhrase($table_name) ?>">
        <column xsi:type="int" name="<?= $primary_key ?>" padding="11" unsigned="true" nullable="false" identity="true" comment="Entity ID" />
        <?php foreach ($option_fields as $field => $option): ?>
        <?php endforeach; ?>
        <constraint xsi:type="primary" referenceId="PRIMARY">
            <column name="<?= $primary_key ?>"/>
        </constraint>
    </table>
</schema>
