<?php

renderFlavoredMarkdown($argv[1]);

function renderFlavoredMarkdown(string $filename): void
{
    $json = file_get_contents($filename);
    $data = json_decode($json, true);

    echo renderAdvisories($data['advisories']);
    echo "\n\n";
    echo renderAbandonedPackages($data['abandoned'] ?? []);
    echo "\n";
}

/**
 * @param array<string, array<array{advisoryId: string, packageName: string, affectedVersions: string, title: string, cve: string, link: string, reportedAt: string}>> $advisories
 * @return string
 */
function renderAdvisories(array $advisories): string
{
    $output = <<<MARKDOWN
## :exclamation: Security vulnerability advisories :exclamation:

MARKDOWN;

    if (empty($advisories)) {
        $output .= 'No security vulnerability advisories found.';
        return $output;
    }

    $output .= <<<MARKDOWN
| Package | CVE | Affected versions | Reported at |
| ------- | --- | ----------------- | ----------- |
MARKDOWN;

    foreach ($advisories as $issues) {
        foreach ($issues as $issue){
            $cve = sprintf(
                '[%s](%s): %s',
                $issue['cve'],
                $issue['link'],
                $issue['title'],
            );

            $output .= sprintf(
                "\n| %s | %s | %s | %s |",
                $issue['packageName'],
                $cve,
                $issue['affectedVersions'],
                DateTime::createFromFormat(DATE_ATOM, $issue['reportedAt'])->format('Y-m-d H:i:s'),
            );
        }
    }

    return $output;
}

/**
 * @param array<string, string> $abandonedPackages
 * @return string
 */
function renderAbandonedPackages(array $abandonedPackages): string
{
    $output = <<<MARKDOWN
## :warning: Abandoned :warning:

MARKDOWN;

    if (empty($abandonedPackages)) {
        $output .= 'No abandoned packages';
        return $output;
    }

    $output .= <<<MARKDOWN
| Abandoned Package | Suggested Replacement |
| ----------------- | --------------------- |
MARKDOWN;

    foreach ($abandonedPackages as $abandoned => $replacement) {
        $output .= sprintf(
            "\n| %s | %s |",
            $abandoned,
            $replacement
        );
    }

    return $output;
}