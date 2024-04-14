@extends('admin.layouts.app')

@push('after-style')
    <style>
        .range-wrap {
            position: relative;
            margin: 0 auto 3rem;
        }

        .form-range {
            width: 100%;
        }

        .bubble {
            background: red;
            color: white;
            padding: 4px 12px;
            position: absolute;
            border-radius: 4px;
            left: 50%;
            transform: translateX(-50%);
        }

        .bubble::after {
            content: "";
            position: absolute;
            width: 2px;
            height: 2px;
            background: red;
            top: -1px;
            left: 50%;
        }

        input[type=range]::-webkit-slider-thumb {
            -webkit-appearance: none;
            border: 1px solid #000000;
            height: 36px;
            width: 16px;
            border-radius: 3px;
            background: #ffffff;
            cursor: pointer;
            margin-top: -14px;
            /* You need to specify a margin in Chrome, but in Firefox and IE it is automatic */
            box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
            /* Add cool effects to your sliders! */
        }

        /* All the same stuff for Firefox */
        input[type=range]::-moz-range-thumb {
            box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
            border: 1px solid #000000;
            height: 36px;
            width: 16px;
            border-radius: 3px;
            background: #ffffff;
            cursor: pointer;
        }

        /* All the same stuff for IE */
        input[type=range]::-ms-thumb {
            box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
            border: 1px solid #000000;
            height: 36px;
            width: 16px;
            border-radius: 3px;
            background: #ffffff;
            cursor: pointer;
        }

        /*lock*/


        .box {
            margin: auto;
            /* padding: 50px 100px; */
        }

        .lock2 {
            display: none;
        }

        .lock2+label {
            display: black;
            margin-top: 9px;
            position: relative;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }

        .lock2+label:before {
            content: '';
            display: block;
            width: 15px;
            height: 10px;
            border-radius: 10px 10px 0 0;
            border: solid #23cc71;
            border-width: 5px 5px 0 5px;
            position: absolute;
            left: 3px;
            top: -11px;
            transform-origin: 1px 100%;
            transform: rotateY(180deg);
            transition: all 0.12s;

        }

        .lock2+label:after {
            content: 'Now lock it';
            display: inline-block;
            width: 90px;
            margin-left: 10px;
        }

        .lock2+label i {
            display: inline-block;
            vertical-align: top;
            width: 20px;
            height: 15px;
            background: #2ecc71;
            position: relative;
            transition: all 0.12s;
        }

        .lock2+label i:before {
            content: '';
            display: block;
            width: 4px;
            height: 4px;
            background: #484848;
            border-radius: 50%;
            position: absolute;
            top: 4px;
            left: 50%;
            margin-left: -2px;

        }

        .lock2+label i:after {
            content: '';
            display: block;
            width: 2px;
            height: 4px;
            background: #484848;
            border-radius: 0 0 50% 50%;
            position: absolute;
            top: 7px;
            left: 50%;
            margin-left: -1px;
        }

        .lock2:checked+label i {
            background: #fb4f4f;
        }

        .lock2:checked+label:before {
            border-color: #fb4f4f;
            transform: rotateY(0);
        }

        .lock2:checked+label:after {
            content: 'Ok, unlock it';
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mqtt/5.5.0/mqtt.js"></script>

    <link rel="stylesheet" href="{{ asset('admin-assets/assets/vendor/libs/plyr/plyr.css') }}" />

    <script>
        var recorder = {},
            recorder2 = {},
            trigger_mic_smarthome = {};
        trigger_mic_smarthome["first"] = 0;
    </script>


    <script src="https://www.gstatic.com/firebasejs/8.2.3/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.2.3/firebase-database.js"></script>

    {{-- <script src="https://www.gstatic.com/firebasejs/10.10.0/firebase-app.js"></script>

    <script src="https://www.gstatic.com/firebasejs/10.10.0/firebase-analytics.js"></script> --}}

    <script>
        // Import the functions you need from the SDKs you need
        // import {
        //     initializeApp
        // } from "https://www.gstatic.com/firebasejs/10.10.0/firebase-app.js";
        // import {
        //     getAnalytics
        // } from "https://www.gstatic.com/firebasejs/10.10.0/firebase-analytics.js";
        // TODO: Add SDKs for Firebase products that you want to use
        // https://firebase.google.com/docs/web/setup#available-libraries

        // Your web app's Firebase configuration
        // For Firebase JS SDK v7.20.0 and later, measurementId is optional
        const firebaseConfig = {
            apiKey: "AIzaSyAWOGL6pGeioj04YALVhjlDm03llLSi5cs",
            authDomain: "diawanpremium-6d4a9.firebaseapp.com",
            databaseURL: "https://diawanpremium-smart-home-5758.asia-southeast1.firebasedatabase.app",
            projectId: "diawanpremium-6d4a9",
            storageBucket: "diawanpremium-6d4a9.appspot.com",
            messagingSenderId: "119160770965",
            appId: "1:119160770965:web:1ee90fdf4ed3a1fe9c669c",
            measurementId: "G-RRRZW6MKS0"
        };

        // Initialize Firebase
        // const app = initializeApp(firebaseConfig);

        const app = firebase.initializeApp(firebaseConfig);
        var database_premium = firebase.database();
    </script>
    <script>
        // var nameRef = database_premium.ref(
        //   "clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/c8879e6e-db31-44e4-905e-ee87f238076a/devices/bcab6c4a-dfce-4801-b591-57aeeb6fedc4/request/4a8b2a95-0ac2-41d2-b11b-51fc38eff3a7/"
        // );
        // nameRef.orderByKey().on('value', function(snapshot) {
        //   snapshot.forEach(function(child) {
        //     console.log(child.val());
        //   })
        // })
        // const url = 'wss://test.mosquitto.org:8081'
        // const url = 'wss://mqtt.diawan.io:9001';
        /***
         * Node.js
         * Using MQTT over TCP with mqtt and mqtts protocols
         * EMQX's mqtt connection default port is 1883, mqtts is 8883
         */
        // const url = 'mqtt://broker.emqx.io:1883'

        // Create an MQTT client instance
        // const options = {
        // // Clean session
        // clean: true,
        // connectTimeout: 10000,
        // // Authentication
        // clientId: Math.random(),
        // username: 'autentik',
        // password: 'diawan',
        // };


        // var client_mqtt = mqtt.connect(url, options);
        const client_mqtt = mqtt.connect("ws://mqtt.diawan.io:8080/");
        // client_mqtt.publish("newtopic/test", "Hello mqtt");

        client_mqtt.on("connect", () => {
            console.log("Connect");
            client_mqtt.subscribe("pushValue", (err) => {
                if (!err) {
                    client_mqtt.publish("pushValue", "Hello mqtt");
                }
            });
        });

        // client_mqtt.on("message", (topic, message) => {
        //     // message is Buffer
        //     console.log(message.toString());
        //     client_mqtt.end();
        // });
    </script>
@endpush

@section('title')
    Data Device untuk Smart Home
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('home') }}">Dashboard</a>
                </li>

                <li class="breadcrumb-item">
                    <a href="{{ route('smarthome.index') }}">Data Smart Home</a>
                </li>

                <li class="breadcrumb-item active">Data Device untuk Smart Home</li>
            </ol>
        </nav>

        <!-- Collapse -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="rooms_id">Nama Room</label>
                            <div class="col-sm-10">
                                <label class="col-form-label">:
                                    {{ $item_smarthome->room->name_rooms . ' - ' . $item_smarthome->room->code_rooms }}</label>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="users_id">Nama user</label>
                            <div class="col-sm-10">
                                <label class="col-form-label">: {{ $item_smarthome->user->name }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Data Smart Home Device</h5>

                        @if (isAccess('create', $get_module, auth()->user()->roles))
                            <a href="{{ url('smarthome/device/create', $id_smarthome) }}">
                                <button type="button" class="btn btn-primary btn-icon-text">
                                    <i class="fa fa-plus btn-icon-prepend"></i>
                                    Tambah
                                </button>
                            </a>
                        @endif
                    </div>

                    <div class="card-body">
                        <div class="row mb-3">

                            <form action="{{ url('smarthome/device', $id_smarthome) }}" method="GET" id="form-search">
                                <div class="col-md-6 mb-3 float-end">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text" id="basic-addon-search31"><i
                                                class="bx bx-search"></i></span>
                                        <input type="text" class="form-control" placeholder="Search..."
                                            aria-label="Search..." aria-describedby="basic-addon-search31" name="search"
                                            id="smarthomedevice_search" value="{{ request('search') }}">

                                        <button type="submit" class="btn btn-secondary" id="button-search">Cari</button>
                                    </div>
                                </div>
                            </form>

                        </div>

                        <div class="row" id="list-smarthome-devices">

                            @if (isAccess('read', $get_module, auth()->user()->roles))
                                @if (count($result) > 0)
                                    {{-- loop --}}
                                    @foreach ($result as $index => $item)
                                        @php
                                            $name_no_space = str_replace(' ', '', $item->device->name_devices);
                                            $end_name_format = $name_no_space . '_' . $index;

                                            foreach ($item->device->deviceattributevalue as $key) {
                                                if ($key->device_attribute_type == 'color') {
                                                    $color = json_decode($key->device_attribute_type_val);
                                                }
                                                if ($key->device_attribute_type == 'lock') {
                                                    $lock = $key->device_attribute_type_val;
                                                }
                                                if ($key->device_attribute_type == 'range') {
                                                    $range = $key->device_attribute_type_val;
                                                }
                                                if ($key->device_attribute_type == 'motion') {
                                                    $motion = $key->device_attribute_type_val;
                                                }
                                                if ($key->device_attribute_type == 'switch') {
                                                    $switch = $key->device_attribute_type_val;
                                                }
                                                if ($key->device_attribute_type == 'mode') {
                                                    $mode = $key->device_attribute_type_val;
                                                }
                                                # code...
                                            }

                                        @endphp

                                        <div class="col-lg-3 col-md-12 col-6 mb-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div
                                                        class="card-title d-flex align-items-start justify-content-between">
                                                        <div class="avatar flex-shrink-0">
                                                            @if (Storage::disk('public')->exists($item->device->icon->file_icons) && $item->device->icon->file_icons != null)
                                                                <img src="{{ Storage::url($item->device->icon->file_icons) }}"
                                                                    alt="img" class="rounded" />
                                                            @else
                                                                <img src="{{ asset('admin-assets/assets/img/icons/unicons/cloud-computing.png') }}"
                                                                    class="rounded" />
                                                            @endif
                                                        </div>

                                                        <div class="dropdown">
                                                            <a class="btn p-0" href="javascript:void(0);"
                                                                data-bs-toggle="offcanvas"
                                                                data-bs-target="#{{ $end_name_format }}"
                                                                aria-controls="offcanvasScroll">
                                                                <i class="fas fa-cog"></i>
                                                            </a>

                                                            <div class="offcanvas offcanvas-end" data-bs-scroll="true"
                                                                data-bs-backdrop="false" tabindex="-1"
                                                                id="{{ $end_name_format }}"
                                                                aria-labelledby="{{ $end_name_format }}Label">
                                                                <div class="offcanvas-header">
                                                                    <h5 id="{{ $end_name_format }}Label"
                                                                        class="offcanvas-title">
                                                                        {{ $item->device->name_devices }} Control
                                                                    </h5>
                                                                    <button type="button" class="btn-close text-reset"
                                                                        data-bs-dismiss="offcanvas"
                                                                        aria-label="Close"></button>
                                                                </div>

                                                                {{-- modal control manual --}}
                                                                <div class="offcanvas-body my-auto mx-0 flex-grow-0">
                                                                    <form
                                                                        action="{{ url('/smarthome/device/store-control-manual', [$id_smarthome, $item->device->id_devices]) }}"
                                                                        method="POST"
                                                                        id="form-control-manual_{{ $index }}">
                                                                        @csrf
                                                                        <input type="hidden" name="_token" id="token"
                                                                            value="{{ csrf_token() }}">

                                                                        @if ($item->device->deviceattributetype->is_monitoring_device_attribute_type == '1')
                                                                            <div class="mb-3" {!! $item->device->deviceattributetype->is_monitoring_device_attribute_type == '1'
                                                                                ? ''
                                                                                : 'style="display: none"' !!}>
                                                                                <div class="row">
                                                                                    <div class="col-md">
                                                                                        <small
                                                                                            class="text-light fw-semibold">
                                                                                            {{ $item->device->deviceattributetype->label_monitoring_device_attribute_type }}
                                                                                        </small>

                                                                                        <div
                                                                                            class="mb-3 flex plyr-video-player">
                                                                                            <video class="w-100"
                                                                                                poster="https://cdn.plyr.io/static/demo/View_From_A_Blue_Moon_Trailer-HD.jpg"
                                                                                                id="plyr-video-player-{{ $index }}"
                                                                                                playsinline controls>
                                                                                                <source
                                                                                                    src="https://cdn.plyr.io/static/demo/View_From_A_Blue_Moon_Trailer-576p.mp4"
                                                                                                    type="video/mp4" />
                                                                                            </video>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endif

                                                                        @if (
                                                                            $item->device->deviceattributetype->is_lock_device_attribute_type == '1' ||
                                                                                $item->device->deviceattributetype->is_switch_device_attribute_type == '1')
                                                                            <div class="mb-3">
                                                                                <div class="row">
                                                                                    @if ($item->device->deviceattributetype->is_switch_device_attribute_type == '1')
                                                                                        <style>
                                                                                            .onoffswitch_{{ $item->device->id_devices }} {
                                                                                                position: relative;
                                                                                                width: 90px;
                                                                                                -webkit-user-select: none;
                                                                                                -moz-user-select: none;
                                                                                                -ms-user-select: none;
                                                                                            }

                                                                                            .onoffswitch-checkbox_{{ $item->device->id_devices }} {
                                                                                                position: absolute;
                                                                                                opacity: 0;
                                                                                                pointer-events: none;
                                                                                            }

                                                                                            .onoffswitch-label_{{ $item->device->id_devices }} {
                                                                                                display: block;
                                                                                                overflow: hidden;
                                                                                                cursor: pointer;
                                                                                                border: 2px solid #999999;
                                                                                                border-radius: 20px;
                                                                                            }

                                                                                            .onoffswitch-inner_{{ $item->device->id_devices }} {
                                                                                                display: block;
                                                                                                width: 200%;
                                                                                                margin-left: -100%;
                                                                                                transition: margin 0.3s ease-in 0s;
                                                                                            }

                                                                                            .onoffswitch-inner_{{ $item->device->id_devices }}:before,
                                                                                            .onoffswitch-inner_{{ $item->device->id_devices }}:after {
                                                                                                display: block;
                                                                                                float: left;
                                                                                                width: 50%;
                                                                                                height: 30px;
                                                                                                padding: 0;
                                                                                                line-height: 30px;
                                                                                                font-size: 14px;
                                                                                                color: white;
                                                                                                font-family: Trebuchet, Arial, sans-serif;
                                                                                                font-weight: bold;
                                                                                                box-sizing: border-box;
                                                                                            }


                                                                                            .onoffswitch-switch_{{ $item->device->id_devices }} {
                                                                                                display: block;
                                                                                                width: 18px;
                                                                                                margin: 6px;
                                                                                                background: #FFFFFF;
                                                                                                position: absolute;
                                                                                                top: 0;
                                                                                                bottom: 0;
                                                                                                right: 56px;
                                                                                                border: 2px solid #999999;
                                                                                                border-radius: 20px;
                                                                                                transition: all 0.3s ease-in 0s;
                                                                                            }

                                                                                            .onoffswitch-checkbox_{{ $item->device->id_devices }}:checked+.onoffswitch-label_{{ $item->device->id_devices }} .onoffswitch-inner_{{ $item->device->id_devices }} {
                                                                                                margin-left: 0;
                                                                                            }

                                                                                            .onoffswitch-checkbox_{{ $item->device->id_devices }}:checked+.onoffswitch-label_{{ $item->device->id_devices }} .onoffswitch-switch_{{ $item->device->id_devices }} {
                                                                                                right: 0px;
                                                                                            }

                                                                                            .onoffswitch-inner_{{ $item->device->id_devices }}:before {
                                                                                                content: "{{ $item->device->deviceattributetype->deviceattributetypeswitch->on_txt_device_attribute_type_switch }}";
                                                                                                padding-left: 10px;
                                                                                                color: #fff !important;
                                                                                                background-color: #595cd9 !important;
                                                                                                border-color: #595cd9 !important;
                                                                                            }

                                                                                            .onoffswitch-inner_{{ $item->device->id_devices }}:after {
                                                                                                content: "{{ $item->device->deviceattributetype->deviceattributetypeswitch->off_txt_device_attribute_type_switch }}";
                                                                                                padding-right: 10px;
                                                                                                background-color: #EEEEEE;
                                                                                                color: #999999;
                                                                                                text-align: right;
                                                                                            }
                                                                                        </style>
                                                                                        <small
                                                                                            class="text-light fw-semibold">{{ $item->device->deviceattributetype->label_switch_device_attribute_type ?? 'Switch On or Off' }}</small>

                                                                                        <div class="col-3">
                                                                                            <div
                                                                                                class="onoffswitch_{{ $item->device->id_devices }}">
                                                                                                <input type="checkbox"
                                                                                                    name="smarthome_device_control_switch_{{ $item->device->id_devices }}"
                                                                                                    class="onoffswitch-checkbox_{{ $item->device->id_devices }} smarthome_device_control_switch_{{ $index }}"
                                                                                                    id="myonoffswitch_{{ $item->device->id_devices }}"
                                                                                                    tabindex="0"
                                                                                                    {{-- onchange="deviceControlChange({{ $index }},'{{ $item->device->id_devices }}')" --}}
                                                                                                    {{ isset($switch) ? ((int) $switch == 1 ? 'checked' : '') : 'checked' }}>
                                                                                                <label
                                                                                                    class="onoffswitch-label_{{ $item->device->id_devices }}"
                                                                                                    for="myonoffswitch_{{ $item->device->id_devices }}"
                                                                                                    id="label_onoffswitch-label_{{ $item->device->id_devices }}">
                                                                                                    <span
                                                                                                        class="onoffswitch-inner_{{ $item->device->id_devices }}"></span>
                                                                                                    <span
                                                                                                        class="onoffswitch-switch_{{ $item->device->id_devices }}"></span>
                                                                                                </label>
                                                                                            </div>
                                                                                        </div>
                                                                                        <script>
                                                                                            $('#myonoffswitch_{{ $item->device->id_devices }}').click(function() {
                                                                                                console.log("change switch");

                                                                                                if ($(this).is(":checked")) {
                                                                                                    // console.log("checked");
                                                                                                    // client_mqtt.on("connect", () => {
                                                                                                    client_mqtt.publish('pushValue', 'on switch {{ $item->device->id_devices }}')
                                                                                                    // })
                                                                                                } else {
                                                                                                    // console.log("unchecked");
                                                                                                    // client_mqtt.on('connect', function() {
                                                                                                    client_mqtt.publish('pushValue', 'off switch {{ $item->device->id_devices }}')
                                                                                                    // })
                                                                                                }
                                                                                            });

                                                                                            // Subscribe to a topic named testtopic with QoS 0
                                                                                            client_mqtt.subscribe('pushValue', function(err) {
                                                                                                if (!err) {
                                                                                                    // Publish a message to a topic


                                                                                                }
                                                                                            })

                                                                                            client_mqtt.on('message', function(topic, message, packet) {
                                                                                                if (topic == 'pushValue') {

                                                                                                    if (message.toString() == "on switch {{ $item->device->id_devices }}") {

                                                                                                        if (!$("#myonoffswitch_{{ $item->device->id_devices }}").prop('checked')) {
                                                                                                            $('#myonoffswitch_{{ $item->device->id_devices }}').prop('checked', true);
                                                                                                        }
                                                                                                    }
                                                                                                    if (message.toString() == "off switch {{ $item->device->id_devices }}") {

                                                                                                        if ($("#myonoffswitch_{{ $item->device->id_devices }}").prop('checked')) {
                                                                                                            $('#myonoffswitch_{{ $item->device->id_devices }}').prop('checked', false);
                                                                                                        }
                                                                                                    }
                                                                                                }


                                                                                            });




                                                                                            // client.on('connect', function () {
                                                                                            //   client.on('message', function (topic, payload, packet) {
                                                                                            //   // Payload is Buffer
                                                                                            //     console.log(`Topic: ${topic}, Message: ${payload.toString()}, QoS: ${packet.qos}`)
                                                                                            //   })
                                                                                            // })


                                                                                            //  client.on('message', function (topic, payload, packet) {
                                                                                            //   // Payload is Buffer
                                                                                            //   console.log(payload.toString());
                                                                                            //     // console.log(`Topic: ${topic}, Message: ${payload.toString()}, QoS: ${packet.qos}`)
                                                                                            // })
                                                                                            // var onRef = database_premium.ref("clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/c8879e6e-db31-44e4-905e-ee87f238076a/devices/{{ $item->device->id_devices }}/value/on");
                                                                                            // onRef.on('value', function(onSnapshot) {
                                                                                            //   // console.log(onSnapshot);
                                                                                            //   if (onSnapshot.exists()) {
                                                                                            //   //   console.log(onSnapshot);
                                                                                            //     if(onSnapshot.val()==1){
                                                                                            //       if(!$("#myonoffswitch_{{ $item->device->id_devices }}").prop('checked')){
                                                                                            //         $('#myonoffswitch_{{ $item->device->id_devices }}').prop('checked', true);
                                                                                            //       }

                                                                                            //     }
                                                                                            //   }

                                                                                            // })
                                                                                            // var offRef =database_premium.ref("clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/c8879e6e-db31-44e4-905e-ee87f238076a/devices/{{ $item->device->id_devices }}/value/off");
                                                                                            // offRef.on('value', function(offSnapshot) {
                                                                                            //   // console.log(offSnapshot);
                                                                                            //   if (offSnapshot.exists()) {
                                                                                            //     if(offSnapshot.val()==1){
                                                                                            //       if($("#myonoffswitch_{{ $item->device->id_devices }}").prop('checked')){
                                                                                            //         $('#myonoffswitch_{{ $item->device->id_devices }}').prop('checked', false);
                                                                                            //       }
                                                                                            //     }
                                                                                            //   }

                                                                                            // })
                                                                                        </script>
                                                                                    @endif

                                                                                    @php
                                                                                        if (
                                                                                            isset(
                                                                                                $item->device
                                                                                                    ->deviceattributetype
                                                                                                    ->deviceattributetypelock[0]
                                                                                                    ->on_txt_device_attribute_type_lock,
                                                                                            )
                                                                                        ) {
                                                                                            $on =
                                                                                                $item->device
                                                                                                    ->deviceattributetype
                                                                                                    ->deviceattributetypelock[0]
                                                                                                    ->on_txt_device_attribute_type_lock;
                                                                                            # code...
                                                                                        } else {
                                                                                            $on = 'Ok, unlock it';
                                                                                        }

                                                                                        if (
                                                                                            isset(
                                                                                                $item->device
                                                                                                    ->deviceattributetype
                                                                                                    ->deviceattributetypelock[0]
                                                                                                    ->off_txt_device_attribute_type_lock,
                                                                                            )
                                                                                        ) {
                                                                                            $off =
                                                                                                $item->device
                                                                                                    ->deviceattributetype
                                                                                                    ->deviceattributetypelock[0]
                                                                                                    ->off_txt_device_attribute_type_lock;

                                                                                            # code...
                                                                                        } else {
                                                                                            $off = 'Now lock it';
                                                                                        }

                                                                                    @endphp
                                                                                    @if ($item->device->deviceattributetype->is_lock_device_attribute_type == '1')
                                                                                        <small
                                                                                            class="text-light fw-semibold">{{ $item->device->deviceattributetype->label_lock_device_attribute_type ?? 'Switch Lock or Unlock' }}</small>

                                                                                        <div class="col-9">
                                                                                            <style>
                                                                                                /* :::::::::::::: Presentation css */
                                                                                                * {
                                                                                                    margin: 0;
                                                                                                    padding: 0;
                                                                                                    box-sizing: border-box;
                                                                                                    --locked-color: #5fadbf;
                                                                                                    --unlocked-color: #ff5153;
                                                                                                }

                                                                                                .container-lock {
                                                                                                    max-width: 200px;
                                                                                                    display: flex;
                                                                                                    align-items: flex-start;
                                                                                                    justify-content: flex-start;
                                                                                                }

                                                                                                /* :::::::::::::: Required CSS */
                                                                                                /* Locked */
                                                                                                .lock_{{ $item->device->id_devices }}+label {
                                                                                                    cursor: pointer;
                                                                                                }

                                                                                                .lock_{{ $item->device->id_devices }} {
                                                                                                    width: 20px;
                                                                                                    height: 21px;
                                                                                                    border: 3px solid var(--locked-color);
                                                                                                    border-radius: 5px;
                                                                                                    position: relative;
                                                                                                    cursor: pointer;
                                                                                                    -webkit-transition: all 0.1s ease-in-out;
                                                                                                    transition: all 0.1s ease-in-out;
                                                                                                }

                                                                                                .lock_{{ $item->device->id_devices }}:after {
                                                                                                    content: "";
                                                                                                    display: block;
                                                                                                    background: var(--locked-color);
                                                                                                    width: 3px;
                                                                                                    height: 7px;
                                                                                                    position: absolute;
                                                                                                    top: 50%;
                                                                                                    left: 50%;
                                                                                                    margin: -3.5px 0 0 -2px;
                                                                                                    -webkit-transition: all 0.1s ease-in-out;
                                                                                                    transition: all 0.1s ease-in-out;
                                                                                                }

                                                                                                .lock_{{ $item->device->id_devices }}:before {
                                                                                                    content: "";
                                                                                                    display: block;
                                                                                                    width: 14px;
                                                                                                    height: 10px;
                                                                                                    bottom: 100%;
                                                                                                    position: absolute;
                                                                                                    left: 50%;
                                                                                                    margin-left: -8px;
                                                                                                    border: 3px solid var(--locked-color);
                                                                                                    border-top-right-radius: 50%;
                                                                                                    border-top-left-radius: 50%;
                                                                                                    border-bottom: 0;
                                                                                                    -webkit-transition: all 0.1s ease-in-out;
                                                                                                    transition: all 0.1s ease-in-out;
                                                                                                }

                                                                                                /* Locked Hover */
                                                                                                .lock_{{ $item->device->id_devices }}:hover:before {
                                                                                                    height: 12px;
                                                                                                }

                                                                                                .lock_{{ $item->device->id_devices }}+label:after {
                                                                                                    content: '{{ $on }}';
                                                                                                }


                                                                                                /* Unlocked */
                                                                                                .unlocked_{{ $item->device->id_devices }} {
                                                                                                    transform: rotate(10deg);
                                                                                                }

                                                                                                .unlocked_{{ $item->device->id_devices }}:before {
                                                                                                    bottom: 130%;
                                                                                                    left: 31%;
                                                                                                    margin-left: -11.5px;
                                                                                                    transform: rotate(-45deg);
                                                                                                }

                                                                                                .unlocked_{{ $item->device->id_devices }},
                                                                                                .unlocked_{{ $item->device->id_devices }}:before {
                                                                                                    border-color: var(--unlocked-color);
                                                                                                }

                                                                                                .unlocked_{{ $item->device->id_devices }}:after {
                                                                                                    background: var(--unlocked-color);
                                                                                                }

                                                                                                /* Unlocked Hover */
                                                                                                .unlocked_{{ $item->device->id_devices }}:hover {
                                                                                                    transform: rotate(3deg);
                                                                                                }

                                                                                                .unlocked_{{ $item->device->id_devices }}:hover:before {
                                                                                                    height: 10px;
                                                                                                    left: 40%;
                                                                                                    bottom: 124%;
                                                                                                    transform: rotate(-30deg);
                                                                                                }

                                                                                                .unlocked_{{ $item->device->id_devices }}+label:after {
                                                                                                    content: '{{ $off }}';
                                                                                                }
                                                                                            </style>

                                                                                            <div class="container-lock"
                                                                                                style="padding-top: 10px">

                                                                                                <span
                                                                                                    class="lock_{{ $item->device->id_devices }}  {{ (int) $lock == 0 ? 'unlocked_' . $item->device->id_devices : '' }}"
                                                                                                    id="smarthome_device_control_lock_{{ $index }}">
                                                                                                </span>

                                                                                                <label for="lock"
                                                                                                    class="text-lock_{{ $item->device->id_devices }}"
                                                                                                    style="margin-left: 4px"><i></i></label>
                                                                                            </div>
                                                                                            <script>
                                                                                                $(".lock_{{ $item->device->id_devices }}").click(function() {
                                                                                                    // $(this).toggleClass('unlocked_{{ $item->device->id_devices }}');
                                                                                                    if ($(this).hasClass('unlocked_{{ $item->device->id_devices }}')) {
                                                                                                        $(".lock_{{ $item->device->id_devices }}").removeClass('unlocked_{{ $item->device->id_devices }}')
                                                                                                    } else {
                                                                                                        $(".lock_{{ $item->device->id_devices }}").addClass('unlocked_{{ $item->device->id_devices }}')
                                                                                                    }
                                                                                                    deviceControlChange("{{ $index }}", "{{ $item->device->id_devices }}");
                                                                                                });
                                                                                                $(".text-lock_{{ $item->device->id_devices }}").click(function() {
                                                                                                    if ($(".lock_{{ $item->device->id_devices }}").hasClass('unlocked_{{ $item->device->id_devices }}')) {

                                                                                                        $(".lock_{{ $item->device->id_devices }}").removeClass('unlocked_{{ $item->device->id_devices }}')
                                                                                                    } else {
                                                                                                        $(".lock_{{ $item->device->id_devices }}").addClass('unlocked_{{ $item->device->id_devices }}')
                                                                                                    }
                                                                                                    // $(".lock_{{ $item->device->id_devices }}").toggleClass('unlocked_{{ $item->device->id_devices }}');
                                                                                                    deviceControlChange("{{ $index }}", "{{ $item->device->id_devices }}");
                                                                                                });
                                                                                                var lockRef = database_premium.ref(
                                                                                                    "clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/c8879e6e-db31-44e4-905e-ee87f238076a/devices/{{ $item->device->id_devices }}/value/lock"
                                                                                                );
                                                                                                lockRef.on('value', function(lockSnapshot) {
                                                                                                    // console.log(onSnapshot);
                                                                                                    if (lockSnapshot.exists()) {

                                                                                                        if (lockSnapshot.val() == 1) {

                                                                                                            if ($(".lock_{{ $item->device->id_devices }}").hasClass(
                                                                                                                    'unlocked_{{ $item->device->id_devices }}')) {
                                                                                                                $(".lock_{{ $item->device->id_devices }}").removeClass(
                                                                                                                    'unlocked_{{ $item->device->id_devices }}')
                                                                                                            }
                                                                                                        }
                                                                                                    }

                                                                                                })
                                                                                                var unlockedRef = database_premium.ref(
                                                                                                    "clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/c8879e6e-db31-44e4-905e-ee87f238076a/devices/{{ $item->device->id_devices }}/value/unlocked"
                                                                                                );
                                                                                                unlockedRef.on('value', function(unlockedSnapshot) {

                                                                                                    if (unlockedSnapshot.exists()) {

                                                                                                        //   console.log(onSnapshot);
                                                                                                        if (unlockedSnapshot.val() == 1) {
                                                                                                            if (!$(".lock_{{ $item->device->id_devices }}").hasClass(
                                                                                                                    'unlocked_{{ $item->device->id_devices }}')) {
                                                                                                                $(".lock_{{ $item->device->id_devices }}").addClass(
                                                                                                                    'unlocked_{{ $item->device->id_devices }}')
                                                                                                            }
                                                                                                        }
                                                                                                    }

                                                                                                })
                                                                                            </script>
                                                                                        </div>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        @endif

                                                                        @if ($item->device->deviceattributetype->is_range_device_attribute_type == '1')
                                                                            <div class="mb-3" {!! $item->device->deviceattributetype->is_range_device_attribute_type == '1' ? '' : 'style="display: none"' !!}>
                                                                                <div class="row">
                                                                                    <div class="col-md">
                                                                                        <small
                                                                                            class="text-light fw-semibold">
                                                                                            {{ $item->device->deviceattributetype->label_range_device_attribute_type }}
                                                                                        </small>

                                                                                        <div class="range-wrap mt-3 flex">
                                                                                            <input type="range"
                                                                                                class="form-range"
                                                                                                min="{{ $item->device->deviceattributetype->deviceattributetyperange->min_device_attribute_type_range ?? 0 }}"
                                                                                                max="{{ $item->device->deviceattributetype->deviceattributetyperange->max_device_attribute_type_range ?? 5 }}"
                                                                                                name="smarthome_device_control_range"
                                                                                                value="{{ isset($range) ? (int) $range ?? 5 : 5 }}"
                                                                                                id="smarthome_device_control_range_{{ $index }}"
                                                                                                onchange="deviceControlChange({{ $index }})">
                                                                                            <output class="bubble"
                                                                                                style="margin-top: 40px"></output>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <script>
                                                                                var suhuRef = database_premium.ref(
                                                                                    "clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/c8879e6e-db31-44e4-905e-ee87f238076a/devices/{{ $item->device->id_devices }}/value/suhu"
                                                                                );
                                                                                suhuRef.on('value', function(suhuSnapshot) {
                                                                                    // console.log(onSnapshot);
                                                                                    if (suhuSnapshot.exists()) {

                                                                                        if (suhuSnapshot.val().value == 1) {
                                                                                            $("#smarthome_device_control_range_{{ $index }}").val(suhuSnapshot.val().number)
                                                                                            const allRanges = document.querySelectorAll(".range-wrap");
                                                                                            allRanges.forEach(wrap => {
                                                                                                const range = wrap.querySelector(".form-range");
                                                                                                const bubble = wrap.querySelector(".bubble");

                                                                                                range.addEventListener("input", () => {
                                                                                                    setBubble(range, bubble);
                                                                                                });
                                                                                                setBubble(range, bubble);
                                                                                            });
                                                                                        }
                                                                                    }

                                                                                })

                                                                                var rangeRef = database_premium.ref(
                                                                                    "clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/c8879e6e-db31-44e4-905e-ee87f238076a/devices/{{ $item->device->id_devices }}/value/range"
                                                                                );
                                                                                rangeRef.on('value', function(rangeSnapshot) {
                                                                                    // console.log(onSnapshot);
                                                                                    if (rangeSnapshot.exists()) {

                                                                                        if (rangeSnapshot.val().value == 1) {
                                                                                            $("#smarthome_device_control_range_{{ $index }}").val(rangeSnapshot.val().number)
                                                                                            const allRanges = document.querySelectorAll(".range-wrap");
                                                                                            allRanges.forEach(wrap => {
                                                                                                const range = wrap.querySelector(".form-range");
                                                                                                const bubble = wrap.querySelector(".bubble");

                                                                                                range.addEventListener("input", () => {
                                                                                                    setBubble(range, bubble);
                                                                                                });
                                                                                                setBubble(range, bubble);
                                                                                            });
                                                                                        }
                                                                                    }

                                                                                })
                                                                            </script>
                                                                        @endif

                                                                        @if ($item->device->deviceattributetype->is_mode_device_attribute_type == '1')
                                                                            <div class="mb-3" {!! $item->device->deviceattributetype->is_mode_device_attribute_type == '1' ? '' : 'style="display: none"' !!}>
                                                                                <div class="row">
                                                                                    <div class="col-md">
                                                                                        <small
                                                                                            class="text-light fw-semibold">
                                                                                            {{ $item->device->deviceattributetype->label_mode_device_attribute_type }}
                                                                                        </small>

                                                                                        <div class="mt-3">
                                                                                            <div class="btn-group"
                                                                                                role="group"
                                                                                                aria-label="Basic example">

                                                                                                @foreach ($item->device->deviceattributetype->deviceattributetypemode as $index_mode => $item_mode)
                                                                                                    <input type="radio"
                                                                                                        class="btn-check control_mode"
                                                                                                        name="smarthome_device_control_mode"
                                                                                                        id="smarthome_device_control_mode_{{ $index }}_{{ $index_mode }}_{{ $item_mode->value_device_attribute_type_mode }}"
                                                                                                        autocomplete="off"
                                                                                                        value="{{ $item_mode->value_device_attribute_type_mode }}"
                                                                                                        {{-- {{ isset($mode) ? ((int) $item_mode->value_device_attribute_type_mode == (int) $mode ? "checked": ""):"" }} --}}
                                                                                                        {{-- onchange="deviceControlChange({{ $index }}, {{ $index_mode }})" --}} />
                                                                                                    <label
                                                                                                        class="btn btn-outline-primary btn_smarthome_device_control_mode"
                                                                                                        data-index="{{ $index }}"
                                                                                                        data-mode="{{ $index_mode }}"
                                                                                                        data-value="{{ $item_mode->value_device_attribute_type_mode }}"
                                                                                                        data-code="{{ $index }}_{{ $index_mode }}_{{ $item_mode->value_device_attribute_type_mode }}"
                                                                                                        id="btn_smarthome_device_control_mode_{{ $index }}_{{ $index_mode }}_{{ $item_mode->value_device_attribute_type_mode }}"
                                                                                                        for="smarthome_device_control_mode_{{ $index }}_{{ $index_mode }}">{{ $item_mode->name_device_attribute_type_mode }}</label>
                                                                                                @endforeach

                                                                                                <input type="hidden"
                                                                                                    class="form-control"
                                                                                                    name="smarthome_device_control_mode_value"
                                                                                                    id="smarthome_device_control_mode_value_{{ $index }}"
                                                                                                    readonly>

                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <script>
                                                                                var modeRef = database_premium.ref(
                                                                                    "clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/c8879e6e-db31-44e4-905e-ee87f238076a/devices/{{ $item->device->id_devices }}/value/mode"
                                                                                );
                                                                                modeRef.on('value', function(modeSnapshot) {
                                                                                    // console.log(onSnapshot);
                                                                                    if (modeSnapshot.exists()) {

                                                                                        if (modeSnapshot.val().value == 1) {
                                                                                            $('.btn_smarthome_device_control_mode').each(function() {
                                                                                                var code = $(this).data('code');
                                                                                                var value = $(this).data('value');
                                                                                                $('#smarthome_device_control_mode_' + code).removeAttr('checked');
                                                                                                if (value == modeSnapshot.val().number) {
                                                                                                    if (!$("#smarthome_device_control_mode_" + code).prop('checked')) {
                                                                                                        $("#smarthome_device_control_mode_" + code).attr("checked", "checked");
                                                                                                    }
                                                                                                }
                                                                                            })
                                                                                        }
                                                                                    }

                                                                                })
                                                                            </script>
                                                                        @endif

                                                                        @if ($item->device->deviceattributetype->is_color_device_attribute_type == '1')
                                                                            <div class="mb-3" {!! $item->device->deviceattributetype->is_color_device_attribute_type == '1' ? '' : 'style="display: none"' !!}>
                                                                                <div class="row">
                                                                                    <div class="col-md">
                                                                                        <small
                                                                                            class="text-light fw-semibold">
                                                                                            {{ $item->device->deviceattributetype->label_color_device_attribute_type }}
                                                                                        </small>

                                                                                        <div class="mb-3 flex">
                                                                                            <input class="form-control"
                                                                                                type="color"
                                                                                                value="{{ isset($color) ? fromRGB($color[0], $color[1], $color[2]) : '#666EE8' }}"
                                                                                                id="smarthome_device_control_color_{{ $index }}"
                                                                                                onchange="deviceControlChange({{ $index }})" />


                                                                                            <small class="fw-semibold">RGB:
                                                                                                <span
                                                                                                    id="HexValue_{{ $index }}">"{{ isset($color) ? $color[0] : '0' }},
                                                                                                    {{ isset($color) ? $color[1] : '0' }},
                                                                                                    {{ isset($color) ? $color[2] : '0' }}"</span></small>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <script>
                                                                                var colorRef = database_premium.ref(
                                                                                    "clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/c8879e6e-db31-44e4-905e-ee87f238076a/devices/{{ $item->device->id_devices }}/value/color"
                                                                                );
                                                                                colorRef.on('value', function(colorSnapshot) {
                                                                                    // console.log(onSnapshot);
                                                                                    if (colorSnapshot.exists()) {

                                                                                        if (colorSnapshot.val().value == 1) {
                                                                                            var Hex = rgbToHex(parseInt(colorSnapshot.val().red), parseInt(colorSnapshot.val().green),
                                                                                                parseInt(colorSnapshot.val().blue));

                                                                                            if ($("#smarthome_device_control_color_{{ $index }}").prop('value') != Hex) {
                                                                                                $("#smarthome_device_control_color_{{ $index }}").attr('value', Hex)
                                                                                                $('#HexValue_{{ $index }}').html('"' + colorSnapshot.val().red + ',' +
                                                                                                    colorSnapshot.val().blue + ',' + colorSnapshot.val().green + '"')
                                                                                            }
                                                                                        }
                                                                                    }

                                                                                })
                                                                            </script>
                                                                        @endif

                                                                    </form>
                                                                </div>
                                                                {{-- / modal control manual --}}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <h5 class="card-title mb-1">
                                                        {{ $item->device->name_devices }}
                                                    </h5>

                                                    {{-- Dibutuhkan ada deskripsi device --}}
                                                    {{-- <span class="d-block">Transactions Apa aja coba test panjang</span> --}}

                                                    <button type="button" id="mic_{{ $item->device->id_devices }}"
                                                        data-id="{{ $item->device->id_devices }}"
                                                        class="btn btn-sm rounded-pill btn-icon btn-danger">
                                                        <small class="text-white fw-semibold">
                                                            <i class="fas fa-microphone-slash"></i>
                                                        </small>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    {{-- loop --}}

                                    <nav aria-label="Page navigation">
                                        <ul class="pagination">
                                            {{ $result->appends($_GET)->links() }}
                                        </ul>
                                    </nav>
                                @else
                                    <div class="col-md-12 text-center">
                                        <h5 class="card-title">Sorry!</h5>
                                        <p class="card-text">Data {!! '<strong>' . request('search') . '</strong>' !!} tidak ditemukan atau tidak
                                            ada data yang terkait.
                                        </p>

                                        @if (isAccess('create', $get_module, auth()->user()->roles))
                                            <a href="{{ url('smarthome/device/create', $id_smarthome) }}"
                                                class="btn btn-primary">Tambahkan
                                                Data</a>
                                        @endif
                                    </div>
                                @endif
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="buy-now">
        <a href="javascript:void(0)" class="btn btn-xl rounded-pill btn-danger btn-icon btn-buy-now" id="mic_smarthome"
            style="z-index: 100">
            <i class="fas fa-microphone-slash"></i>
        </a>
    </div>
@endsection

@push('after-script')
    <script>
        $('.btn_smarthome_device_control_mode').each(function() {
            // alert($(this).data("code"))
            $(this).click(function() {
                $('.control_mode').each(function() {
                    $(this).removeAttr('checked');
                    // element.checked=false;
                });
                var code = $(this).data("code");
                var mode = $(this).data("mode");
                var index = $(this).data("index");

                $("#smarthome_device_control_mode_" + code).attr('checked', 'checked');
                deviceControlChange(index, mode, code);
            });

        });

        var CSRF_TOKEN = $('#token').val();
    </script>

    <script src="{{ asset('admin-assets/assets/vendor/libs/plyr/plyr.js') }}"></script>

    <script src="https://www.WebRTC-Experiment.com/RecordRTC.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- use 5.6.2 or any other version on cdnjs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/RecordRTC/5.6.2/RecordRTC.js"></script>

    <script>
        var data = @json($result);
        data.data.forEach(element => {
            var id_devices = element.device.id_devices;
            trigger_mic_smarthome[id_devices] = 0;
            $("#mic_" + id_devices).click(function() {
                if (trigger_mic_smarthome[id_devices] == 0) {


                    navigator.mediaDevices.getUserMedia({
                            audio: true
                        } /*of type MediaStreamConstraints*/ )
                        //returns a promise that resolves to the audio stream
                        .then(stream /*of type MediaStream*/ => {

                            stopRecordingAll()

                            $("#mic_" + id_devices).removeClass('btn-danger');
                            $("#mic_" + id_devices).addClass('btn-info');
                            $("#mic_" + id_devices).find($(".fas")).toggleClass('fa-microphone')
                                .toggleClass(
                                    'fa-microphone-slash');

                            recorder[id_devices] = RecordRTC(stream, {
                                type: 'audio',
                                recorderType: RecordRTC
                                    .StereoAudioRecorder, // force for all browsers
                                numberOfAudioChannels: 1,
                                timeSlice: 5000, // pass this parameter

                                // getNativeBlob: true,
                                ondataavailable: function(blob) {
                                    // chunks.push(blob)
                                    // sendToServer(blob)
                                    sendToServerById(blob, id_devices)
                                    // console.log(blob);

                                    // blobs.push(blob);

                                    // var size = 0;
                                    // blobs.forEach(function (b) {
                                    //     size += b.size;
                                    // });

                                    // h1.innerHTML = 'Total blobs: ' + blobs.length + ' (Total size: ' + bytesToSize(size) + ')';
                                }
                            });

                            recorder2[id_devices] = RecordRTC(stream, {
                                type: 'audio',
                                recorderType: RecordRTC
                                    .StereoAudioRecorder, // force for all browsers
                                numberOfAudioChannels: 1,
                                timeSlice: 5000, // pass this parameter

                                ondataavailable: function(blob) {
                                    // chunks.push(blob)
                                    sendToServerById(blob, id_devices)
                                    // console.log(blob);

                                    // blobs.push(blob);

                                    // var size = 0;
                                    // blobs.forEach(function (b) {
                                    //     size += b.size;
                                    // });

                                    // h1.innerHTML = 'Total blobs: ' + blobs.length + ' (Total size: ' + bytesToSize(size) + ')';
                                }
                            });


                            recorder[id_devices].startRecording();
                            // Swal.showLoading ()


                            var delayInMilliseconds = 3000; //1 second

                            //  let i = 1;
                            //  const interval = setInterval(() => {
                            //      if (i == 0) {
                            //          recorder2.startRecording();
                            //          Swal.hideLoading ()
                            //          clearInterval(interval);
                            //      }
                            //      i--;
                            //  }, delayInMilliseconds);

                            let timerInterval
                            Swal.fire({
                                title: 'Tunggu Sebentar!',
                                html: 'Mulai merekam... <b>' + Math.round(delayInMilliseconds /
                                    1000) + '</b>',
                                timer: delayInMilliseconds,
                                timerProgressBar: true,
                                closeOnClickOutside: false,
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading()
                                    const b = Swal.getHtmlContainer().querySelector('b')
                                    timerInterval = setInterval(() => {
                                        b.textContent = Math.round(parseInt(Swal
                                            .getTimerLeft()) / 1000)

                                    }, 1000)
                                },
                                willClose: () => {
                                    clearInterval(timerInterval)
                                }
                            }).then((result) => {
                                /* Read more about handling dismissals below */
                                if (result.dismiss === Swal.DismissReason.timer) {
                                    recorder2[id_devices].startRecording();
                                    // Swal.hideLoading ()
                                }
                            })




                            function sendToServerById(params, id) {

                                // let reader = new FileReader();
                                // reader.readAsDataURL(params);

                                // // audioRecorder.audioBlobs.shift();
                                // // // audioRecorder.audioBlobs = [];

                                // console.log("dasdasds");

                                let reader = new window.FileReader();
                                reader.readAsDataURL(params); // <----------------check this line
                                reader.onloadend = function() {
                                    var audioBase64 = reader.result;

                                    let base64URL = audioBase64.substr(audioBase64.indexOf(',') +
                                        1);
                                    // console.log(base64URL);
                                    $.ajax({
                                        url: "https://asia-southeast2-diawanpremium-6d4a9.cloudfunctions.net/spechToText",
                                        type: "POST",
                                        data: {
                                            "voice": base64URL,
                                            "clientId": "c8879e6e-db31-44e4-905e-ee87f238076a",
                                            "userId": "c8879e6e-db31-44e4-905e-ee87f238076a",
                                            "idDevice": id
                                        },
                                        success: function(result) {
                                            // when call is sucessfull
                                            console.log(result.result);
                                            // audioRecorder.audioBlobs = [];
                                            //  audioRecorder.audioBlobs = [];
                                        },
                                        error: function(err) {
                                            console.log(err);
                                            // check the err for error details
                                        }
                                    });
                                };

                                // reader.onload = (e) => {
                                //     console.log(e);
                                //     let base64URL = e.target.result;
                                //     console.log(base64URL);
                                //     base64URL = base64URL.replace("data:audio/wav;base64,", "");






                                //     $.ajax({
                                //         url: "http://localhost:5001/diawanpremium-6d4a9/asia-southeast2/spechToText",
                                //         type: "POST",
                                //         data: { "voice": base64URL, "clientId": "c8879e6e-db31-44e4-905e-ee87f238076a", "userId": "c8879e6e-db31-44e4-905e-ee87f238076a" },
                                //         success: function (result) {
                                //             // when call is sucessfull
                                //             console.log(result.result);
                                //             // audioRecorder.audioBlobs = [];
                                //             //  audioRecorder.audioBlobs = [];
                                //         },
                                //         error: function (err) {
                                //             console.log(err);
                                //             // check the err for error details
                                //         }
                                //     }); // ajax call closing

                                // }
                            }


                            trigger_mic_smarthome[id_devices] = 1;
                            // var refreshIntervalId = setInterval(() => {
                            //     // console.log("dfdsfds");
                            //     if (start == 0) {

                            //         record_and_send();
                            //     } else {
                            //         clearInterval(refreshIntervalId);
                            //     }

                            // }, 2000);
                            // record_and_send(stream);

                        });

                } else {

                    stopRecordingAll()
                }
            })
        });

        new Plyr(".plyr-video-player")
    </script>

    <script>
        $("#mic_smarthome").click(function() {
            if (trigger_mic_smarthome["first"] == 0) {

                navigator.mediaDevices.getUserMedia({
                        audio: true
                    } /*of type MediaStreamConstraints*/ )
                    //returns a promise that resolves to the audio stream
                    .then(stream /*of type MediaStream*/ => {

                        stopRecordingAll()
                        // $("#mic_smarthome").removeClass('btn-danger');
                        // $("#mic_smarthome").addClass('btn-info');
                        // $("#mic_smarthome").find($(".fas")).toggleClass('fa-microphone-slash').toggleClass('fa-microphone');

                        $("#mic_smarthome").removeClass('btn-danger');
                        $("#mic_smarthome").addClass('btn-info');
                        $("#mic_smarthome").find($(".fas")).toggleClass('fa-microphone-slash').toggleClass(
                            'fa-microphone');
                        // $("#mic_smarthome").find($(".fas")).toggleClass('fa-microphone').toggleClass('fa-microphone-slash');
                        recorder["first"] = RecordRTC(stream, {
                            type: 'audio',
                            recorderType: RecordRTC.StereoAudioRecorder, // force for all browsers
                            numberOfAudioChannels: 1,
                            timeSlice: 5000, // pass this parameter

                            // getNativeBlob: true,
                            ondataavailable: function(blob) {
                                // chunks.push(blob)
                                sendToServer(blob)
                                // console.log(blob);

                                // blobs.push(blob);

                                // var size = 0;
                                // blobs.forEach(function (b) {
                                //     size += b.size;
                                // });

                                // h1.innerHTML = 'Total blobs: ' + blobs.length + ' (Total size: ' + bytesToSize(size) + ')';
                            }
                        });

                        recorder2["first"] = RecordRTC(stream, {
                            type: 'audio',
                            recorderType: RecordRTC.StereoAudioRecorder, // force for all browsers
                            numberOfAudioChannels: 1,
                            timeSlice: 5000, // pass this parameter

                            ondataavailable: function(blob) {
                                // chunks.push(blob)
                                sendToServer(blob)
                                // console.log(blob);

                                // blobs.push(blob);

                                // var size = 0;
                                // blobs.forEach(function (b) {
                                //     size += b.size;
                                // });

                                // h1.innerHTML = 'Total blobs: ' + blobs.length + ' (Total size: ' + bytesToSize(size) + ')';
                            }
                        });


                        recorder["first"].startRecording();
                        // Swal.showLoading ()


                        var delayInMilliseconds = 3000; //1 second

                        //  let i = 1;
                        //  const interval = setInterval(() => {
                        //      if (i == 0) {
                        //          recorder2.startRecording();
                        //          Swal.hideLoading ()
                        //          clearInterval(interval);
                        //      }
                        //      i--;
                        //  }, delayInMilliseconds);

                        let timerInterval
                        Swal.fire({
                            title: 'Tunggu Sebentar!',
                            html: 'Mulai merekam... <b>' + Math.round(delayInMilliseconds / 1000) +
                                '</b>',
                            timer: delayInMilliseconds,
                            timerProgressBar: true,
                            closeOnClickOutside: false,
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading()
                                const b = Swal.getHtmlContainer().querySelector('b')
                                timerInterval = setInterval(() => {
                                    b.textContent = Math.round(parseInt(Swal
                                        .getTimerLeft()) / 1000)

                                }, 1000)
                            },
                            willClose: () => {
                                clearInterval(timerInterval)
                            }
                        }).then((result) => {
                            /* Read more about handling dismissals below */
                            if (result.dismiss === Swal.DismissReason.timer) {
                                recorder2["first"].startRecording();
                                // Swal.hideLoading ()
                            }
                        })




                        function sendToServer(params) {

                            // let reader = new FileReader();
                            // reader.readAsDataURL(params);

                            // // audioRecorder.audioBlobs.shift();
                            // // // audioRecorder.audioBlobs = [];

                            // console.log("dasdasds");

                            let reader = new window.FileReader();
                            reader.readAsDataURL(params); // <----------------check this line
                            reader.onloadend = function() {
                                var audioBase64 = reader.result;

                                let base64URL = audioBase64.substr(audioBase64.indexOf(',') + 1);
                                // console.log(base64URL);
                                $.ajax({
                                    url: "https://asia-southeast2-diawanpremium-6d4a9.cloudfunctions.net/spechToText",
                                    type: "POST",
                                    data: {
                                        "voice": base64URL,
                                        "clientId": "c8879e6e-db31-44e4-905e-ee87f238076a",
                                        "userId": "c8879e6e-db31-44e4-905e-ee87f238076a",
                                        "idRoom": "{{ $id_smarthome }}"
                                    },
                                    success: function(result) {
                                        // when call is sucessfull
                                        console.log(result.result);
                                        // audioRecorder.audioBlobs = [];
                                        //  audioRecorder.audioBlobs = [];
                                    },
                                    error: function(err) {
                                        console.log(err);
                                        // check the err for error details
                                    }
                                });
                            };

                            // reader.onload = (e) => {
                            //     console.log(e);
                            //     let base64URL = e.target.result;
                            //     console.log(base64URL);
                            //     base64URL = base64URL.replace("data:audio/wav;base64,", "");






                            //     $.ajax({
                            //         url: "http://localhost:5001/diawanpremium-6d4a9/asia-southeast2/spechToText",
                            //         type: "POST",
                            //         data: { "voice": base64URL, "clientId": "c8879e6e-db31-44e4-905e-ee87f238076a", "userId": "c8879e6e-db31-44e4-905e-ee87f238076a" },
                            //         success: function (result) {
                            //             // when call is sucessfull
                            //             console.log(result.result);
                            //             // audioRecorder.audioBlobs = [];
                            //             //  audioRecorder.audioBlobs = [];
                            //         },
                            //         error: function (err) {
                            //             console.log(err);
                            //             // check the err for error details
                            //         }
                            //     }); // ajax call closing

                            // }
                        }



                        // var refreshIntervalId = setInterval(() => {
                        //     // console.log("dfdsfds");
                        //     if (start == 0) {

                        //         record_and_send();
                        //     } else {
                        //         clearInterval(refreshIntervalId);
                        //     }

                        // }, 2000);
                        // record_and_send(stream);

                        trigger_mic_smarthome["first"] = 1;
                    });
            } else {

                stopRecordingAll()

            }
        });

        function stopRecordingAll() {
            if (recorder["first"] != undefined && recorder["first"] != null) {
                recorder["first"].stopRecording();
            }
            if (recorder2["first"] != undefined && recorder2["first"] != null) {
                recorder2["first"].stopRecording();
            }
            data.data.forEach(element => {
                let id_devices = element.device.id_devices;
                if (recorder[id_devices] != undefined && recorder[id_devices] != null) {
                    recorder[id_devices].stopRecording();
                }
                if (recorder2[id_devices] != undefined && recorder2[id_devices] != null) {
                    recorder2[id_devices].stopRecording();
                }
                if (trigger_mic_smarthome[id_devices] == 1) {
                    $('#mic_' + id_devices).removeClass('btn-info');
                    $('#mic_' + id_devices).addClass('btn-danger');
                    $('#mic_' + id_devices).find($('small')).find($(".fas")).toggleClass('fa-microphone')
                        .toggleClass(
                            'fa-microphone-slash');
                    trigger_mic_smarthome[id_devices] = 0;
                }
            });
            if (trigger_mic_smarthome["first"] == 1) {

                $("#mic_smarthome").removeClass('btn-info');
                $("#mic_smarthome").addClass('btn-danger');
                $("#mic_smarthome").find($(".fas")).toggleClass('fa-microphone').toggleClass('fa-microphone-slash');
                trigger_mic_smarthome["first"] = 0;
            }
        }

        function changeButtonIncrease(row) {
            $("#qty_input_" + row).val(parseInt($("#qty_input_" + row).val()) + 1)
        }

        function changeButtonDecrease(row) {
            $("#qty_input_" + row).val(parseInt($("#qty_input_" + row).val()) - 1);

            if ($("#qty_input_" + row).val() == 0) {
                $("#qty_input_" + row).val(1);
            }
        }

        $(function() {
            $(".qty_input").prop("disabled", true);

            $('#list-smarthome-devices').on('click', '.btn-hapus', function() {
                var kode = $(this).data('id');
                var nama = $(this).data('nama');
                Swal.fire({
                        title: "Apakah anda yakin?",
                        text: "Untuk menghapus data : " + nama,
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                type: 'ajax',
                                method: 'get',
                                url: '/smarthome/delete/' + kode,
                                async: true,
                                dataType: 'json',
                                success: function(response) {
                                    if (response.status == true) {
                                        Swal.fire({
                                                title: "Success!",
                                                text: response.pesan,
                                                icon: "success"
                                            })
                                            .then(function() {
                                                location.reload(true);
                                            });
                                    } else {
                                        Swal.fire("Hapus Data Gagal!", {
                                            icon: "warning",
                                            title: "Failed!",
                                            text: response.pesan,
                                        });
                                    }
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    var err = eval("(" + jqXHR.responseText + ")");
                                    console.log(err);
                                    if (err.Message.includes("Unable to connect")) {
                                        Swal.fire("no Connection!",
                                            "Anda Tidak Terkoneksi dengan Internet..",
                                            "error");
                                    } else {
                                        Swal.fire("Error!", err.Message, "error");
                                    }
                                }
                            });
                        } else {
                            Swal.fire("Cancelled", "Hapus Data Dibatalkan.", "error");
                        }
                    });
            });
        });

        const allRanges = document.querySelectorAll(".range-wrap");
        allRanges.forEach(wrap => {
            const range = wrap.querySelector(".form-range");
            const bubble = wrap.querySelector(".bubble");

            range.addEventListener("input", () => {
                setBubble(range, bubble);
            });
            setBubble(range, bubble);
        });

        function setBubble(range, bubble) {
            const val = range.value;
            const min = range.min ? range.min : 0;
            const max = range.max ? range.max : 100;
            const newVal = Number(((val - min) * 100) / (max - min));
            bubble.innerHTML = val;

            // Sorta magic numbers based on size of the native UI thumb
            bubble.style.left = `calc(${newVal}% + (${8 - newVal * 0.15}px))`;
        }

        function deviceControlChange(row_parent, row_child = null, code = null) {

            // buat variabel dulu untuk menyimpan value 

            var device_control_switch = 0;
            var device_control_range = 0;
            var device_control_lock = 0;
            var device_control_color = '';
            var device_control_mode = 0;

            // check dulu apakah element ada atau tidak
            if ($('.smarthome_device_control_switch_' + row_parent).length) {
                if ($('.smarthome_device_control_switch_' + row_parent).is(':checked')) {
                    device_control_switch = 1;
                } else {
                    device_control_switch = 0;
                }
            } else {
                device_control_switch = null;
            }

            if ($('#smarthome_device_control_range_' + row_parent).length) {
                device_control_range = $('#smarthome_device_control_range_' + row_parent).val();
            } else {
                device_control_range = null;
            }


            if ($(".lock_" + row_child).length) {

                if (!$(".lock_" + row_child).hasClass('unlocked_' + row_child)) {
                    device_control_lock = 1;
                } else {
                    device_control_lock = 0;
                }
            } else {
                device_control_lock = null;
            }



            if ($('#smarthome_device_control_color_' + row_parent).length) {
                let HexValue = document.getElementById("HexValue_" + row_parent);

                let thatv = $('#smarthome_device_control_color_' + row_parent).val();
                let rgbV = hexTorgb(thatv);

                HexValue.innerHTML = rgbV;

                device_control_color = rgbV;
            } else {
                device_control_color = null;
            }
            // console.log(row_parent + '_' + row_child);
            if ($('#smarthome_device_control_mode_' + code).length) {
                if ($('#smarthome_device_control_mode_' + code).prop("checked")) {

                    device_control_mode = $('#smarthome_device_control_mode_' + code).val();
                }
            } else {
                device_control_mode = null;
            }

            $.ajax({
                type: "post",
                url: $('#form-control-manual_' + row_parent).attr('action'),
                data: {
                    '_token': CSRF_TOKEN,
                    'device_control_switch': device_control_switch,
                    'device_control_range': device_control_range,
                    'device_control_lock': device_control_lock,
                    'device_control_color': device_control_color,
                    'device_control_mode': device_control_mode
                },
                dataType: "json",
                success: function(response) {
                    if (response.status == true) {} else {
                        var pesan = "";
                        var data_pesan = response.pesan;
                        const wrapper = document.createElement('div');

                        if (typeof(data_pesan) == 'object') {

                            jQuery.each(data_pesan, function(key, value) {
                                console.log(value);
                                pesan += value + '. <br>';
                                wrapper.innerHTML = pesan;
                            });

                            Swal.fire({
                                title: "Error!",
                                content: wrapper,
                                icon: "warning"
                            });
                        } else {

                            if (response.pesan.includes("Unable to connect")) {
                                Swal.fire({
                                    title: "no Connection!",
                                    text: "Anda Tidak Terkoneksi dengan Internet..",
                                    icon: "warning"
                                });
                            } else {
                                Swal.fire({
                                    title: "Error",
                                    text: response.pesan,
                                    icon: "warning"
                                });
                            }
                        }
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    var err = eval("(" + jqXHR.responseText + ")");
                    if (err.Message.includes("Unable to connect")) {
                        Swal.fire("no Connection!", "Anda Tidak Terkoneksi dengan Internet..", "error");
                    } else {
                        Swal.fire("Error!", err.Message, "error");
                    }
                }
            });
        }

        function hexTorgb(hex) {
            return ['0x' + hex[1] + hex[2] | 0, '0x' + hex[3] + hex[4] | 0, '0x' + hex[5] + hex[6] | 0];
        }

        function componentToHex(c) {
            var hex = c.toString(16);
            return hex.length == 1 ? "0" + hex : hex;
        }

        function rgbToHex(r, g, b) {
            return "#" + componentToHex(r) + componentToHex(g) + componentToHex(b);
        }
    </script>
@endpush
