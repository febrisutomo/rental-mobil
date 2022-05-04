<?php
if ($_SESSION['login']!='user') {
    header('Location:index.php#login');
}
$id = $_GET['id'];
$car = select("SELECT * FROM tb_mobil WHERE id_mobil = $id")[0];

function rental($data)
{
    global $conn;
    global $_SESSION;


    $id_user = $_SESSION['id'];
    $id_mobil = $data['id_mobil'];
    $harga = $data['harga'];
    $time = $data['tgl_sewa'] . " " . $data['jam_sewa'];
    $tgl_sewa = date('Y-m-d H:i:s', strtotime("$time"));
    $durasi = htmlspecialchars($data['durasi']);
    $total_harga = (int)$harga * (int)$durasi;;

    $query = "INSERT INTO tb_transaksi VALUES(NULL, $id_user, $id_mobil, '$tgl_sewa', $durasi, $total_harga, NULL, NULL, 'dibooking' )";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

?>
<section id="rental" class="mt-5">
    <div class="container">
        <div class="section-title justify-content-start">
            <h2><?= $car['nama_mobil']; ?></h2>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-8 m-auto">
                <img src="../src/img/mobil/<?= $car['gambar']; ?>" class="img-fluid">
                <div class="row pt-3">
                    <div class="col-3 text-center">
                        <i class="fa fa-money-bill-wave"></i>
                        <h6>IDR<?= $car['harga']; ?>K</h6>
                    </div>
                    <div class="col-3 text-center">
                        <i class="fa fa-cogs"></i>
                        <h6><?= $car['transmisi']; ?></h6>
                    </div>
                    <div class="col-3 text-center">
                        <i class="fa fa-chair"></i>
                        <h6><?= $car['jml_seat']; ?></h6>
                    </div>
                    <div class="col-3 text-center">
                        <i class="fa fa-paint-roller"></i>
                        <h6><?= $car['warna']; ?></h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">

                <div class="card">
                    <form id="rental" action="" method="POST">
                        <div class="card">
                            <div class="card-body">
                                <input type="text" name="id_mobil" id="id_mobil" value="<?= $car['id_mobil']; ?>" hidden>
                                <input type="text" name="harga" id="harga" value="<?= $car['harga']; ?>" hidden>
                                <h4 class="text-center">Book This Car</h4>
                                <div class="form-group">
                                    <label for="tgl_sewa">Pick Up Date</label>
                                    <input type="text" class="form-control" name="tgl_sewa" id="tgl_sewa" placeholder="Pick Up Date" required>
                                </div>
                                <div class="form-group">
                                    <label for="jam_sewa">Pick Up Time</label>
                                    <input type="time" class="form-control" name="jam_sewa" id="jam_sewa" placeholder="Pick Up Time" required>
                                </div>
                                <div class="form-group">
                                    <label for="durasi">Duration</label>
                                    <input type="number" class="form-control" name="durasi" id="durasi" placeholder="Duration (day)" required>
                                </div>
                                <div class="form-group">
                                    <label for="total">Total Amount</label>
                                    <input type="text" class="form-control" style="font-size: xx-large;" name="total" id="total" readonly>
                                </div>
                                <div class="float-right">
                                    <button type="submit" name="rental" class="btn btn-primary" onclick="return confirm('Apakah anda yakin ingin menyewa mobil ini?')">Book Now</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
$( function() {
    $( "#tgl_sewa" ).datepicker({ minDate: 0, maxDate: "+3D" });
  } );
</script>

 <!-- ajax total harga  -->
 <script>
    $(document).ready(function() {
      $("#harga, #durasi").keyup(function() {
        if ($("#durasi").val() != "") {
          var harga = $("#harga").val();
          var durasi = $("#durasi").val();
          var total = "Rp" + parseInt(harga) * parseInt(durasi) + ".000,-";
        } else {
          var total = "Rp" + 0 + ",-";
        }
        $("#total").val(total);
      });
    });
  </script>

<?php
// booking  alert
if (isset($_POST["rental"])) {
    $rental = rental($_POST);
    if ($rental > 0) {
      echo "
          <script>
              Swal.fire({
                  icon: 'success',
                  title: 'Mobil berhasil dibooking!',
                  showConfirmButton: false,
                  timer: 1500,
              })
              .then(function() {
                  window.location = '?page=profil';
              });
          </script>
      ";
    } else {
      echo "
              <script>
                  Swal.fire({
                      icon: 'error',
                      title: 'Transaksi gagal!',
                  })
              </script>
          ";
    }
  }

?>