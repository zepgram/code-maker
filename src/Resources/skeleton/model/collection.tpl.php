<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace_collection ?>;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use <?= $use_resource ?> as <?= $model_name ?>Resource;
use <?= $use_model ?> as <?= $model_name ?>Model;

class <?= $name_collection ?> extends AbstractCollection
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init(<?= $model_name ?>Model::class, <?= $model_name ?>Resource::class);
    }
}
