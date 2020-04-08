<?php
use Zepgram\CodeMaker\Str;

?>
<?= "<?php\n" ?>

namespace <?= $namespace_entity ?>;

use <?= $use_extend ?? 'Magento\Framework\DataObject' ?>;
use <?= $use_entity_interface ?>;

/**
 * Class <?= $name_entity ?>.
 */
class <?= $name_entity ?> extends <?= $name_extend ?? 'DataObject' ?> implements <?= "$name_entity_interface\r\n" ?>
{
<?php foreach ($option_fields as $field => $option): ?>
<?php $fieldName = Str::asPascaleCase($field); ?>
<?php $fieldConst = Str::asUpperSnakeCase($field); ?>
<?php $fieldParameter = Str::asCamelCase($field); ?>
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
<?php if ($field !== array_key_last($option_fields)):
echo "\n";
endif?>
<?php endforeach; ?>
}
