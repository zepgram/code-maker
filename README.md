### Installation

```shell
git clone git@github.com:zepgram/magento2-code-maker.git
cd magento2-code-maker
composer install
chmod +x bin/maker
sudo ln -sfn {absloute_path}/magento2-code-maker/bin/maker /usr/local/bin/maker
```

To execute maker, you must be in a Magento project directory and run:
```
maker
```

### Available commands

| Command                        | Description                           |
|--------------------------------|---------------------------------------|
| `create:block`                 | Create block                         |
| `create:command`               | Create console command               |
| `create:config`                | Create system config                 |
| `create:controller`            | Create controller                    |
| `create:controller-view`       | Create controller with view          |
| `create:cron`                  | Create cron                          |
| `create:graph-ql`              | Create resolver GraphQL              |
| `create:logger`                | Create logger                        |
| `create:model`                 | Create model                         |
| `create:model:service-contract`| Create model with service contract   |
| `create:module`                | Create new module                    |
| `create:observer`              | Create observer                      |
| `create:patch-data`            | Create patch data                    |
| `create:patch-schema`          | Create patch schema                  |
| `create:plugin`                | Create plugin                        |
| `create:service-contract`      | Create service contract              |
| `create:view-model`            | Create view model                    |
| `create:webapi`                | Create WebAPI REST or SOAP           |

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

