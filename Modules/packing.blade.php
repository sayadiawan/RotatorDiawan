@extends('admin.layouts.app')

@section('css')
  <style>
    @media print {
      * {
        visibility: hidden;
        font-size: 24px;
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
                <label for="">Driver</label>
                <select name="driver" id="driver" class="smt-select2 form-control">
                  <option value="">semua driver</option>
                  @foreach ($drivers as $driverdata)
                    <option value="{{ $driverdata->id_employee }}" {{ isSelected($driver, $driverdata->id_employee) }}>
                      {{ $driverdata->name_employee }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-2 mb-3">
                <label for="">Tanggal</label>
                <input type="date" name="date" id="date" class="form-control" value="{{ $date }}">
              </div>
              <div class="col-md-4 mb-3">
                <button type="submit" class="btn btn-sm btn-primary btn-fw mt-4">FILTER</button>
                <button type="button" onclick="window.print()" class="btn btn-sm btn-primary btn-fw mt-4">CETAK</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="row" id="section-to-print" style="width: 100%">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="card-title text-center">
            DAFTAR PACKING PESANAN <br>
            {{ fdate($date, 'DDMMYYYY') }}
          </div>
          <div class="row">
            @if ($transactions == null)
              <center>
                <div class="alert alert-warning text-center">DAFTAR PESANAN KOSONG</div>
              </center>
            @endif
            <div class="col-md-12">
              <div class="card-body">
                <table class="table" border="1">
                  @foreach ($transactions as $dt)
                    <thead>
                      <tr style="background: #f0f0f0">
                        <td><b>{{ $dt->customer->name_customer }} - {{ $dt->customer->shipping->name_area }}</td>
                        <td width="10%" align="center"><b style="font-size: 21px">{{ $dt->group_transaction }}</b></td>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                        $data_trd = [];
                        $tQty = 0;
                        $tTotal = 0;
                        $no = 1;
                      @endphp
                      @foreach ($dt->transactiondetail as $items)
                        @php
                          $qty = $items->isrupiah_transdetail == 1 ? rupiah_format(round($items->qtyprice_transdetail, 2)) : round($items->qty_transdetail, 2);
                          $name_prd = $items->isrupiah_transdetail == 1 ? $items->product->name_product . ' ' . $qty : $items->product->name_product . ' ' . $qty . ' ' . $items->product->piece->name_piece;
                          // $qty = round($items->qty_transdetail,2);
                          $tQty += $items->qty_transdetail;
                          $tTotal += $items->total_transdetail;
                          $data_trd[$items->product->supplier->id_supplier]['name'] = $items->product->supplier->name_supplier;
                          $data_trd[$items->product->supplier->id_supplier]['data'][$no] = $name_prd . ' ' . $items->desc_transaction;
                          $no++;
                        @endphp
                      @endforeach

                      @foreach ($data_trd as $dtrd)
                        <table class="table" border="1">
                          <tr>
                            <td colspan="2"><b>{{ $dtrd['name'] }}</b></td>
                          </tr>
                          @foreach ($dtrd['data'] as $no => $item)
                            <tr>
                              <td>{{ $no }}</td>
                              <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;{{ $item }}</td>
                            </tr>
                          @endforeach
                        </table>
                      @endforeach
                    </tbody>
                  @endforeach
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script>
    WinPrint.print();
    // WinPrint.close();
  </script>
@endsection
