
@section('title','Lihat Raport Siswa')
@section('halaman','siswa')

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


@section('container')

<div class="section-body">
    <div class="invoice">
      <div class="invoice-print">
        <div class="row">
          <div class="col-lg-12">
            <div class="invoice-title">
              <h2>Semester 1 Tahun Pelajaran {{ getsettings::tapelaktif() }}</h2>
              {{-- <h2>Laporan Penilaian Hasil Belajar</h2> --}}
              {{-- <div class="invoice-number">Semester 1 Tahun Pelajaran {{ getsettings::tapelaktif() }}</div> --}}
            </div>
            <hr>
            <div class="row">
              <div class="col-md-6">
                  <strong>Nama Peserta Didik</strong>  <strong>: {{ $siswa->nama }}</strong><br>
                  <strong>Nomer Induk</strong> <strong>: {{ $siswa->nis }}</strong><br>
                  <strong>Program Keahlian</strong><strong>: {{ Fungsi::periksajurusan($siswa->kelas_nama) }}</strong><br>
                  <strong>Kompetensi Keahlian</strong>  <strong>: {{ Fungsi::periksajurusankompetensi($siswa->kelas_nama) }}</strong><br>

              </div>
            
           
              <div class="col-md-6">
                  <strong>Tahun Pelajaran</strong><strong>: {{ getsettings::tapelaktif() }}</strong><br>
                  <strong>Tingkat / Tahun</strong><strong>: {{ Fungsi::periksajurusantingkat($siswa->kelas_nama) }} / {{ Fungsi::tahunaktif(getsettings::tapelaktif()) }} </strong><br>
                  <strong>Semester</strong><strong>: {{ getsettings::semesteraktif() }} ({{ Fungsi::periksasemester(getsettings::semesteraktif()) }})</strong><br>
              </div>
            </div>
          </div>
        </div>

        <div class="row mt-4">
          <div class="col-md-12">
            <div class="section-title">A. Nilai Akademik</div>
            {{-- <p class="section-lead">All items here cannot be deleted.</p> --}}
            <div class="table-responsive" >
              <table class="table table-striped table-hover table-md" border="1">
                <tr>
                  <th data-width="40" rowspan="2" class="text-center align-middle">NO</th>
                  <th class="text-center align-middle" rowspan="2">Mata Pelajaran</th>
                  <th class="text-center align-middle" rowspan="2">KKM</th>
                  <th class="text-center" colspan="2">Pengetahuan</th>
                  <th class="text-center"colspan="2">Ketrampilan</th>
                </tr>
                <tr>
                    <th class="text-center">Nilai</th>
                    <th class="text-center">Predikat</th>

                    <th class="text-center">Nilai</th>
                    <th class="text-center">Predikat</th>
                  </tr>
                  @foreach ($mapela  as $mapel)
                      
                <tr>
                  <td class="text-center">{{ (($loop->index)+1) }}</td>
                  <td>{{ $mapel->nama }}</td>
                  <td class="text-center">{{ $mapel->kkm }}</td>
                  <td class="text-center">80</td>
                  <td class="text-center">B+</td>
                  <td class="text-center">80</td>
                  <td class="text-center">B+</td>
                </tr>
                @endforeach

              </table>
            </div>


            <div class="section-title">B. Muatan kewilayahan</div>
            {{-- <p class="section-lead">All items here cannot be deleted.</p> --}}
            <div class="table-responsive" >
              <table class="table table-striped table-hover table-md" border="1">
                <tr>
                  <th data-width="40" rowspan="2" class="text-center align-middle">NO</th>
                  <th class="text-center align-middle" rowspan="2">Mata Pelajaran</th>
                  <th class="text-center align-middle" rowspan="2">KKM</th>
                  <th class="text-center" colspan="2">Pengetahuan</th>
                  <th class="text-center"colspan="2">Ketrampilan</th>
                </tr>
                <tr>
                    <th class="text-center">Nilai</th>
                    <th class="text-center">Predikat</th>

                    <th class="text-center">Nilai</th>
                    <th class="text-center">Predikat</th>
                  </tr>
                  @foreach ($mapelb as $mapel)
                      
                <tr>
                  <td class="text-center">{{ (($loop->index)+1) }}</td>
                  <td>{{ $mapel->nama }}</td>
                  <td class="text-center">{{ $mapel->kkm }}</td>
                  <td class="text-center">80</td>
                  <td class="text-center">B+</td>
                  <td class="text-center">80</td>
                  <td class="text-center">B+</td>
                </tr>
                @endforeach

              </table>
            </div>

            <div class="section-title">C. Muatan Peminatan Kejuruhan</div>
            <div class="section-title">C1. Dasar Bidang Keahlian</div>
            {{-- <p class="section-lead">All items here cannot be deleted.</p> --}}
            <div class="table-responsive" >
              <table class="table table-striped table-hover table-md" border="1">
                <tr>
                  <th data-width="40" rowspan="2" class="text-center align-middle">NO</th>
                  <th class="text-center align-middle" rowspan="2">Mata Pelajaran</th>
                  <th class="text-center align-middle" rowspan="2">KKM</th>
                  <th class="text-center" colspan="2">Pengetahuan</th>
                  <th class="text-center"colspan="2">Ketrampilan</th>
                </tr>
                <tr>
                    <th class="text-center">Nilai</th>
                    <th class="text-center">Predikat</th>

                    <th class="text-center">Nilai</th>
                    <th class="text-center">Predikat</th>
                  </tr>
                  @foreach ($mapelc1 as $mapel)
                      
                <tr>
                  <td class="text-center">{{ (($loop->index)+1) }}</td>
                  <td>{{ $mapel->nama }}</td>
                  <td class="text-center">{{ $mapel->kkm }}</td>
                  <td class="text-center">80</td>
                  <td class="text-center">B+</td>
                  <td class="text-center">80</td>
                  <td class="text-center">B+</td>
                </tr>
                @endforeach

              </table>
            </div>

            <div class="section-title">C2. Dasar Program Keahlian</div>
            {{-- <p class="section-lead">All items here cannot be deleted.</p> --}}
            <div class="table-responsive" >
              <table class="table table-striped table-hover table-md" border="1">
                <tr>
                  <th data-width="40" rowspan="2" class="text-center align-middle">NO</th>
                  <th class="text-center align-middle" rowspan="2">Mata Pelajaran</th>
                  <th class="text-center align-middle" rowspan="2">KKM</th>
                  <th class="text-center" colspan="2">Pengetahuan</th>
                  <th class="text-center"colspan="2">Ketrampilan</th>
                </tr>
                <tr>
                    <th class="text-center">Nilai</th>
                    <th class="text-center">Predikat</th>

                    <th class="text-center">Nilai</th>
                    <th class="text-center">Predikat</th>
                  </tr>
                  @foreach ($mapelc2  as  $mapel)
                   @php
                     $kodekelas=Fungsi::periksajurusankode($siswa->kelas_nama);
                    //  dd($kodekelas);
                   @endphp   
                   @if($mapel->jurusan===$kodekelas)
                     
                <tr>
                  <td class="text-center">{{ (($loop->index)+1) }}</td>
                  <td>{{ $mapel->nama }}</td>
                  <td class="text-center">{{ $mapel->kkm }}</td>
                  <td class="text-center">80</td>
                  <td class="text-center">B+</td>
                  <td class="text-center">80</td>
                  <td class="text-center">B+</td>
                </tr>

                @endif
                @endforeach
                <tr>
                    <td colspan="3" class="text-center"> <strong>JUMLAH</strong> </td>
                    <td colspan="2" class="text-center">1200</td>
                    <td colspan="2" class="text-center">1200</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-center"> <strong>RATA - RATA </strong></td>
                    <td colspan="2" class="text-center">1200</td>
                    <td colspan="2" class="text-center">1200</td>
                </tr>

              </table>
            </div>

            <div class="row mt-4">
              <div class="col-lg-8">
                {{-- <div class="section-title">Payment Method</div> --}}

                {{-- <p class="section-lead">The payment method that we provide is to make it easier for you to pay invoices.</p> --}}
                <div class="d-flex">
        {{-- <div class="mr-2 bg-visa" data-width="61" data-height="38"></div>
                  <div class="mr-2 bg-jcb" data-width="61" data-height="38"></div>
                  <div class="mr-2 bg-mastercard" data-width="61" data-height="38"></div>
                  <div class="bg-paypal" data-width="61" data-height="38"></div> --}}
                </div>
              </div>
              <div class="col-lg-4 text-right">
                {!! QrCode::size(250)->generate( url('/raport/'.$siswa->nis) ); !!} 

       {{-- <div>{!! DNS1D::getBarcodeHTML('4445645656', 'C39') !!}</div></br>
       <div>{!! DNS1D::getBarcodeHTML('4445645656', 'POSTNET') !!}</div></br>
       <div>{!! DNS1D::getBarcodeHTML('4445645656', 'PHARMA') !!}</div></br>
       <div>{!! DNS2D::getBarcodeHTML('4445645656', 'QRCODE') !!}</div></br>
       <div>{!! DNS2D::getBarcodeHTML( url('/barcode'), 'QRCODE') !!}</div></br> --}}
                {{-- <div class="invoice-detail-item">
                  <div class="invoice-detail-name">Subtotal</div>
                  <div class="invoice-detail-value">$670.99</div>
                </div>
                <div class="invoice-detail-item">
                  <div class="invoice-detail-name">Shipping</div>
                  <div class="invoice-detail-value">$15</div>
                </div>
                <hr class="mt-2 mb-2">
                <div class="invoice-detail-item">
                  <div class="invoice-detail-name">Total</div>
                  <div class="invoice-detail-value invoice-detail-value-lg">$685.99</div>
                </div> --}}
              </div>
            </div>
          </div>
        </div>
      </div>
      <hr>
      <div class="text-md-right">
        <div class="float-lg-left mb-lg-0 mb-3">
          {{-- <button class="btn btn-primary btn-icon icon-left"><i class="fas fa-credit-card"></i> Process Payment</button>
          <button class="btn btn-danger btn-icon icon-left"><i class="fas fa-times"></i> Cancel</button> --}}
        </div>
        <button class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i> Print</button>
      </div>
    </div>
  </div>

@endsection
