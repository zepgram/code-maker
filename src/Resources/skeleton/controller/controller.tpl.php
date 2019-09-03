<?= "<?php\n" ?>

namespace <?= $name_space_controller ?>;

<?php foreach ($dependencies as $dependency): ?>
use <?= "$dependency;\r\n" ?>
<?php endforeach; ?>

/**
 * Class <?= $action ?>.
 */
class <?= $action ?> extends Action
{
    /**
     * <?= $action ?> constructor.
     *
     * @param Context     $context
     */
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    public function execute()
    {
<?php if (isset($template)): ?>
        $this->_view->loadLayout();
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__($this->getRequest()->getActionName()));
        $this->_view->renderLayout();
<?php else: ?>
        die('You are in controller action:' . $this->getRequest()->getActionName());
<?php endif; ?>
    }
}
