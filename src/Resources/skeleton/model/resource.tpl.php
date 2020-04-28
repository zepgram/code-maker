<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace_resource ?>;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class <?= $name_resource ?> extends AbstractDb
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('<?= $table_name ?>', '<?= $primary_key ?>');
    }
}
