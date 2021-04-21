# Jazz (PHP) Library

## Dockerfile
```bash
docker build -t jazz .
docker create --name=jazz --volume=./:/var/www jazz
```

---
## Modules

### Config
```bash
configs/modules.php
```
#### Namespace
`MODULES_NAMESPACE` (default "_App\\Modules\\_")

#### Path 
`MODULES_PATH` (default "_app/Modules_")

#### KEY
`MODULES_KEY` (default "_module_")

#### NAME
`MODULES_NAME` (default "_Module_")

### Composer
The default settings will place new MODULE files within the `app/` directory
under the `App\Modules\` namespace. If using path outside `app/`, update the 
`composer.json` file to reflect that _(see `tests/Modules/sandbox` for example)_.

```bash
composer.json
======================================
...
"autoload": {
  "psr-4": {
      "App": "app",
      "Module": "modules"
  }
},
...
...

```
