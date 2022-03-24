<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace_plugin ?>;

use <?= "$target_class" ?>;

class <?= "$name_plugin\n" ?>
{
    /**
     * @param <?= $target_class_name ?> $subject
     */
    public function beforeMethod(<?= $target_class_name ?> $subject)
    {
        // @todo: implement plugin before
    }

    /**
     * @param <?= $target_class_name ?> $subject
     * @param callable $proceed
     */
    public function aroundMethod(<?= $target_class_name ?> $subject, callable $proceed)
    {
        // @todo: implement plugin around
    }

    /**
     * @param <?= $target_class_name ?> $subject
     * @param $result
     */
    public function afterMethod(<?= $target_class_name ?> $subject, $result)
    {
        // @todo: implement plugin after
    }
}
