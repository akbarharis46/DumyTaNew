<?php if($this->session->userdata('level')!='admin'){redirect('login');};?>
<link href="<?php echo base_url('assets')?>/assets/css/datatables.css" rel="stylesheet" type="text/css" />
<div class="cc">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid" >
        <div class="row mb-2">
          <div class="col-sm-6">
            <h2 class="m-0 text-primary" ><i class="nav-icon fas fa-microphone" ></i> Data Pengiriman Barang</h2>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
      <div class="alert alert-secondary" role="alert">
      <i class="nav-icon fas fa-home"></i> Dashboard &nbsp; &nbsp; > &nbsp;  &nbsp;<i class="nav-icon fas fa-microphone"></i> Pengiriman
        </div>
        <div class="row">
          <div class="col"> 
              <!-- Tabel -->
              <div class="card">
            <!-- /.card-header -->
            <div class="card-body" >
                <div class='card-header' style="margin-left:-20px;">
                 
                 
                <form action="<?php echo site_url(); ?>pengirimanclient/exportToPDF/" method="GET">
                <div class="row">
                
                  <div class="col-md-3">

                    <a class='btn btn-primary' href="<?php echo site_url(); ?>pengirimanclient/post/">
                      <i class="fa fa-plus"></i>
                      <span>
                        Tambah
                      </span>
                    </a>

                  </div>

                  
                  <div class="col-md-4">


                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="far fa-calendar-alt"></i>
                        </span>
                      </div>
                      <input type="text" name="interval-tanggal" class="form-control float-right" id="aktif-date-range">
                    </div>                  
                  </div>
                  <div class="col-md-5">
                  
                    <button class='btn btn-outline-danger'>
                      <i class="fa fa-file-pdf"></i>
                      <span>
                        Filter PDF
                      </span>
                    </button>
                    <a class='btn btn-danger' href="<?php echo site_url(); ?>pengirimanclient/exportToPDF/">
                      <i class="fa fa-file-pdf"></i>
                      <span>
                        Cetak Keseluruhan
                      </span>
                    </a>
                  
                  </div>

                </div>
                </form>

                </div>   
                  <span>
                  <br>
                    <?php
                   if (!empty($this->session->flashdata('pesan')))
                   {
                     ?>
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $this->session->flashdata('pesan');?>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  </div>
                  <?php   
                  }
                  ?>

                  <?php
                   if (!empty($this->session->flashdata('pesan2')))
                   {
                     ?>
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <?= $this->session->flashdata('pesan2');?>
                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                </div>
                 <?php   
                 }
                 ?>

                  <?php
                   if (!empty($this->session->flashdata('pesan3')))
                   {
                     ?>
                  <div class="alert alert-warning alert-dismissible fade show" role="alert">
                  <?= $this->session->flashdata('pesan3');?>
                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                </div>
                 <?php   
                 }
                 ?>
                 </span> 
                 
              <table id="tabel" class="table table-striped dataTable-table">
                <thead>
                <tr>
                  <th data-sourtable="">NOMOR</th>
                  <th data-sourtable="">NAMA PENGIRIM</th>
                  <th data-sourtable="">NOMOR HP PETUGAS PENGIRIMAN</th>
                  <th data-sourtable="">TUJUAN PENGIRIMAN</th>
                  <th data-sourtable="">JUMLAH PENGIRIMAN</th>
                  <th data-sourtable="">JENIS KENDARAAN</th>
                  <th data-sourtable="">NOMOR KENDARAAN</th>
                  <th data-sourtable="">TANGGAL</th>
                  <th data-sourtable="">STATUS PENGIRIMAN</th>
                  <th data-sourtable="">AKSI</th>
 
                </tr>
                </thead>
                <tbody>
                <?php 
                  $i=1;

                foreach ($pengiriman as $rows) : ?>
                    <tr>
                        <td><?php echo  $i++; ?></td>
                        <td><?php echo $rows->nama_pengirim; ?>
                        <td><?php echo $rows->nomorhp; ?>
                        <td><?php echo $rows->tujuan; ?>
                        <td><?php echo $rows->jumlah; ?>
                        <td><?php echo $rows->jenis_kendaraan; ?>
                        <td><?php echo $rows->nomor_kendaraan; ?>
                        <td><?php echo $rows->tanggal; ?>
                        <td><?php echo $rows->status_pengiriman; ?>


                            </td>
                        <td>
                            <a href="<?php echo site_url(); ?>pengirimanclient/put/<?php echo $rows->id_pengiriman; ?>" class="btn btn-warning">
                            <i class="fa fa-pen" aria-hidden="true"></i></a>


                            <a href="<?= base_url(); ?>pengirimanclient/delete/<?= $rows->id_pengiriman; ?>" class="btn btn-danger" onClick="return confirm('yakin mau hapus');">
                            <i class="fa fa-trash" aria-hidden="true"></i></a>


                            <a class='btn btn-danger' href="<?php echo site_url(); ?>pengirimanclient/exportsuratjalan/<?= $rows->id_pengiriman ?>">
            			          <i class="fa fa-file-pdf"></i></a>
                      

                            <a class="btn btn-success "  href="<?=base_url();?>pengirimanclient/barang_keluar/<?= $rows->id_pengiriman;?>">
                            <i class="fa fa-file-exit"></i></a>
                        </td>
                    </tr>
                    <?php endforeach ; ?>
                </tbody>
              </table>             
            <!-- /.card-body -->
          </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->