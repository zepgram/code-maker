<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace_entity_repository_interface ?>;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResults;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
<?php if (!isset($name_resource)): ?>
use Magento\Framework\Exception\LocalizedException;
<?php endif; ?>
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
     * @throws CouldNotSaveException
     * @return <?= "$name_entity_interface\r\n" ?>
     */
    public function save(<?= $name_entity_interface ?> $<?= $name_camel_case_entity ?>): <?= $name_entity_interface ?>;

    /**
     * Get <?= $name_entity_interface ?> Entity By Id
     *
     * @param $id
     * @throws NoSuchEntityException
     * @return <?= "$name_entity_interface\r\n" ?>
     */
    public function getById($id): <?= $name_entity_interface ?>;

    /**
     * Get <?= $name_entity_interface ?> Entity List
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return <?= "$name_search_results_interface\r\n" ?>|SearchResults
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResults;

    /**
     * Delete <?= $name_entity_interface ?> Entity
     *
     * @param $<?= "$name_camel_case_entity\r\n" ?>
     * @throws CouldNotDeleteException
     * @return bool
     */
    public function delete(<?= $name_entity_interface ?> $<?= $name_camel_case_entity ?>): bool;

    /**
     * Delete <?= $name_entity_interface ?> Entity By Id
     *
     * @param $id
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function deleteById($id): bool;
}
