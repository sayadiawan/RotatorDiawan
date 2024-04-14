<!DOCTYPE html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-default"
  data-assets-path="../../admin-assets/assets/" data-template="vertical-menu-template-free">

<head>
  @include('admin.includes.meta')

  <title>Diawan | @yield('title')</title>

  @stack('before-style')

  @include('admin.includes.style')

  @stack('after-style')
</head>

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <!-- Menu -->
      @include('admin.includes.navbar')
      <!-- / Menu -->

      <!-- Layout container -->
      <div class="layout-page">
        <!-- Navbar -->
        @include('admin.includes.header')
        <!-- / Navbar -->

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Content -->
          @yield('content')
          <!-- / Content -->

          <!-- Footer -->
          @include('admin.includes.footer')
          <!-- / Footer -->

          <div class="content-backdrop fade"></div>
        </div>
        <!-- Content wrapper -->
      </div>
      <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
  </div>
  <!-- / Layout wrapper -->

  @stack('before-script')
  @include('admin.includes.script')
  <script>
    $('.table-responsive').on('show.bs.dropdown', function() {
      $('.table-responsive').css("overflow", "inherit");
    });

    $('.table-responsive').on('hide.bs.dropdown', function() {
      $('.table-responsive').css("overflow", "auto");
    })
    $(document).ready(function() {
      if ($('.smt-select2').length) {
        $('.smt-select2').select2({
          theme: "bootstrap-5"
        });
      }

      // bind change event to select
      $('#smt_navigation').on('change', function() {
        var url = $(this).val(); // get selected value
        if (url) { // require a URL
          window.location = url; // redirect
        }
        return false;
      });

      // check active sub parent menu
      var listItems = $('.layout-menu ul li.menu-sub-parent ul.menu-sub .menu-item');

      //Loop the listitems and check to see if any are active.
      $.each(listItems, function(key, litem) {
        if ($(litem).hasClass('active')) {
          $(this).parent().parent().addClass('active open');
          return false;
        } else {
          $(this).parent().parent().removeClass('active open');
        }
      })
    });
  </script>
  @stack('after-script')
</body>

</html>
