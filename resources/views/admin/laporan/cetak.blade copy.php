@php
    if(empty($pages)){
        $pages='kosong';
    }

    $ambilsettings = DB::table('settings')
      ->where('id', '=', '1')
      ->get();
      foreach ($ambilsettings as $settings) {
      }
@endphp

<html>
    <head>
        <title>Laporan Tahun Pelajaran</title>
    </head>
    <body>
        <style type="text/css">
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
            <td width="13%" align="right"><img src="../download.jpeg" width="110" height="110"></td>
            <td width="80%" align="center"><p><b><font size="28px">{{ $settings->sekolahnama }}</font><br>
            </b>
                                         <br>{{ $settings->sekolahalamat }}<BR>
                                            Telp: {{ $settings->sekolahtelp }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;http://google.com
                                        </p>
    
                                        </td>
            <td widht="7%"></td>
            </tr>
            <tr>
                <td colspan="3"><hr style="border:2px;">
                </td>
            </tr>
            </table>
            <center><h1>Laporan</h1></center>
    
      Saya yang bertanda tangan dibawah ini :<br>
      <table width="100%" border="0">
    
    
                  {{-- {{dd($pernyataans)}} --}}
    
                    <tr>
                      <td width="20%">Nama Lengkap</td>
                      <td width="1%">:</td>
                      <td width="79%" class="spa">asd</td>
    
                    </tr>
                    
    
    
                    <tr>
    
                    </tr>
                  </tfoot>
                </table>
                <br>
                <div align="center"><b><font size="18px">Menyatakan</font></b></div><br>
                Bahwa jika saya dinyatakan diterima sebagai siswa SMK Dhama Wanita Kromengan, maka Saya
                <table>
                    <tr>
                        <td>1</td>
                        <td>
                            Akan belajar dengan tekun dan penuh semangat.
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>
                            Akan menjaga nama baik diri sendiri, keluarga dan sekolah.
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>
                            Sanggup mentaati dan mematuhi pelaksanaan Wiyatamandala termasuk pakaian seragam sekolah, OSIS dan kegiatan-kegiatan sekolah serta tata tertib sekolah.
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                    
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>
                            Sanggup tidak melanggar peraturan sekolah dalam waktu minimal satu tahun
                        </td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>
                            Sanggup tidak menikah selama menjadi siswa SMK Dharmia Wanita Kromengan
                        </td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td>
                            Apabila saya tidak mentaati ketentuan yang ditetapkan oleh sekolah, saya sanggup menerima sanksi yaitu
      a. Tidak diperkenankan mengikuti pelajaran selama janka waktu tertentu
      b Dikembalikan ke Orang Tua/Wali saya
                        </td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td>
                            Akan merigikuti kegiatan Ekstrakurikuler yang dilaksanakan oleh sekolah yaitu Pramuka/ PMR / UKS-KKR / KIR / Sispala / Rohis/ Seni Prestasi / Olahraga Prestasi / Paskibra/dllnya )
                        </td>
                    </tr>
                </table>
    <br><br>
    Pernyataan ini saya buat dengan sebenar-benarnya dan dengan penuh tanggung jawab serta diketahui orang tua/wali saya
    <br><br><br><br><br>
    <table width="100%" border="0">
        <tr>
            <th width="3%"></th>
            <th width="30%" align="center">
                Mengetahui, <br>
                Orang Tua / Wali<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <br><br><br><br><br><br><br><br>
                <hr style="width:70%; border-top:2px dotted; border-style: none none dotted;  ">
    
            </th>
    
            <th width="34%"></th>
    
            <th width="30%" align="center">.........,..............................20
    
                <br>Yang Membuat Pernyataan,<br>
                <br><br>
                {{-- <img src="data:image/png;base64, {!! $qrcode !!}"> --}}
                <hr style="width:80%; border-top:2px dotted; border-style: none none dotted;  ">
                <b>123123</b>
            </th>
            <th width="3%"></th>
    
        </tr>
    </table>
    </body>
    </html>
    