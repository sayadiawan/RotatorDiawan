<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <div class="nav-link">
                <div class="profile-image">
                    <img src="{{ show_image('images/user_thub/'.$AuthData->employee->avatar) }}" alt="image" />
                </div>
                <div class="profile-name">
                    <p class="name">
                        {{$AuthData->name}}
                    </p>
                    <p class="designation">
                        {{$AuthData->level}}
                    </p>
                </div>
            </div>
        </li>
        @foreach ($modules as $module)
        @php
        //role config
        $role_access = isAccess('list',$module->id_module,$AuthData->roles);
        if(!$role_access){continue;}
        @endphp
        @if ($module->modules->count() > 0)
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#{{$module->link_module}}" aria-expanded="false"
                aria-controls="sidebar-layouts">
                <i class="{{$module->icon_module}} menu-icon"></i>
                <span class="menu-title">{{$module->name_module}}</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="{{$module->link_module}}">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="/{{$module->link_module}}">Dashboard {{$module->name_module}}</a>
                    </li>
                    @foreach ($module->modules as $submodule)
                    @php
                    //role config
                    $role_access = isAccess('list',$submodule->id_module,$AuthData->roles);
                    if(!$role_access){continue;}
                    @endphp
                    <li class="nav-item">
                        <a class="nav-link" href="/{{$submodule->link_module}}">{{$submodule->name_module}}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </li>
        @else
        <li class="nav-item">
            <a class="nav-link" href="/{{$module->link_module}}">
                <i class="{{$module->icon_module}} menu-icon"></i>
                <span class="menu-title" style="margin-left:-5px">{{$module->name_module}}</span>
            </a>
        </li>
        @endif
        @endforeach
    </ul>
</nav>