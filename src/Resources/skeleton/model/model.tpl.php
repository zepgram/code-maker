<?php
use Zepgram\CodeMaker\Str;

?>
<?= "<?php\n" ?>

namespace <?= $namespace_model ?>;

use Magento\Framework\Model\AbstractModel;
use <?= $use_resource ?> as <?= $name_model ?>Resource;
<?php
$implements = null;
if (isset($use_entiy_interface)): ?>
use <?= $use_entity_interface ?>;
<?php
$implements = "implements $name_entity_interface\r\n";
endif; ?>
/**
 * Class <?= $name_model ?>.
 */
class <?= $name_model ?> extends AbstractModel <?= $implements ?>
{
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
endif; ?>
<?php endforeach; ?>
}
