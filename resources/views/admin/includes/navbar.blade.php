<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="{{ url('home') }}" class="app-brand-link">
      <span class="app-brand-logo demo">
        <img src="{{ asset('admin-assets/assets/img/icons/diawan_logo_small.png') }}" width="50" viewBox="0 0 25 42"
          alt="" />
      </span>

      <span class="app-brand-text demo menu-text fw-bolder ms-2">Diawan.io</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">

    {{-- get module menu --}}
    @foreach ($modules as $module)
      @php
        //role config
        $role_access = isAccess('list', $module->id_module, $AuthData->roles);
        
        if (!$role_access) {
            continue;
        }
      @endphp

      @if ($module->modules->count() > 0)
        <li class="menu-item menu-sub-parent">
          <a href="javascript:void(0)" class="menu-link menu-toggle">
            <i class="menu-icon {{ $module->icon_module }}"></i>
            <div data-i18n="{{ $module->name_module }}">{{ $module->name_module }}</div>
          </a>

          <ul class="menu-sub">
            <li class="menu-item {{ activeMenu($module->link_module) }}">
              <a href="/{{ $module->link_module }}" class="menu-link">
                <div data-i18n="{{ $module->name_module }}">Dashboard {{ $module->name_module }}</div>
              </a>
            </li>

            @foreach ($module->modules as $submodule)
              @php
                //role config
                $role_access = isAccess('list', $submodule->id_module, $AuthData->roles);
                
                if (!$role_access) {
                    continue;
                }
              @endphp

              <li class="menu-item {{ activeMenu($submodule->link_module) }}">
                <a href="/{{ $submodule->link_module }}" class="menu-link">
                  <div data-i18n="{{ $submodule->name_module }}">{{ $submodule->name_module }}</div>
                </a>
              </li>
            @endforeach
          </ul>
        </li>
      @else
        <li class="menu-item {{ activeMenu($module->link_module) }}">
          <a href="/{{ $module->link_module }}" class="menu-link">
            <i class="menu-icon {{ $module->icon_module }}"></i>
            <div data-i18n="{{ $module->name_module }}">{{ $module->name_module }}</div>
          </a>
        </li>
      @endif
    @endforeach
    {{-- /get module menu --}}
  </ul>
</aside>
