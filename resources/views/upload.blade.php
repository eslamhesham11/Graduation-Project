<form action="{{ route("api.upload") }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="file" name="image"  required>
    <button type="submit">Upload</button>
</form>