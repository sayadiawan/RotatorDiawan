@extends('admin.layouts.app')

@section('css')
  <style>
    @media print {
      body * {
        visibility: hidden;
      }

      #section-to-print,
      #section-to-print * {
        visibility: visible;
        padding: 5px;
      }

      #section-to-print {
        position: absolute;
        left: 0;
        top: 0;
      }
    }
  </style>
@endsection

@section('page-title')
@endsection

@section('content')
  <div class="row">
    <div class="col-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <form action="">
            <div class="form-group row">
              <div class="col-md-2 mb-3">
                <label for="">Shopper</label>
                <select name="shopper" id="shopper" class="smt-select2 form-control">
                  <option value="">semua shopper</option>
                  @foreach ($shoppers as $shopperdata)
                    <option value="{{ $shopperdata->id_employee }}" {{ isSelected($shopper, $shopperdata->id_employee) }}>
                      {{ $shopperdata->name_employee }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-2 mb-3">
                <label for="">Tanggal</label>
                <input type="date" name="date" id="date" class="form-control" value="{{ $date }}">
              </div>
              <div class="col-md-2 mb-3">
                <label for="">Output</label>
                <select name="output" id="output" class="form-control">
                  <option value="1" {{ isSelected('1', $output) }}>Output 1</option>
                  <option value="2" {{ isSelected('2', $output) }}>Output 2</option>
                  <option value="3" {{ isSelected('3', $output) }}>Output 3</option>
                </select>
              </div>
              <div class="col-md-4 mb-3">
                <button type="submit" class="btn btn-sm btn-primary btn-fw mt-4">FILTER</button>
                <button type="submit" value="print" name="action"
                  class="btn btn-sm btn-primary btn-fw mt-4">CETAK</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <?php 
if($output == "1")
{ ?>
  <div class="row" id="section-to-print">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="card-title text-center">
            DAFTAR BELANJA <br>
            {{ fdate($date, 'DDMMYYYY') }}
          </div>

          <div class="row">

            @if ($data == null)
              <center>
                <div class="alert alert-warning text-center">DAFTAR BELANJA KOSONG</div>
              </center>
            @endif

            @foreach ($data as $dt)
              <div class="col-md-6 ">
                <div class="card-body">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <td colspan="2"><b>{{ $dt['supplier']['name'] }} -
                            ({{ smt_reference('supplier_position', $dt['supplier']['position']) }})</b> - <a href="#"
                            class="open-invoiceDialog" data-toggle="modal"
                            data-message="{{ $dt['supplier']['message'] }}" data-id="{{ $dt['supplier']['id'] }}"
                            data-supplier="{{ $dt['supplier']['name'] }}"
                            data-phone="{{ number_wa($dt['supplier']['phone']) }}" title="Invoice sudah dibuat">KIRIM
                            WA</a></td>
                        <td>{{ $dt['supplier']['lastcall'] }}</td>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                        $dataSort = [];
                        $tQty = 0;
                        $tTotal = 0;
                        $no = 0;
                        $lastgroup = '';
                      @endphp
                      @foreach ($dt['items'] as $items)
                        @foreach ($items['product'] as $qty => $product)
                          @php
                            $x = 0;
                            
                          @endphp
                          @foreach ($product['data'] as $key_prd => $item)
                            <tr>
                              <td width="20px">{{ $item['group'] == $lastgroup ? '' : $item['group'] }}</td>
                              <td>{{ $item['product'] }} {{ $item['qty'] }}</td>
                              <td></td>
                            </tr>
                            @php
                              $lastgroup = $item['group'];
                              $x++;
                            @endphp
                          @endforeach
                        @endforeach
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>

  <?php 
if($output == "2")
{ ?>
  <div class="row" id="section-to-print">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="card-title text-center">
            DAFTAR BELANJA <br>
            {{ fdate($date, 'DDMMYYYY') }}
          </div>

          <div class="row">

            @if ($data == null)
              <center>
                <div class="alert alert-warning text-center">DAFTAR BELANJA KOSONG</div>
              </center>
            @endif
            @foreach ($data as $dt)
              <div class="col-md-6 ">
                <div class="card-body">
                  <table class="table" border="1">
                    <thead>
                      <tr>
                        <td colspan="2"><b>{{ $dt['supplier']['name'] }} -
                            ({{ smt_reference('supplier_position', $dt['supplier']['position']) }})</b> - <a
                            href="#" class="open-invoiceDialog" data-toggle="modal"
                            data-message="{{ $dt['supplier']['message'] }}"
                            data-supplier="{{ $dt['supplier']['name'] }}"
                            data-phone="{{ number_wa($dt['supplier']['phone']) }}" title="Invoice sudah dibuat">KIRIM
                            WA</a></td>
                        <td>{{ $dt['supplier']['lastcall'] }}</td>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                        $tQty = 0;
                        $tTotal = 0;
                      @endphp
                      @foreach ($dt['items'] as $items)
                        @php
                          $key = 0;
                          $tQty += $items['tQty'];
                          $tTotal += $items['tTotal'];
                          $g = 'A';
                          $g++;
                        @endphp
                        @foreach ($items['product'] as $qty => $product)
                          @php
                            $x = 0;
                            usort($product['data'], function ($a, $b) {
                                return $a['group'] <=> $b['group'];
                            });
                          @endphp
                          @foreach ($product['data'] as $key_prd => $item)
                            @if ($item['isGroup'] == '0')
                              <tr>
                                <td width="20px">{{ $item['group'] }}</td>
                                <td>{{ $item['product'] }} {{ rupiah_format($item['qty'], 2) }} {{ $item['piece'] }}
                                </td>
                                <td></td>
                              </tr>
                            @else
                              @if ($x == '0')
                                <tr>
                                  {{-- <td width="20px">{{($item['isGroup'] == "0") ? $item['group'] :"" }}</td> --}}
                                  <td width="20px">-</td>
                                  <td>{{ $item['product'] }} {{ $item['qty'] }}
                                    {{ count($product['data']) == 1 ? '' : 'x ' . count($product['data']) }}</td>
                                  <td></td>
                                </tr>
                              @endif
                            @endif
                            @php
                              $x++;
                            @endphp
                            @php
                              $key++;
                            @endphp
                          @endforeach
                        @endforeach
                      @endforeach
                    </tbody>
                    {{-- <tfoot>
                                    <tr style="background: #f0f0f0">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Total</td>
                                        <td>{{round($tQty,2)}}</td>
                                        <td>{{rupiah_format($tTotal)}}</td>
                                        <td></td>
                                    </tr>
                                </tfoot> --}}
                  </table>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>

  <?php 
if($output == "3")
{ ?>
  <div class="row" id="section-to-print">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="card-title text-center">
            DAFTAR BELANJA <br>
            {{ fdate($date, 'DDMMYYYY') }}
          </div>
          <div class="row">
            @if ($data == null)
              <center>
                <div class="alert alert-warning text-center">DAFTAR BELANJA KOSONG</div>
              </center>
            @endif
            @php
              $datas = [];
              $x = 0;
            @endphp
            @foreach ($transactiondetail as $trd)
              @php
                $datas[$trd->product_transdetail]['id'] = $trd->product->id_product;
                $datas[$trd->product_transdetail]['name'] = $trd->product->name_product;
                $datas[$trd->product_transdetail]['data'][$x]['group'] = $trd->transaction->group_transaction;
                $datas[$trd->product_transdetail]['data'][$x]['qty'] = $trd->isrupiah_transdetail == '1' ? rupiah_format($trd->qtyprice_transdetail) : $trd->qty_transdetail . ' ' . $trd->product->piece->name_piece;
                
                $x++;
              @endphp
            @endforeach

            @foreach ($datas as $data)
              <div class="col-md-6 ">
                <div class="card-body">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <td><b>{{ $data['name'] }}</b></td>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                        usort($data['data'], function ($a, $b) {
                            return $a['group'] <=> $b['group'];
                        });
                      @endphp
                      @foreach ($data['data'] as $item)
                        <tr>
                          <td width="20px">{{ $item['group'] }} - {{ $item['qty'] }}</td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>

  <div class="modal hide" id="invoiceDialog">
    <div class="modal-dialog">
      <div class="modal-content">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Invoice</h5>
          <button type="button" class="close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="phone_supplier" id="phone_supplier" value="" />
          <input type="hidden" name="id_supplier" id="id_supplier" value="" />

          <p>Konfirmasi Pembelian Barang </p>
          <textarea class="form-control" id="message_supplier" rows="10"></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" onclick="send_wa()">Kirim WA</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script>
    $(document).on("click", ".open-invoiceDialog", function() {
      var message = $(this).data('message');
      var name_supplier = $(this).data('supplier');
      var id_supplier = $(this).data('id');
      var phone_supllier = $(this).data('phone');

      $('#id_supplier').val(id_supplier);
      $('#phone_supplier').val(phone_supllier);

      $("#message_supplier").html("Hai " + name_supplier + ", \npesan belanja sebagai berikut : \n" + message +
        "\nOM SAYOER");
      $('#invoiceDialog').modal('show');
    });

    function send_wa() {
      var id_supplier = $('#id_supplier').val();
      var message_html = $('#message_supplier').val();
      var phone = $('#phone_supplier').val();
      var message = encodeURIComponent(message_html);

      $.ajax({
        url: "/supplier/update_lastcall/" + id_supplier,
        type: "GET",
        data: {},
        success: function(response) {
          window.open("https://wa.me/" + phone + "?text=" + message, '_blank');
          location.reload();

        }
      });
    }
  </script>
@endsection
