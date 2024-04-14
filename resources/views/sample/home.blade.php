@extends('admin.layouts.app')

@section('css')
@endsection

@section('page-title')
@endsection

@section('content')
  <div class="page-header">
    <h3 class="page-title">
      Dashboard
    </h3>
  </div>
  <div class="row">

    <div class="col-12 grid-margin stretch-card">

      <div class="card card-menu">

        <div class="">

          <div class="d-md-flex justify-content-between align-items-center">

            <nav class="navbar navbar-expand-lg navbar-light ">

              <button class="navbar-toggler navbar-toggler-right border-0" type="button" data-toggle="collapse"
                data-target="#navbar4">

                <span class="ti-align-left font-white"></span>

              </button>

              <div class="container">

                <div class="collapse navbar-collapse" id="navbar4">

                  <ul class="navbar-nav mr-auto">


                    <li class="jarak-menu active-menu">

                      <span class="font-menu-icon">

                        <i class="fas fa-home mr-1"></i> <a href="" class="font-white">Beranda</a>

                      </span>

                    </li>


                    <li class="jarak-menu">
                      <span class="font-menu-icon" style="font-size:14px;">
                        <i class="fas fa-edit mr-1"></i> <a href="sample/table" class="font-white">Sample Table</a>
                      </span>
                    </li>
                    <li class="jarak-menu">
                      <span class="font-menu-icon" style="font-size:14px;">
                        <i class="fas fa-truck mr-1"></i> <a href="sample/form" class="font-white">Sample Form</a>
                      </span>
                    </li>
                    <li class="jarak-menu">
                      <span class="font-menu-icon" style="font-size:14px;">
                        <i class="fas fa-window-maximize mr-1"></i> <a href="sample/notfound" class="font-white">Sample
                          Not Found</a>
                      </span>
                    </li>
                  </ul>

                </div>

              </div>

            </nav>

          </div>

        </div>

      </div>

    </div>

  </div>
  <div class="row grid-margin">
    <div class="col-12">
      <div class="card card-statistics">
        <div class="card-body">
          <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
            <div class="statistics-item">
              <p>
                <i class="icon-sm fa fa-user mr-2"></i>
                Data User
              </p>
              <h2>54000</h2>
              <label class="badge badge-outline-success badge-pill">2.7% increase</label>
            </div>
            <div class="statistics-item">
              <p>
                <i class="icon-sm fas fa-hourglass-half mr-2"></i>
                Data Penjualan
              </p>
              <h2>123.50</h2>
              <label class="badge badge-outline-danger badge-pill">30% decrease</label>
            </div>
            <div class="statistics-item">
              <p>
                <i class="icon-sm fas fa-cloud-download-alt mr-2"></i>
                Downloads
              </p>
              <h2>3500</h2>
              <label class="badge badge-outline-success badge-pill">12% increase</label>
            </div>
            <div class="statistics-item">
              <p>
                <i class="icon-sm fas fa-check-circle mr-2"></i>
                Update
              </p>
              <h2>7500</h2>
              <label class="badge badge-outline-success badge-pill">57% increase</label>
            </div>
            <div class="statistics-item">
              <p>
                <i class="icon-sm fas fa-chart-line mr-2"></i>
                Sales
              </p>
              <h2>9000</h2>
              <label class="badge badge-outline-success badge-pill">10% increase</label>
            </div>
            <div class="statistics-item">
              <p>
                <i class="icon-sm fas fa-circle-notch mr-2"></i>
                Pending
              </p>
              <h2>7500</h2>
              <label class="badge badge-outline-danger badge-pill">16% decrease</label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">
            <i class="fas fa-gift"></i>
            Orders
          </h4>
          <canvas id="orders-chart"></canvas>
          <div id="orders-chart-legend" class="orders-chart-legend"></div>
        </div>
      </div>
    </div>
    <div class="col-md-4 grid-margin stretch-card">
      <div class="card">
        <div class="card-body d-flex flex-column">
          <h4 class="card-title">
            <i class="fas fa-chart-pie"></i>
            Sales status
          </h4>
          <div class="flex-grow-1 d-flex flex-column justify-content-between">
            <canvas id="sales-status-chart" class="mt-3"></canvas>
            <div class="pt-4">
              <div id="sales-status-chart-legend" class="sales-status-chart-legend"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 grid-margin stretch-card">
      <div class="card">
        <div class="card-body d-flex flex-column">
          <h4 class="card-title">
            <i class="fas fa-tachometer-alt"></i>
            Daily Sales
          </h4>
          <p class="card-description">Daily sales for the past one month</p>
          <div class="flex-grow-1 d-flex flex-column justify-content-between">
            <canvas id="daily-sales-chart" class="mt-3 mb-3 mb-md-0"></canvas>
            <div id="daily-sales-chart-legend" class="daily-sales-chart-legend pt-4 border-top"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Bar chart</h4>
          <div id="morris-bar-example"></div>
        </div>
      </div>
    </div>
    <div class="col-md-4 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Line chart</h4>
          <div id="morris-line-example"></div>
        </div>
      </div>
    </div>
    <div class="col-md-4 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Area chart</h4>
          <div id="morris-area-example"></div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-8 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Real-time Chart</h4>
          <div class="flot-chart-container">
            <div id="realtime-chart" class="flot-chart"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Sample</h4>
          <div class="mb-4" id="g1"></div>
          <div class="container text-center">
            <div id="g2" class="gauge"></div>
            <a href="#" class="btn btn-success" id="g2_refresh">Random Refresh</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-8 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">
            <i class="fas fa-table"></i>
            Sales Data
          </h4>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Customer</th>
                  <th>Item code</th>
                  <th>Orders</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="font-weight-bold">
                    Clifford Wilson
                  </td>
                  <td class="text-muted">
                    PT613
                  </td>
                  <td>
                    350
                  </td>
                  <td>
                    <label class="badge badge-success badge-pill">Dispatched</label>
                  </td>
                </tr>
                <tr>
                  <td class="font-weight-bold">
                    Mary Payne
                  </td>
                  <td class="text-muted">
                    ST456
                  </td>
                  <td>
                    520
                  </td>
                  <td>
                    <label class="badge badge-warning badge-pill">Processing</label>
                  </td>
                </tr>
                <tr>
                  <td class="font-weight-bold">
                    Adelaide Blake
                  </td>
                  <td class="text-muted">
                    CS789
                  </td>
                  <td>
                    830
                  </td>
                  <td>
                    <label class="badge badge-danger badge-pill">Failed</label>
                  </td>
                </tr>
                <tr>
                  <td class="font-weight-bold">
                    Adeline King
                  </td>
                  <td class="text-muted">
                    LP908
                  </td>
                  <td>
                    579
                  </td>
                  <td>
                    <label class="badge badge-primary badge-pill">Delivered</label>
                  </td>
                </tr>
                <tr>
                  <td class="font-weight-bold">
                    Bertie Robbins
                  </td>
                  <td class="text-muted">
                    HF675
                  </td>
                  <td>
                    790
                  </td>
                  <td>
                    <label class="badge badge-info badge-pill">On Hold</label>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">
            <i class="fas fa-calendar-alt"></i>
            Calendar
          </h4>
          <div id="inline-datepicker-example" class="datepicker"></div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
@endsection
