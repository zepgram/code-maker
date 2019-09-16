<?= "<?php\n" ?>

namespace <?= $name_space_api ?>;

use <?= $use_class_entity_interface ?>;
use <?= $name_space_api_data ?>\<?= $class_entity ?>SearchResultsInterface;
use Magento\Framework\Api\Search\SearchResult;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;

/**
 * Interface <?= $class_entity ?>RepositoryInterface.
 */
interface <?= $class_entity ?>RepositoryInterface
{
    /**
     * Save <?= $class_entity ?>Interface Entity
     *
     * @param $<?= "$class_entity_param\r\n" ?>
     * @return <?= $class_entity ?>Interface
     * @throws CouldNotSaveException
     */
    public function save(<?= $class_entity ?>Interface $<?= $class_entity_param ?>);

    /**
     * Get <?= $class_entity ?>Interface Entity By Id
     *
     * @param $id
     * @return <?= $class_entity ?>Interface
     * @throws NoSuchEntityException
     */
    public function getById($id);

    /**
     * Get <?= $class_entity ?>Interface Entity List
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return <?= $class_entity ?>SearchResultsInterface|SearchResult
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete <?= $class_entity ?>Interface Entity
     *
     * @param $<?= "$class_entity_param\r\n" ?>
     * @return mixed
     * @throws LocalizedException
     */
    public function delete(<?= $class_entity ?>Interface $<?= $class_entity_param ?>);

    /**
     * Delete <?= $class_entity ?>Interface Entity By Id
     *
     * @param $id
     * @return mixed
     * @throws LocalizedException
     */
    public function deleteById($id);
}
