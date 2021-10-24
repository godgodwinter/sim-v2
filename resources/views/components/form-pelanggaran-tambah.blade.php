<div>
    <div class="card-header">
        <h5>Tambah Pelanggaran</h5>
    </div>
    <div class="row">

        <div class="form-group col-md-2 col-12 mt-0 ml-5">
            <label class="form-label">Pilih Siswa</label>
        </div>
        <div class="form-group col-md-8 col-12 mt-0 ml-5" >
            <select class="js-example-basic-single form-control-sm @error('walikelas_id')
            is-invalid
        @enderror" name="walikelas_id"  style="width: 75%" required>
            <option disabled selected value=""> Pilih Siswa</option>
                <option value="tes">tes</option>
          </select>
          </div>


        <div class="form-group col-md-2 col-12 mt-0 ml-5">
            <label class="form-label">Nama Pelanggaran</label>
        </div>
        <div class="form-group col-md-8 col-12 mt-0 ml-5" >
            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{old('nama') ? old('nama') : ''}}" required>
            @error('nama')<div class="invalid-feedback"> {{$message}}</div>
            @enderror
          </div>


        <div class="form-group col-md-2 col-12 mt-0 ml-5">
            <label class="form-label">Skor Pelanggaran</label>
        </div>
        <div class="form-group col-md-8 col-12 mt-0 ml-5" >
            <input type="number" name="skor" id="skor" class="form-control @error('skor') is-invalid @enderror" value="{{old('skor') ? old('skor') : '1'}}" required min="0" max="100">
            @error('skor')<div class="invalid-feedback"> {{$message}}</div>
            @enderror
          </div>

    </div>

    <div class="card-footer text-right mr-5">
        <button class="btn btn-primary">Simpan</button>
    </div>
</div>
