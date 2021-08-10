<div>
    <!-- Knowing is not enough; we must apply. Being willing is not enough; we must do. - Leonardo da Vinci -->

    <div class="alert alert-{{ $tipe }} alert-has-icon alert-dismissible show fade">
        <div class="alert-icon"><i class="{{ $icon }}"></i></div>
                          <div class="alert-body">
                            <div class="alert-title">{{ Str::ucfirst($tipe) }}</div>
                            <button class="close" data-dismiss="alert">
                              <span>&times;</span>
                            </button>
                            {{ $message }}
                          </div>
                        </div>
</div>