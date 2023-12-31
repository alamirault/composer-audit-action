# Composer Audit action

This action run `composer audit` command and print user-friendly summary.

## Inputs

## Outputs

## Example usage

```yaml
jobs:
  composer-audit:
    runs-on: ubuntu-latest
    name: Composer audit
    steps:
      - name: "Checkout code"
        uses: actions/checkout@v4

      - name: Install PHP with extensions
        uses: shivammathur/setup-php@2.26.0
        with:
          coverage: "none"
          php-version: 8.2
          tools: composer:v2

      - name: "Composer install"
        uses: "ramsey/composer-install@2.2.0"
        with:
          composer-options: "--prefer-dist"

      - name: Run composer audit
        uses: alamirault/composer-audit-action@v1
```

![summary-ko.png](docs%2Fsummary-ko.png)
![summary-ko.png](docs%2Fsummary-ok.png)