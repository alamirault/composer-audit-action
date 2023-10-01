#!/bin/sh -l

composer audit --format=json --no-scripts --no-plugins --no-interaction > composer-audit-output.json
status=$?

cat composer-audit-output.json

php /jsonToOutput.php composer-audit-output.json >> $GITHUB_STEP_SUMMARY

exit $status;