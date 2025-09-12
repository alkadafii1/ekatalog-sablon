<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        :root {
            --primary-brown: #8B4513;
            --secondary-brown: #A0522D;
            --light-brown: #D2B48C;
            --cream: #F5F5DC;
            --gray-light: #F8F9FA;
            --gray-medium: #E9ECEF;
            --gray-dark: #6C757D;
            --white: #FFFFFF;
            --border-radius: 8px;
            --shadow: 0 2px 12px rgba(139, 69, 19, 0.1);
            --transition: all 0.3s ease;
        }

        body {
            background-color: var(--gray-light);
            font-family: Arial, sans-serif;
            padding-bottom: 40px;
        }

        .page-header {
            background: linear-gradient(135deg, var(--white), var(--cream));
            padding: 1.5rem 2rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            border-left: 5px solid var(--primary-brown);
            margin: 2rem auto 2rem auto;
            max-width: 960px;
        }

        .page-header h1 {
            font-size: 1.75rem;
            font-weight: bold;
            margin: 0;
            color: var(--primary-brown);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .custom-file-input:focus ~ .custom-file-label {
            border-color: var(--primary-brown);
            box-shadow: 0 0 0 0.2rem rgba(139, 69, 19, 0.25);
        }


        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            max-width: 960px;
            margin: auto;
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

        .form-control {
            border-radius: var(--border-radius);
            border: 1px solid var(--gray-medium);
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            margin-bottom: 1rem;
        }

        .form-control:focus {
            border-color: var(--primary-brown);
            box-shadow: 0 0 0 3px rgba(139, 69, 19, 0.1);
        }

        .form-label {
            font-weight: 600;
            color: var(--gray-dark);
        }

        .btn-primary-brown {
            background: linear-gradient(135deg, var(--primary-brown), var(--secondary-brown));
            color: var(--white);
            padding: 0.6rem 1.5rem;
            border: none;
            border-radius: var(--border-radius);
            font-weight: 600;
            transition: var(--transition);
        }

        .btn-primary-brown:hover {
            background: linear-gradient(135deg, var(--secondary-brown), var(--primary-brown));
            transform: translateY(-2px);
            box-shadow: var(--shadow);
            color: var(--white);
        }

        .btn-secondary {
            background: var(--gray-medium);
            color: var(--gray-dark);
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: var(--border-radius);
            font-weight: 600;
        }

        .btn-secondary:hover {
            background: var(--gray-dark);
            color: var(--white);
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="page-header">
        <h1><i class="fas fa-plus-circle"></i> Tambah Produk</h1>
    </div>

    <!-- Form Card -->
    <div class="card">
        <div class="card-header">
            <i class="fas fa-info-circle"></i> Informasi Produk
        </div>
        <div class="card-body">
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Nama Produk -->
                <div class="form-group">
                    <label for="name" class="form-label">Nama Produk</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama produk" required>
                </div>

                <!-- Kategori -->
                <div class="form-group">
                    <label for="category_id" class="form-label">Kategori Produk</label>
                    <select class="form-control" id="category_id" name="category_id" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Deskripsi -->
                <div class="form-group">
                    <label for="description" class="form-label">Deskripsi Produk</label>
                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Masukkan deskripsi produk"></textarea>
                </div>

                <!-- Gambar Utama -->
                <div class="form-group">
                    <label for="main_image" class="form-label">Gambar Utama <span class="text-danger">*</span></label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="main_image" name="main_image" accept="image/*" required>
                        <label class="custom-file-label" for="main_image">Pilih gambar utama...</label>
                    </div>
                </div>


                <!-- Gambar Pendukung -->
                <!-- <div class="form-group">
                    <label for="supporting_images" class="form-label">Gambar Pendukung</label>
                    <input type="file" class="form-control-file" id="supporting_images" name="supporting_images[]" accept="image/*" multiple>
                </div> -->

                <!-- Ketersediaan -->
                <div class="form-group">
                    <label for="availability" class="form-label">Ketersediaan Produk</label>
                    <select class="form-control" id="availability" name="availability" required>
                        <option value="1">Tersedia</option>
                        <option value="0">Belum Tersedia</option>
                    </select>
                </div>

                <!-- Tombol -->
                <div class="d-flex justify-content-end mt-4">
                    <button type="button" class="btn btn-secondary mr-2" onclick="window.history.back()">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary-brown">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Menampilkan nama file yang dipilih
        document.querySelector('.custom-file-input').addEventListener('change', function (e) {
            var fileName = document.getElementById("main_image").files[0].name;
            var nextSibling = e.target.nextElementSibling
            nextSibling.innerText = fileName;
        });
    </script>

</body>
</html>
