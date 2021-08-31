@extends('layouts.layoutadmin1')

@section('title','Tagihan Siswa')
@section('halaman','tagihansiswa')

@section('csshere')
@endsection

@section('jshere')
@endsection


@section('notif')


@if (session('tipe'))
        @php
        $tipe=session('tipe');    
        @endphp
@else
        @php
            $tipe='light';
        @endphp
@endif

@if (session('icon'))
        @php
        $icon=session('icon');    
        @endphp
@else
        @php
            $icon='far fa-lightbulb';
        @endphp
@endif

@php
  $message=session('status');
@endphp
@if (session('status'))
<x-alert tipe="{{ $tipe }}" message="{{ $message }}" icon="{{ $icon }}"/>

@endif
@endsection 


{{-- DATATABLE --}}
@section('headtable')
<th width="5%" class="text-center">
  <input type="checkbox" id="chkCheckAll"> <label for="chkCheckAll"> All</label></th>
  <th width="5%" >Bayar</th>
  <th>Nama</th>
  <th>Tahun</th>
  <th>Kelas</th>
  <th>Nominal Tagihan</th>
  <th>Terbayar</th>
  <th>Kurang</th>
  <th width="10%"  class="text-center">%</th>
@endsection

@section('bodytable')
<script>
  // console.log('asdad');
  $().jquery;
  $.fn.jquery;
  $(function(e){
      $("#chkCheckAll").click(function(){
          $(".checkBoxClass").prop('checked',$(this).prop('checked'));
      })

      $("#deleteAllSelectedRecord").click(function(e){
          e.preventDefault();
          var allids=[];
              $("input:checkbox[name=ids]:checked").each(function(){
                  allids.push($(this).val());
              });

      $.ajax({
          url:"{{ route('tagihansiswa.multidel') }}",
          type:"DELETE",
          data:{
              _token:$("input[name=_token]").val(),
              ids:allids
          },
          success:function(response){
              $.each(allids,function($key,val){
                      $("#sid"+val).remove();
              })
          }
      });

      })

  });
</script>
@foreach ($datas as $data)@php
    $sumdetailbayar = DB::table('tagihansiswadetail')
      ->where('siswa_nis', '=', $data->siswa_nis)
      ->where('tapel_nama', '=', $data->tapel_nama)
      ->where('kelas_nama', '=', $data->kelas_nama)
      ->sum('nominal');
      $kurang=$data->nominaltagihan-$sumdetailbayar;
      $persen=number_format(($sumdetailbayar/$data->nominaltagihan*100),2);
        $warna='light';
        $icon='fas fa-times';
      if($persen>='100'){
        $warna='success';
        $icon='fas fa-check';
      }
    @endphp
<tr id="sid{{ $data->id }}">
    <td class="text-center">  <input type="checkbox" name="ids" class="checkBoxClass " value="{{ $data->id }}"> {{ ($loop->index)+1 }}</td>
      <td class="text-center">
        <button class="btn btn-icon btn-{{ $warna }}" data-toggle="modal" data-target="#modalbayar{{ $data->id }}" ><i class="far fa-money-bill-alt"></i></button>
      </td>
      <td class="text-left">{{ $data->siswa_nis }} - {{ $data->siswa_nama }}</td>
      <td class="text-left">{{ $data->tapel_nama }}</td>
      <td class="text-left">{{ $data->kelas_nama }}</td>
      <td class="text-left">@currency($data->nominaltagihan)</td>
      <td class="text-left">@currency($sumdetailbayar)</td>
      <td>@currency($kurang)</td>
      <td class="text-center">

    <span class="btn btn-icon icon-left btn-{{ $warna }}"><i class="{{ $icon }}"></i> {{ $persen }} %</span>
      
      </td>

      {{-- <td class="text-center">
          <a href="/admin/{{ $pages }}/{{$data->id}}"  class="btn btn-icon icon-left btn-info"><i class="fas fa-edit"></i> Detail</a>
        <form action="/admin/{{ $pages }}/{{$data->id}}" method="post" class="d-inline">
              @method('delete')
              @csrf
              <button class="btn btn-icon btn-danger"
                  onclick="return  confirm('Anda yakin menghapus data ini? Y/N')"><span
                      class="pcoded-micon"> <i class="fas fa-trash"></i></span></button>
          </form>
      </td> --}}
    </tr>
@endforeach

<tr>
  <td class="text-left" colspan="2">
    <a href="#" class="btn btn-sm  btn-danger" id="deleteAllSelectedRecord"
    onclick="return  confirm('Anda yakin menghapus data ini? Y/N')"><i class="fas fa-trash"></i> Hapus Terpilih</a></td>
</tr>
@endsection

@section('foottable')  
@php
  $cari=$request->cari;
  $tapel_nama=$request->tapel_nama;
  $kelas_nama=$request->kelas_nama;
