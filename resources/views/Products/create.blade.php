
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 1000px;
        }
        .page-header {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }
        .page-header i {
            margin-right: 10px;
            color: #578FCA;
        }
        .card {
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            border: none;
        }
        .card-header {
            background-color: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 15px 20px;
            font-weight: 500;
            display: flex;
            align-items: center;
        }
        .card-header i {
            margin-right: 10px;
            color: #578FCA;
        }
        .form-control {
            border-radius: 4px;
            border: 1px solid #e2e8f0;
            padding: 8px 12px;
            margin-bottom: 10px;
        }
        .form-control:focus {
            border-color: #a0aec0;
            box-shadow: 0 0 0 0.2rem rgba(160, 174, 192, 0.25);
        }
        .btn-primary {
            background-color: #578FCA;
            border-color: #578FCA;
        }
        .btn-primary:hover {
            background-color: rgb(148, 179, 211);
            border-color: rgb(148, 179, 211);
        }
        .btn-secondary {
            background-color: #a0aec0;
            border-color: #a0aec0;
        }
        .btn-secondary:hover {
            background-color: #8fa3b8;
            border-color: #8fa3b8;
        }
        .tech-support {
            color: #718096;
            font-size: 0.9rem;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        .tech-support i {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="page-header">
                <i class="fas fa-plus-circle"></i>
                <h4 class="mb-0">Tambah Produk</h4>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <i class="fas fa-info-circle"></i> Produk Information
            </div>
            <div class="card-body">
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Nama Produk -->
                    <div class="form-group">
                        <label for="name">Nama Produk</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama produk" required>
                    </div>

                    <!-- Kategori Produk -->
                    <div class="form-group">
                        <label for="category_id">Kategori Produk</label>
                        <select class="form-control" id="category_id" name="category_id" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Deskripsi Produk -->
                    <div class="form-group">
                        <label for="description">Deskripsi Produk</label>
                        <textarea class="form-control" id="description" name="description" rows="4" placeholder="Masukkan deskripsi produk"></textarea>
                    </div>
                    
                    <!-- Gambar Utama -->
                    <div class="form-group">
                        <label for="main_image">Gambar Utama</label>
                        <input type="file" class="form-control-file" id="main_image" name="main_image" accept="image/*" required>
                    </div>
                    
                    <!-- Gambar Pendukung -->
                    <div class="form-group">
                        <label for="supporting_images">Gambar Pendukung</label>
                        <input type="file" class="form-control-file" id="supporting_images" name="supporting_images[]" accept="image/*" multiple>
                    </div>
                    
                    <!-- Ketersediaan Produk -->
                    <div class="form-group">
                        <label for="availability">Ketersediaan Produk</label>
                        <select class="form-control" id="availability" name="availability" required>
                            <option value="1">Tersedia</option>
                            <option value="0">Belum Tersedia</option>
                        </select>
                    </div>
                    
                    <!-- Tombol Simpan dan Batal -->
                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="btn btn-secondary mr-2" onclick="window.history.back()">Batal</button>
                        <button type="submit" class="btn btn-primary px-4">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

