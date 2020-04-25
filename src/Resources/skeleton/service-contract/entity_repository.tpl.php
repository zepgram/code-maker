<?= "<?php\n" ?>

namespace <?= $namespace_entity_repository ?>;

<?php if (isset($name_resource)):
$nameEntityFactory = $name_camel_case_entity. 'Factory';
$classEntityFactory = $name_entity_interface. 'Factory';
$useEntityFactory = $use_entity_interface. 'Factory';
$nameSearchResultFactory = $name_camel_case_search_results_interface. 'Factory';
$classSearchResultFactory = $name_search_results_interface. 'Factory';
$useSearchResultFactory = $use_search_results_interface. 'Factory';
$nameCollectionFactory = $name_camel_case_collection. 'Factory';
$classCollectionFactory = $name_collection. 'Factory';
$useCollectionFactory = $use_collection. 'Factory';
$nameResource = $name_camel_case_entity . 'Resource';
$classResource = $entity_name . 'Resource';
$useResource = $use_resource . ' as ' . $entity_name. 'Resource';
?>
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use <?= $use_entity_repository_interface ?>;
use <?= $use_entity_interface ?>;
use <?= $useEntityFactory ?>;
use <?= $use_search_results_interface ?>;
use <?= $useSearchResultFactory ?>;
use <?= $useResource ?>;
use <?= $use_collection ?>;
use <?= $useCollectionFactory ?>;
<?php else: ?>
use Magento\Framework\Exception\LocalizedException;
use <?= $use_entity_interface ?>;
use <?= $use_entity_repository_interface ?>;
<?php endif; ?>

/**
 * Class <?= $name_entity_repository ?>.
 */
class <?= $name_entity_repository ?> implements <?= "$name_entity_repository_interface\r\n" ?>
{
<?php if(isset($name_resource)): ?>
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var <?= "$classEntityFactory\r\n" ?>
     */
    private $<?= $nameEntityFactory ?>;

    /**
     * @var <?= "$classSearchResultFactory\r\n" ?>
     */
    private $<?= $nameSearchResultFactory ?>;

    /**
     * @var <?= "$classResource\r\n" ?>
     */
    private $<?= $nameResource ?>;

    /**
     * @var <?= "$classCollectionFactory\r\n" ?>
     */
    private $<?= $nameCollectionFactory ?>;

    /**
     * <?= $name_entity_repository ?> constructor.
     *
     * @param CollectionProcessorInterface $collectionProcessor
     * @param <?= "$classEntityFactory $$nameEntityFactory\r\n" ?>
     * @param <?= "$classSearchResultFactory $$nameSearchResultFactory\r\n" ?>
     * @param <?= "$classResource $$nameResource\r\n" ?>
     * @param <?= "$classCollectionFactory $$nameCollectionFactory\r\n" ?>
     */
    public function __construct(
        CollectionProcessorInterface $collectionProcessor,
        <?= "$classEntityFactory $$nameEntityFactory,\r\n" ?>
        <?= "$classSearchResultFactory $$nameSearchResultFactory,\r\n" ?>
        <?= "$classResource $$nameResource,\r\n" ?>
        <?= "$classCollectionFactory $$nameCollectionFactory\r\n" ?>
    ) {
        $this->collectionProcessor = $collectionProcessor;
        $this-><?= $nameEntityFactory ?> = $<?= $nameEntityFactory ?>;<?= "\r\n" ?>
        $this-><?= $nameSearchResultFactory ?> = $<?= $nameSearchResultFactory ?>;<?= "\r\n" ?>
        $this-><?= $nameResource ?> = $<?= $nameResource ?>;<?= "\r\n" ?>
        $this-><?= $nameCollectionFactory ?> = $<?= $nameCollectionFactory ?>;<?= "\r\n" ?>
    }

    /**
     * {@inheritdoc}
     */
    public function save(<?= $name_entity_interface ?> $<?= $name_camel_case_entity ?>): <?= "$name_entity_interface\r\n" ?>
    {
        try {
            /** @var <?= $name_entity ?> $<?= $name_camel_case_entity ?> */
            $this-><?= $nameResource ?>->save($<?= $name_camel_case_entity ?>);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__('Could not save <?= $name_entity ?>: %1', $e->getMessage()), $e);
        }

        return $<?= $name_camel_case_entity ?>;
    }

    /**
     * {@inheritdoc}
     */
    public function getById($id): <?= "$name_entity_interface\r\n" ?>
    {
        /** @var <?= $name_entity ?> $<?= $name_camel_case_entity ?> */
        $<?= $name_camel_case_entity ?> = $this-><?= $nameEntityFactory ?>->create();
        $this-><?= $nameResource ?>->load($<?= $name_camel_case_entity ?>, $id);
        if (!$<?= $name_camel_case_entity ?>->getId()) {
            throw new NoSuchEntityException(__("No <?= $name_entity ?> found with id: %1", $id), $e);
        }

        return $<?= $name_camel_case_entity ?>;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(SearchCriteriaInterface $searchCriteria): <?= "$name_search_results_interface\r\n" ?>
    {
        /** @var <?= $name_collection ?> $<?= $name_camel_case_entity ?> */
        $<?= $name_camel_case_collection ?> = $this-><?= $nameCollectionFactory ?>->create();
        $this->collectionProcessor->process($searchCriteria, $<?= $name_camel_case_collection ?>);

        /** @var <?= $name_search_results_interface ?> $searchResults */
        $searchResults = $this-><?= $nameSearchResultFactory ?>->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(<?= $name_entity_interface ?> $<?= $name_camel_case_entity ?>): bool
    {
        try {
            /** @var <?= $name_entity ?> $<?= $name_camel_case_entity ?> */
            $this-><?= $nameResource ?>->delete($<?= $name_camel_case_entity ?>);
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__('Could not delete <?= $name_entity ?>: %1', $e->getMessage()), $e);
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($id): bool
    {
        try {
            return $this->delete($this->getById($id));
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__('Could not delete <?= $name_entity ?>: %1', $e->getMessage()), $e);
        }
    }
<?php else: ?>
    /**
     * {@inheritdoc}
     */
    public function save(<?= $name_entity_interface ?> $<?= $name_camel_case_entity ?>): <?= "$name_entity_interface\r\n" ?>
    {
        throw new LocalizedException(__('Service not yet implemented.'));
    }

    /**
     * {@inheritdoc}
     */
    public function getById($id): <?= "$name_entity_interface\r\n" ?>
    {
        throw new LocalizedException(__('Service not yet implemented.')):
    }

    /**
     * {@inheritdoc}
     */
    public function getList(SearchCriteriaInterface $searchCriteria): <?= "$name_search_results_interface\r\n" ?>
    {
        throw new LocalizedException(__('Service not yet implemented.'));
    }

    /**
     * {@inheritdoc}
     */
    public function delete(<?= $name_entity_interface ?> $<?= $name_camel_case_entity ?>): bool
    {
        throw new LocalizedException(__('Service not yet implemented.'));
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($id): bool
    {
        throw new LocalizedException(__('Service not yet implemented.'));
    }
<?php endif; ?>
}
