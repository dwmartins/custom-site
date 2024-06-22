# Custom Site

## Project setup (Front end)
```
npm install
```

### Compiles and hot-reloads for development
```
npm run serve
```

### Compiles and minifies for production
```
npm run build
```

### Lints and fixes files
```
npm run lint
```

### Customize configuration
See [Configuration Reference](https://cli.vuejs.org/config/).

## Project setup (API)

Este documento descreve os comandos disponíveis para gerenciar migrações, controladores e classes no seu projeto.

### Gerar Migração
```bash
php console.php generate:migration DESCRIPTIVE_NAME
```
Substitua DESCRIPTIVE_NAME por um nome descritivo para a migração.

### Executar as Migrações
```bash
php console.php migrate
```

### Reverter Migrações
Para reverter a última migração, use:
```bash
php console.php rollback
```

### Reverter uma Migração Específica
```bash
php console.php rollback --name:NAME_MIGRATION
```
Substitua NAME_MIGRATION pelo nome do arquivo de migração que você deseja reverter.

### Reverter Várias Migrações
Para reverter as últimas N migrações, use:

```bash
php console.php rollback --order:N
```
Substitua N pelo número de migrações que você deseja reverter.