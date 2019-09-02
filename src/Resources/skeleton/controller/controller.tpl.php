<?= "<?php\n" ?>

namespace <?= $name_space ?>;

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
        die('you are in controller action');
    }
}
