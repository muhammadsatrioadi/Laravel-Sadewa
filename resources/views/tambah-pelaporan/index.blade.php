@extends('layouts.main')

@section('content')
    <div class="section-header">
        <h1>Tambah Pelaporan</h1>
    </div>

    <div class="section-body">
        @if (session()->has('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="row">
            <div class="col-lg-4">
                <div class="card card-primary">
                    <div class="card-header">
                        Scan Barcode Disini
                    </div>
                    <div class="card-body">
                        <div id="reader" width="600px"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card card-primary">
                    <div class="card-header">
                        Detail Barang Inventaris
                    </div>
                    <div class="card-body">
                        <form action="/tambah-pelaporan" method="POST">
                            @csrf
                            <input type="hidden" name="barang_id" id="id">

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label>Nama Barang</label>
                                        <input type="text" class="form-control" name="nm_barang" id="nm_barang">
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Kode Barang</label>
                                        <input type="text" class="form-control" name="kd_barang" id="result" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label>Kategori</label>
                                        <input type="text" class="form-control" name="kategori" id="kategori">
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Merek</label>
                                        <input type="text" class="form-control" name="merk" id="merk">
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Lokasi</label>
                                        <input type="text" class="form-control" name="lokasi" id="lokasi">
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="row my-2">
                                <div class="col">
                                    <label>Judul Pelaporan <span style="color: red">*</span></label>
                                    <input type="text" class="form-control" name="judul" id="judul">
                                    @error('judul')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col">
                                    <label>Deskripsi Pelaporan <span style="color: red">*</span></label>
                                    <textarea class="form-control" name="deskripsi"></textarea>
                                    @error('deskripsi')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary float-right">Kirim Laporan</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

<script>
    // Format barcode/QR yang diperbolehkan
    const formatsToSupport = [
        Html5QrcodeSupportedFormats.QR_CODE,      // kalau QR diperlukan
        Html5QrcodeSupportedFormats.CODE_128,
        Html5QrcodeSupportedFormats.EAN_13,
        Html5QrcodeSupportedFormats.UPC_A
    ];

    let html5QrCodeScanner;

    function onScanSuccess(decodedText) {
        console.log("HASIL SCAN:", decodedText);

        // Masukkan kode barang
        document.getElementById('result').value = decodedText;

        // Stop kamera setelah scan berhasil
        html5QrCodeScanner.clear()
            .then(() => console.log("Scanner berhenti"))
            .catch(err => console.error("Gagal stop scanner:", err));

        // Ambil data barang dari backend
        fetch(`/get-data-barang?result=${encodeURIComponent(decodedText)}`)
            .then(res => res.json())
            .then(data => {
                console.log("DATA DARI BACKEND:", data);

                if (data && data.id) {
                    document.getElementById('id').value = data.id;
                    document.getElementById('nm_barang').value = data.nm_barang;
                    document.getElementById('kategori').value = data.kategori;
                    document.getElementById('merk').value = data.merk;
                    document.getElementById('lokasi').value = data.lokasi;
                } else {
                    alert("❌ Barang tidak ditemukan di database");
                }
            })
            .catch(err => {
                console.error("Fetch error:", err);
                alert("❌ Gagal mengambil data dari server");
            });
    }

    function onScanFailure(error) {
        console.warn("Scan gagal:", error);
    }

    // Mulai Scanner
    html5QrCodeScanner = new Html5QrcodeScanner(
        "reader",
        {
            fps: 10,
            qrbox: { width: 250, height: 250 },
            formatsToSupport: formatsToSupport   // ⬅ filter supaya tidak scan muka/benda lain
        },
        false
    );

    html5QrCodeScanner.render(onScanSuccess, onScanFailure);
</script>
@endsection
