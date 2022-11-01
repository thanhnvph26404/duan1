<?php
ob_start();
session_start();
include "model/pdo.php";
include "model/sanpham.php";
include "global.php";
include "model/danhmuc.php";
include "model/taikhoan.php";
include "model/cart.php";

if (!isset($_SESSION['mycart'])) {
    $_SESSION['mycart'] = [];
}

$dsdm = loadall_danhmuc();
$spnew = loadall_sanpham_home();
$dstop10 = loadall_sanpham_top10();
include "view/header.php";
if ((isset($_GET['act'])) && ($_GET['act'] != "")) {
    $act = $_GET['act'];
    switch ($act) {
        case 'gioithieu':
            include "view/gioithieu.php";
            break;
        case 'bill':
            include "view/cart/bill.php";
            break;
        case 'viewcart':
            include "view/cart/viewcart.php";
            break;
        case 'dangnhap':
            if (isset($_POST['dangnhap']) && ($_POST['dangnhap'])) {

                $user = $_POST['user'];
                $pass = $_POST['pass'];
                $checkuser = checkuser($user, $pass);

                if (is_array($checkuser)) {
                    extract($checkuser);
                    $_SESSION['user'] = $checkuser;
                    header("location: index.php");
                } else {
                    $thongbao = "Tài khoản không tồn tại, vui lòng kiểm tra lại";
                }
            }
            include "view/taikhoan/dangnhap.php";
            break;

        case 'edit_taikhoan':
            if (isset($_POST['capnhat']) && ($_POST['capnhat'])) {
                $user = $_POST['user'];
                $pass = $_POST['pass'];
                $email = $_POST['email'];
                $tel = $_POST['tel'];
                $address = $_POST['address'];
                $id = $_POST['id'];

                update_taikhoan($id, $user, $pass, $email, $address, $tel);
                $_SESSION['user'] = checkuser($user, $pass);
                header('location: index.php?act=edit_taikhoan');
            }
            include "view/taikhoan/edit_taikhoan.php";
            break;

        case 'quenmk':

            if (isset($_POST['guiemail']) && ($_POST['guiemail'])) {

                $email = $_POST['email'];
                $checkemail = checkemail($email);
                if (is_array($checkemail)) {
                    // var_dump($checkemail);die;
                    $thongbao = "Mật khẩu của bạn là: " . $checkemail['customerPassword'];
                } else {
                    $thongbao = "Email không tồn tại";
                }
            }
            include "view/taikhoan/quenmk.php";
            break;
        case 'dangky':
            if (isset($_POST['dangky']) && ($_POST['dangky'])) {
                $email = $_POST['email'];
                $user = $_POST['user'];
                $pass = $_POST['pass'];
                insert_taikhoan($email, $user, $pass);
                $thongbao = "Đăng ký thành công, vui lòng đăng nhập ";
            }
            include "view/taikhoan/dangki.php";
            break;
        case 'lienhe':
            include "view/lienhe.php";
            break;
        case 'sanpham':
            if (isset($_POST['kyw']) && ($_POST['kyw'] != "")) {
                $kyw = $_POST['kyw'];
            } else {
                $kyw = "";
            }
            if (isset($_GET['iddm']) && ($_GET['iddm'] > 0)) {
                $iddm = $_GET['iddm'];
            } else {
                $iddm = 0;
            }
            $dssp = loadall_sanpham($kyw, $iddm);
            $tendm = load_ten_dm($iddm);
            include "view/sanpham.php";
            break;
        case 'sanphamct':

            if (isset($_GET['idsp']) && ($_GET['idsp'] > 0)) {
                $id = $_GET['idsp'];

                $onesp = loadone_sanpham($id);
                extract($onesp);
                $sp_cung_loai = load_sanpham_cungloai($id, $categoryId);

                include "view/sanphamct.php";
            } else {
                include "view/home.php";
            }

            break;
        case 'thoat':
            session_unset();
            header("location: index.php");

            break;
        case 'gioithieu':
            include "view/gioithieu.php";
            break;

        case 'delcart':

            if (isset($_GET['idcart'])) {
                array_splice($_SESSION['mycart'], $_GET['idcart'], 1);
            } else {
                $_SESSION['mycart'] = [];
            }
            header('location: index.php?act=viewcart');
            break;


        case 'addtocart':
            if (isset($_POST['addtocart']) && ($_POST['addtocart'])) {
                $id = $_POST['id'];
                $name = $_POST['name'];
                $img = $_POST['img'];
                $price = $_POST['price'];
                $soluong = 1;
                $ttien = $soluong * $price;
                $spadd = [$id, $name, $img, $price, $soluong, $ttien];
                array_push($_SESSION['mycart'], $spadd);
            }
            include "view/cart/viewcart.php";
            break;

        case 'mybill':
            $listbill = loadall_bill($_SESSION['user']['id']);
            include "view/cart/mybill.php";
            break;
        
        case 'billconfirm':
            if (isset($_POST['dongydathang']) && ($_POST['dongydathang'])) {
                if ($_SESSION['user']) {
                    $iduser = $_SESSION['user']['id'];
                } else {
                    $iduser = 0;
                }
                $name = $_POST['name'];
                $email = $_POST['email'];
                $address = $_POST['address'];
                $pttt = $_POST['pttt'];
                $tel = $_POST['tel'];
                $ngaydathang = date('h:i:sa d/m/Y');
                $tongdonhang = tongdonhang();
                $idbill = insert_bill($iduser, $name, $email, $address, $tel, $pttt, $ngaydathang, $tongdonhang);

                //insert into cart: session['mycart'] && idbill
                foreach ($_SESSION['mycart'] as $cart) {
                    insert_cart($_SESSION['user']['id'], $cart[0], $cart[2], $cart[1], $cart[3], $cart[4], $cart[5], $idbill);
                }
                //xóa ss cart
                $_SESSION['cart'] = [];
            }
            $bill = loadone_bill($idbill);

            $billct = loadall_cart($idbill);
            include "view/cart/billconfirm.php";
            break;
        default:
            # code...
            break;
    }
} else {
    include "view/home.php";
}

include "view/footer.php";
ob_flush();
