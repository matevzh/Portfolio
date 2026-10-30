<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/layout.php';

$posts = blog_load_posts();

blog_render_header(
    'Blog · Matevž Prašnikar',
    'Blog by Matevž Prašnikar — notes on software, hardware, and networks.'
);
?>
        <main>
            <section class="page-intro">
                <h1 class="page-title">Blog</h1>
                <p class="page-lead">Notes on software, hardware, networks, and whatever I’m learning along the way.</p>
            </section>

            <section class="work-section">
                <div class="work-block">
                    <p class="work-block-heading">Posts</p>
                    <div class="work-list" id="post-list">
                        <?php if ($posts === []): ?>
                            <p class="empty-state">No posts yet — check back soon.</p>
                        <?php else: ?>
                            <?php foreach ($posts as $post): ?>
                                <a class="work-list-item" href="post.php?slug=<?= blog_e($post['slug']) ?>">
                                    <span class="work-list-title"><?= blog_e($post['title']) ?></span>
                                    <span class="work-list-meta"><?= blog_e(blog_format_date($post['date'])) ?></span>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        </main>
<?php
blog_render_footer();
