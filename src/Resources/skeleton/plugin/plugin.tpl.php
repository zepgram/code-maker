<?= "<?php\n" ?>

namespace <?= $name_space_plugin ?>;

use <?= "$target_class" ?>;

/**
 * Class <?= $class_plugin ?>.
 */
class <?= "$class_plugin\n" ?>
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
