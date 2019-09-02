<?= "<?php\n" ?>

namespace <?= $name_space_controller ?>;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\View\Result\Page;

/**
 * Class <?= $controller ?>.
 */
class <?= $controller ?> extends Action
{
    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    /**
     * Index constructor.
     *
     * @param Context     $context
     * @param PageFactory $pageFactory
     */
    public function __construct(Context $context, PageFactory $pageFactory)
    {
        $this->resultPageFactory = $pageFactory;
        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|ResultInterface|Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__($this->getRequest()->getActionName()));

        return $resultPage;
    }
}
