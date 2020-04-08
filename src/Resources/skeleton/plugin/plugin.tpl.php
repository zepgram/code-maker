<?= "<?php\n" ?>

namespace <?= $namespace_plugin ?>;

use <?= "$target_class" ?>;

/**
 * Class <?= $name_plugin ?>.
 */
class <?= "$name_plugin\n" ?>
{
    /**
     * @param <?= $target_class_name ?> $subject
     */
    public function beforeMethod(<?= $target_class_name ?> $subject)
    {

    }

    /**
     * @param <?= $target_class_name ?> $subject
     * @param $result
     */
    public function afterMethod(<?= $target_class_name ?> $subject, $result)
    {

    }

    /**
     * @param <?= $target_class_name ?> $subject
     * @param callable $proceed
     */
    public function aroundMethod(<?= $target_class_name ?> $subject, callable $proceed)
    {

    }
}
