<?= "<?php\n" ?>

namespace <?= $namespace_controller ?>;

<?php foreach ($dependencies as $dependency): ?>
use <?= "$dependency;\r\n" ?>
<?php endforeach; ?>

/**
 * Class <?= $name_controller ?>.
 */
class <?= $name_controller ?> extends Action
{
    /**
     * <?= $name_controller ?> constructor.
     *
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
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
