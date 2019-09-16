<?= "<?php\n" ?>

namespace <?= $name_space_entity ?>;

use <?= $use_class_entity_interface ?>;
use <?= $name_space_api ?>\<?= $class_entity ?>RepositoryInterface;
use Magento\Framework\Api\Search\SearchResult;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;

/**
 * Class <?= $class_entity ?>Repository.
 */
class <?= $class_entity ?>Repository implements <?= $class_entity ?>RepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function save(<?= $class_entity ?>Interface $<?= $class_entity_param ?>)
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
    public function delete(<?= $class_entity ?>Interface $<?= $class_entity_param ?>)
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
