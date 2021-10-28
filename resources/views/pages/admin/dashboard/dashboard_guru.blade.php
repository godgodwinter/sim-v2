
@section('content')
        <section class="section">
            <div class="section-header">
            <h1>Data Siswa, Kelas dan Silabus Anda sebagai Guru / Walikelas</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">Dashboard</a></div>
                {{-- <div class="breadcrumb-item"><a href="#">Layout</a></div> --}}
                {{-- <div class="breadcrumb-item">Default Layout</div> --}}
            </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                      <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div class="card-wrap">
                          <div class="card-header">
                            <h4>Jumlah Siswa Saya</h4>
                          </div>
                          <div class="card-body">
                            @php
                                // $datasiswa=\App\Models\siswa::with('kelas')->get();
                                $datakelas=\App\Models\kelas::with('siswa')->where('guru_id',$guru_id)->get();
                                $jmlsiswa=0;
                                $laki=0;
                                $perempuan=0;
                                foreach ($datakelas as $dk) {
                                    $jmlsiswa+=$dk->siswa!=null?$dk->siswa->count():0;
                                    $laki+=$dk->siswa!=null?$dk->siswa->where('jk','Laki-laki')->count():0;
                                    $perempuan+=$dk->siswa!=null?$dk->siswa->where('jk','Perempuan')->count():0;
                                    // dd($dk->siswa->where('jk','Laki-laki')->count());
                                // dd($dk->siswa->count());
                                }
                                $jmlkelas=DB::table('kelas')->count();

                            @endphp
                            {{$jmlsiswa}} Siswa
                            <div class="text-muted text-small"><span class="text-primary"><i class="fas fa-caret-up"></i></span> {{$datakelas->count()}} Kelas</div>

                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                      <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-school"></i>
                        </div>
                        <div class="card-wrap">
                          <div class="card-header">
                            <h4>Kelas</h4>
                          </div>
                          <div class="card-body">
                            @php
                                $jmlguru=DB::table('guru')->whereNull('deleted_at')->count();
                            @endphp
                            {{$datakelas->count()}} Kelas
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                      <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fab fa-monero"></i>
                        </div>
                        <div class="card-wrap">
                          <div class="card-header">
                            <h4>Jumlah Mata Pelajaran</h4>
                          </div>
                          <div class="card-body">
                            @php
                                $jmlmapel=\App\Models\dataajar::where('guru_id',$guru_id)->count();
                                $jmlmapelperkelas=DB::table('dataajar')->whereNull('deleted_at')->count();
                            @endphp
                            {{$jmlmapel}} Mapel

                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                      <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-microchip"></i>
                        </div>
                        <div class="card-wrap">
                          <div class="card-header">
                            <h4>Bank Soal</h4>
                          </div>
                          <div class="card-body">
                            @php

                            $dataajar=\App\Models\dataajar::with('banksoal')->where('guru_id',$guru_id)->get();
                                $jmlsoal=0;
                                foreach ($dataajar as $dk) {
                                    $jmlsoal+=$dk->banksoal!=null?$dk->banksoal->count():0;
                                // dd($dk->siswa->count());
                                }
                            $datakd=\App\Models\dataajar::with('kompetensidasar')->where('guru_id',$guru_id)->get();
                                $jmlkompetensidasar=0;
                                foreach ($datakd as $dk) {
                                    $jmlkompetensidasar+=$dk->kompetensidasar!=null?$dk->kompetensidasar->count():0;
                                // dd($dk->siswa->count());
                                }
                            @endphp
                                {{$jmlsoal}} Soal
                            <div class="text-muted text-small"><span class="text-primary"><i class="fas fa-caret-up"></i></span>  {{$jmlkompetensidasar}} Silabus</div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>



              <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                  <div class="card">
                    <div class="card-header">
                      <h4>Jumlah Siswa : {{$jmlsiswa}}</h4>
                    </div>
                    <div class="card-body">
                      <canvas id="myChart3"></canvas>
                    </div>
                  </div>
                </div>

              </div>



            </div>
        </section>


@push('after-style')

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
<script>


  $(document).ready(function() {
    //doughnut
    var ctx = document.getElementById('myChart3').getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ['Siswa Laki-laki', 'Siswa Perempuan'],
      datasets: [{
        label: '# of Votes',
        data: [{{$laki}}, {{$perempuan}}],
        backgroundColor: [
          'rgba(255, 99, 132, 0.2)',
          'rgba(54, 162, 235, 0.2)'
        ],
        borderColor: [
          'rgba(255, 99, 132, 1)',
          'rgba(54, 162, 235, 1)'
        ],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true
          }
        }]
      }
    }
  });



});

    </script>
@endpush
@endsection
