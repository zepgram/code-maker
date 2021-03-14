<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace_controller ?>;

<?php foreach ($dependencies as $dependency): ?>
use <?= "$dependency;\r\n" ?>
<?php endforeach; ?>
<?php if (isset($generate_grid)): ?>
use Magento\Framework\View\Result\PageFactory;
<?php endif; ?>

class <?= $name_controller ?> extends Action
{
<?php if (isset($generate_grid)): ?>
    /** @var string */
    public const ADMIN_RESOURCE = '<?= $module_namespace ?>_<?= $module_name ?>::<?= $table_name ?>';

    /** @var PageFactory */
    private $pageFactory;

<?php endif; ?>
    /**
     * <?= $name_controller ?> constructor.
     *
<?php if (!isset($generate_grid)): ?>
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }
<?php else: ?>
     * @param Context $context
     * @param PageFactory $pageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory
    ) {
        $this->pageFactory = $pageFactory;
        parent::__construct($context);
    }
<?php endif; ?>

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
<?php if (isset($template)): ?>
        $this->_view->loadLayout();
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__($this->getRequest()->getActionName()));
        $this->_view->renderLayout();
<?php elseif (isset($generate_grid)): ?>
        $resultPage = $this->pageFactory->create();
        $resultPage->setActiveMenu('<?= $module_namespace ?>_<?= $module_name ?>::<?= $table_name ?>');
        $resultPage->addBreadcrumb(__('<?= $module_name ?>'), __('<?= $module_name ?>'));
        $resultPage->addBreadcrumb(__('<?= $name_model ?>'), __('<?= $name_model ?>'));
        $resultPage->getConfig()->getTitle()->prepend(__('<?= $name_model ?>'));

        return $resultPage;
<?php else: ?>
        $this->getResponse()->setBody('You are in controller action: ' . $this->getRequest()->getActionName());
<?php endif; ?>
    }
}
