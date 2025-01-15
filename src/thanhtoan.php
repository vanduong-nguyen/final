<?php
session_start();
include_once '../connt/connect.php';
global $conn;

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$user_info = null;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT fullname, phone FROM user WHERE id = '$user_id'";
    $result = $conn->query($sql);

    if (!$result) {
        die("Error in SQL query: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        $user_info = $result->fetch_assoc();
    }
} elseif (isset($_COOKIE['user_phone']) && isset($_COOKIE['user_password'])) {
    $phone = $_COOKIE['user_phone'];
    $password = $_COOKIE['user_password'];

    $sql = "SELECT id, fullname FROM user WHERE phone = '$phone' AND password = '$password'";
    $result = $conn->query($sql);

    if (!$result) {
        die("Error in SQL query: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        $user_info = $result->fetch_assoc();
        $_SESSION['user_id'] = $user_info['id'];
    }
}
?>
<?php
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 1;

$sql = "SELECT * FROM product WHERE id = '$product_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $product_name = $row['name'];
    $product_price = $row['price'];
} else {
    $product_name = "Sản phẩm không tồn tại";
    $product_price = 0;
}

$total_price = $product_price + 30000;
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/thanhtoan.css">
    <link rel="stylesheet" href="../font/fontawesome-free-6.5.2-web/fontawesome-free-6.5.2-web/css/all.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Orbitron:wght@400..900&family=Protest+Guerrilla&family=Shizuru&display=swap" rel="stylesheet">
</head>
<body>
<p class="address">NHÓM 8</p>
<div id="hostline">
    <p style="padding-left: 30px;" class="display">Đặt hàng online: 086868686 - Địa chỉ: 54 Triều Khúc - Thanh Xuân - Hà Nội</p>
    <p style="text-transform: uppercase;
                        float: right;
                        padding-right: 30px;
                        font-size: 14px;" class="display">TRANG BÁN QUẦN ÁO CỦA NHÓM 8</p>
