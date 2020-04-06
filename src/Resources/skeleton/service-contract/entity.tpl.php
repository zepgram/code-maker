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
<?php foreach ($entity_fields as $field => $option): ?>
<?php $fieldName = FormatString::asPascaleCase($field); ?>
<?php $fieldConst = FormatString::asUpperSnakeCase($field); ?>
<?php $fieldParameter = FormatString::asCamelCase($field); ?>
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
    public function set<?= $fieldName ?>(<?= $option['type'] ?> $<?= $fieldParameter ?>)
    {
        $this->setData(self::<?= $fieldConst ?>, $<?= $fieldParameter ?>);

        return $this;
    }
<?php if ($field !== array_key_last($entity_fields)):
echo "\n";
endif?>
<?php endforeach; ?>
}
