<article>
    <div class="headline">
        <h2>QUẢN LÝ HÀNG HÓA</h2>
    </div>
    <form action="index.php?act=adddm" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="">Mã loại</label>
                    <input class="form-control" type="text" name="maloai" readonly placeholder="auto number" disabled>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="">Tên loại</label>
                    <input class="form-control" type="text" name="tenloai" placeholder="tên hàng">
                </div>
            </div>
            

        </div>
        <button class="btn" type="submit" name="themmoi">Thêm</button>
        <button class="btn"><a href="index.php?act=listdm">Danh sách</a></button>
        <?php
        if(isset($thongbao) && ($thongbao != "")) echo $thongbao;
        ?>
    </form>
</article>