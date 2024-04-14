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
                  @foreach (($module->where('id_module','925d041e-6aa8-4dfc-ae09-3a40c1587ff5')->get()) as $mdl)
                  <li class="jarak-menu">
                    <span class="font-menu-icon" style="font-size:14px;">
                      <i class="{{$mdl->icon_module}} mr-1"></i> <a href="{{url($mdl->link_module)}}"
                        class="font-white">{{$mdl->name_module}}</a>
                    </span>
                  </li>
                  @endforeach
                </ul>
              </div>
            </div>
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>
<br>