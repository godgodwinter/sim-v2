@extends('layouts.layoutadminv3')

@section('title','Tagihan Atur')
@section('halaman','tagihanatur')

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
@endsection

@section('bodytable')
@endsection

@section('foottable') 
@endsection

{{-- DATATABLE-END --}}

@section('container')

  <div class="section-body">

    <div class="row mt-sm-4">

      <div class="col-12 col-md-12 col-lg-7">
        <div class="card">
            <form action="/admin/{{ $pages }}" method="post">
                @csrf
            <div class="card-header">
                <span class="btn btn-icon btn-light"><i class="fas fa-feather"></i> EDIT {{ Str::upper($pages) }}</span>
            </div>
            <div class="card-body">
                <div class="row">

                  <div class="form-group col-md-6 col-6">
                    <label>Tahun Pelajaran <code>*)</code></label>
                    <select class="form-control form-control-lg" required name="tapel_nama">  
                          @if ($tagihanatur->tapel_nama)
                          <option>{{$tagihanatur->tapel_nama}}</option>                        
                          @endif
                      @foreach ($tapel as $t)
                          {{-- <option>{{ $t->nama }}</option> --}}
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label>Kelas <code>*)</code></label>
                    <select class="form-control form-control-lg" required name="kelas_nama">
                          @if ($tagihanatur->kelas_nama)
                          <option>{{$tagihanatur->kelas_nama}}</option>                        
                          @endif
                      @foreach ($kelas as $k)
                          {{-- <option>{{ $k->nama }}</option> --}}
                      @endforeach
                    </select>
                  </div>
                  


                  @if ($tagihanatur->nominaltagihan)
                      @php                    
                        $nominaltagihan=$tagihanatur->nominaltagihan;
                      @endphp
                  @else
                      @php
                      $nominaltagihan=1;
                      @endphp                    
                  @endif
                  <div class="form-group col-md-6 col-6">
                    <label for="nominaltagihan">Nominal <code>*)</code> </label>
                    <input type="text" name="labelrupiah" min="1" id="labelrupiah" class="form-control-plaintext" readonly="" value="@currency($nominaltagihan)" >
                    <input type="number" name="nominaltagihan" min="0" id="rupiah" class="form-control @error('nominaltagihan') is-invalid @enderror" value="{{ $nominaltagihan }}" required>
                    @error('nominaltagihan')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                  <script type="text/javascript">
                    
                    var rupiah = document.getElementById('rupiah');
                    var labelrupiah = document.getElementById('labelrupiah');
                    rupiah.addEventListener('keyup', function(e){
                      // tambahkan 'Rp.' pada saat form di ketik
                      // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
                      // rupiah.value = formatRupiah(this.value, 'Rp. ');
                      labelrupiah.value = formatRupiah(this.value, 'Rp. ');
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
                
                </div>
             
            </div>
            <div class="card-footer text-right">
              <a href="{{ route($pages) }}" class="btn btn-icon btn-dark ml-3"> <i class="fas fa-backward"></i> Batal</a>
              <button class="btn btn-primary">Simpan</button>
            </div>

            <div class="card-body">
                <div class="section-title mt-0">Catatan : </div>
                <blockquote>
                  Jika Tahun Pelajaran dan Kelas sudah ada maka akan edit data tersebut.
                </blockquote>
              </div>
          </form>
        </div>


        

      </div>


    <div class="col-12 col-md-12 col-lg-5">
      <div class="card">
        <form method="post" action="/admin/datatagihanatur/upload/{{ $tagihanatur->id }}" enctype="multipart/form-data">
          {{ csrf_field() }}
          
          <div class="card-header">
              <span class="btn btn-icon btn-light"><i class="fas fa-feather"></i> Scan Documen Pendukung</span>
          </div>
          <div class="card-body">
              <div class="row">


                <div class="form-group col-md-12 col-3 ml-4">      
                  <div class="col-lg-8 d-flex align-items-stretch mb-4">

              @if($tagihanatur->gambar!=null)
              {{-- <img alt="image" src="{{ asset("storage/") }}/{{ $du->profile_photo_path }}" class="rounded-circle profile-widget-picture" width="100px"> --}}
        
              <img alt="image" src="{{ asset("storage/gambar/scan") }}/{{ $tagihanatur->gambar }}"class="img-thumbnail">

              @else
              {{-- <img alt="image" src="https://ui-avatars.com/api/?name={{ $siswa->nama }}&color=7F9CF5&background=EBF4FF" class="rounded-circle profile-widget-picture" width="200px"> --}}
              <img alt="image" src="https://ui-avatars.com/api/?name={{ $tagihanatur->kelas_nama }}&color=7F9CF5&background=EBF4FF" class="img-thumbnail" width="200px">

              @endif

               </div>
              {{-- <img alt="image" src="{{ asset("assets/") }}/img/products/product-3-50.png" class="rounded-circle profile-widget-picture"> --}}
                  <label for="file">Pilih Photo <code>*)</code></label>
                  <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" required>
                  @error('file')<div class="invalid-feedback"> {{$message}}</div>
                  @enderror

                <div class="card-footer text-right">
                
                  <button class="btn btn-success"><i class="fas fa-upload"></i> Simpan</button>
                </form>

                  <form action="/admin/datatagihanatur/upload/{{ $tagihanatur->id }}" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    <input type="hidden" name="namaphoto" value="gambar/scan/{{ $tagihanatur->id }}.jpg" required>
                    <button class="btn btn-icon btn-danger btn-md"
                        onclick="return  confirm('Anda yakin menghapus data ini? Y/N')"><span
                            class="pcoded-micon"> <i class="fas fa-trash"></i> Hapus</span></button>
                </form>
                <a href="{{ route($pages) }}" class="btn btn-icon btn-dark ml-3"> <i class="fas fa-backward"></i> Batal</a>
                </div>
                </div>



           
          </div>
          </div>
          {{-- <div class="card-footer text-right">
            <button class="btn btn-primary">Simpan</button>
          </div> --}}

          <div class="card-body">
              <div class="section-title mt-0">Catatan : </div>
              <blockquote>
                Jika gambar rusak coba untuk re upload gambar!
              </blockquote>
            </div>
        </form>
      </div>


      

    </div>
  </div>
@endsection
