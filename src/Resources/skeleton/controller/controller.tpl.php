<?= "<?php\n" ?>

namespace <?= $name_space ?>\Controller\<?= $admin_html_namespace ?><?= $controller ?>;

<?php foreach($dependencies as $dependency): ?>
use <?= "$dependency;\r\n" ?>
<?php endforeach; ?>

/**
 * Class <?= $action ?>.
 */
class <?= $action ?> extends Action
{
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    public function execute()
    {
        // TODO: Implement execute() method.
    }
}
