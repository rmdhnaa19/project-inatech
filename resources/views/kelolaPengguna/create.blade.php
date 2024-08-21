@extends('layouts.template')
@section('title', 'Kelola Pengguna')
@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ url('kelolaPengguna') }}" class="form-horizontal" enctype="multipart/form-data"
                id="tambahPengguna">
                @csrf
                <div class=" form-group row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="basicInput">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama"
                                placeholder="Masukkan Nama" value="{{ old('nama') }}">
                        </div>
                        <div class="form-group">
                            <label for="helpInputTop">Input text with help</label>
                            <small class="text-muted">eg.<i>someone@example.com</i></small>
                            <input type="text" class="form-control" id="helpInputTop">
                        </div>

                        <div class="form-group">
                            <label for="helperText">With Helper Text</label>
                            <input type="text" id="helperText" class="form-control" placeholder="Name">
                            <p><small class="text-muted">Find helper text here for given textbox.</small></p>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex justify-content-center align-items-center">
                        <div class="form-group">
                            <div class="col">
                                <div class="row mb-1">
                                    <div class="drop-zone">
                                        <div class="col">
                                            <div class="text-center row">
                                                <i class="fa-solid fa-cloud-arrow-up"
                                                    style="height: 50px; font-size: 50px"></i>
                                            </div>
                                            <div class="row">
                                                <span class="drop-zone__prompt text-center">Seret lalu letakkan file di
                                                    sini</span>
                                            </div>
                                        </div>
                                        <input type="file" name="image" class="drop-zone__input" required>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <span class="text-center">Atau</span>
                                </div>
                                <div class="row">
                                    <div class="form-file">
                                        <input type="file" class="form-file-input" id="customFile">
                                        <label class="form-file-label" for="customFile">
                                            <span class="form-file-text">Choose file...</span>
                                            <span class="form-file-button">Browse</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endsection
    @push('css')
    @endpush
    @push('js')
        <script>
            document.querySelectorAll('.drop-zone__input').forEach((inputElement) => {
                const dropZoneElement = inputElement.closest('.drop-zone');

                dropZoneElement.addEventListener('click', (e) => {
                    inputElement.click();
                });

                inputElement.addEventListener('change', (e) => {
                    if (inputElement.files.length) {
                        updateThumbnail(dropZoneElement, inputElement.files[0]);
                    }
                });

                dropZoneElement.addEventListener('dragover', (e) => {
                    e.preventDefault();
                    dropZoneElement.classList.add('drop-zone--over');
                });

                ['dragleave', 'dragend'].forEach((type) => {
                    dropZoneElement.addEventListener(type, (e) => {
                        dropZoneElement.classList.remove('drop-zone--over');
                    });
                });

                dropZoneElement.addEventListener('drop', (e) => {
                    e.preventDefault();

                    if (e.dataTransfer.files.length) {
                        inputElement.files = e.dataTransfer.files;
                        updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
                    }

                    dropZoneElement.classList.remove('drop-zone--over');
                });
            });

            function updateThumbnail(dropZoneElement, file) {
                let thumbnailElement = dropZoneElement.querySelector('.drop-zone__thumb');

                // Remove the prompt
                if (dropZoneElement.querySelector('.drop-zone__prompt')) {
                    dropZoneElement.querySelector('.drop-zone__prompt').remove();
                }

                // First time - there is no thumbnail element, so let's create it
                if (!thumbnailElement) {
                    thumbnailElement = document.createElement('div');
                    thumbnailElement.classList.add('drop-zone__thumb');
                    dropZoneElement.appendChild(thumbnailElement);
                }

                thumbnailElement.dataset.label = file.name;

                // Show thumbnail for image files
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();

                    reader.readAsDataURL(file);
                    reader.onload = () => {
                        thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
                    };
                } else {
                    thumbnailElement.style.backgroundImage = null;
                }
            }
        </script>
    @endpush
