<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Produk</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    :root {
      --primary-brown: #8B4513;
      --secondary-brown: #A0522D;
      --light-brown: #D2B48C;
      --cream: #F5F5DC;
      --gray-light: #F8F9FA;
      --gray-medium: #E9ECEF;
      --gray-dark: #6C757D;
      --shadow: 0 2px 12px rgba(139, 69, 19, 0.1);
      --border-radius: 8px;
    }

    body {
      background-color: var(--gray-light);
      font-family: Arial, sans-serif;
    }

    .container {
      max-width: 960px;
    }

    .page-header {
      background: linear-gradient(135deg, var(--white), var(--cream));
      border-left: 5px solid var(--primary-brown);
      border-radius: var(--border-radius);
      box-shadow: var(--shadow);
      padding: 1.5rem;
      margin-bottom: 2rem;
      display: flex;
      align-items: center;
    }

    .page-header h4 {
      margin: 0;
      color: var(--primary-brown);
      font-weight: 700;
      font-size: 1.5rem;
    }

    .page-header i {
      margin-right: 10px;
      color: var(--primary-brown);
    }

    .card {
      border-radius: var(--border-radius);
      box-shadow: var(--shadow);
      border: none;
    }

    .card-header {
      background-color: var(--cream);
      border-bottom: 1px solid var(--gray-medium);
      padding: 1rem 1.25rem;
      font-weight: 600;
      color: var(--primary-brown);
    }

    .card-header i {
      margin-right: 8px;
    }

    .form-control, .custom-file-input {
      border-radius: 6px;
      border: 1px solid var(--gray-medium);
      padding: 10px;
      font-size: 0.95rem;
      background-color: white;
    }

    .form-control:focus, .custom-file-input:focus {
      border-color: var(--primary-brown);
      box-shadow: 0 0 0 2px rgba(139, 69, 19, 0.15);
    }

    .btn-primary {
      background: linear-gradient(135deg, var(--primary-brown), var(--secondary-brown));
      border: none;
      color: white;
      padding: 0.6rem 1.5rem;
      font-weight: 600;
      border-radius: var(--border-radius);
    }

    .btn-primary:hover {
      background: linear-gradient(135deg, var(--secondary-brown), var(--primary-brown));
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(139, 69, 19, 0.25);
    }

    .btn-secondary {
      background-color: var(--gray-medium);
      color: var(--gray-dark);
      font-weight: 600;
      border-radius: var(--border-radius);
      padding: 0.6rem 1.5rem;
      border: none;
    }

    .btn-secondary:hover {
      background-color: var(--gray-dark);
      color: white;
    }

    .custom-file-label::after {
      content: "Telusuri";
      background-color: var(--light-brown);
      border-left: 1px solid var(--gray-medium);
    }

    .img-thumbnail {
      max-width: 150px;
      margin-top: 10px;
      border: 2px solid var(--light-brown);
      border-radius: var(--border-radius);
    }
  </style>
</head>
<body>
  <div class="container mt-4">
    <div class="page-header">
      <i class="fas fa-edit fa-lg"></i>
      <h4 class="mb-0">Edit Produk</h4>
    </div>

    <div class="card">
      <div class="card-header">
        <i class="fas fa-info-circle"></i> Informasi Produk
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
            <label for="category_id">Kategori Produk</label>
            <select class="form-control" id="category_id" name="category_id" required>
              <option value="">-- Pilih Kategori --</option>
              @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                  {{ $category->nama }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="description">Deskripsi Produk</label>
            <textarea class="form-control" id="description" name="description" rows="4">{{ $product->description }}</textarea>
          </div>

          <div class="form-group">
              <label for="price">Harga Produk</label>
              <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $product->price) }}" required step="0.01">
          </div>

          <div class="form-group">
            <label for="main_image">Gambar Utama</label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="main_image" name="main_image" accept="image/*">
              <label class="custom-file-label" for="main_image">Pilih gambar baru...</label>
            </div>
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
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script>
    $('.custom-file-input').on('change', function (e) {
      let fileName = e.target.files.length === 1
        ? e.target.files[0].name
        : `${e.target.files.length} file dipilih`;
      $(this).next('.custom-file-label').html(fileName);
    });
  </script>
</body>
</html>
