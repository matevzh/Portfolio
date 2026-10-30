# Blog (PHP)

File-based PHP blog for **https://blog.matevz.tech**. No database.

The portfolio on Cloudflare Workers cannot run PHP. Upload this `blog/` folder to a PHP 8.x host and point the subdomain there.

## Deploy

1. Get any PHP 8.x shared host with FTP/SFTP.
2. Upload the contents of this folder to the host web root (or the vhost root for `blog.matevz.tech`):
   - `index.php`, `post.php`, `.htaccess`
   - `includes/`
   - `posts/`
3. Do **not** rely on `index.html` on the PHP host — it is only a redirect for `matevz.tech/blog/` on Workers. `.htaccess` prefers `index.php`.
4. In Cloudflare → **matevz.tech** → **DNS** → add a record for `blog` (A or CNAME as your PHP host instructs). Keep the proxy on if you want.
5. Do **not** add `blog.matevz.tech` as a Workers Custom Domain — that would send the subdomain back to the Worker.

CSS and theme JS load from `https://matevz.tech/style.css` and `https://matevz.tech/script.js`.

## Publish a post

1. Copy `posts/hello-world.php` to `posts/your-slug.php`.
2. Set `title`, `date` (`Y-m-d`), `slug`, and HTML `body`.
3. Upload that file via FTP.

Posts are listed newest-first by `date`.
