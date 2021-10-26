
@section('content')
        <section class="section">
            <div class="section-header">
            <h1>@yield('title')</h1>
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
                            <h4>Jumlah Siswa</h4>
                          </div>
                          <div class="card-body">
                            @php
                                $jmlsiswa=DB::table('siswa')->whereNull('deleted_at')->count();
                                $jmlkelas=DB::table('kelas')->count();
                            @endphp
                            {{$jmlsiswa}} Siswa
                            <div class="text-muted text-small"><span class="text-primary"><i class="fas fa-caret-up"></i></span> {{$jmlkelas}} Kelas</div>

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
                            <h4>Jumlah Guru</h4>
                          </div>
                          <div class="card-body">
                            @php
                                $jmlguru=DB::table('guru')->whereNull('deleted_at')->count();
                            @endphp
                            {{$jmlguru}} Guru
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
                                $jmlmapel=DB::table('mapel')->whereNull('deleted_at')->count();
                                $jmlmapelperkelas=DB::table('dataajar')->whereNull('deleted_at')->count();
                            @endphp
                            {{$jmlmapel}} Mapel
                            <div class="text-muted text-small"><span class="text-primary"><i class="fas fa-caret-up"></i></span> Total {{$jmlmapelperkelas}} Mapel</div>
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
                                $jmlkompetensidasar=DB::table('kompetensidasar')->whereNull('deleted_at')->count();
                                $jmlbanksoal=DB::table('banksoal')->whereNull('deleted_at')->count();
                            @endphp
                                {{$jmlbanksoal}} Soal
                            <div class="text-muted text-small"><span class="text-primary"><i class="fas fa-caret-up"></i></span>  {{$jmlkompetensidasar}} Silabus</div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="card">
                    <div class="card-header">
                      <h4>Silabus dan Bank Soal</h4>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        @forelse ($mapel as $m)
                        @php
                        $totalkd=0;
                        $totalsoal=0;
                            $ambildataajar=DB::table('dataajar')->where('mapel_id',$m->id)->whereNull('deleted_at')->get();
                            foreach ($ambildataajar as $d) {
                                $jmlkd=DB::table('kompetensidasar')->whereNull('deleted_at')->where('dataajar_id',$d->id)->count();
                                $totalkd+=$jmlkd;
                                $jmlsoal=DB::table('banksoal')->whereNull('deleted_at')->where('dataajar_id',$d->id)->count();
                                $totalsoal+=$jmlsoal;
                            }
                        @endphp
                        <div class="col text-center col-6 col-md-3 mt-2">

                            <img alt="image" src="https://ui-avatars.com/api/?name={{$m->nama}}&color=7F9CF5&background=EBF4FF&length=3" class="img-thumbnail" data-toggle="tooltip" title="{{$m->nama}}" width="100px" height="100px" style="object-fit:cover;">

                            <div class="mt-2 font-weight-bold">{{$m->nama}}</div>
                            <div class="text-muted text-small"><span class="text-primary"><i class="fas fa-caret-up"></i></span> {{$totalkd}} Silabus </div>
                            <div class="text-muted text-small"><span class="text-primary"><i class="fas fa-caret-up"></i></span> {{$totalsoal}} Soal </div>
                          </div>

                        @empty

                        @endforelse


                      </div>
                    </div>
                  </div>

            {{-- <div class="card">
                <div class="card-header">
                <h4>Contoh Halaman</h4>
                </div>
                <div class="card-body">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                </div>
                <div class="card-footer bg-whitesmoke">
                This is card footer
                </div>
            </div> --}}


              <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                  <div class="card">
                    <div class="card-header">
                      <h4>Jumlah Siswa : {{$laki+$perempuan}}</h4>
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
