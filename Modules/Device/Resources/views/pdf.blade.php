@if ($status=="1")
<!-- halaman status perpegawai / code 1 -->
<h2 style="text-align:center;">BIODATA PEGAWAI</h2>
<table>
    <tr>
        <td>Nama</td>
        <td>: {{ $get_data->name_employee }}</td>
    </tr>
    <tr>
        <td>Nomor Telepon</td>
        <td>: {{ $get_data->phone_employee }}</td>
    </tr>
    <tr>
        <td>Email</td>
        <td>: {{ $get_data->email_employee }}</td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>: {{ $get_data->address_employee }}</td>
    </tr>
    <tr>
        <td>Jabatan</td>
        <td>: {{ reference('posisi_pegawai',$get_data->position_employee) }}</td>
    </tr>
    <tr>
        <td>Status</td>
        <td>: {{ reference('status',$get_data->status) }}</td>
    </tr>

</table>
<!-- end halaman status perpegawai / code 1 -->
@else
{{-- halaman status pegawai / code 0 (all data) --}}
<style>
    #customers {
      /* font-family: Arial, Helvetica, sans-serif; */
      border-collapse: collapse;
      width: 100%;
    }
    
    #customers td, #customers th {
      border: 1px solid rgb(12, 12, 12);
      padding: 5px;
      font-size: 13px;
    }
    
    /* #customers tr:nth-child(even){background-color: #f2f2f2;} */
    
    /* #customers tr:hover {background-color: #ddd;} */
    
    #customers th {
      padding-top: 12px;
      padding-bottom: 12px;
      text-align: left;
      /* background-color: #04AA6D; */
      /* color: white; */
    }
</style>
<h2 style="text-align: center">LAPORAN SEMUA DATA PEGAWAI</h2>
<table id="customers">
    <tr>
      <th wdith="5%" style="text-align: center">No</th>
      <th style="text-align: center">Nama</th>
      <th wdith="15%" style="text-align: center">Nomor Telepon</th>
      <th style="text-align: center">Email</th>
      <th style="text-align: center">Alamat</th>
      <th style="text-align: center">Jabatan</th>
      <th style="text-align: center">Posisi</th>
    </tr>
    @foreach ($get_data as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->name_employee }}</td>
            <td>{{ $item->phone_employee }}</td>
            <td>{{ $item->email_employee }}</td>
            <td>{{ $item->address_employee }}</td>
            <td>{{ reference('posisi_pegawai',$item->position_employee) }}</td>
            <td>{{ reference('status',$item->status) }}</td>        
        </tr>
    @endforeach
</table>
{{-- end  halaman status pegawai / code 0 (all data) --}}
@endif