@endphp
  {{-- {{ $datas->appends(['cari'=>$request->cari,'yearmonth'=>$request->yearmonth,'kategori_nama'=>$request->kategori_nama])->links() }} --}}
  {{ $datas->onEachSide(1)
    ->appends(['cari'=>$cari])
    ->appends(['tapel_nama'=>$tapel_nama])
    ->appends(['kelas_nama'=>$kelas_nama])
    ->links() }}
  <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
      <li class="breadcrumb-item"><i class="far fa-file"></i> Halaman ke-{{ $datas->currentPage() }}</li>
      <li class="breadcrumb-item"><i class="fas fa-paste"></i> {{ $datas->total() }} Total Data</li>
      <li class="breadcrumb-item active" aria-current="page"><i class="far fa-copy"></i> {{ $datas->perPage() }} Data Perhalaman</li>
  </ol>
  </nav>
@endsection

{{-- DATATABLE-END --}}

@section('tomboltambahan')

<form action="/admin/{{ $pages }}/sync" method="post" class="d-inline">
  @csrf
  <button 
      onclick="return  confirm('Anda yakin melakukan sinkronisasi data ? Y/N')" class="btn btn-icon icon-left btn-primary btn-sm mt-1" data-toggle="tooltip" data-placement="top" title="Akan mengambil data siswa dan tagihan atur yang belum dimasukkan kedalam tagihan siswa!"><i class="fas fa-retweet"></i> Sinkronisasi Data</button>
</form>


<button type="button" class="btn btn-icon btn-primary btn-sm" data-toggle="modal" data-target="#importExcel"><i class="fas fa-upload"></i>
Import 
</button>




<a href="/admin/data{{  $pages }}/export" type="submit" value="Import" class="btn btn-icon btn-primary btn-sm"><span
    class="pcoded-micon"> <i class="fas fa-download"></i> Export </span></a href="$add">


<button type="button" class="btn btn-icon btn-primary btn-sm" data-toggle="modal" data-target="#importExceltagihansiswadetail"><i class="fas fa-upload"></i>
Import Detail Tagihan
</button>


<a href="/admin/datatagihansiswadetail/export" type="submit" value="Import" class="btn btn-icon btn-primary btn-sm"><span
    class="pcoded-micon"> <i class="fas fa-download"></i> Export Detail Tagihan</span></a href="$add">

@endsection
@section('container')


<div class="row ">
  <div class="col-12 col-md-12 col-lg-12">
    {{-- <div class="card">
      <div class="card-body"> --}}
        <form action="{{ route('tagihansiswa.cari') }}" method="GET">
          <div class="row">
              <div class="form-group  col-xl-2 col-md-3 col-2 mt-1 text-right">
                <input type="text" name="cari" id="cari" class="form-control form-control-md @error('cari') is-invalid @enderror" value="{{$request->cari}}"  placeholder="Cari...">
                @error('cari')<div class="invalid-feedback"> {{$message}}</div>
                @enderror
              </div>

              <div class="form-group col-xl-2 col-md-3 col-2 text-right">
            
                <select class="form-control form-control-sm" name="tapel_nama" >   
                @if($request->tapel_nama)
                  <option>{{$request->tapel_nama}}</option>
                @else
                 <option value="" disabled selected>Pilih Tahun Pelajaran</option>
                @endif
              @foreach ($tapel as $t)
                  <option>{{ $t->nama }}</option>
              @endforeach
            </select>
              </div>
              <div class="form-group col-xl-2  col-md-3 col-2 text-right">
         
              <select class="form-control form-control-sm" name="kelas_nama">    
                @if($request->kelas_nama)
                  <option>{{$request->kelas_nama}}</option>
                @else
                 <option value="" disabled selected>Pilih Kelas</option>
                @endif
             
            @foreach ($kelas as $t)
                <option>{{ $t->nama }}</option>
            @endforeach
          </select>
              </div>
          <div class="form-group   text-right">
     
          <button type="submit" value="CARI" class="btn btn-icon btn-info btn-md mt-1" ><span
          class="pcoded-micon"> <i class="fas fa-search"></i> Pecarian</span></button>

        </form>
        
              </div>
           
         
        
      </div>
      <div class="col-12 col-md-12 col-lg-12">
        <x-layout-table3 pages="{{ $pages }}" pagination="{{ $datas->perPage() }}"/>
       </div> 

    </div>
  </div>
@endsection


@section('container-modals')

@foreach ($datas as $data)
@php
$sumdetailbayar = DB::table('tagihansiswadetail')
  ->where('siswa_nis', '=', $data->siswa_nis)
  ->where('tapel_nama', '=', $data->tapel_nama)
  ->where('kelas_nama', '=', $data->kelas_nama)
  ->sum('nominal');
  $kurang=$data->nominaltagihan-$sumdetailbayar;
  $persen=number_format(($sumdetailbayar/$data->nominaltagihan*100),2);
