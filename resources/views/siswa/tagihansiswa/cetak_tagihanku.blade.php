@php
    if(empty($pages)){
        $pages='kosong';
    }

    $ambilsettings = DB::table('settings')
      ->where('id', '=', '1')
      ->get();
      foreach ($ambilsettings as $settings) {
        $sekolahttd=$settings->sekolahttd;
      }
@endphp



{{-- DATALAPORAN --}}
{{-- DATALAPORAN-END --}}


@section('title')
Rekap Pembayaran Tagihan Siswa 
@endsection

@section('kepsek')
@endsection

@section('alamat')
{{ $settings->sekolahalamat }}
@endsection

@section('telp')
{{ $settings->sekolahtelp }}
@endsection

@section('namasekolah')
{{ $settings->sekolahnama }}
@endsection

@section('logo')
{{ $settings->sekolahlogo }}
@endsection


{{-- DATATABLE --}}


@section('bodytable')
  
  


@endsection
{{-- DATATABLE-END --}}


{{-- DATATABLEdua --}}


@section('bodytable2')



    
    

@endsection
{{-- DATATABLEdua-END --}}


{{-- DATATABLETIGA --}}


@section('bodytable3')

  
  

    
    

@endsection
{{-- DATATABLETIGA-END --}}


<html>
    <head>
        <title>@yield('title')</title>
    </head>
    <body>
        <style type="text/css">
        table {
            border-spacing: 0;
            margin: 2px;
          }
        th { 
                padding: 5px;
            }
        td { 
                padding: 5px;
            }
            table tr td,
            table tr th{
                font-size: 12px;
                font-family: Georgia, 'Times New Roman', Times, serif;
            }
            td{
                height:10px;
            }
            body {
                font-size: 12px;
                font-family:Georgia, 'Times New Roman', Times, serif;
                }
            h1 h2 h3 h4 h5{
                line-height: 1.2;
            }
            .spa{
              letter-spacing:3px;
            }
        </style>
        <table width="100%" border="0">
            <tr>
              @if(($settings->sekolahlogo!='')&&($settings->sekolahlogo!=null))
                <td width="13%" align="right"><img src="storage/{{ $settings->sekolahlogo }}" width="110" height="110"></td>

              @else
                <td td width="13%" align="right"><img src="assets/upload/logotutwuri.png" width="110" height="110"></td>

              @endif

            <td width="80%" align="center"><p><b><font size="28px">@yield('namasekolah')</font><br>
            </b>
            <br>@yield('alamat')
            <BR>Telp: @yield('telp')&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        </p>
    
                                        </td>
            <td widht="7%"></td>
            </tr>
            <tr>
                <td colspan="3"><hr style="border:2px;">
                </td>
            </tr>
            </table>
            {{-- <center><h2>@yield('title')</h2></center> --}}
   
@foreach ($datas as $data)
@php
$warna='default';
$sumdetailbayar = DB::table('tagihansiswadetail')
  ->where('siswa_nis', '=', $data->siswa_nis)
  ->where('tapel_nama', '=', $data->tapel_nama)
  ->where('kelas_nama', '=', $data->kelas_nama)
  ->sum('nominal');
  $kurang=$data->nominaltagihan-$sumdetailbayar;
  $persen=number_format(($sumdetailbayar/$data->nominaltagihan*100),2);
  $persenkurang=number_format(($kurang/$data->nominaltagihan*100),2);
  if($persen=='100'){
    $warna='success';
  }
@endphp
@endforeach
                <h3 align="center">Rekap Tagihan Siswa</h3>
                <p>NIS : {{ $nis }}</p>
                <p>Nama : {{ $datasiswa->nama }}</p>
                <table width="100%" border="1">
                  <tr>
                    <th width="5%"> No</th>
                    <th> Nama</th>
                    <th width="25%"> Nominal</th>
                  </tr>
                  <tr>
                    <td align="center">1</td>
                    <td> Total Tagihan</td>
                    <td>@currency($data->nominaltagihan) - {{ $persen }}%</td>
                  </tr>
                  <tr>
                    <td align="center">2</td>
                    <td> Total Terbayar</td>
                    <td>@currency($sumdetailbayar)</td>
                  </tr>
                  @foreach ($datadetails as $dd)
                    <tr>
                      <td align="center">-</td>
                      <td> Pembayaran ke- {{ ($loop->index)+1 }}</td>
                      <td>@currency($dd->nominal)</td>
                    </tr>
                    
                  @endforeach
                  <tr>
                    <td align="center">3</td>
                    <td> Kurang</td>
                    <td>@currency($kurang) - {{ $persenkurang }}%</td>
                  </tr>
                </table>


                <br>
              
    <br><br><br><br><br>
    <table width="100%" border="0">
        <tr>
            <th width="3%"></th>
            <th width="30%" align="center">
                <br>
               <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <br><br><br><br><br><br><br><br>
                {{-- <hr style="width:70%; border-top:2px dotted; border-style: none none dotted;  "> --}}
    
            </th>
    
            <th width="34%"></th>
    
            <th width="30%" align="center">.........,..........................,  @php
               echo  date('Y');
            @endphp
    
                <br>Mengetahui,<br>
                <br><br>
                <br><br>
                <br><br>
                <br><br>
                {{-- <img src="data:image/png;base64, {!! $qrcode !!}"> --}}
                {{-- <hr style="width:80%; border-top:2px dotted; border-style: none none dotted;  "> --}}
                <b>{{ $sekolahttd }}</b>
            </th>
            <th width="3%"></th>
    
        </tr>
    </table>
    </body>
    </html>