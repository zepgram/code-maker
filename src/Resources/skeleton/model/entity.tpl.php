<?php
use Zepgram\CodeMaker\Str;

?>
<?= "<?php\n" ?>

namespace <?= $namespace_entity ?>;

use Magento\Framework\Model\AbstractModel;
use <?= $use_resource ?> as <?= $name_entity ?>Resource;

/**
 * Class <?= $name_entity ?>.
 */
class <?= $name_entity ?> extends AbstractModel
{
<?php foreach ($option_fields as $field => $option): ?>
    /** @var <?= $option['type'] ?> */
    const <?= Str::asUpperSnakeCase($field) ?> = '<?= Str::asSnakeCase($field)."';\r\n" ?>
<?php if ($field !== array_key_last($option_fields)):
echo "\n";
endif?>
<?php endforeach;  ?>

    /**
     * {@inheritdoc}
     */
    protected $_eventPrefix = '<?= $name_snake_case_entity ?>';

    /**
     * {@inheritdoc}
     */
    protected $_eventObject = '<?= $name_snake_case_entity ?>';

    /**
     * {@inheritdoc}
     */
    protected $_idFieldName = '<?= $primary_key ?>';

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init(<?= $name_entity ?>Resource::class);
    }

<?php foreach ($option_fields as $field => $option): ?>
<?php $fieldName = Str::asPascaleCase($field); ?>
<?php $fieldConst = Str::asUpperSnakeCase($field); ?>
<?php $fieldParameter = Str::asCamelCase($field); ?>
    /**
     * Get <?= "$fieldName\n" ?>
     *
     * @return <?= $option['type']."\n" ?>
     */
    public function get<?= $fieldName ?>()
    {
        return $this->getData(self::<?= $fieldConst ?>);
    }

    /**
     * Set <?= "$fieldName\n" ?>
     *
     * @param <?= $option['type'] ?> $<?= "$fieldParameter\n" ?>
     *
     * @return $this<?= "\n" ?>
     */
    public function set<?= $fieldName ?>(<?= $option['type'] ?> $<?= $fieldParameter ?>)
    {
        $this->setData(self::<?= $fieldConst ?>, $<?= $fieldParameter ?>);

        return $this;
    }
<?php if ($field !== array_key_last($option_fields)):
    echo "\n";
endif; ?>
<?php endforeach; ?>
}
