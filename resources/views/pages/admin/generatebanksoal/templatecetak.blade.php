@section('title')Cetak Data
{{-- Laporan Pemasukan dan Pengeluaran di {{ $settings->sekolahnama }} --}}
@endsection



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
            height: 10px;
            /* border: 1px black solid; */
            padding: 5px;
        }

        table tr td,
        table tr th {
            font-size: 12px;
            font-family: Georgia, 'Times New Roman', Times, serif;
        }


        body {
            font-size: 12px;
            font-family: Georgia, 'Times New Roman', Times, serif;
        }

        h1 h2 h3 h4 h5 {
            margin: auto;
            display: inline-block;
            /* line-height: 1.2; */
        }
        label{
            padding: 0;
        }

        .spa {
            letter-spacing: 3px;
        }

        hr.style2 {
        }


        .rotate {
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            width: 1.5em;
        }

        .rotate div {
            -moz-transform: rotate(90.0deg);
            /* FF3.5+ */
            -o-transform: rotate(90.0deg);
            /* Opera 10.5 */
            -webkit-transform: rotate(90.0deg);
            /* Saf3.1+, Chrome */
            filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083);
            /* IE6,IE7 */
            -ms-filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083)";
            /* IE8 */
            margin-left: -10em;
            margin-right: -10em;
            /* text-orientation: upright; */
        }

        table#tableKop, table#tableKop>tr>th, table#tableKop>tr>td{
            /* background-color: red; */
            border: 0px black solid;
            border-collapse: collapse;
            /* padding: 0; */
            margin-bottom: 0;
            padding-bottom: 0;
            /* margin: 0; */
        }
        table#tableKop{
            border-bottom: 3px double #8c8b8b;
        }
         table#tableBiasa,tr,th{
            border: 1px black solid;
            border-collapse: collapse;
            margin-top: 0px;
        }
        div#judul,h2,p{
            padding: 0;
            margin: 0;
        }
        div#judul2,h4{
            display: inline-block;
            padding: 0;
            margin: 0;
        }
    </style>
    @php
    $logo='assets/upload/logotutwuri.png';
    @endphp
    <table width="100%" id="tableKop" border="0">
        <tr>
            <td width="13%" align="right" style="padding-bottom:15px"><img src="{{$logo}}" width="70" height="70"></td>
            <td width="80%" align="center">
                <p><b>
                        <font size="18px">LEMBAGA PSIKOLOGI PELITA WACANA </font>
                    </b><br>
                    <font size="16px"> Jl.Simpang Wilis 2 Kav. B Telp. 0341-581777 Malang</font>



            </td>
        </tr>

    </table>

        <div style="margin-bottom: 0;text-align:center" id="judul">
            <h2>Judul</h2>
            <p for="">Tapel 2019-2020</p>
        </div>

    <div id="judul2">
        <h4>Kelas : VII</h4>
    </div>

    {{-- <center><h2>@yield('title')</h2></center> --}}


    <br>
    <table width="100%" id="tableBiasa">
        <tr>
            <th align="center">No</th>
            <th align="left">No Induk</th>
            <th align="center">Nama</th>
            <th align="center" class='rotate'>
                <div>KK</div>
            </th>
            <th align="center" class='rotate'>
                <div>KB</div>
            </th>
            <th align="center" class='rotate'>
                <div>LB</div>
            </th>

        </tr>

    </table>


    <br>

    <table width="100%" border="0">
        <tr>
            <td align="left" width="70%">

            </td>
            <td align="left" width="30%"><b>Denda per hari : <br>
                </b></td>

        </tr>
    </table>

    <br>

    <br>
    <br>


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

            <th width="30%" align="center">

                <img src="data:image/png;base64,{{DNS2D::getBarcodePNG('asdads', 'QRCODE')}}" alt="barcode"
                    width="150px" height="150px" />


            </th>
            <th width="3%"></th>

        </tr>

    </table>

</body>

</html>