@endphp
    <div class="modal fade" tabindex="-1" role="dialog" id="modalbayar{{ $data->id }}">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Pembayaran "{{ $data->siswa_nis }} - {{ $data->siswa_nama }}"</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            {{-- <p>Modal body text goes here.</p> --}}

            <form action="/admin/{{ $pages }}/bayartagihan/{{ $data->id }}" method="post">
              @csrf
            <div class="form-group">

              @if (old('nominal'))
              @php                    
                $nominal=old('nominal');
              @endphp
          @else
              @php
              $nominal=0;
              @endphp                    
          @endif

          <div class="input-group">
            <div class="input-group-prepend">
              <div class="input-group-text">Sisa Tagihan :
              </div>
            </div>  
             <input type="text" class="form-control-plaintext" readonly="" value="@currency($kurang)" >
          </div>
          <div class="input-group">
            <div class="input-group-prepend">
              <div class="input-group-text">Nominal Bayar:
              </div>
            </div>  
             <input type="text" name="labelrupiah" min="0" id="labelrupiah{{ $data->id }}" class="form-control-plaintext" readonly="" value="@currency($nominal)" >
          </div>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="far fa-money-bill-alt""></i>
                  </div>
                </div>
                <input type="number" class="form-control  @error('nominal') is-invalid @enderror" name="nominal" id="rupiah{{ $data->id }}" value="{{ $nominal }}"  required>

                  @error('nominal')<div class="invalid-feedback"> {{$message}}</div>
                  @enderror
              </div>

            </div>


          <script type="text/javascript">
            
            var rupiah{{ $data->id }} = document.getElementById('rupiah{{ $data->id }}');
            var labelrupiah{{ $data->id }} = document.getElementById('labelrupiah{{ $data->id }}');
            rupiah{{ $data->id }}.addEventListener('keyup', function(e){
              // tambahkan 'Rp.' pada saat form di ketik
              // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
              // rupiah.value = formatRupiah(this.value, 'Rp. ');
              labelrupiah{{ $data->id }}.value = formatRupiah(this.value, 'Rp. ');
            });
        
            /* Fungsi formatRupiah */
            function formatRupiah(angka, prefix){
              var number_string = angka.replace(/[^,\d]/g, '').toString(),
              split   		= number_string.split(','),
              sisa     		= split[0].length % 3,
              rupiah     		= split[0].substr(0, sisa),
              ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
        
              // tambahkan titik jika yang di input sudah menjadi angka ribuan
              if(ribuan){
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
              }
        
              rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
              return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
            }
          </script>
        
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Bayar</button>
            </form>
          </div>
          <div class="modal-body">
            {{-- <p>Modal body text goes here.</p> --}}
            <div class="table-responsive">
              <table class="table table-bordered table-md">
                <tr>
                  <th width="5%" class="text-center">Pembayaran ke-</th>
                  <th>Nominal</th>
                  <th width="5%" class="text-center">Aksi</th>
                </tr>
                @php
                    $detailbayar = DB::table('tagihansiswadetail')
                      ->where('siswa_nis', '=', $data->siswa_nis)
                      ->where('tapel_nama', '=', $data->tapel_nama)
                      ->where('kelas_nama', '=', $data->kelas_nama)
                      ->get();
                @endphp
                @foreach ($detailbayar as $db)
                    
                <tr>
                  <td  class="text-center">{{ ($loop->index)+1 }}</td>
                  <td class="text-left">
                    @currency($db->nominal)</td>
                  <td class="text-center"> 
                    <form action="/admin/{{ $pages }}/bayartagihan/{{$db->id}}/hapus  " method="post" class="d-inline">
                        @method('delete')
                        @csrf
                        <button class="btn btn-icon btn-danger"
                            onclick="return  confirm('Anda yakin menghapus data ini? Y/N')"><span
                                class="pcoded-micon"> <i class="fas fa-trash"></i></span></button>
                  </form>
                    </td>
                  </tr>

                @endforeach
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endforeach



              <!-- Import Excel -->
              <div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <form method="post" action="{{ route('tagihansiswa.import') }}" enctype="multipart/form-data">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Import data "Tagihan Siswa" Excel</h5>
                      </div>
                      <div class="modal-body">
           
                        {{ csrf_field() }}
           
                        <label>Pilih file excel(.xlsx)</label>
                        <div class="form-group">
                          <input type="file" name="file" required="required">
                        </div>
           
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>

              <!-- Import Excel -->
              <div class="modal fade" id="importExceltagihansiswadetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <form method="post" action="{{ route('tagihansiswadetail.import') }}" enctype="multipart/form-data">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Import data "Tagihan Siswa Detail" Excel </h5>
                      </div>
                      <div class="modal-body">
           
                        {{ csrf_field() }}
           
                        <label>Pilih file excel(.xlsx)</label>
                        <div class="form-group">
                          <input type="file" name="file" required="required">
                        </div>
           
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
          

@endsection