@extends('layouts.main')

@section('content')
    <div class="section-header">
        <h1>Tambah Data Barang</h1>
        <div class="ml-auto">
            <a href="/barang" class="btn btn-secondary"><i class="fa fa-plus"></i> Kembali</a>
        </div>
    </div>

    <div class="section-body">
        <form action="/barang" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-8">
                    <div class="card card-primary">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="text" class="form-control" name="tgl_penambahan" id="tgl_penambahan"
                                    readonly value="">
                            </div>
                            <div class="form-group">
                                <label>Nama Barang <span style="color: red">*</span></label>
                                <input type="text" class="form-control" name="nm_barang">
                                @error('nm_barang')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-0">
                                <label>Deskripsi <span style="color: red">*</span></label>
                                <textarea class="form-control" name="deskripsi" class="deskripsi"></textarea>
                                @error('deskripsi')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row mt-3">
                                <div class="col-4">
                                    <label>Kategori <span style="color: red">*</span></label>
                                    <select class="form-control" name="kategori_id">
                                        <option value="" selected>-- Pilih Kategori -- </option>
                                        @foreach ($kategories as $kategori)
                                            <option value="{{ $kategori->id }}">{{ $kategori->kategori }}</option>
                                        @endforeach
                                    </select>
                                    @error('kategori_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <label>Merek <span style="color: red">*</span></label>
                                    <select class="form-control" name="merk_id">
                                        <option value="" selected>-- Pilih Merek -- </option>
                                        @foreach ($merks as $merk)
                                            <option value="{{ $merk->id }}">{{ $merk->merk }}</option>
                                        @endforeach
                                    </select>
                                    @error('merk_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <label>Lokasi <span style="color: red">*</span></label>
                                    <select class="form-control" name="lokasi_id">
                                        <option value="" selected>-- Pilih Lokasi -- </option>
                                        @foreach ($lokasies as $lokasi)
                                            <option value="{{ $lokasi->id }}">{{ $lokasi->lokasi }}</option>
                                        @endforeach
                                    </select>
                                    @error('lokasi_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card card-primary">
                        <div class="card-body">
                            <div class="form-group">
                                <img src="" class="public/assets/img/qr_tv.jpg" id="preview"
                                    style="border-radius: 5px; max-height:300px; overflow:hidden;"><br>
                                <label>Gambar <span style="color: red">*</span></label>
                                <input type="file" class="form-control" name="gambar" onchange="previewImage()">
                                @error('gambar')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary float-right">Simpan</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Mendapatkan tanggal hari ini
        var today = new Date();

        // Mendapatkan tahun, bulan, dan tanggal
        var year = today.getFullYear();
        var month = (today.getMonth() + 1).toString().padStart(2, '0'); // Bulan dimulai dari 0
        var day = today.getDate().toString().padStart(2, '0');

        // Format tanggal sesuai kebutuhan (misal: YYYY-MM-DD)
        var formattedDate = year + '-' + month + '-' + day;

        // Mengatur nilai input tanggal
        document.getElementById('tgl_penambahan').value = formattedDate;
    </script>

    <!-- Preview Image -->
    <script>
        function previewImage() {
            preview.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
@endsection
