FROM composer:latest

COPY entrypoint.sh /entrypoint.sh
COPY jsonToOutput.php /jsonToOutput.php

ENTRYPOINT ["/entrypoint.sh"]
