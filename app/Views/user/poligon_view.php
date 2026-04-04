    
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0">
                <div class="card-header card-header-custom py-3">
                    <h5 class="m-0 font-weight-bold"><i class="fas fa-map-marked-alt mr-2"></i> Input Data Poligon Tambang</h5>
                </div>
                
                <div class="card-body">
                    
                    <!-- Notifikasi Sukses -->
                    <?php if(session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle mr-1"></i> <?= session()->getFlashdata('success') ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('poligon/simpan') ?>" method="post" enctype="multipart/form-data">
                        
                        <!-- Section: Informasi Umum -->
                        <h6 class="heading-small text-muted mb-4"><i class="fas fa-info-circle"></i> Informasi Umum</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label font-weight-bold">Nama Perusahaan</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-building"></i></span>
                                            </div>
                                            <input type="text" name="companyName" class="form-control" placeholder="Contoh: PT. Tambang Sejahtera" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label font-weight-bold">Nama Lokasi / Site</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-map-pin"></i></span>
                                            </div>
                                            <input type="text" name="locationName" class="form-control" placeholder="Contoh: Blok A - Utara" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label font-weight-bold">Nomor Izin (Permit)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-file-contract"></i></span>
                                            </div>
                                            <input type="number" name="permit" class="form-control" placeholder="Nomor SK / Izin" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label font-weight-bold">Foto Lokasi (JPG/PNG)</label>
                                        <div class="custom-file">
                                            <input type="file" name="foto_lokasi" class="custom-file-input" id="customFileFoto" accept="image/*">
                                            <label class="custom-file-label" for="customFileFoto">Pilih foto...</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label font-weight-bold">Dokumen (PDF/DOC)</label>
                                        <div class="custom-file">
                                            <input type="file" name="dokumen_pendukung" class="custom-file-input" id="customFileDokumen" accept=".pdf,.doc,.docx">
                                            <label class="custom-file-label" for="customFileDokumen">Pilih dokumen...</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Section: Koordinat -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="heading-small text-muted mb-0"><i class="fas fa-globe-asia"></i> Titik Koordinat (DMS)</h6>
                            <button type="button" class="btn btn-primary btn-sm shadow-sm" id="btn-tambah">
                                <i class="fas fa-plus"></i> Tambah Titik
                            </button>
                        </div>

                        <div id="koordinat-container">
                            <!-- Template Baris Koordinat -->
                            <div class="coord-box p-3 mb-3 rounded position-relative" id="row-0">
                                <div class="row">
                                    <!-- Latitude -->
                                    <div class="col-md-5 border-right">
                                        <label class="font-weight-bold text-primary small mb-2">LATITUDE (LINTANG)</label>
                                        <div class="form-row">
                                            <div class="col-3 px-1">
                                                <input type="number" name="lat_deg[]" class="form-control form-control-sm text-center" placeholder="Deg" required>
                                                <small class="text-muted d-block text-center" style="font-size: 10px;">Derajat</small>
                                            </div>
                                            <div class="col-3 px-1">
                                                <input type="number" name="lat_min[]" class="form-control form-control-sm text-center" placeholder="Min" required>
                                                <small class="text-muted d-block text-center" style="font-size: 10px;">Menit</small>
                                            </div>
                                            <div class="col-3 px-1">
                                                <input type="number" name="lat_sec[]" class="form-control form-control-sm text-center" placeholder="Sec" required>
                                                <small class="text-muted d-block text-center" style="font-size: 10px;">Detik</small>
                                            </div>
                                            <div class="col-3 px-1">
                                                <select name="lat_dir[]" class="form-control form-control-sm bg-light">
                                                    <option value="S">S (LS)</option>
                                                    <option value="N">N (LU)</option>
                                                </select>
                                                <small class="text-muted d-block text-center" style="font-size: 10px;">Arah</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Longitude -->
                                    <div class="col-md-5">
                                        <label class="font-weight-bold text-success small mb-2">LONGITUDE (BUJUR)</label>
                                        <div class="form-row">
                                            <div class="col-3 px-1">
                                                <input type="number" name="long_deg[]" class="form-control form-control-sm text-center" placeholder="Deg" required>
                                                <small class="text-muted d-block text-center" style="font-size: 10px;">Derajat</small>
                                            </div>
                                            <div class="col-3 px-1">
                                                <input type="number" name="long_min[]" class="form-control form-control-sm text-center" placeholder="Min" required>
                                                <small class="text-muted d-block text-center" style="font-size: 10px;">Menit</small>
                                            </div>
                                            <div class="col-3 px-1">
                                                <input type="number" name="long_sec[]" class="form-control form-control-sm text-center" placeholder="Sec" required>
                                                <small class="text-muted d-block text-center" style="font-size: 10px;">Detik</small>
                                            </div>
                                            <div class="col-3 px-1">
                                                <select name="long_dir[]" class="form-control form-control-sm bg-light">
                                                    <option value="E">E (BT)</option>
                                                    <option value="W">W (BB)</option>
                                                </select>
                                                <small class="text-muted d-block text-center" style="font-size: 10px;">Arah</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tombol Hapus -->
                                    <div class="col-md-2 d-flex align-items-center justify-content-center border-left">
                                        <button type="button" class="btn btn-outline-danger btn-sm btn-hapus" style="display:none; width: 100%;">
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </button>
                                        <span class="text-muted small default-label text-center">Titik #1</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5">
                            <button type="submit" class="btn btn-success btn-lg btn-block shadow">
                                <i class="fas fa-save mr-2"></i> Simpan Data Poligon
                            </button>
                        </div>

                    </form>
                </div>
            </div>
            
            <div class="text-center mt-3 text-muted small">
                &copy; <?= date('Y') ?> Sistem Informasi Geografis Pertambangan
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('koordinat-container');
        const btnTambah = document.getElementById('btn-tambah');
        let counter = 1;

        // Inisialisasi custom file input bootstrap (Update untuk menangani banyak file input)
        document.querySelectorAll('.custom-file-input').forEach(input => {
            input.addEventListener('change', function(e) {
                var fileName = e.target.files[0].name;
                var nextSibling = e.target.nextElementSibling;
                nextSibling.innerText = fileName;
            });
        });

        // Fungsi Tambah Baris
        btnTambah.addEventListener('click', function() {
            counter++;
            
            const firstRow = container.querySelector('.coord-box');
            const newRow = firstRow.cloneNode(true);
            
            newRow.id = 'row-' + counter;
            const inputs = newRow.querySelectorAll('input');
            inputs.forEach(input => input.value = '');

            const labelSpan = newRow.querySelector('.default-label');
            if(labelSpan) labelSpan.remove();

            const btnHapus = newRow.querySelector('.btn-hapus');
            btnHapus.style.display = 'block';
            
            btnHapus.addEventListener('click', function() {
                newRow.remove();
            });

            newRow.style.opacity = 0;
            container.appendChild(newRow);
            
            setTimeout(() => {
                newRow.style.transition = 'opacity 0.5s';
                newRow.style.opacity = 1;
            }, 10);
        });
    });
</script>
<?= $this->endSection() ?>