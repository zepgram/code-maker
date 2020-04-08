<?= "<?php\n" ?>

namespace <?= $namespace_entity_repository ?>;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use <?= $use_entity_interface ?>;
use <?= $use_entity_repository_interface ?>;

/**
 * Class <?= $name_entity_repository ?>.
 */
class <?= $name_entity_repository ?> implements <?= "$name_entity_repository_interface\r\n" ?>
{
    /**
     * {@inheritdoc}
     */
    public function save(<?= $name_entity_interface ?> $<?= $name_camel_case_entity ?>)
    {
        throw new LocalizedException(__('Service not yet implemented.'));
    }

    /**
     * {@inheritdoc}
     */
    public function getById($id)
    {
        throw new LocalizedException(__('Service not yet implemented.'));
    }

    /**
     * {@inheritdoc}
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        throw new LocalizedException(__('Service not yet implemented.'));
    }

    /**
     * {@inheritdoc}
     */
    public function delete(<?= $name_entity_interface ?> $<?= $name_camel_case_entity ?>)
    {
        throw new LocalizedException(__('Service not yet implemented.'));
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($id)
    {
        throw new LocalizedException(__('Service not yet implemented.'));
    }
}
