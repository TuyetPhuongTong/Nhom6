<?php require_once('header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $banner_cart = $row['banner_cart'];
}
?>

<?php
$ThongBaoLoi = ''; // Thông Báo Lỗi
if(isset($_POST['form1'])) {

    $i = 0;
    $statement = $pdo->prepare("SELECT * FROM tbl_product");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        $i++;
        $table_product_id[$i] = $row['p_id'];
        $table_quantity[$i] = $row['p_qty'];
    }

    $i=0;
    foreach($_POST['product_id'] as $val) {
        $i++;
        $arr1[$i] = $val;
    }
    $i=0;
    foreach($_POST['quantity'] as $val) {
        $i++;
        $arr2[$i] = $val;
    }
    $i=0;
    foreach($_POST['product_name'] as $val) {
        $i++;
        $arr3[$i] = $val;
    }
    
    $ChoPhepCapNhat = 1; // Cho Phép Cập Nhật
    for($i=1;$i<=count($arr1);$i++) {
        for($j=1;$j<=count($table_product_id);$j++) {
            if($arr1[$i] == $table_product_id[$j]) {
                $temp_index = $j;
                break;
            }
        }
        if($table_quantity[$temp_index] < $arr2[$i]) {
        	$ChoPhepCapNhat = 0;
            $ThongBaoLoi .= '"'.$arr2[$i].'" Món Hàng Không Đủ Số Lượng Cho "'.$arr3[$i].'"\n';
        } else {
            $_SESSION['cart_p_qty'][$i] = $arr2[$i];
        }
    }
    $ThongBaoLoi .= '\nCác Món Hàng Khác Đã Được Cập Nhật Thành Công!';
    ?>
    
    <?php if($ChoPhepCapNhat == 0): ?>
    	<script>alert('<?php echo $ThongBaoLoi; ?>');</script>
	<?php else: ?>
		<script>alert('Cập Nhật Số Lượng Tất Cả Các Món Hàng Thành Công!');</script>
	<?php endif; ?>
    <?php

}
?>

<div class="page-banner" style="background-image: url(https://i.pinimg.com/736x/3b/e0/6d/3be06d9ac4093ddeb51b86ce2383658c.jpg)">
    <div class="overlay"></div>
    <div class="page-banner-inner">
        <h1><?php echo "Giỏ hàng của tôi"; ?></h1>
    </div>
</div>

<div class="page">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

                <?php if(!isset($_SESSION['cart_p_id'])): ?>
                    <?php echo '<h2 class="text-center">Giỏ Hàng Đang Trống!!</h2></br>'; ?>
                    <?php echo '<h4 class="text-center">Thêm Sản Phẩm Vào Giỏ Để Hiển Thị Tại Đây.</h4>'; ?>
                <?php else: ?>
                <form action="" method="post">
                    <?php $csrf->echoInputField(); ?>
				<div class="cart">
                    <table class="table table-responsive table-hover table-bordered">
                        <tr>
                            <th><?php echo "STT" ?></th>
                            <th><?php echo "Hình ảnh"; ?></th>
                            <th><?php echo "Tên sản phẩm"; ?></th>
                            <th><?php echo "Kích cỡ"; ?></th>
                            <th><?php echo "Độ đậm Cacao"; ?></th>
                            <th><?php echo "Giá tiền"; ?></th>
                            <th><?php echo "Số lượng"; ?></th>
                            <th class="text-right"><?php echo "Thành tiền"; ?></th>
                            <th class="text-center" style="width: 100px;"><?php  echo "Hành động"; ?></th>
                        </tr>
                        <?php
                        $TongTienBang = 0;

                        $i=0;
                        foreach($_SESSION['cart_p_id'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_id[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_size_id'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_size_id[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_size_name'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_size_name[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_color_id'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_color_id[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_color_name'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_color_name[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_p_qty'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_qty[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_p_current_price'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_current_price[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_p_name'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_name[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_p_featured_photo'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_featured_photo[$i] = $value;
                        }
                        ?>
                        <?php for($i=1;$i<=count($arr_cart_p_id);$i++): ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td>
                                <img src="assets/uploads/<?php echo $arr_cart_p_featured_photo[$i]; ?>" alt="">
                            </td>
                            <td><?php echo $arr_cart_p_name[$i]; ?></td>
                            <td><?php echo $arr_cart_size_name[$i]; ?></td>
                            <td><?php echo $arr_cart_color_name[$i]; ?></td>
                            <td><?php echo $arr_cart_p_current_price[$i]; ?><?php echo "₫"; ?></td>

                            <td>
                                <input type="hidden" name="product_id[]" value="<?php echo $arr_cart_p_id[$i]; ?>">
                                <input type="hidden" name="product_name[]" value="<?php echo $arr_cart_p_name[$i]; ?>">
                                <input type="number" class="input-text qty text" step="1" min="1" max="" name="quantity[]" value="<?php echo $arr_cart_p_qty[$i]; ?>" title="Qty" size="4" pattern="[0-9]*" inputmode="numeric">
                            </td>
                            <td class="text-right">
                                <?php 
                             // Tính tổng giá trị của một mặt hàng và nhân với 1000 để hiển thị 70,000 thay vì 70
                            $TongTienHang = floatval($arr_cart_p_current_price[$i]) * intval($arr_cart_p_qty[$i])*1000;
                            $TongTienBang = $TongTienBang + $TongTienHang;                                                       
                                ?>
                               <?php echo number_format($TongTienHang, 0, ',', ','); ?> <?php echo "₫"; ?>
                            </td>
                            <td class="text-center">
                                <a onclick="return confirmDelete();" href="cart-item-delete.php?id=<?php echo $arr_cart_p_id[$i]; ?>&size=<?php echo $arr_cart_size_id[$i]; ?>&color=<?php echo $arr_cart_color_id[$i]; ?>" class="trash"><i class="fa fa-trash" style="color:red;"></i></a>
                            </td>
                        </tr>
                        <?php endfor; ?>
                        <tr>
                            <th colspan="7" class="total-text">Tổng</th>
                            <th class="total-amount"><?php echo number_format($TongTienBang, 0, ',', ','); ?><?php echo "₫"; ?></th>

                            <th></th>
                        </tr>
                    </table> 
                </div>

                <div class="cart-buttons">
                    <ul>
                        <li><input type="submit" value="<?php echo "Cập nhật Giỏ hàng"; ?>" class="btn btn-primary" name="form1"></li>
                        <li><a href="index.php" class="btn btn-primary"><?php echo "Tiếp tục mua hàng"; ?></a></li>
                        <li><a href="checkout.php" class="btn btn-primary"><?php echo "Tiến hành thanh toán"; ?></a></li>
                    </ul>
                </div>
                </form>
                <?php endif; ?>

                

			</div>
		</div>
	</div>
</div>

<?php require_once('footer.php'); ?>
//hhh