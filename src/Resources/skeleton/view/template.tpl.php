<?= "<?php\n" ?>
/**
 * @var \Magento\Framework\View\Element\Template $block
 * @var <?= $use_view_model ?> $viewModel
 */

$viewModel = $block->getViewModel();
?>

<?= '<?= $viewModel->getHelloWorld() ?>' . "\n" ?>
