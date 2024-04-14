<!doctype html>
<html lang="en">

<head>
  @include('admin.metadata')
  @yield('css')
</head>

<body class="sidebar-toggle-display sidebar-hidden">
  <div class="container-scroller">
    @include('admin.header')
    <div class="container-fluid page-body-wrapper">
      @include('admin.navigation')
      <div class="main-panel">
        <div class="content-wrapper">
          @yield('page-title')
          @yield('content')
        </div>
      </div>
    </div>
    @include('admin.footer')
  </div>

  <script>
    $(document).ready(function() {
      $('#set-data').DataTable({
        stateSave: true
      });

      $(".alert").fadeOut(5000);
      // Default Datatables
      $('.smt-table').DataTable();
      // bind change event to select
      $('#smt_navigation').on('change', function() {
        var url = $(this).val(); // get selected value
        if (url) { // require a URL
          window.location = url; // redirect
        }
        return false;
      });
    });
  </script>
  @yield('script')
</body>

</html>
