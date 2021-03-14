<?php
use Zepgram\CodeMaker\Str;

$implements = "\r\n";
?>
<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace_model ?>;

use Magento\Framework\Model\AbstractModel;
<?php if (isset($use_entity_interface)): ?>
use <?= $use_entity_interface ?>;
<?php $implements = " implements $name_entity_interface\r\n";
endif; ?>
use <?= $use_resource ?> as <?= $name_model ?>Resource;

class <?= $name_model ?> extends AbstractModel<?= $implements ?>
{
<?php if (!isset($use_entity_interface)): ?>
<?php foreach ($option_fields as $field => $option): ?>
    /** @var <?= $option['type'] ?> */
    public const <?= Str::asUpperSnakeCase($field) ?> = '<?= Str::asSnakeCase($field)."';\r\n" ?>

<?php endforeach; ?>
<?php endif; ?>
    /**
     * {@inheritdoc}
     */
    protected $_eventPrefix = '<?= $name_snake_case_model ?>';

    /**
     * {@inheritdoc}
     */
    protected $_eventObject = '<?= $name_snake_case_model ?>';

    /**
     * {@inheritdoc}
     */
    protected $_idFieldName = '<?= $primary_key ?>';

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init(<?= $name_model ?>Resource::class);
    }

<?php foreach ($option_fields as $field => $option): ?>
<?php $fieldName = Str::asPascaleCase($field); ?>
<?php $fieldConst = Str::asUpperSnakeCase($field); ?>
<?php $fieldParameter = Str::asCamelCase($field); ?>
    /**
<?php if (isset($use_entity_interface)): ?>
     * {@inheritdoc}
     */
<?php else: ?>
     * Get <?= "$fieldName\n" ?>
     *
     * @return <?= $option['type'] . "\n" ?>
     */
 <?php endif; ?>
    public function get<?= $fieldName ?>()
    {
        return $this->getData(self::<?= $fieldConst ?>);
    }

    /**
<?php if (isset($use_entity_interface)): ?>
     * {@inheritdoc}
<?php else: ?>
     * Set <?= "$fieldName\n" ?>
     *
     * @param <?= $option['type'] ?> $<?= "$fieldParameter\n" ?>
     *
     * @return $this<?= "\n" ?>
<?php endif; ?>
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
