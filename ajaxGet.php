<!DOCTYPE html>
<html lang="en">
<head>
    <title>CRUD Example</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        table {
            margin-top: 20px;
        }
    </style>
</head>
<body class="container mt-5">
    <h2>Daftar Mahasiswa</h2>

    <!-- Formulir input data -->
    <form class="form-inline mb-3">
        <div class="form-group mr-2">
            <input type="text" class="form-control" id="npm" placeholder="NPM">
        </div>
        <div class="form-group mr-2">
            <input type="text" class="form-control" id="nama" placeholder="Nama Mahasiswa">
        </div>
        <div class="form-group mr-2">
            <input type="text" class="form-control" id="studi" placeholder="Studi">
        </div>
        <div class="form-group mr-2">
            <input type="text" class="form-control" id="semester" placeholder="Semester">
        </div>
        <div class="form-group mr-2">
            <input type="text" class="form-control" id="type_pembayaran" placeholder="Type Pembayaran">
        </div>
        <div class="form-group mr-2">
            <input type="text" class="form-control" id="tingkat_pembayaran" placeholder="Tingkat Pembayaran">
        </div>
        <div class="form-group mr-2">
            <input type="text" class="form-control" id="total_pembayaran" placeholder="Total Pembayaran">
        </div>
        <button type="button" class="btn btn-primary" onclick="addMahasiswa()">Tambah</button>
    </form>

    <!-- Tabel untuk menampilkan data mahasiswa -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>NPM</th>
                <th>Nama Mahasiswa</th>
                <th>Studi</th>
                <th>Semester</th>
                <th>Type Pembayaran</th>
                <th>Tingkat Pembayaran</th>
                <th>Total Pembayaran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="mahasiswaTableBody"></tbody>
    </table>

    <!-- Modal untuk pembaruan data -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Perbarui Data Mahasiswa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="updateId">ID Mahasiswa:</label>
                        <input type="text" class="form-control" id="updateId" readonly>
                    </div>
                    <div class="form-group">
                        <label for="updateNama">Nama Mahasiswa:</label>
                        <input type="text" class="form-control" id="updateNama">
                    </div>
                    <!-- Tambahkan input lain sesuai kebutuhan -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" onclick="updateMahasiswa()">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.8/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Variabel global untuk menyimpan ID yang sedang di-update
        var updatingMahasiswaId = null;

        function fetchData() {
            fetch('GetMahasiswa.php?npm=')
                .then(response => response.json())
                .then(data => {
                    updateTable(data);
                })
                .catch(error => console.error('Error:', error));
        }

        function addMahasiswa() {
            var npm = document.getElementById("npm").value;
            var nama = document.getElementById("nama").value;
            var studi = document.getElementById("studi").value;
            var semester = document.getElementById("semester").value;
            var type_pembayaran = document.getElementById("type_pembayaran").value;
            var tingkat_pembayaran = document.getElementById("tingkat_pembayaran").value;
            var total_pembayaran = document.getElementById("total_pembayaran").value;
            
            fetch('GetMahasiswa.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'npm=' + npm + '&nama=' + nama + '&studi=' + studi + '&semester=' + semester +
                      '&type_pembayaran=' + type_pembayaran + '&tingkat_pembayaran=' + tingkat_pembayaran +
                      '&total_pembayaran=' + total_pembayaran,
            })
            .then(response => response.text())
            .then(data => {
                fetchData();
                console.log('Success:', data);
            })
            .catch(error => console.error('Error:', error));
        }

        function deleteMahasiswa(id) {
            fetch('GetMahasiswa.php', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id=' + id,
            })
            .then(response => response.text())
            .then(data => {
                fetchData();
                console.log('Success:', data);
            })
            .catch(error => console.error('Error:', error));
        }

        // function updateMahasiswa() {
        //     // Menggunakan updatingMahasiswaId untuk mendapatkan ID yang sedang di-update
        //     var id = updatingMahasiswaId;
        //     var npm = document.getElementById("npm").value;
        //     var nama = document.getElementById("nama").value;
        //     // Tambahkan pembaruan input lain sesuai kebutuhan
            
        //     fetch('GetMahasiswa.php', {
        //         method: 'PATCH',
        //         headers: {
        //             'Content-Type': 'application/x-www-form-urlencoded',
        //         },
        //         body: 'id=' + id + '&npm=' + npm + '&nama=' + nama,
        //         // Tambahkan data input lain sesuai kebutuhan
        //     })
        //     .then(response => response.text())
        //     .then(data => {
        //         fetchData();
        //         console.log('Success:', data);
        //         $('#updateModal').modal('hide'); // Tutup modal setelah pembaruan
        //     })
        //     .catch(error => console.error('Error:', error));
        // }

        function showUpdateModal(id) {
            // Menyimpan ID yang sedang di-update
            updatingMahasiswaId = id;

            // Tampilkan modal pembaruan data
            $('#updateModal').modal('show');

            // Ambil data mahasiswa berdasarkan ID
            fetch('GetMahasiswa.php?id=' + id)
                .then(response => response.json())
                .then(data => {
                    // Isi nilai input modal dengan data mahasiswa yang akan diperbarui
                    document.getElementById("updateId").value = data[0].id;
                    document.getElementById("updateNama").value = data[0].nama;
                    // Isi nilai input lain sesuai kebutuhan
                })
                .catch(error => console.error('Error:', error));
        }

        function updateTable(data) {
            var tableBody = document.getElementById("mahasiswaTableBody");
            tableBody.innerHTML = "";

            data.forEach(function(mahasiswa) {
                var row = "<tr>";
                row += "<td>" + mahasiswa.id + "</td>";
                row += "<td>" + mahasiswa.npm + "</td>";
                row += "<td>" + mahasiswa.nama + "</td>";
                row += "<td>" + mahasiswa.studi + "</td>";
                row += "<td>" + mahasiswa.semester + "</td>";
                row += "<td>" + mahasiswa.type_pembayaran + "</td>";
                row += "<td>" + mahasiswa.tingkat_pembayaran + "</td>";
                row += "<td>" + mahasiswa.total_pembayaran + "</td>";
                row += "<td><button class='btn btn-danger' onclick='deleteMahasiswa(" + mahasiswa.id + ")'>Hapus</button></td>";
                row += "<td><button class='btn btn-primary' onclick='showUpdateModal(" + mahasiswa.id + ")'>Update</button></td>";
                row += "</tr>";
                tableBody.innerHTML += row;
            });
        }

        fetchData();
    </script>
</body>
</html>
