<?= "<?php\n" ?>

namespace <?= $namespace_block ?>;

<?php foreach ($dependencies as $dependency): ?>
use <?= "$dependency;\r\n" ?>
<?php endforeach; ?>

/**
 * Class <?= $name_block ?>.
 */
class <?= $name_block ?> extends Template
{
    public function __construct(Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }
}
