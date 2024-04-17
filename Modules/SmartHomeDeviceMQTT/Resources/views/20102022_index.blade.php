@extends('admin.layouts.app')

@push('after-style')
    <script>
        var recorder = {},
            recorder2 = {},
            trigger_mic_smarthome = {};
        trigger_mic_smarthome["first"] = 0;
    </script>
@endpush

@section('title')
    Data Site untuk Smart Home
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

                <li class="breadcrumb-item active">Data Site untuk Smart Home</li>
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
                        <h5 class="mb-0">Data Smart Home Site</h5>

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
                                        @endphp

                                        <div class="col-lg-3 col-md-12 col-6 mb-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div
                                                        class="card-title d-flex align-items-start justify-content-between">
                                                        <div class="avatar flex-shrink-0">
                                                            @if (Storage::disk('public')->exists('icon_device/' . $item->device->image_devices) &&
                                                                    $item->device->image_devices != null)
                                                                <img src="{{ Storage::url('icon_device/' . $item->image_devices) }}"
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
                                                                    <div class="form-check form-switch mb-3">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            checked="" />
                                                                        <label class="form-check-label"
                                                                            for="flexSwitchCheckChecked">
                                                                            Switch On/Off
                                                                        </label>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <div class="row">
                                                                            <div class="col-md">
                                                                                <small class="text-light fw-semibold">
                                                                                    Volume
                                                                                </small>

                                                                                <div class="mt-3">
                                                                                    <input type="range" class="form-range"
                                                                                        min="0" max="5" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <div class="row">
                                                                            <div class="col-md">
                                                                                <small class="text-light fw-semibold">
                                                                                    Mode
                                                                                </small>

                                                                                <div class="mt-3">
                                                                                    <div class="btn-group" role="group"
                                                                                        aria-label="Basic example">
                                                                                        <button type="button"
                                                                                            class="btn btn-outline-secondary">
                                                                                            Mode 1
                                                                                        </button>
                                                                                        <button type="button"
                                                                                            class="btn btn-outline-secondary">
                                                                                            Mode 2
                                                                                        </button>
                                                                                        <button type="button"
                                                                                            class="btn btn-outline-secondary">
                                                                                            Mode 3
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <div class="row">
                                                                            <div class="col-md">
                                                                                <small class="text-light fw-semibold">
                                                                                    Volume
                                                                                </small>

                                                                                <div class="mt-3">
                                                                                    <div class="input-group mb-3">
                                                                                        <div class="input-group-prepend">
                                                                                            <button type="button"
                                                                                                class="btn btn-dark btn-sm"
                                                                                                id="minus-btn-decrease-{{ $index }}"
                                                                                                onclick="changeButtonDecrease({{ $index }})">
                                                                                                <i class="fa fa-minus"></i>
                                                                                            </button>
                                                                                        </div>

                                                                                        <input type="number"
                                                                                            id="qty_input_{{ $index }}"
                                                                                            name="qty_input"
                                                                                            class="form-control form-control-sm qty_input"
                                                                                            value="1"
                                                                                            min="1" />

                                                                                        <div class="input-group-prepend">
                                                                                            <button type="button"
                                                                                                class="btn btn-dark btn-sm"
                                                                                                id="plus-btn-increase-{{ $index }}"
                                                                                                onclick="changeButtonIncrease({{ $index }})">
                                                                                                <i class="fa fa-plus"></i>
                                                                                            </button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                {{-- / modal control manual --}}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <h5 class="card-title text-nowrap mb-1">
                                                        {{ $item->device->name_devices }}
                                                    </h5>

                                                    <button type="button" id="mic_{{ $item->device->id_sites }}"
                                                        data-id="{{ $item->device->id_sites }}"
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
                                            {{ $result->links() }}
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
    <script src="https://www.WebRTC-Experiment.com/RecordRTC.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- use 5.6.2 or any other version on cdnjs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/RecordRTC/5.6.2/RecordRTC.js"></script>
    <script>
        var data = '<?php echo json_encode($result); ?>';
        data = JSON.parse(data);
        data.data.forEach(element => {
            var id_sites = element.device.id_sites;
            trigger_mic_smarthome[id_sites] = 0;
            $("#mic_" + id_sites).click(function() {
                if (trigger_mic_smarthome[id_sites] == 0) {


                    navigator.mediaDevices.getUserMedia({
                            audio: true
                        } /*of type MediaStreamConstraints*/ )
                        //returns a promise that resolves to the audio stream
                        .then(stream /*of type MediaStream*/ => {

                            stopRecordingAll()

                            $("#mic_" + id_sites).removeClass('btn-danger');
                            $("#mic_" + id_sites).addClass('btn-info');
                            $("#mic_" + id_sites).find($(".fas")).toggleClass('fa-microphone')
                                .toggleClass(
                                    'fa-microphone-slash');

                            recorder[id_sites] = RecordRTC(stream, {
                                type: 'audio',
                                recorderType: RecordRTC
                                    .StereoAudioRecorder, // force for all browsers
                                numberOfAudioChannels: 1,
                                timeSlice: 5000, // pass this parameter

                                // getNativeBlob: true,
                                ondataavailable: function(blob) {
                                    // chunks.push(blob)
                                    // sendToServer(blob)
                                    sendToServerById(blob, id_sites)
                                    // console.log(blob);

                                    // blobs.push(blob);

                                    // var size = 0;
                                    // blobs.forEach(function (b) {
                                    //     size += b.size;
                                    // });

                                    // h1.innerHTML = 'Total blobs: ' + blobs.length + ' (Total size: ' + bytesToSize(size) + ')';
                                }
                            });

                            recorder2[id_sites] = RecordRTC(stream, {
                                type: 'audio',
                                recorderType: RecordRTC
                                    .StereoAudioRecorder, // force for all browsers
                                numberOfAudioChannels: 1,
                                timeSlice: 5000, // pass this parameter

                                ondataavailable: function(blob) {
                                    // chunks.push(blob)
                                    sendToServerById(blob, id_sites)
                                    // console.log(blob);

                                    // blobs.push(blob);

                                    // var size = 0;
                                    // blobs.forEach(function (b) {
                                    //     size += b.size;
                                    // });

                                    // h1.innerHTML = 'Total blobs: ' + blobs.length + ' (Total size: ' + bytesToSize(size) + ')';
                                }
                            });


                            recorder[id_sites].startRecording();
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
                                    recorder2[id_sites].startRecording();
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


                            trigger_mic_smarthome[id_sites] = 1;
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
                                        "idRoom": "7ef4a0ea-1b30-42b7-8fb1-8666b00de270"
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
                let id_sites = element.device.id_sites;
                if (recorder[id_sites] != undefined && recorder[id_sites] != null) {
                    recorder[id_sites].stopRecording();
                }
                if (recorder2[id_sites] != undefined && recorder2[id_sites] != null) {
                    recorder2[id_sites].stopRecording();
                }
                if (trigger_mic_smarthome[id_sites] == 1) {
                    $('#mic_' + id_sites).removeClass('btn-info');
                    $('#mic_' + id_sites).addClass('btn-danger');
                    $('#mic_' + id_sites).find($('small')).find($(".fas")).toggleClass('fa-microphone')
                        .toggleClass(
                            'fa-microphone-slash');
                    trigger_mic_smarthome[id_sites] = 0;
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
                swal({
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
                                        swal({
                                                title: "Success!",
                                                text: response.pesan,
                                                icon: "success"
                                            })
                                            .then(function() {
                                                location.reload(true);
                                            });
                                    } else {
                                        swal("Hapus Data Gagal!", {
                                            icon: "warning",
                                            title: "Failed!",
                                            text: response.pesan,
                                        });
                                    }
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    var err = eval("(" + jqXHR.responseText + ")");
                                    swal("Error!", err.Message, "error");
                                }
                            });
                        } else {
                            swal("Cancelled", "Hapus Data Dibatalkan.", "error");
                        }
                    });
            });
        });
    </script>
@endpush
