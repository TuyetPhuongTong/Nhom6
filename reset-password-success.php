<?php require_once('header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
foreach ($result as $row) {
    $banner_forget_password = $row['banner_forget_password'];
}
?>

<div class="page-banner" style="background-color:#444;background-image: url(https://i.pinimg.com/736x/82/cd/4a/82cd4a8c262b9c774f0638d7fd88997a.jpg);">
    <div class="inner">
        <h1><?php echo "Thay đổi mật khẩu"; ?></h1>
    </div>
</div>

<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="user-content">
                    <?php echo "Mật khẩu đã được đặt lại thành công. Bây giờ bạn có thể đăng nhập"; ?><br><br>
                    <a href="<?php echo BASE_URL; ?>login.php" style="color:#e4144d;font-weight:bold;"><?php echo "Bâm vào đây để Đăng nhập"; ?></a>
                </div>                
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>