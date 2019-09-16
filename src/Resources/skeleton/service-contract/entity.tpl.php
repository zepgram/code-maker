<?php
use Zepgram\CodeMaker\FormatString;
?>
<?= "<?php\n" ?>

namespace <?= $name_space_entity ?>;

use <?= $use_class_entity_interface ?>;
use Magento\Framework\DataObject;

/**
 * Class <?= $class_entity ?>.
 */
class <?= $class_entity ?> extends DataObject implements <?= $class_entity ?>Interface
{
<?php foreach ($entity_fields as $field): ?>
<?php $fieldName = FormatString::asPascaleCase($field['value']); ?>
<?php $fieldConst = FormatString::asUpperSnakeCase($field['value']); ?>
<?php $fieldParameter = FormatString::asCamelCase($field['value']); ?>
    /**
     * {@inheritdoc}
     */
    public function get<?= $fieldName ?>()
    {
        return $this->getData(self::<?= $fieldConst ?>);
    }

    /**
     * {@inheritdoc}
     */
    public function set<?= $fieldName ?>(<?= $field['type'] ?> $<?= $fieldParameter ?>)
    {
        $this->setData(self::<?= $fieldConst ?>, $<?= $fieldParameter ?>);

        return $this;
    }
<?php if ($field['value'] !== end($entity_fields)['value']):
echo "\n";
endif?>
<?php endforeach; ?>
}
