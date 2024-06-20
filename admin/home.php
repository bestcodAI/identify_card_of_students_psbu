<h1>Welcome, <?php echo $_settings->userdata('firstname')." ".$_settings->userdata('lastname') ?>!</h1>
<hr>
<div class="row">
  <div class="col-12 col-sm-4 col-md-4">
    <div class="info-box">
      <span class="info-box-icon bg-gradient-olive elevation-1"><i class="fas fa-horse-head"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Animals Listed</span>
        <span class="info-box-number text-right h5">
          <?php 
            $animal = $conn->query("SELECT * FROM animal_list where delete_flag = 0")->num_rows;
            echo format_num($animal);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-4 col-md-4">
    <div class="info-box">
      <span class="info-box-icon bg-gradient-warning elevation-1"><i class="fas fa-coins"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Today's Total Collections</span>
        <span class="info-box-number text-right h5">
          <?php 
            $collection = $conn->query("SELECT SUM(COALESCE((adult_price * adult_no) + (child_price * child_no), 0)) FROM ticket_list where date(date_created) = '".date('Y-m-d')."' ")->fetch_array()[0];
            echo format_num($collection);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-4 col-md-4">
    <div class="info-box">
      <span class="info-box-icon bg-gradient-light elevation-1"><i class="fas fa-ticket-alt"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Total Visitor Today</span>
        <span class="info-box-number text-right h5">
          <?php 
            $visitor = $conn->query("SELECT SUM(COALESCE( (adult_no + child_no) ,0)) FROM ticket_list where date(date_created) = '".date('Y-m-d')."' ")->fetch_array()[0];
            echo format_num($visitor);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-4 col-md-4">
    <div class="info-box">
      <span class="info-box-icon bg-gradient-dark elevation-1"><i class="fas fa-ticket-alt"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Total Adult Visitor Today</span>
        <span class="info-box-number text-right h5">
          <?php 
            $visitor = $conn->query("SELECT SUM(COALESCE(adult_no ,0)) FROM ticket_list where date(date_created) = '".date('Y-m-d')."' ")->fetch_array()[0];
            echo format_num($visitor);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <div class="col-12 col-sm-4 col-md-4">
    <div class="info-box">
      <span class="info-box-icon bg-gradient-secondary elevation-1"><i class="fas fa-ticket-alt"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Total Child Visitor Today</span>
        <span class="info-box-number text-right h5">
          <?php 
            $visitor = $conn->query("SELECT SUM(COALESCE(child_no ,0)) FROM ticket_list where date(date_created) = '".date('Y-m-d')."' ")->fetch_array()[0];
            echo format_num($visitor);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-4 col-md-4">
    <div class="info-box">
      <span class="info-box-icon bg-gradient-primary elevation-1"><i class="fas fa-info-circle"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Read Inquiries</span>
        <span class="info-box-number text-right h5">
          <?php 
            $inquiry = $conn->query("SELECT * FROM inquiry_list where `status` = 1")->num_rows;
            echo format_num($inquiry);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-4 col-md-4">
    <div class="info-box">
      <span class="info-box-icon bg-gradient-danger elevation-1"><i class="fas fa-info-circle"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Unread Inquiries</span>
        <span class="info-box-number text-right h5">
          <?php 
            $inquiry = $conn->query("SELECT * FROM inquiry_list where `status` = 0")->num_rows;
            echo format_num($inquiry);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
</div>
<div class="container">
  <?php 
    $files = array();
      $fopen = scandir(base_app.'uploads/banner');
      foreach($fopen as $fname){
        if(in_array($fname,array('.','..')))
          continue;
        $files[]= validate_image('uploads/banner/'.$fname);
      }
  ?>
  <div id="tourCarousel"  class="carousel slide" data-ride="carousel" data-interval="3000">
      <div class="carousel-inner h-100">
          <?php foreach($files as $k => $img): ?>
          <div class="carousel-item  h-100 <?php echo $k == 0? 'active': '' ?>">
              <img class="d-block w-100  h-100" style="object-fit:contain" src="<?php echo $img ?>" alt="">
          </div>
          <?php endforeach; ?>
      </div>
      <a class="carousel-control-prev" href="#tourCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#tourCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
      </a>
  </div>
</div>
