<?php

$mobil = select("SELECT COUNT(id_mobil) as jumlah FROM tb_mobil")[0]['jumlah'];
$user = select("SELECT COUNT(id_user) as jumlah FROM tb_user")[0]['jumlah'];
$peminjaman = select("SELECT COUNT(id_transaksi) as jumlah FROM tb_transaksi")[0]['jumlah'];
$aktif = select("SELECT COUNT(id_transaksi) as jumlah FROM tb_transaksi 
                    JOIN tb_user ON tb_transaksi.id_user= tb_user.id_user 
                    JOIN tb_mobil ON tb_transaksi.id_mobil = tb_mobil.id_mobil 
                    WHERE status = 'dibooking' OR status = 'disewakan'")[0]['jumlah'];
?>
<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3><?= $user; ?></h3>

                <p>Total User</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
                <!-- <i class="ion ion-bag"></i> -->
            </div>
            <a href="?page=data-user" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3><?= $mobil; ?></h3>

                <p>Total Mobil</p>
            </div>
            <div class="icon">
                <i class="fas fa-car"></i>
                <!-- <i class="ion ion-stats-bars"></i> -->
            </div>
            <a href="?page=data-mobil" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3><?= $peminjaman; ?></h3>

                <p>Total Transaksi</p>
            </div>
            <div class="icon">
                <i class="fas fa-chart-line"></i>
                <!-- <i class="ion ion-person-add"></i> -->
            </div>
            <a href="?page=log-rental" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3><?= $aktif; ?></h3>

                <p>Transaksi Berjalan</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-clock"></i>
                <!-- <i class="ion ion-pie-graph"></i> -->
            </div>
            <a href="?page=transaksi-rental" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-5">
        <!-- Calendar -->
        <div class="card bg-gradient-success">
            <div class="card-header border-0">
                <h3 class="card-title">
                    <i class="far fa-calendar-alt"></i>
                    Calendar
                </h3>
                <!-- tools card -->
                <div class="card-tools">
                    <!-- button with a dropdown -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" data-offset="-52">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div class="dropdown-menu" role="menu">
                            <a href="#" class="dropdown-item">Add new event</a>
                            <a href="#" class="dropdown-item">Clear events</a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">View calendar</a>
                        </div>
                    </div>
                    <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <!-- /. tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body pt-0">
                <!--The calendar -->
                <div id="calendar" style="width: 100%"></div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>

</div>
