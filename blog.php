<?php require_once('header.php'); ?>

<?php
// Lấy thông tin từ bảng tbl_page
$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
$statement->execute();
$page = $statement->fetch(PDO::FETCH_ASSOC);
$blog_title = $page['blog_title'];
$blog_banner = $page['blog_banner'];
$blog_meta_title = $page['blog_meta_title'];
?>

<div class="page-banner" style="background-image: url(assets/uploads/<?php echo $blog_banner; ?>);">
    <div class="inner">
        <h1><?php echo $blog_title; ?></h1>
    </div>
</div>
                    <div class="container">
    <h1 style="text-align: center; margin-bottom: 20px;">Bài viết nổi bật</h1>
    <div class="posts-container">
    <div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php if (!isset($_GET['post_slug'])) { ?>
                    <!-- Danh sách bài viết -->
                    <div class="post-list">
                        <?php
                        $statement = $pdo->prepare("SELECT * FROM tbl_post ORDER BY post_date DESC");
                        $statement->execute();
                        $posts = $statement->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($posts as $post) {
                            $short_content = mb_strimwidth(strip_tags($post['post_content']), 0, 200, "...");
                            ?>
                            <div class="post-item">
                                <div class="row">
                                    <div class="col-md-4">
                                        <img src="assets/uploads/<?php echo $post['photo']; ?>" class="img-fluid" alt="<?php echo $post['post_title']; ?>">
                                    </div>
                                    <div class="col-md-8">
                                        <h2><?php echo $post['post_title']; ?></h2>
                                        <p><?php echo $short_content; ?></p>
                                        <a href="blog.php?post_slug=<?php echo $post['post_slug']; ?>" class="btn btn-primary">Xem thêm</a>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        <?php } ?>
                    </div>
                <?php } else { 
                    // Hiển thị chi tiết bài viết
                    $post_slug = $_GET['post_slug'];
                    $statement = $pdo->prepare("SELECT * FROM tbl_post WHERE post_slug = ?");
                    $statement->execute([$post_slug]);
                    $post = $statement->fetch(PDO::FETCH_ASSOC);

                    if ($post) {
                        ?>
                        <div class="post-detail">
                            <h1><?php echo $post['post_title']; ?></h1>
                            <img src="assets/uploads/<?php echo $post['photo']; ?>" class="img-fluid" alt="<?php echo $post['post_title']; ?>">
                            <p><?php echo $post['post_content']; ?></p>
                            <a href="blog.php" class="btn btn-secondary">Quay lại</a>
                        </div>
                    <?php } else { ?>
                        <div class="alert alert-danger">
                            Bài viết không tồn tại!
                        </div>
                        <a href="blog.php" class="btn btn-secondary">Quay lại</a>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>