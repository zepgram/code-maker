### Installation

```shell
git clone git@github.com:zepgram/magento2-code-maker.git
cd magento2-code-maker
composer install
sudo ln -sfn {absloute_path}/magento2-code-maker/bin/maker /usr/local/bin/maker
```

To execute maker, you must be in a Magento project directory and run:
```
maker
```

### Todo
- Generator issue:
  - Resolve specific case of xml merge
  - Add basic front source model selection for core_config
  - Make correct implementation of controllers with interface

---

- Improvements:
  - Generator add configurator with a ".maker" file:
one shot, then must be updated with CLI - set current project: set project path + user name + user email + declare strict types
one shot, then must be updated with CLI - assign module
  - Generator with magento versioning with a "x.y.z.json" file: declare and load config for specific project version

---

- Missing component:
  - Create form ui component

---

