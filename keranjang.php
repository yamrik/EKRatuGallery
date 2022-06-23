<?php
include 'code/config.php';
$kosong=$keranjang->getAllData();
$no=1;
if(isset($_POST['delete'])){
    $keranjang->delKeranjang();}
if(isset($_POST['checkout']) and $kosong==null){
    echo("<script LANGUAGE='JavaScript'>
                    window.alert('Maaf anda belum menambahkan barang kedalam keranjang');
                    window.location.href='keranjang.php';
                </script>");
    }
    else if(isset($_POST['checkout']) and $kosong!=null)
    {header("Location: checkout.php");};
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once "theme/head.php";?>
<body>
<?php require_once "theme/navig.php";?>
<?php require_once "theme/header.php";?>

<div class="container py-5 full-height">
    <h2>Tabel Keranjang <i class="bi bi-cart"></i></h2>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Ukuran</th>
                    <th>Warna</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Pilihan</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $total=0;
            $sumjumlah=0;
            foreach((array) $keranjang->getAllData() as $d){
                $item=$produk->getDataById($d['id_product']);
                $subtotal=$d['total']*$item['price'];
                $subjumlah=$d['total'];
            ?>
                <tr>
                    <td><?=$no?>.</td>
                    <td><?=$item['name']?></td>
                    <td><?=$d['size']?></td>
                    <td><?=$d['color']?></td>
                    <td><?=$produk->getRupiahFormat($item['price'])?></td>
                    <td><?=$d['total']?></td>
                    <td><?=$produk->getRupiahFormat($subtotal)?></td>
                    <td>
                        <form action="keranjang.php?id_cart=<?=$d['id_cart']?>" class="text-right" method="POST">
                            <input type="submit" name="delete" class="btn btn-danger mx-1" value="Hapus">
                        </form>
                    </td>
                </tr>
            <?php
            $total+=$subtotal;
            $sumjumlah+=$subjumlah;
            $no++;
            }
            ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan='5'>Total Yang Harus Dibayar:</td>
                    <td colspan='1'><?=$sumjumlah?></td>
                    <td colspan='1'><?=$produk->getRupiahFormat($total)?></td>
                    <td ><form action="" class="text-right" method="POST">
                            <input type="submit" name="checkout" class="btn btn-success mx-1 hollow circle" value="Checkout">
                        </form>
                    </td>
                </tr>
                <tr>
                    <td colspan="8"><button class="btn btn-secondary" type="button" onclick="history.back()">Kembali</button></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<?php require_once "theme/footer.php"; ?>
</body>
</html>