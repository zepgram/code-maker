<?= "<?php\n" ?>

namespace <?= $name_space_plugin ?>;

use <?= "$target_class" ?>;

/**
 * Class <?= $class_plugin ?>.
 */
class <?= "$class_plugin\n" ?>
{
    public function beforeMethod(<?= $target_class_name ?> $subject)
    {

    }

    public function afterMethod(<?= $target_class_name ?> $subject, $result)
    {

    }

    public function aroundMethod(<?= $target_class_name ?> $subject, callable $proceed)
    {

    }
}
