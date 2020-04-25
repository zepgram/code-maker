<?php
use Zepgram\CodeMaker\Str;

?>
<?= "<?xml version=\"1.0\"?>\n" ?>
<schema xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:Setup/Declaration/Schema/etc/schema.xsd">
    <table name="<?= $table_name ?>" resource="default" engine="innodb" comment="Table <?= Str::getPhraseUcWord($table_name) ?>">
        <column name="<?= $primary_key ?>" xsi:type="int" nullable="false" padding="11" unsigned="true" identity="true" comment="Entity ID" />
        <?php foreach ($option_fields as $field => $option):
        $dbType = $option['db_type'];
        $field = Str::asSnakeCase($field);
        $comment = Str::getPhraseUcWord($field);
        $isNullable = $option['is_nullable'];
        switch ($dbType):
        case 'varchar':
        echo '<column name="'.$field.'" xsi:type="'.$dbType.'" nullable="'.$isNullable.'" length="255" comment="'.$comment.'"/>';
        break;
        case 'int':
        echo '<column name="'.$field.'" xsi:type="'.$dbType.'" nullable="'.$isNullable.'" padding="10" unsigned="true" identity="false" comment="'.$comment.'"/>';
        break;
        case 'smallint':
        echo '<column name="'.$field.'" xsi:type="'.$dbType.'" nullable="'.$isNullable.'" padding="5" unsigned="true" identity="false" comment="'.$comment.'"/>';
        break;
        case 'boolean':
        case 'text':
        case 'mediumtext':
        case 'date':
        echo '<column name="'.$field.'" xsi:type="'.$dbType.'" nullable="'.$isNullable.'" comment="'.$comment.'"/>';
        break;
        case 'decimal':
        echo '<column name="'.$field.'" xsi:type="'.$dbType.'" nullable="'.$isNullable.'" scale="4" precision="20" unsigned="false" comment="'.$comment.'"/>';
        break;
        case 'timestamp':
        echo '<column name="'.$field.'" xsi:type="'.$dbType.'" nullable="'.$isNullable.'" default="CURRENT_TIMESTAMP" on_update="false" comment="'.$comment.'"/>';
        break;
        case 'timestamp_on_update':
        echo '<column name="'.$field.'" xsi:type="timestamp" nullable="'.$isNullable.'" default="CURRENT_TIMESTAMP" on_update="true" comment="'.$comment.'"/>';
        break;
        endswitch;
        endforeach; ?>
        <constraint xsi:type="primary" referenceId="PRIMARY">
            <column name="<?= $primary_key ?>"/>
        </constraint>
    </table>
</schema>
