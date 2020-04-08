<?= "<?php\n" ?>

namespace <?= $namespace_entity_repository_interface ?>;

use Magento\Framework\Api\Search\SearchResult;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use <?= $use_entity_interface ?>;
use <?= $use_search_results_interface ?>;

/**
 * Interface <?= $name_entity_repository_interface ?>.
 */
interface <?= "$name_entity_repository_interface\r\n" ?>
{
    /**
     * Save <?= $name_entity_interface ?> Entity
     *
     * @param $<?= "$name_camel_case_entity\r\n" ?>
     * @return <?= "$name_entity_interface\r\n" ?>
     * @throws CouldNotSaveException
     */
    public function save(<?= $name_entity_interface ?> $<?= $name_camel_case_entity ?>);

    /**
     * Get <?= $name_entity_interface ?> Entity By Id
     *
     * @param $id
     * @return <?= "$name_entity_interface\r\n" ?>
     * @throws NoSuchEntityException
     */
    public function getById($id);

    /**
     * Get <?= $name_entity_interface ?> Entity List
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return <?= $name_search_results_interface ?>|SearchResult
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete<?= $name_entity_interface ?> Entity
     *
     * @param $<?= "$name_camel_case_entity\r\n" ?>
     * @return mixed
     * @throws LocalizedException
     */
    public function delete(<?= $name_entity_interface ?> $<?= $name_camel_case_entity ?>);

    /**
     * Delete <?= $name_entity_interface ?> Entity By Id
     *
     * @param $id
     * @return mixed
     * @throws LocalizedException
     */
    public function deleteById($id);
}
