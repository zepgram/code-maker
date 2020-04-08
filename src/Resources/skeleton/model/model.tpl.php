<?= "<?php\n" ?>

namespace <?= $namespace_model ?>;

use Magento\Framework\Model\AbstractModel;
use <?= $use_resource ?> as <?= $name_model ?>Resource;

class <?= $name_model ?> extends AbstractModel
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
}
