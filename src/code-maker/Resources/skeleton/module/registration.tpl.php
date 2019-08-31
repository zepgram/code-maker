<?= "<?php\n" ?>

\Magento\Framework\Component\ComponentRegistrar::register(
    \Magento\Framework\Component\ComponentRegistrar::MODULE,
    '<?= $module_namespace ?>_<?= $module_name ?>',
    __DIR__
);