</div>
<header class="bg-white shadow-sm" style="padding: 0.7% 0;">
    <div class="container-fluid py-2 d-flex align-items-center justify-content-between" style="width: 94%!important;">
        <!-- Logo -->
        <div class="logo">
            <a href="../index.php"><img src="../image/logo.webp" alt="logo" class="img-fluid" style="max-height: 50px;"></a>
        </div>

        <!-- Navigation -->
        <nav class="d-none d-lg-flex">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="../index.php">Trang chủ</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        Thời trang nữ
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Áo</a></li>
                        <li><a class="dropdown-item" href="#">Quần</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        Thời trang nam
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                Áo
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Campaign</a></li>
                                <li><a class="dropdown-item" href="#">Lookbook</a></li>
                            </ul>
                        </li>
                        <li><a class="dropdown-item" href="#">Quần</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        Bộ sưu tập
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Campaign</a></li>
                        <li><a class="dropdown-item" href="#">Lookbook</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        Tin tức
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Bài viết nổi bật</a></li>
                        <li><a class="dropdown-item" href="#">Bản tin Pantio</a></li>
                        <li><a class="dropdown-item" href="#">Xu hướng thời trang</a></li>
                        <li><a class="dropdown-item" href="#">Sự kiện</a></li>
                        <li><a class="dropdown-item" href="#">Tuyển dụng</a></li>
                    </ul>
                </li>
            </ul>
        </nav>

        <!-- Search and User Actions -->
        <div class="d-flex align-items-center">
            <!-- Search -->
            <div class="me-3" style="transform: translateY(+70px);">

                <form method="GET" action="timKiem.php" class="search">
                    <input type="text" class="form-control" name="search" id="search-input" placeholder="Tìm sản phẩm">

                </form>
            </div>
            <!-- Icons -->
            <div style="width: 170px">
                <div style="width: 170px">
                    <a href="../src/cart.php" class="fa-solid fa-bag-shopping"
                       style="padding-right: 17px;
                            transform: translateY(-13px);"></a>
                <ul class="tools_header" style="display: inline-block!important;">
                    <?php if ($user_info): ?>
                        <li class="user_menu" style="display: flex; align-items: center; gap: 10px;">
                            <img src="../image/bst1.png" alt="Avatar" style="width: 50px; height: 50px; border-radius: 50%;">
                            <div style="text-align: center;">
                                <span style="display: block; font-size: 14px;"><?=$user_info['fullname'] ?></span>
                                <a href="../checking/dangxuat.php" style="font-size: 14px; color: #007BFF; text-decoration: none;">Đăng xuất</a>
                            </div>
                        </li>
                    <?php else: ?>
                        <a href="login.php" class="me-3 text-dark"><i class="fa-regular fa-circle-user"></i></a>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</header>
    <div class = "flex-container">
        <div id="content" class="form-group" style="margin-left: 80px;">
            <h2>THÔNG TIN THANH TOÁN</h2>
            <div class="userbox">
                <form action="../connt/connect.php" method="post">
                    <div class="flex-container">
                        <div class="form-group">
                            <input type="text" id="fullname" name="fullname" placeholder="Họ và tên" required>
                        </div>
                        <div class="form-group">
                            <input type="text" id="phone" name="phone" placeholder="Số điện thoại" required pattern="[0-9]{10}">
                        </div>
                    </div>
                    <input type="email" id="email" name="email" placeholder="Email" required>
                    <input type="text" id="location" name="location" placeholder="Địa chỉ" required>

                    <div class = "flex-container diadiem">
                        <div class="form-group">
                            <select id="tinh_tp" style="cursor: pointer;" required>
                                <option value="">Chọn tỉnh/thành phố</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select id="quan_huyen" required disabled style="cursor: pointer;">
                                <option value="">Chọn quận huyện</option>
                            </select>
                        </div>
                        <div class="form-group" >
                            <select id="phuong_xa" required disabled style="cursor: pointer;">
                                <option value="">Chọn phường/xã</option>
                            </select>
                        </div>

                        <script>
                            // Gọi API lấy danh sách tỉnh/thành phố
                            fetch('https://provinces.open-api.vn/api/p/')
                                .then(response => response.json())
                                .then(data => {
                                    const tinhTpDropdown = document.getElementById('tinh_tp');
                                    data.forEach(province => {
                                        const option = document.createElement('option');
                                        option.value = province.code;
                                        option.textContent = province.name;
                                        tinhTpDropdown.appendChild(option);
                                    });
                                })
                                .catch(error => console.error('Lỗi khi tải danh sách tỉnh/thành phố:', error));

                            // Sự kiện khi chọn tỉnh/thành phố
                            document.getElementById('tinh_tp').addEventListener('change', function () {
                                const tinhTpCode = this.value;
                                const quanHuyenDropdown = document.getElementById('quan_huyen');
                                const phuongXaDropdown = document.getElementById('phuong_xa');
                                quanHuyenDropdown.innerHTML = '<option value="">Chọn quận huyện</option>'; // Xóa quận/huyện cũ
                                phuongXaDropdown.innerHTML = '<option value="">Chọn phường/xã</option>'; // Xóa phường/xã cũ
                                quanHuyenDropdown.disabled = true; // Vô hiệu hóa dropdown quận/huyện
                                phuongXaDropdown.disabled = true; // Vô hiệu hóa dropdown phường/xã

                                if (tinhTpCode) {
                                    // Gọi API lấy danh sách quận/huyện dựa trên mã tỉnh
                                    fetch(`https://provinces.open-api.vn/api/p/${tinhTpCode}?depth=2`)
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.districts && data.districts.length > 0) {
                                                data.districts.forEach(district => {
                                                    const option = document.createElement('option');
                                                    option.value = district.code;
                                                    option.textContent = district.name;
                                                    quanHuyenDropdown.appendChild(option);
                                                });
                                                quanHuyenDropdown.disabled = false; // Bật dropdown quận/huyện
                                            }
                                        })
                                        .catch(error => console.error('Lỗi khi tải danh sách quận/huyện:', error));
                                }
                            });

                            // Sự kiện khi chọn quận/huyện
                            document.getElementById('quan_huyen').addEventListener('change', function () {
                                const quanHuyenCode = this.value;
                                const phuongXaDropdown = document.getElementById('phuong_xa');
                                phuongXaDropdown.innerHTML = '<option value="">Chọn phường/xã</option>'; // Xóa phường/xã cũ
                                phuongXaDropdown.disabled = true; // Vô hiệu hóa dropdown phường/xã

                                if (quanHuyenCode) {
                                    // Gọi API lấy danh sách phường/xã dựa trên mã quận/huyện
                                    fetch(`https://provinces.open-api.vn/api/d/${quanHuyenCode}?depth=2`)
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.wards && data.wards.length > 0) {
                                                data.wards.forEach(ward => {
                                                    const option = document.createElement('option');
                                                    option.value = ward.code;
                                                    option.textContent = ward.name;
                                                    phuongXaDropdown.appendChild(option);
                                                });
                                                phuongXaDropdown.disabled = false; // Bật dropdown phường/xã
                                            }
                                        })
                                        .catch(error => console.error('Lỗi khi tải danh sách phường/xã:', error));
                                }
                            });
                        </script>

                    </div>
                    <br>
                        <g>Chọn phương thức thanh toán:</g>
                        <div class="form-check"><i class="fa-solid fa-wallet" style="font-size: 24px; color: #000;"></i>
                            <label class="form-check-label" for="cash">Thanh toán khi nhận hàng</label>
                            <input class="form-check-input" type="radio" name="payment" id="cash" value="cash">
                        </div>
                        <div class="form-check"><i class="fa-solid fa-credit-card" style="font-size: 24px; color: #000;"></i>
                            <label class="form-check-label" for="online">Thanh toán trên website</label>
                            <input class="form-check-input" type="radio" name="payment" id="online" value="online">
                        </div>



                    <div id="card-info" style="display: none; margin-top: 20px;">
                        <script>
                            document.addEventListener("DOMContentLoaded", function () {
                                const paymentRadios = document.querySelectorAll('input[name="payment"]');
                                const cardInfoDiv = document.getElementById('card-info');

                                paymentRadios.forEach(radio => {
                                    radio.addEventListener('change', function () {
                                        if (this.value === 'online') {
                                            cardInfoDiv.style.display = 'block'; // Hiển thị bảng nhập mã thẻ
                                        } else {
                                            cardInfoDiv.style.display = 'none'; // Ẩn bảng nhập mã thẻ
                                        }
                                    });
                                });
                            });
                        </script>
                        <h4>Nhập thông tin thẻ:</h4>
                        <div class="form-group">
                            <input type="text" id="card-number" name="card-number" placeholder="Số thẻ" required>
                        </div>
                        <div class="form-group">
                            <input type="text" id="card-holder" name="card-holder" placeholder="Tên chủ thẻ" required>
                        </div>
                        <div class="form-group">
                            <input type="text" id="expiry-date" name="expiry-date" placeholder="Ngày hết hạn (MM/YY)" required>
                        </div>
                        <div class="form-group">
                            <input type="password" id="cvv" name="cvv" placeholder="CVV" required>
                        </div>
                    </div>


                    <button type="submit" class="btn">Thanh toán</button>
                </form>
            </div>
        </div>
        <div id="content" class="form-group">
                <div class="detailPayCart">
                    <div class="title_detail_cart">
                        <p class="name_detail_cart">ĐƠN HÀNG CỦA BẠN</p>
                    </div>
                    <div class="content_detailPayCart">
                        <div class="box_content_detailPayCart">
                            <p class="lable_detailPayCart">Sản phẩm</p>
                            <p class="lable_detailPayCart">Tạm tính</p>
                        </div>
                        <div class="box_content_detailPayCart">
                            <p class="lable_detailPayCart"><?php echo $product_name; ?></p>
                            <p class="lable_detailPayCart"><?php echo number_format($product_price, 0, ',', '.') . ' VND'; ?></p>
                        </div>
                        <div class="box_content_detailPayCart">
                            <div class="title_box_content">
                                <p class="lable_content">Tạm tính</p> <br>
                                <p class="lable_content">Giao hàng</p>
                            </div>
                            <div class="title_box_content">
                                <p class="price_title_box"><?php echo number_format($product_price, 0, ',', '.') . ' VND'; ?></p>
                                <br>
                                <p><span class="lable_content">Đồng giá: </span>30.000 VND</p>
                            </div>
                        </div>
                        <div class="box_content_detailPayCart">
                            <p class="lable_detailPayCart">Tổng cộng</p>
                            <p class="lable_detailPayCart"><?php echo number_format($total_price, 0, ',', '.') . ' VND'; ?></p>
                        </div>
                    </div>
                </div>
        </div>

    </div>

    <footer class="bg-white py-5">
        <div class="container">
            <div class="row align-items-center">
                <!-- Logo Section -->
                <div class="col-md-3 text-center text-md-start mb-4 mb-md-0">
                    <div class="logo_footer">
                        <img src="../image/logo.webp" alt="logo" class="img-fluid" style="max-height: 40px;">
                    </div>
                </div>

                <!-- Contact Section -->
                <div class="col-md-3">
                    <h5 class="mb-3">LIÊN HỆ</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fa-solid fa-location-dot me-2"></i>54 Triều Khúc - Thanh Xuân - Hà Nội</li>
                        <li class="mb-2"><i class="fa-solid fa-phone me-2"></i>Hotline: 083868386</li>
                        <li><i class="fa-solid fa-envelope me-2"></i>Email: utt@gmail.com</li>
                    </ul>
                </div>

                <!-- Policy Section -->
                <div class="col-md-3">
                    <h5 class="mb-3">CHÍNH SÁCH</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-decoration-none text-dark">Chính sách thành viên</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-dark">Chính sách đổi trả</a></li>
                        <li><a href="#" class="text-decoration-none text-dark">Chính sách vận chuyển</a></li>
                    </ul>
                </div>

                <!-- Social Media Section -->
                <div class="col-md-3 text-center text-md-start">
                    <h5 class="mb-3">KẾT NỐI</h5>
                    <div class="d-flex justify-content-md-start justify-content-center gap-4">
                        <a href="#" class="text-dark"><i class="fa-brands fa-facebook fa-2x"></i></a>
                        <a href="#" class="text-dark"><i class="fa-brands fa-instagram fa-2x"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <div class="footer-bottom"></div>
</body>
</html>