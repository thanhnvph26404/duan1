<div class="headline">
                <h2>QUẢN LÝ BÌNH LUẬN</h2>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th>#</th>
                        <th>ID</th>
                        <th>Nội dung</th>
                        <th>Iduser</th>
                        <th>Idproduct</th>
                        <th>Ngày bình luận</th>
                        
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($listbinhluan as $key => $value): extract($value);
                       
                        $xoabl = "index.php?act=xoabl&id=".$id;
                        ?>
                        
                    <tr>
                        <td><input type="checkbox"></td>
                        <td><?php echo $key+1 ?></td>
                        <td><?php echo $id?></td>
                        <td><?php echo $commentContent?></td>
                        <td><?php echo $customerId?></td>
                        <td><?php echo $productId?></td>
                        <td><?php echo $commentDate?></td>
                        
                        <td>
                            
                            <button class="btn btn-danger"><a href="<?php echo $xoabl?>">Xóa</a></button>
                        </td>
                    </tr>
                    <?php endforeach?>
                </tbody>
            </table>
            <a href="index.php?act=adddm"><button class="btn" type="submit" name="btn_insert">Thêm</button></a>
            <a href=""><button class="btn" type="submit" name="btn_insert">Chọn tất cả</button></a>
            <a href=""><button class="btn" type="submit" name="btn_insert">Bỏ chọn tất cả</button></a>
            <a href=""><button class="btn" type="submit" name="btn_insert">Xóa các mục đã chọn</button></a>
        </article>