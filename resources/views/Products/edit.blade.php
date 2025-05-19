
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
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
            color: #FFCB74;
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
            color: #FFCB74;
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
            background-color: #FFCB74;
            border-color: #FFCB74;
        }
        .btn-primary:hover {
            background-color: #6c44e0;
            border-color: #6c44e0;
        }
        .btn-secondary {
            background-color: #a0aec0;
            border-color: #a0aec0;
        }
        .btn-secondary:hover {
            background-color: #8fa3b8;
            border-color: #8fa3b8;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="page-header">
                <i class="fas fa-edit"></i>
                <h4 class="mb-0">Edit Produk</h4>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <i class="fas fa-info-circle"></i> Produk Information
            </div>
            <div class="card-body">
                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="name">Nama Produk</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Deskripsi Produk</label>
                        <textarea class="form-control" id="description" name="description" rows="4">{{ $product->description }}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="main_image">Gambar Utama</label>
                        <input type="file" class="form-control-file" id="main_image" name="main_image" accept="image/*">
                        @if($product->main_image)
                            <img src="{{ asset('storage/' . $product->main_image) }}" alt="Gambar Utama" class="img-thumbnail mt-2" style="max-width: 150px;">
                        @endif
                    </div>
                    
                    <div class="form-group">
                        <label for="supporting_images">Gambar Pendukung</label>
                        <input type="file" class="form-control-file" id="supporting_images" name="supporting_images[]" accept="image/*" multiple>
                    </div>
                    
                    <div class="form-group">
                        <label for="availability">Ketersediaan Produk</label>
                        <select class="form-control" id="availability" name="availability" required>
                            <option value="1" {{ $product->availability ? 'selected' : '' }}>Tersedia</option>
                            <option value="0" {{ !$product->availability ? 'selected' : '' }}>Belum Tersedia</option>
                        </select>
                    </div>
                    
                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="btn btn-secondary mr-2" onclick="window.history.back()">Batal</button>
                        <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
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
