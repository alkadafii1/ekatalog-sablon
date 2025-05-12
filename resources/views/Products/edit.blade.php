<form action="{{ route('products.update', $editProduk->id) }}" method="POST">
    @csrf @method('PUT')
    <div>
        <label>Nama</label>
        <input type="text" name="nama" value="{{ $editProduk->nama }}" required>
    </div>
    <div>
        <label>Harga</label>
        <input type="number" name="harga" value="{{ $editProduk->harga }}" required>
    </div>
    <div>
        <label>Stok</label>
        <input type="number" name="stok" value="{{ $editProduk->stok }}" required>
    </div>
    <button type="submit">Update</button>
</form>
