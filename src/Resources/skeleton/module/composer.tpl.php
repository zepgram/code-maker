<?php
use Zepgram\CodeMaker\FormatString;
?>
<?= "{\n" ?>
  "name": "<?= $lower_namespace ?>/module-<?= FormatString::asKebabCase($module_name) ?>",
  "description": "<?= $module_namespace ?> <?= $module_name ?>",
  "type": "magento2-module",
  "version": "0.0.1",
  "require": {
    "magento/framework": "^101.0.7|^102.0.0"
  },
  "autoload": {
    "files": [
      "registration.php"
    ],
    "psr-4": {
      "<?= $module_namespace ?>\\<?= $module_name ?>\\": ""
    }
  },
  "license": "proprietary",
  "repositories": {
    "repo.magento.com": {
      "type": "composer",
      "url": "https://repo.magento.com/"
    }
  }
}
