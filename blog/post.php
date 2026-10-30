<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/layout.php';

$slug = isset($_GET['slug']) ? (string) $_GET['slug'] : '';
$post = blog_find_post($slug);

if ($post === null) {
    http_response_code(404);
    blog_render_header('Post not found · Matevž Prašnikar');
    ?>
        <main>
            <section class="page-intro">
                <h1 class="page-title">Post not found</h1>
                <p class="page-lead">That post doesn’t exist. <a href="/">Back to the blog</a>.</p>
            </section>
        </main>
    <?php
    blog_render_footer();
    exit;
}

blog_render_header(
    $post['title'] . ' · Matevž Prašnikar',
    $post['title']
);
?>
        <main>
            <article class="post">
                <header class="page-intro">
                    <p class="work-list-meta post-date"><?= blog_e(blog_format_date($post['date'])) ?></p>
                    <h1 class="page-title"><?= blog_e($post['title']) ?></h1>
                </header>
                <div class="post-body">
                    <?= $post['body'] ?>
                </div>
                <p class="post-nav"><a href="/">← All posts</a></p>
            </article>
        </main>
<?php
blog_render_footer();
