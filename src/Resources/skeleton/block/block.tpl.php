<?= "<?php\n" ?>

namespace <?= $name_space_block ?>;

<?php foreach ($dependencies as $dependency): ?>
use <?= "$dependency;\r\n" ?>
<?php endforeach; ?>

/**
 * Class <?= $class_block ?>.
 */
class <?= $class_block ?> extends Template
{
    public function __construct(Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }
}
