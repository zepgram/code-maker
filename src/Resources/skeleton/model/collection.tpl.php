<?= "<?php\n" ?>

namespace <?= $namespace_collection ?>;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use <?= $use_resource ?> as <?= $entity_name ?>Resource;
use <?= $use_model ?> as <?= $entity_name ?>Model;

class <?= $name_collection ?> extends AbstractCollection
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init(<?= $entity_name ?>Model::class, <?= $entity_name ?>Resource::class);
    }
}
