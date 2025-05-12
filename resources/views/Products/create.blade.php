<form action="{{ route('products.store') }}" method="POST">
    @csrf
    <div>
        <label>Nama</label>
        <input type="text" name="nama" required>
    </div>
    <div>
        <label>Harga</label>
        <input type="number" name="harga" required>
    </div>
    <div>
        <label>Stok</label>
        <input type="number" name="stok" required>
    </div>
    <button type="submit">Tambah</button>
</form>
