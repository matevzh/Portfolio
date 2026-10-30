<?php

declare(strict_types=1);

function blog_posts_dir(): string
{
    return dirname(__DIR__) . DIRECTORY_SEPARATOR . 'posts';
}

/**
 * @return list<array{title: string, date: string, slug: string, body: string, file: string}>
 */
function blog_load_posts(): array
{
    $dir = blog_posts_dir();
    if (!is_dir($dir)) {
        return [];
    }

    $posts = [];
    foreach (glob($dir . DIRECTORY_SEPARATOR . '*.php') ?: [] as $file) {
        $post = include $file;
        if (!is_array($post)) {
            continue;
        }

        $slug = (string) ($post['slug'] ?? pathinfo($file, PATHINFO_FILENAME));
        $title = trim((string) ($post['title'] ?? ''));
        $date = trim((string) ($post['date'] ?? ''));
        $body = (string) ($post['body'] ?? '');

        if ($title === '' || $date === '') {
            continue;
        }

        $posts[] = [
            'title' => $title,
            'date' => $date,
            'slug' => $slug,
            'body' => $body,
            'file' => $file,
        ];
    }

    usort($posts, static function (array $a, array $b): int {
        return strcmp($b['date'], $a['date']);
    });

    return $posts;
}

/**
 * @return array{title: string, date: string, slug: string, body: string, file: string}|null
 */
function blog_find_post(string $slug): ?array
{
    $slug = trim($slug);
    if ($slug === '' || !preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $slug)) {
        return null;
    }

    foreach (blog_load_posts() as $post) {
        if ($post['slug'] === $slug) {
            return $post;
        }
    }

    return null;
}

function blog_format_date(string $date): string
{
    $dt = DateTimeImmutable::createFromFormat('Y-m-d', $date);
    if ($dt === false) {
        return $date;
    }

    return $dt->format('M Y');
}

function blog_e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
