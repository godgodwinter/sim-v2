
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
            <td width="13%" align="right"><img src="assets/upload/@yield('logo')" width="110" height="110"></td>
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
            <center><h2>@yield('title')</h2></center>
    
      <table width="100%" border="1">
    
    
                  {{-- {{dd($pernyataans)}} --}}
    
                    <tr>

                @yield('headtable')
                    </tr>
                    
                @yield('bodytable')
    
    
                  </tfoot>
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
    
                <br>Yang Membuat Pernyataan,<br>
                <br><br>
                <br><br>
                <br><br>
                <br><br>
                {{-- <img src="data:image/png;base64, {!! $qrcode !!}"> --}}
                {{-- <hr style="width:80%; border-top:2px dotted; border-style: none none dotted;  "> --}}
                <b>@yield('kepsek')</b>
            </th>
            <th width="3%"></th>
    
        </tr>
    </table>
    </body>
    </html>